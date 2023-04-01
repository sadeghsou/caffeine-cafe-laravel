<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Traits\Utils\Responser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use Responser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function createProduct()
    {
        DB::beginTransaction();
        try {
            $validation = Validator::make($this->request->all(), [
                'name' => 'required|string',
                'price' => 'required|numeric',
                'label' => 'required|string',
                'category' => 'required|numeric',
                'image' => 'numeric',
                'description' => 'string',
            ], [
                'name.required' => 'نام الزامی میباشد',
                'name.string' => 'نام باید رشته باشد',
                'label.required' => 'عنوان الزامی میباشد',
                'label.string' => 'عنوان باید رشته باشد',
                'description.string' => 'توضیحات باید رشته باشد',
                'image.numeric' => 'عکس نامعتبر میباشد',
                'price.required' => 'دسته بندی الزامی میباشد',
                'price.numeric' => 'دسته بندی نامعتبر میباشد',
                'category.required' => 'دسته بندی الزامی میباشد',
                'category.numeric' => 'دسته بندی نامعتبر میباشد',
            ]);

            if ($validation->fails()) throw new \Exception(serialize($validation->getMessageBag()), 400);

            if (!Category::find($this->request->category)) throw new \Exception('دسته بندی نامعتبر است', 400);

            if ($this->request->has('image') && !File::find($this->request->image)) throw new \Exception('عکس نامعتبر است', 400);

            $product = new Product;
            $product->name = $this->request->name;
            $product->label = $this->request->label;
            $product->price = $this->request->price;
            $product->category_id = $this->request->category;
            if ($this->request->has('description')) $product->description = $this->request->description;
            if ($this->request->has('image')) $product->image_id = $this->request->image;
            $product->save();
            DB::commit();
            return $this->successful($product, "Product Created", 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 400) return $this->clientError($exception->getMessage());
            return $this->serverError($exception->getMessage());
        }
    }

    public function getOneProduct(Product $product)
    {
        try {
            return $this->successful($product);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function getAllProducts()
    {
        try {
            if ($this->request->has('category')) {
                if ($this->request->has('full'))
                    return $this->successful(Product::withTrashed()->with('category')->get());
                return $this->successful(Product::with('category')->get());
            } else if ($this->request->has('full'))
                return $this->successful(Product::withTrashed()->get());
            return $this->successful(Product::get());
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function editProduct(Product $product)
    {
        DB::beginTransaction();

        try {
            if (count($this->request->all()) === 0) throw new \Exception('مقداری ارسال نشده است', 400);

            $validation = Validator::make($this->request->all(), [
                'name' => 'string',
                'label' => 'string',
                'description' => 'string',
                'image' => 'integer',
            ], [
                'name.string' => 'نام باید رشته باشد',
                'label.string' => 'عنوان باید رشته باشد',
                'description.string' => 'توضیحات باید رشته باشد',
                'image.integer' => 'آی‌دی عکس باید عدد باشد',
            ]);

            if ($validation->fails()) throw new \Exception(serialize($validation->getMessageBag()), 400);

            if ($this->request->has('name')) $product->name = $this->request->name;
            if ($this->request->has('label')) $product->label = $this->request->label;
            if ($this->request->has('description')) $product->description = $this->request->description;
            if ($this->request->has('image')) $product->image = $this->request->image;
            $product->save();
            DB::commit();
            return $this->successful($product);
        } catch (\Exception $exception) {
            DB::rollBack();
            if ($exception->getCode() == 400) return  $this->clientError($exception->getMessage());
            return $this->serverError($exception->getMessage());
        }
    }


    public function deleteProduct(Product $product)
    {
        try {
            $product->delete();
            return $this->successful($product, 'Product Deleted', 204);
        } catch (\Exception $exception) {
            return $this->serverError($exception->getMessage());
        }
    }

    public function productPage(String $categoryName, String $productName)
    {
        $product = Product::where('name', $productName)->with(['category', 'image'])->whereRelation('category', 'name', $categoryName)->select('name', 'label', 'description', 'price', 'category_id', 'image_id')->first();
        return view(!$product ? 'notfound' : 'menu/product', ['product' => $product]);
    }
}
