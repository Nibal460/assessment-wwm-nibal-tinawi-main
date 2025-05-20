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
        $this->middleware('auth:sanctum'); // oder 'auth:api' je nach Auth-System
    }

    /**
     * Zeige die Benutzerdaten (Profil).
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    /**
     * Aktualisiere die Benutzerdaten (Profil).
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
            'user' => $user
        ], 200);
    }

    /**
     * Lösche das Benutzerkonto.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Das Passwort ist falsch.'
            ], 403);
        }

        Auth::logout();
        $user->delete();

        return response()->json([
            'message' => 'Benutzerkonto wurde gelöscht.'
        ], 200);
    }
}
