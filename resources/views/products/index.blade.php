@extends('layouts.app')

@section('content')
<div class="w-full max-w-7xl mx-auto mt-10 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Produkte</h1>

        @if(Auth::user()->is_admin)
        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
            + Neues Produkt
        </a>
        @endif
    </div>

    @if($products->count())
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm text-center bg-white">
            <thead class="bg-gray-100 text-gray-800 font-semibold">
                <tr>
                    <th class="border border-gray-300 px-4 py-3">Name</th>
                    <th class="border border-gray-300 px-4 py-3">Kategorie</th>
                    <th class="border border-gray-300 px-4 py-3">Preis (€)</th>
                    @if(Auth::user()->is_admin)
                    <th class="border border-gray-300 px-4 py-3 w-48">Aktionen</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2 text-left">{{ $product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-left">{{ $product->category->name ?? '–' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-left">
                        {{ number_format($product->price, 2, ',', '.') }} €
                    </td>
                    @if(Auth::user()->is_admin)
                    <td class="border border-gray-300 px-4 py-2">
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:underline">Bearbeiten</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bist du sicher?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Löschen</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-gray-600">Keine Produkte gefunden.</p>
    @endif
</div>
@endsection
