<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Burger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderCompleted;
use App\Notifications\OrderCanceled;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompletedMail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'cancel', 'complete', 'annuler', 'markAsPaid']);
        $this->middleware('isAdmin')->only(['complete', 'annuler', 'markAsPaid']);
    }

    /**
     * Filter orders based on query parameters.
     */
    public function filtre(Request $request)
    {
        $validated = $request->validate([
            'burger_id' => 'nullable|exists:burgers,id',
            'date' => 'nullable|date',
            'status' => 'nullable|in:pending,completed,canceled,paid',
            'client_id' => 'nullable|exists:users,id',
        ]);

        $query = Order::query();

        if (isset($validated['burger_id'])) {
            $query->where('burger_id', $validated['burger_id']);
        }

        if (isset($validated['date'])) {
            $query->whereDate('created_at', $validated['date']);
        }

        if (isset($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (isset($validated['client_id'])) {
            $query->where('user_id', $validated['client_id']);
        }

        $orders = $query->with('burger', 'user')->get();
        $burgers = Burger::all();
        $clients = User::all();

        return response()->json([
            'orders' => $orders,
            'burgers' => $burgers,
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'burgerId' => 'required|integer',
            'amount' => 'required|numeric',
            'status' => 'required|string'
        ]);
    
        $burger = Burger::find($validated['burgerId']);
    
        if (!$burger) {
            return response()->json(['error' => 'Burger non trouvé'], 404);
        }
    
        if (Auth::check()) {
            $order = Order::create([
                'burger_id' => $burger->id,
                'user_id' => Auth::id(),
                'amount' => $validated['amount'],
                'status' => $validated['status'],
            ]);
    
            return response()->json(['success' => 'Commande passée avec succès', 'order' => $order], 201);
        }
    
        return response()->json(['error' => 'Veuillez vous connecter pour passer une commande'], 401);
    }

    /**
     * Cancel the specified order.
     */
    public function cancel(Order $order)
    {
        if ($order->status == 'pending') {
            $order->update(['status' => 'canceled']);
            return response()->json(['success' => 'Commande annulée', 'order' => $order]);
        }
    
        return response()->json(['error' => 'Aucune commande en cours à annuler'], 400);
    }
    
    public function complete(Order $order)
    {
        if ($order->status == 'pending') {
            $order->update(['status' => 'completed']);
            // Generate the PDF
        $pdf = PDF::loadView('emails.invoice', ['order' => $order]);

        // Send the email with the PDF attachment
        Mail::to($order->user->email)->send(new OrderCompletedMail($order, $pdf));
    
            return response()->json(['success' => 'Commande terminée et notification envoyée', 'order' => $order]);
        }
    
        return response()->json(['error' => 'La commande n\'est pas en attente'], 400);
    }
    
    public function annuler(Order $order)
    {
        // Vérifiez que la commande est en attente
        if ($order->status == 'pending') {
            // Mettez à jour le statut de la commande
            $order->update(['status' => 'canceled']);
            
            // Envoyez une notification à l'utilisateur
            Notification::send($order->user, new OrderCanceled($order));
    
            // Répondez avec un message de succès
            return response()->json(['success' => 'Commande annulée par l\'administrateur', 'order' => $order]);
        }
    
        // Répondez avec un message d'erreur si la commande n'est pas en attente
        return response()->json(['error' => 'La commande n\'est pas en attente'], 400);
    }
    
    
    public function markAsPaid(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->payments()->exists()) {
            return response()->json(['error' => 'Cette commande est déjà payée'], 400);
        }

        $paymentAmount = $request->input('montant', $order->burger->prix);
        $paymentDate = $request->input('payment_date', now());

        $order->payments()->create([
            'montant' => $paymentAmount,
            'payment_date' => $paymentDate,
        ]);

        $order->status = 'paid';
        $order->save();

        // Generate the PDF
        $pdf = PDF::loadView('emails.invoice', ['order' => $order]);

        // Send the email with the PDF attachment
        Mail::to($order->user->email)->send(new OrderCompletedMail($order, $pdf));
        
        return response()->json(['success' => 'Commande marquée comme payée, paiement enregistré, et email envoyé.']);
    }
    
    

    public function getStatus($burgerId, Request $request)
{
    try {
        $userId = $request->query('userId');
        \Log::info("burgerId: $burgerId, userId: $userId");

        $order = Order::where('burger_id', $burgerId)
                      ->where('user_id', $userId)
                      ->first();
        
        return response()->json(['order' => $order]);
    } catch (\Exception $e) {
        \Log::error('Error in getStatus: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    

    public function index()
{
    $orders = Order::all();
    return response()->json($orders);
}
}
