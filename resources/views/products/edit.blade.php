@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="main-wrapper">
            <div class="main-content">
                <div class="container">
                    <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card mt-5">
                            <div class="card-header">
                                <h3>Edit Product</h3>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <div class="alert-title">
                                            <h4>Whoops!</h4>
                                        </div>
                                        There are some problems with your input.
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" name="sku"
                                        value="{{ old('sku', $product->sku) }}" placeholder="#SKU">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $product->name) }}" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" class="form-control">
                                        @foreach ($brands as $brandID => $name)
                                            <option value="{{ $brandID }}"
                                                {{ old('brand_id', $product->brand_id) == $brandID ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    @foreach ($categories as $categoryID => $categoryName)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="category_ids[]"
                                                value="{{ $categoryID }}"
                                                {{ in_array($categoryID, $product->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $categoryName }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="text" class="form-control" name="price"
                                        value="{{ old('price', $product->price) }}" placeholder="Price">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="text" class="form-control" name="stock"
                                        value="{{ old('stock', $product->stock) }}" placeholder="Stock">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description"
                                        value="{{ old('description', $product->description) }}" placeholder="description">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Product</label>
                                    <input type="file" class="form-control" name="fotoProduct"
                                        value="{{ old('fotoProduct', $product->fotoProduct) }}" placeholder="description">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
