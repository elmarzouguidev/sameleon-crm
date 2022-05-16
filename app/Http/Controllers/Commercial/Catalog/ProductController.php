<?php

namespace App\Http\Controllers\Commercial\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\Product\ProductFormRequest;
use App\Http\Requests\Catalog\Product\ProductUpdateFormRequest;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Color;
use App\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{


    public function index()
    {
        $products = Product::with('media')->get();

        return view('theme.pages.Catalog.Product.__datatable.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();

        $brands = Brand::select(['id', 'name'])->get();

        $colors = Color::select(['id', 'name'])->get();

        return view('theme.pages.Catalog.Product.create.index', compact('brands', 'categories', 'colors'));
    }

    public function store(ProductFormRequest $request)
    {

        $product = new Product();
        $product->name = $request->name;
        $product->reference = $request->reference;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        $product->description = $request->description;

        $product->brand()->associate($request->brand);
        $product->category()->associate($request->category);

        if ($request->has('colors') &&  $request->filled('colors')) {
            $product->colors()->attach($request->colors);
        }

        $product->save();

        if ($request->hasFile('photo')) {

            $product->addMediaFromRequest('photo')
                ->toMediaCollection('products_images');
        }

        return redirect()->back()->with('success', "Le produit a été ajouter avec success");
    }

    public function edit(Product $product)
    {

        $categories = Category::select(['id', 'name'])->get();

        $brands = Brand::select(['id', 'name'])->get();

        $colors = Color::select(['id', 'name'])->get();

        return view('theme.pages.Catalog.Product.edit.index', compact('brands', 'categories', 'colors', 'product'));
    }

    public function update(ProductUpdateFormRequest $request, Product $product)
    {

        $product->name = $request->name;
        $product->reference = $request->reference;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        $product->description = $request->description;

        $product->brand()->associate($request->brand);
        $product->category()->associate($request->category);

        if ($request->has('colors') &&  $request->filled('colors')) {
            $product->colors()->attach($request->colors);
        }

        if ($request->hasFile('photo')) {

            $product->clearMediaCollection('products_images');

            $product->addMediaFromRequest('photo')
                ->toMediaCollection('products_images');
        }

        $product->save();

        return redirect()->back()->with('success', "Le produit a été modifier avec success");
    }

    public function delete(Request $request)
    {
        $request->validate(['productId' => 'required|uuid']);

        $product = Product::whereUuid($request->productId)->firstOrFail();

        if ($product) {

            //$product->delete();

            return redirect()->back()->with('success', "Le produit a été supprimer avec success");
        }

        return redirect()->back()->with('error', "Error !!!");
    }
}
