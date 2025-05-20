<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Kategorien",
 *     description="API Endpoints für Kategorien"
 * )
 */
class CategoryController extends Controller
{
    
    
    /**
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     summary="Kategorie nach ID abrufen",
 *     tags={"Kategorien"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID der Kategorie",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Kategorie gefunden",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Kategorie nicht gefunden"
 *     )
 * )
 **/
public function show(int $id): JsonResponse
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
    }

    return response()->json($category, 200);
}

   /**
 * @OA\Post(
 *     path="/api/categories",
 *     summary="Neue Kategorie erstellen",
 *     tags={"Kategorien"},
 *     security={{"sanctum": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Kategorie erfolgreich erstellt",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Kategorie erfolgreich erstellt."),
 *             @OA\Property(property="category", ref="#/components/schemas/Category")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Ungültige Eingabe"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Nicht autorisiert"
 *     )
 * )
 */

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Kategorie erfolgreich erstellt.',
            'category' => $category
        ], 201);
    }

    /**
 * @OA\Put(
 *     path="/api/categories/{id}",
 *     summary="Kategorie aktualisieren",
 *     tags={"Kategorien"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID der Kategorie",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Erfolgreich aktualisiert",
 *         @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Kategorie nicht gefunden"
 *     )
 * )
 */

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategorie nicht gefunden'], 404);
        }

        $category->update($request->validated());

        return response()->json($category, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{id}",
     *     summary="Kategorie löschen",
     *     tags={"Kategorien"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID der Kategorie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Kategorie erfolgreich gelöscht",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Kategorie erfolgreich gelöscht.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Kategorie nicht gefunden"),
     *     @OA\Response(response=403, description="Nicht autorisiert")
     * )
     */
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
