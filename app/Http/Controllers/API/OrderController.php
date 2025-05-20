<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Bestellung anlegen mit Produkten und Bestandsverwaltung.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validierung (empfohlen: eigene FormRequest Klasse)
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            // 'total_price' => $request->input('total_price'), // Optional
        ]);

        foreach ($request->input('products') as $productData) {
            $product = Product::findOrFail($productData['id']);

            // Produkte der Bestellung hinzufügen mit Menge
            $order->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
            ]);

            // Lagerabgang erfassen
            InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => 'out',
                'quantity' => $productData['quantity'],
            ]);

            // Lagerbestand reduzieren
            $product->quantity -= $productData['quantity'];
            $product->save();
        }

        return response()->json(['message' => 'Bestellung erfolgreich erstellt'], 201);
    }

    /**
     * Lagerbestand eines Produkts erhöhen.
     *
     * @param Request $request
     * @param int $productId
     * @return JsonResponse
     */
    public function addStock(Request $request, int $productId): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        $product->quantity += $request->input('quantity');
        $product->save();

        // Lagerzugang erfassen
        InventoryTransaction::create([
            'product_id' => $product->id,
            'type' => 'in',
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json(['message' => 'Bestand aktualisiert'], 200);
    }
}
