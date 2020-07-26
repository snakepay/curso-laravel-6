@extends('admin.layouts.app')

@section('title', "Editar produto {$product->name}")

@section('content')
    <h1>Editar produto {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        {{-- precisa dessa linha abaixo PUT quando for rota PUT.. senao não pega --}}
        {{-- <input type="hidden" name="_method" value="PUT">  ou desse outro modo--}}
        @method('PUT')
        @include('admin.pages.products._partials.form')
    </form>
@endsection