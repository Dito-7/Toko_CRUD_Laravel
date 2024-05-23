@extends('layouts.app')

@section('content')
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($products as $product)
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('storage/images/' . $product->fotoProduct) }}" class="card-img-top" alt="...">

                    <div class="card-body">
                        <h2 class="card-title">{{ $product->name }}</h2>
                        <h3 class="card-text">{{ $product->brand->name }}</h3>

                        <br>
                        <p class="card-text">{{ $product->price }}</p>
                        <p class="card-text">{{ $product->stock }}</p>
                        <p class="card-text">{{ $product->description }}</p>
                        <a class="btn btn-primary" href="/products/{{ $product['id'] }}">Go {{ $product->name }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
