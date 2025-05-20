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

        // Schutz für Admin-Funktionen
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                return redirect()->route('dashboard.staff')->with('error', 'Nur Admins dürfen diese Aktion durchführen.');
            }

            return $next($request);
        })->only(['create', 'store', 'update', 'destroy']);
    }

    // ✅ Für alle (auch Mitarbeiter)
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

    // ✅ Nur Admins (durch Middleware geschützt)
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich erstellt.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategorie erfolgreich aktualisiert.');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categories.index')->with('success', 'Kategorie gelöscht.');
    }
}