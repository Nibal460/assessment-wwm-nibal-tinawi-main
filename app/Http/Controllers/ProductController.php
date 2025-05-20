<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Authentifizierung erforderlich
        $this->middleware('auth');

        // Nur Admins dürfen diese Methoden verwenden
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                return redirect()->route('dashboard.staff')->with('error', 'Nur Admins dürfen diese Aktion durchführen.');
            }

            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // Für alle sichtbar (Admin und Mitarbeiter)
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Nur Admins (durch Middleware geschützt)
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produkt erfolgreich erstellt.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produkt erfolgreich aktualisiert.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produkt gelöscht.');
    }
}