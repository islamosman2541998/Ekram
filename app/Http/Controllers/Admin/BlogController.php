<?php

namespace App\Http\Controllers\Admin;

use App\Models\Articles;
use App\Models\Categories;
use App\Models\Tag;
use App\Models\ArticleTags;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Articles::query()
            ->with(['trans', 'categories.trans'])
            ->orderBy('sort', 'ASC')
            ->paginate($this->pagination_count);
            
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Categories::query()
            ->with('trans')
            ->active()
            ->feature()
            ->orderBy('sort', 'ASC')
            ->get();
            
        $tags = Tag::query()
            ->with('trans')
            ->active()
            ->feature()
            ->orderBy('sort', 'ASC')
            ->get();
            
        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'required|string|max:255|unique:articles_translations,slug',
            'slug_en' => 'required|string|max:255|unique:articles_translations,slug',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'boolean',
            'feature' => 'boolean',
            'sort' => 'integer|min:0',
        ]);

        $blog = new Articles();
        $blog->category_id = $request->category_id;
        $blog->status = $request->has('status') ? 1 : 0;
        $blog->feature = $request->has('feature') ? 1 : 0;
        $blog->sort = $request->sort ?? 0;
        $blog->created_by = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blogs', $imageName, 'public');
            $blog->image = $imagePath;
        }

        $blog->save();

        // Save translations
        $locales = ['ar', 'en'];
        foreach ($locales as $locale) {
            $blog->translateOrNew($locale)->title = $request->input("title_{$locale}");
            $blog->translateOrNew($locale)->slug = $request->input("slug_{$locale}");
            $blog->translateOrNew($locale)->description = $request->input("description_{$locale}");
            $blog->translateOrNew($locale)->content = $request->input("content_{$locale}");
            $blog->translateOrNew($locale)->meta_title = $request->input("meta_title_{$locale}");
            $blog->translateOrNew($locale)->meta_description = $request->input("meta_description_{$locale}");
            $blog->translateOrNew($locale)->meta_key = $request->input("meta_key_{$locale}");
        }
        $blog->save();

        // Sync tags
        if ($request->has('tags')) {
            foreach ($request->tags as $tagId) {
                ArticleTags::create([
                    'article_id' => $blog->id,
                    'tag_id' => $tagId
                ]);
            }
        }

        return redirect()->route('admin.blogs.index')->with('success', 'تم إنشاء المقال بنجاح');
    }

    public function show($id)
    {
        $blog = Articles::with(['trans', 'categories.trans', 'tags.trans'])->findOrFail($id);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit($id)
    {
        $blog = Articles::with(['trans', 'categories.trans', 'tags.trans'])->findOrFail($id);
        
        $categories = Categories::query()
            ->with('trans')
            ->active()
            ->feature()
            ->orderBy('sort', 'ASC')
            ->get();
            
        $tags = Tag::query()
            ->with('trans')
            ->active()
            ->feature()
            ->orderBy('sort', 'ASC')
            ->get();
            
        $selectedTags = $blog->tags->pluck('id')->toArray();
            
        return view('admin.blogs.edit', compact('blog', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, $id)
    {
        $blog = Articles::findOrFail($id);
        
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'required|string|max:255|unique:articles_translations,slug,' . $blog->id . ',article_id',
            'slug_en' => 'required|string|max:255|unique:articles_translations,slug,' . $blog->id . ',article_id',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'boolean',
            'feature' => 'boolean',
            'sort' => 'integer|min:0',
        ]);

        $blog->category_id = $request->category_id;
        $blog->status = $request->has('status') ? 1 : 0;
        $blog->feature = $request->has('feature') ? 1 : 0;
        $blog->sort = $request->sort ?? 0;
        $blog->updated_by = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blogs', $imageName, 'public');
            $blog->image = $imagePath;
        }

        $blog->save();

        // Update translations
        $locales = ['ar', 'en'];
        foreach ($locales as $locale) {
            $blog->translateOrNew($locale)->title = $request->input("title_{$locale}");
            $blog->translateOrNew($locale)->slug = $request->input("slug_{$locale}");
            $blog->translateOrNew($locale)->description = $request->input("description_{$locale}");
            $blog->translateOrNew($locale)->content = $request->input("content_{$locale}");
            $blog->translateOrNew($locale)->meta_title = $request->input("meta_title_{$locale}");
            $blog->translateOrNew($locale)->meta_description = $request->input("meta_description_{$locale}");
            $blog->translateOrNew($locale)->meta_key = $request->input("meta_key_{$locale}");
        }
        $blog->save();

        // Sync tags
        ArticleTags::where('article_id', $blog->id)->delete();
        if ($request->has('tags')) {
            foreach ($request->tags as $tagId) {
                ArticleTags::create([
                    'article_id' => $blog->id,
                    'tag_id' => $tagId
                ]);
            }
        }

        return redirect()->route('admin.blogs.index')->with('success', 'تم تحديث المقال بنجاح');
    }

    public function destroy($id)
    {
        $blog = Articles::findOrFail($id);
        
        // Delete image
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        
        // Delete tags relationship
        ArticleTags::where('article_id', $blog->id)->delete();
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'تم حذف المقال بنجاح');
    }
}
