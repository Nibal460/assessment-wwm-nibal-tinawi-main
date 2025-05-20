<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // Auth via Sanctum
        $this->middleware('auth:sanctum');

        // Admin-Check für bestimmte Methoden
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'error' => 'Nur Admins dürfen diese Aktion durchführen.'
                ], 403);
            }

            return $next($request);
        })->only(['store', 'update', 'destroy']);
    }

    // Für alle Authentifizierten
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Produkt erfolgreich erstellt.',
            'product' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produkt erfolgreich aktualisiert.',
            'product' => $product
        ], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produkt gelöscht.'
        ], 200);
    }
}
