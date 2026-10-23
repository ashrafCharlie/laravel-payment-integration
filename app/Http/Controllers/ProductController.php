<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('product',[
            'products'=> $products,
        ]);
    }
    public  function show(){
        return view('create');
    }
    public function create(StoreProductRequest $request){
        $product = $request->validated();
        Product::create($product);
        return redirect('/products');
    }

    public function edit(Product $product){
        return view('edit',[
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product){
        $data = $request->validated();
        $product->update($data);
        return redirect('/products');
    }

    public function delete(Product $product){
        $product->delete();
        return redirect('/products');
    }

}
