<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Http\Requests\StoreBurgerRequest;
use App\Http\Requests\UpdateBurgerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class BurgerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
        $this->middleware('isAdmin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 5; // Nombre de burgers par page
        $searchQuery = $request->input('search');
        $page = $request->input('page', 1);

        $query = Burger::query();

        if ($searchQuery) {
            $query->where('nom', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$searchQuery}%");
        }

        $burgers = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $burgers->items(),
            'totalPages' => $burgers->lastPage(),
            'totalCount' => $burgers->total(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric',
        'image' => 'nullable|image',
        'status' => 'required|in:active,archived'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $burger = new Burger();
    $burger->nom = $request->nom;
    $burger->description = $request->description;
    $burger->prix = $request->prix;
    $burger->status = $request->status;

   // Traitement de l'image
   if ($request->hasFile('image')) {
    // Déplacer l'image dans le répertoire public/images
    $file = $request->file('image');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('images'), $fileName);
    
    // Stocker le nom de l'image dans la base de données
    $burger->image = 'images/' . $fileName;
}
    $burger->save();

    return response()->json($burger, Response::HTTP_CREATED);
}
    /**
     * Display the specified resource.
     */
    public function show(Burger $burger)
    {
        return response()->json($burger);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Burger $burger)
{
    // Vérifiez si le burger est en cours de commande
    $order = Order::where('burger_id', $burger->id)->where('status', 'pending')->first();
    if ($order) {
        return response()->json(['error' => 'Le burger ne peut pas être modifié car il est en cours de commande.'], Response::HTTP_FORBIDDEN);
    }
    $validator = Validator::make($request->all(), [
        'nom' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'prix' => 'sometimes|required|numeric',
        'image' => 'nullable|image',
        'status' => 'sometimes|required|in:active,archived'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    if ($request->has('nom')) {
        $burger->nom = $request->nom;
    }
    if ($request->has('description')) {
        $burger->description = $request->description;
    }
    if ($request->has('prix')) {
        $burger->prix = $request->prix;
    }
    if ($request->has('status')) {
        $burger->status = $request->status;
    }

    // Traitement de l'image
    if ($request->hasFile('image')) {
        // Supprime l'ancienne image
        if ($burger->image) {
            Storage::delete($burger->image);
        }
        $path = $request->file('image')->store('images');
        $burger->image = $path;
    }

    $burger->save();

    return response()->json($burger);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Burger $burger)
    {
        // Vérifie si le burger est en commande
        if (Order::where('burger_id', $burger->id)->exists()) {
            return response()->json(['message' => 'Burger ne peut être supprimé car il est en commande'], Response::HTTP_CONFLICT);
        }

        // Supprimer l'image
        if ($burger->image) {
            Storage::delete($burger->image);
        }

        $burger->delete();

        return response()->json(['message' => 'Burger supprimé']);
    }

    /**
     * Mark an order as completed
     */
    public function markAsCompleted($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'completed';
        $order->save();

        return response()->json(['message' => 'Order marked as completed']);
    }
}
