<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Authentifizierung via Sanctum (oder 'auth:api' je nach Setup)
        $this->middleware('auth:sanctum');
    }

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     summary="Profil des angemeldeten Benutzers anzeigen",
     *     tags={"Profil"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Erfolgreiche Antwort mit Benutzerprofil",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     * )
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/profile",
     *     summary="Profildaten des angemeldeten Benutzers aktualisieren",
     *     tags={"Profil"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProfileUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil erfolgreich aktualisiert",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profil erfolgreich aktualisiert."),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Nicht autorisiert")
     * )
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil erfolgreich aktualisiert.',
            'user' => $user,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/profile",
     *     summary="Benutzerkonto löschen",
     *     tags={"Profil"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="password", type="string", format="password", example="GeheimesPasswort123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Benutzerkonto erfolgreich gelöscht",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Benutzerkonto wurde gelöscht.")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Falsches Passwort oder nicht autorisiert")
     * )
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Das Passwort ist falsch.',
            ], 403);
        }

        Auth::logout();

        $user->delete();

        return response()->json([
            'message' => 'Benutzerkonto wurde gelöscht.',
        ], 200);
    }
}
