@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Neue Kategorie erstellen</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Kategoriename:</label>
            <input type="text" name="name" id="name" required
                   class="w-full border rounded px-3 py-2 mt-1">
        </div>

        <div class="flex justify-center mt-4">
    <button type="submit" class="border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white font-bold py-2 px-4 rounded transition duration-200">
        Speichern
    </button>
</div>
    </form>
</div>
@endsection
