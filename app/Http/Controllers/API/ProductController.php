<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // Auth via Sanctum für alle Methoden
        $this->middleware('auth:sanctum');

        // Admin-Check nur für Store, Update, Destroy
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->is_admin) {
                return response()->json([
                    'error' => 'Nur Admins dürfen diese Aktion durchführen.'
                ], 403);
            }
            return $next($request);
        })->only(['store', 'update', 'destroy']);
    }

    // GET /api/products
    public function index(): JsonResponse
    {
        $products = Product::with('category')->get(); // Kategorie laden
        return response()->json($products, 200);
    }

    // POST /api/products
    public function store(Request $request): JsonResponse
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

    // GET /api/products/{product}
    public function show(Product $product): JsonResponse
    {
        $product->load('category'); // Kategorie nachladen
        return response()->json($product, 200);
    }

    // PUT/api/products/{product}
    public function update(Request $request, Product $product): JsonResponse
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

    // DELETE /api/products/{product}
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Produkt gelöscht.'
        ], 200);
    }
}
