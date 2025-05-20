@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Neues Produkt erstellen</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Preis (€):</label>
            <input type="number" name="price" id="price" step="0.01" class="w-full border rounded px-3 py-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700">Kategorie:</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 mt-1" required>
                <option value="">-- Bitte wählen --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

<div class="flex justify-center mt-4">
    <button type="submit" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-bold py-2 px-4 rounded transition duration-200">
        Erstellen
    </button>
</div>



    </form>
</div>
@endsection
