@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Produkt bearbeiten</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Produktname -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Produktname</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Preis -->
        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-semibold mb-2">Preis (€)</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Kategorie -->
        <div class="mb-6">
            <label for="category_id" class="block text-gray-700 font-semibold mb-2">Kategorie</label>
            <select name="category_id" id="category_id"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="border border-black text-black font-bold py-2 px-4 rounded hover:bg-gray-100">
    Aktualisieren
        </button>

    </form>
</div>
@endsection
