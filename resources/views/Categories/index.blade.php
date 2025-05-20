@extends('layouts.app')

@section('content')
<style>
    .product-row {
        display: none;
    }

    @media print {
        .product-row {
            display: table-row !important;
            opacity: 1 !important;
            height: auto !important;
            overflow: visible !important;
        }
    }
</style>

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Kategorienübersicht</h1>

        @if(Auth::user()->is_admin)
            <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                + Neue Kategorie
            </a>
        @endif
    </div>

    @if ($categories->isEmpty())
        <p class="text-gray-700">Es wurden noch keine Kategorien erstellt.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Erstellt am</th>
                        <th class="border border-gray-300 px-4 py-2">Produkte</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="category-row hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $category->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $category->created_at->format('d.m.Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <button class="toggle-products-btn text-red-600 hover:underline" data-category-id="{{ $category->id }}">
                                    Produkte anzeigen
                                </button>
                            </td>
                        </tr>
                        <tr class="product-row" data-category-id="{{ $category->id }}">
                            <td colspan="4" class="border-t border-b border-gray-300 bg-gray-50 px-4 py-2 text-left">
                                @if ($category->products->count())
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($category->products as $product)
                                            <li>
                                                <span class="font-semibold">{{ $product->name }}</span> – {{ number_format($product->price, 2, ',', '.') }} €
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500 italic">Keine Produkte in dieser Kategorie.</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.toggle-products-btn');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const categoryId = button.getAttribute('data-category-id');
                const productRow = document.querySelector(`.product-row[data-category-id="${categoryId}"]`);

                if (productRow.style.display === 'table-row') {
                    productRow.style.display = 'none';
                    button.textContent = 'Produkte anzeigen';
                } else {
                    productRow.style.display = 'table-row';
                    button.textContent = 'Produkte ausblenden';
                }
            });
        });
    });

    window.onbeforeprint = () => {
        document.querySelectorAll('.product-row').forEach(row => {
            row.style.display = 'table-row';
        });
    };

    window.onafterprint = () => {
        document.querySelectorAll('.product-row').forEach(row => {
            row.style.display = 'none';
        });
        document.querySelectorAll('.toggle-products-btn').forEach(button => {
            button.textContent = 'Produkte anzeigen';
        });
    };
</script>
@endsection
