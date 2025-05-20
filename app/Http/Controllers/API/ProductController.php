<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // Auth via Sanctum für alle Methoden
        $this->middleware('auth:sanctum');

        // Admin-Check nur für schreibende Methoden (store, update, destroy)
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'error' => 'Nur Admins dürfen diese Aktion durchführen.'
                ], 403);
            }
            return $next($request);
        })->only(['store', 'update', 'destroy']);
    }

    // GET /api/products - Liste aller Produkte mit Kategorie laden
    public function index()
    {
        $products = Product::with('category')->get();  // Eager Loading für Kategorie
        return response()->json($products, 200);
    }

    // POST /api/products - Produkt erstellen
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Produkt erfolgreich erstellt.',
            'product' => $product
        ], 201);
    }

    // GET /api/products/{product} - Einzelnes Produkt anzeigen
    public function show(Product $product)
    {
        $product->load('category');  // Kategorie laden
        return response()->json($product, 200);
    }

    // PUT/PATCH /api/products/{product} - Produkt aktualisieren
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Produkt erfolgreich aktualisiert.',
            'product' => $product
        ], 200);
    }

    // DELETE /api/products/{product} - Produkt löschen
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Produkt gelöscht.'
        ], 200);
    }
}
