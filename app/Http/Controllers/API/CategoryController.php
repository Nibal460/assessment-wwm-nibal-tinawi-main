<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Nur authentifizierte Nutzer
        $this->middleware('auth:sanctum');

        // Nur Admins für Schreiboperationen
        $this->middleware(function ($request, $next) {
            if (!Auth::user()?->is_admin) {
                return response()->json(['message' => 'Nicht autorisiert'], 403);
            }
            return $next($request);
        })->only(['store', 'update', 'destroy']);
    }

    // 🟢 GET /api/categories
    public function index(): JsonResponse
    {
        return response()->json(Category::all(), 200);
    }

    // 🟢 GET /api/categories/{id}
    public function show(int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        return response()->json($category, 200);
    }

    // 🛡️ POST /api/categories
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Kategorie erfolgreich erstellt.',
            'category' => $category
        ], 201);
    }

    // 🛡️ PUT /api/categories/{id}
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        $category->update($request->validated());

        return response()->json([
            'message' => 'Kategorie erfolgreich aktualisiert.',
            'category' => $category
        ], 200);
    }

    // 🛡️ DELETE /api/categories/{id}
    public function destroy(int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Kategorie erfolgreich gelöscht.'], 200);
    }
}
