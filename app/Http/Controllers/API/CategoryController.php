<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Nur authentifizierte Nutzer
        $this->middleware('auth:sanctum');
    }

    // 🟢 GET /api/categories
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // 🟢 GET /api/categories/{id}
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        return response()->json($category, 200);
    }

    // 🛡️ POST /api/categories (nur für Admins)
    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Nicht autorisiert'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        return response()->json(['message' => 'Kategorie erstellt', 'category' => $category], 201);
    }

    // 🛡️ PUT /api/categories/{id} (nur für Admins)
    public function update(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Nicht autorisiert'], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json(['message' => 'Kategorie aktualisiert', 'category' => $category], 200);
    }

    // 🛡️ DELETE /api/categories/{id} (nur für Admins)
    public function destroy($id)
    {
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Nicht autorisiert'], 403);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Kategorie gelöscht'], 200);
    }
}
