<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\Utils\Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use Responser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function createCategory()
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($this->request->all(), [
                'name' => 'required|string',
                'label' => 'required|string',
                'description' => 'string',
                'image' => 'mimes:png,jpg,jpeg|max:4194304'
            ], [
                'name.required' => 'نام الزامی میباشد',
                'name.string' => 'نام باید رشته باشد',
                'label.required' => 'عنوان الزامی میباشد',
                'label.string' => 'عنوان باید رشته باشد',
                'description.string' => 'توضیحات باید رشته باشد',
                'image.mimes' => 'فرمت عکس نامعتبر میباشد',
                'image.max' => 'حجم عکس زیاد است',
            ]);

            if ($validation->fails()) throw new \Exception(serialize($validation->getMessageBag()), 400);


            $category = new Category;
            $category->name = $this->request->name;
            $category->label = $this->request->label;
            if ($this->request->has('description')) $category->description = $this->request->description;
            if ($this->request->has('image')) {
                $filePath = 'categories/' . $this->request->name . '.' . explode('/', $this->request->image->getMimeType())[1];
                $this->request->file('image')->storeAs('public', $filePath);
                $category->image = $filePath; //$category->image = $this->request->image;
            }
            $category->save();
            DB::commit();
            return $this->successful($category, "Category Created", 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 400) return $this->clientError($exception->getMessage());
            return $this->serverError($exception->getMessage());
        }
    }

    public function getOneCategory(Category $category)
    {
        try {
            return $this->successful($category);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function getAllCategories()
    {
        try {
            if ($this->request->has('product')) {
                if ($this->request->has('full'))
                    return $this->successful(Category::withTrashed()->with('products')->get());
                return $this->successful(Category::with('products')->get());
            } else if ($this->request->has('full'))
                return $this->successful(Category::withTrashed()->get());
            return $this->successful(Category::get());
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function editCategory(Category $category)
    {
        DB::beginTransaction();

        try {
            if (count($this->request->all()) === 0) throw new \Exception('مقداری ارسال نشده است', 400);

            $validation = Validator::make($this->request->all(), [
                'name' => 'string',
                'label' => 'string',
                'description' => 'string',
                'image' => 'string',
            ], [
                'name.string' => 'نام باید رشته باشد',
                'label.string' => 'عنوان باید رشته باشد',
                'description.string' => 'توضیحات باید رشته باشد',
                'image.string' => 'آدرس عکس نامعتبر میباشد',
            ]);

            if ($validation->fails()) throw new \Exception(serialize($validation->getMessageBag()), 400);

            if ($this->request->has('name')) $category->name = $this->request->name;
            if ($this->request->has('label')) $category->label = $this->request->label;
            if ($this->request->has('description')) $category->description = $this->request->description;
            if ($this->request->has('image')) $category->image = $this->request->image;
            $category->save();
            DB::commit();
            return $this->successful($category);
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 400) return  $this->clientError($exception->getMessage());
            return $this->serverError($exception->getMessage());
        }
    }


    public function deleteCategory(Category $category)
    {
        try {
            $category->delete();
            return $this->successful($category, 'Category Deleted', 204);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function categoriesPage()
    {
        $categories = Category::select('id', 'name', 'label', 'description', 'image')->get();
        return view('menu/categories', ['categories' => $categories]);
    }

    public function categoryPage(String $categoryName)
    {
        $category = Category::where('name', $categoryName)->with('products')->select('id', 'name', 'label', 'description', 'image')->first();
        return view(!$category ? 'notfound' : 'menu/category', ['category' => $category]);
    }
}
