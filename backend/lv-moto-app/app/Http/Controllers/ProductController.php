<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductSetting {
    public $label;
    public $name;
    public $value;
    public $placeholder;
    public $type;
    public $mandatory;

    function __construct($name,$value,$label,$mandatory = false, $type = "text", $placeholder = false) {
        if (!$placeholder) {
            $placeholder = $label;
        }

        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->mandatory = $mandatory;
    }
}

class ProductController extends Controller
{
    public function getSettings($dbEntry = [ "code" => "", "title" => "", "description" => "", "cost" => "", "images" => [], "category" => "", "sizes" => [], "variations" => [], "stock" => true ]) {
        return [
            new ProductSetting("title","","Title", true),
            new ProductSetting("code","","Product Code", true),
            new ProductSetting("cost","","Cost", true, "number"),
            new ProductSetting("category","","Category", true),
            new ProductSetting("description","","Description", false)
        ];
    }

    public function edit($id) {
         $product = MongoController::getOneProduct($id);

         if (!empty($product)) {
             return view('admin.pages.products-create')->with([
                 'title' => "Edit Product",
                 'confirmText' => "Update",
                 'product' => $product,
                 'category' => $product['category'],
                 'availableSettings' => $this->getSettings()
             ]);
         }

         return redirect(route('admin.products'))->with('error','Product Not found');
    }

    public function create($category) {
        return view('admin.pages.products-create')->with([
            'category' => $category,
            'availableSettings' => $this->getSettings()
        ]);
    }

    public function uploadImage(Request $request) {
        $image = $request->file;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        Storage::putFileAs('productImages/', $image, $imageName);
        return url("/productImages/" . $imageName);
    }

    public function confirmCreate(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'code' => 'required|numeric',
            'cost' => 'required|numeric',
            'category' => 'required',
            'description' => 'required|min:3'
        ]);

        $product = [
            'title' => $request->title,
            'code' => $request->code,
            'cost' => $request->cost,
            'category' => $request->category,
            'description' => $request->description,
            'images' => $request->images,
            'sizes' => $request->sizes,
            'variations' => $request->colors,
            'stock' => $request->stock
        ];

        return MongoController::addProduct($product);
    }

    public function moveProd(Request $request) {
        $request->validate([
            '_id' => "required",
            'newCat' => "required"
        ]);

        return MongoController::editProduct($request->_id, [
            'category' => $request->newCat
        ]);
    }

    public function createCategory(Request $request) {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        return MongoController::newCategory($request->name);
    }

    public function renameCat($id,$newName) {
        return redirect()->back()->with('result', MongoController::editCategory($id, [
            "label" => $newName
        ]));
    }

    public function delCategory($id) {

        return redirect()->back()->with("answer", MongoController::delCategory($id));
    }
}
