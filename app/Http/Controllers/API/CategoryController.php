<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Authentifizierung erforderlich
        $this->middleware('auth');

        // Nur Admins dürfen diese Methoden verwenden
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->is_admin) {
                return redirect()->route('dashboard.staff')->with('error', 'Nur Admins dürfen diese Aktion durchführen.');
            }

            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // ✅ Für alle sichtbar (Admins und Mitarbeiter)
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // ✅ Nur für Admins
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategorie gelöscht.');
    }
}
