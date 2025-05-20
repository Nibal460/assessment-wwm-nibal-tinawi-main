<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Liste aller Produkte abrufen",
     *     tags={"Produkte"},
     *     @OA\Response(
     *         response=200,
     *         description="Erfolgreiche Antwort mit Produktliste",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $products = Product::with('category')->get();
        return response()->json($products, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Neues Produkt erstellen",
     *     tags={"Produkte"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produkt erfolgreich erstellt",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=403, description="Nicht autorisiert")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/products/{product}",
     *     summary="Produktdetails abrufen",
     *     tags={"Produkte"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID des Produkts",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produktdetails",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=404, description="Produkt nicht gefunden")
     * )
     */
    public function show(Product $product): JsonResponse
    {
        $product->load('category');
        return response()->json($product, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{product}",
     *     summary="Produkt aktualisieren",
     *     tags={"Produkte"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID des Produkts",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductCreateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produkt erfolgreich aktualisiert",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=403, description="Nicht autorisiert"),
     *     @OA\Response(response=404, description="Produkt nicht gefunden")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/products/{product}",
     *     summary="Produkt löschen",
     *     tags={"Produkte"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID des Produkts",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produkt erfolgreich gelöscht",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Produkt gelöscht.")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Nicht autorisiert"),
     *     @OA\Response(response=404, description="Produkt nicht gefunden")
     * )
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Produkt gelöscht.'
        ], 200);
    }


/**
 * @OA\Get(
 *     path="/api/products/search",
 *     summary="Suche nach Produkten",
 *     tags={"Produkte"},
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         description="Name des Produkts (Teilsuche)",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="Kategorie-ID",
 *         required=false,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="min_price",
 *         in="query",
 *         description="Mindestpreis",
 *         required=false,
 *         @OA\Schema(type="number", format="float")
 *     ),
 *     @OA\Parameter(
 *         name="max_price",
 *         in="query",
 *         description="Höchstpreis",
 *         required=false,
 *         @OA\Schema(type="number", format="float")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Liste der gefundenen Produkte",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Product")
 *         )
 *     )
 * )
 */

    public function search(Request $request)
{
    $query = Product::query();

    if ($request->filled('name')) {
        $query->where('name', 'LIKE', '%' . $request->name . '%');
    }

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    return response()->json($query->get());
}

}
