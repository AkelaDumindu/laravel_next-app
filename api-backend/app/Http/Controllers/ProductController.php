<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $userId = auth()->user()->id;

        $products = Product::where('user_id', $userId)->get();

        return response()->json([
            "status" => true,
            "products" => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            "title" => "required"
        ]);

        $data["user_id"] = auth()->user()->id;
        if($request->hasFile("banner_image")){
            $data["banner_image"] = $request->file("banner_image")->store("produts", "public");
        }

        Product::create($data);

        return response()->json([
            "status" => true,
            "message" => "Product created successfully."
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        return response()->json([
            "status" => true,
            "message" => "Product data found.",
            "product" => $product
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $data = $request->validate([
            "title" => "required"
        ]);

        if($request->hasFile("banner_image")){
            if($product->banner_image){
                Storage::disk("public")->delete($product->banner_image);
            }

            $data["banner_image"] = $request->file("banner_image")->store("products", "public");
        }

        $product->update($data);

        return response()->json([
            "status" => true,
            "message" => "Product update successfully.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            "status" => true,
            "message" => "Product deleted successfully.",
            "product" => $product
        ]);
    }
}
