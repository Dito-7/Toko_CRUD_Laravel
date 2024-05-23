<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(): Response
    {
        $products = Product::all();

        return response(view('products.index', ['products' => $products]));
    }

    public function homeView(): Response
    {
        $products = Product::all();

        return response(view('products.home', ['products' => $products]));
    }

    public function create(): Response
    {
        $brands = Brand::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('name', 'asc')->get()->pluck('name', 'id');

        return response(view('products.create', ['brands' => $brands, 'categories' => $categories]));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $product = Product::create($params);

        $product->categories()->sync($params['category_ids']);

        if ($request->hasFile('fotoProduct')) {
            $imageName = time() . '.' . $request->file('fotoProduct')->getClientOriginalExtension();
            $request->file('fotoProduct')->storeAs('public/images', $imageName);

            $product->fotoProduct = $imageName;
            $product->save();
        }

        return redirect(route('products.index'))->with('success', 'Added!');
    }

    public function show(string $product): Response
    {
        $product = Product::findOrFail($product);
        $brands = Brand::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('name', 'asc')->get()->pluck('name', 'id');

        return response(view('products.show', ['product' => $product, 'brands' => $brands, 'categories' => $categories]));
    }

    public function edit(string $id): Response
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('name', 'asc')->get()->pluck('name', 'id');

        return response(view('products.edit', ['product' => $product, 'brands' => $brands, 'categories' => $categories]));
    }

    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $params = $request->validated();

        if ($request->hasFile('fotoProduct')) {
            // Hapus foto lama jika ada
            if ($product->fotoProduct) {
                Storage::delete('public/images/' . $product->fotoProduct);
            }

            // Unggah foto baru
            $imageName = time() . '.' . $request->file('fotoProduct')->getClientOriginalExtension();
            $request->file('fotoProduct')->storeAs('public/images', $imageName);

            // Simpan nama foto baru ke dalam database
            $params['fotoProduct'] = $imageName;
        }

        if ($product->update($params)) {
            return redirect(route('products.index'))->with('success', 'Product updated successfully!');
        } else {
            return back()->withErrors('Failed to update product!');
        }
    }


    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->categories()->detach();

        if ($product->delete()) {
            return redirect(route('products.index'))->with('success', 'Deleted!');
        }

        return redirect(route('products.index'))->with('error', 'Sorry, unable to delete this!');
    }
}
