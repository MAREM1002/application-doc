<?php
// app/Http/Controllers/CardController.php

/* namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();
        return view('dashboard', compact('cards'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
        ]);

        $card = Card::create($validatedData);

        return response()->json($card);
    }
}
 */
namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        // Récupère toutes les cartes pour les afficher dans la vue
        $cards = Card::all();
        return view('dashboard', compact('cards'));
    }

    public function store(Request $request)
    {
        // Valide les données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        // Crée une nouvelle carte
        Card::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
        ]);

        // Redirige vers le tableau de bord avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Card added successfully!');
    }

    public function destroy(Card $card)
    {
        // Supprime la carte
        $card->delete();

        // Redirige vers le tableau de bord avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Card deleted successfully!');
    }
}
