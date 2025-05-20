<?php

namespace App\Http\Controllers;

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
     * Zeige das Profil des aktuell angemeldeten Benutzers.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ], 200);
    }

    /**
     * Aktualisiere die Profildaten mit validierten Daten.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        // Wenn die E-Mail geändert wurde, setze die Verifizierung zurück
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
     * Lösche das Benutzerkonto nach Passwortbestätigung.
     */
    public function destroy(Request $request): JsonResponse
    {
        // Passwort validieren
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        // Passwort prüfen
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Das Passwort ist falsch.',
            ], 403);
        }

        // User-Session beenden
        Auth::logout();

        // Benutzerkonto löschen
        $user->delete();

        return response()->json([
            'message' => 'Benutzerkonto wurde gelöscht.',
        ], 200);
    }
}
