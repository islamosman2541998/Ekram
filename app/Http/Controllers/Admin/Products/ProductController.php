<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\TagProduct;
use App\Models\AttributeSet;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductVariances;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\ProductProductRequest;
use App\Models\Review;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.dashboard.products.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['category'] =  ProductCategory::query()->with('trans')->get('id');
        $data['vendors'] =  Vendor::query()->with('trans')->get('id');
        // $data['tags'] =  TagProduct::query()->with('trans')->get('id');
        $data['attribute_set'] =  AttributeSet::query()->with('attribute', 'trans')->get('id');

        if ($data['category']->first() == null) {
            session()->flash('success', trans('message.admin.please_create_category_first'));
            return redirect()->back();
        }
        if ($data['vendors']->first() == null) {
            session()->flash('success', trans('message.admin.please_create_vendor_first'));
            return redirect()->back();
        }

        // if ($data['tags']->first() == null) {
        //     session()->flash('success', trans('message.admin.please_create_tags_first'));
        //     return redirect()->back();
        // }
        return view('admin.dashboard.products.product.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductProductRequest $request)
    {
        $data = $request->getSanitized();
        // Sava Data to table product  is variance == 0
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Products'));
        }
        $product = Product::create($data);
        if (request()->tags != null) {
            $product->tags()->attach(request()->tags);
        }
        if (!empty($data['attributes']['attributevalue_id'])) {
            $data['is_variance'] = 1;
            $variance = Product::create($data);
            $products_variances = ProductVariances::create([
                'product_id' => $product->id,
                'variance_id' => $variance->id,
                'default' => 0
            ]);
            foreach ($data['attributes']['attributesSet_id'] as $value) {
                $product->attributeSet()->attach($value);
            }
            foreach ($data['attributes']['attributevalue_id'] as $value) {
                $products_variances->attributeValue()->attach($value);
            }
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.eccommerce.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data['product'] = $product;
        // unique_attributeSet
        $data['unique_attributeSet'] = $product->attributeSet()->get();

        $data['category'] =  ProductCategory::query()->with('trans')->get();
        $data['vendors'] =  Vendor::query()->with('trans')->get();
        $data['tags'] =  TagProduct::query()->with('trans')->get();
        $data['attribute_set'] =  AttributeSet::query()->with('attribute', 'trans')->get();
        return view('admin.dashboard.products.product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['product'] = $product;
        // unique_attributeSet
        $data['unique_attributeSet'] = $product->attributeSet()->with('trans')->get();

        $data['category'] =  ProductCategory::query()->with('trans')->get();
        $data['vendors'] =  Vendor::query()->with('trans')->get();
        $data['tags'] =  TagProduct::query()->with('trans')->get();
        $data['attribute_set'] =  AttributeSet::query()->with('attribute', 'trans')->get();
        return view('admin.dashboard.products.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductProductRequest $request, Product $product)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('cover_image')) {
            $this->delete_file($product->image);
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Products'));
        }
        $product->update($data);
        if (request()->tags != null) {
            $product->tags()->sync(request()->tags);
        }
        if (!empty($data['attributes']['attributevalue_id'])) {
            $data['is_variance'] = 1;
            $variance = Product::create($data);

            $products_variances = ProductVariances::create([
                'product_id' => $product->id,
                'variance_id' => $variance->id,
                'default' => 0
            ]);
            foreach ($data['attributes']['attributesSet_id'] as $value) {
                $product->attributeSet()->attach($value);
            }
            foreach ($data['attributes']['attributevalue_id'] as $value) {
                $products_variances->attributeValue()->attach($value);
            }
        }
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.eccommerce.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->delete_file($product->image);
        $product->delete();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return back();
    }


    public function update_status($id)
    {
        $review = Review::findOrfail($id);
        $review->status == 1 ? $review->status = 0 : $review->status = 1;
        $review->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    public function getAttribute($id)
    {
        $attribute_value = Attribute::with('trans')->where('attribute_set_id', $id)->get();
        $res = [];
        foreach ($attribute_value as $attr_val) {
            $res[$attr_val->id] = $attr_val->trans->where('locale', app()->getLocale())->first()->title;
        }
        return $res;
    }


    public function reviews(Request $request, $id)
    {
        // dd($request->all());
        $product = Product::query()->with('reviews')->findOrFail($id);

        $reviews = $product->reviews;
        if ($request->rate != '') {
            $reviews = $reviews->where('rate', $request->rate);
        }
        if ($request->created_by != '') {
            $reviews = $reviews->where('created_by', $request->created_by);
        }
        return view('admin.dashboard.products.product.review', compact('product', 'reviews'));
    }

    public function deleteReview(Request $request)
    {
        $reviews = Review::findOrFail($request->delete_id);
        $reviews->delete();
        session()->flash('success', trans('pages.delete_all_sucessfully'));
        return redirect()->back();
    }
}
