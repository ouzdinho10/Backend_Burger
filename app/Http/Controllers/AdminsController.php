<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Burger;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class AdminsController extends Controller
{
    public function index()
    {
        $burgers = Burger::orderBy('created_at', 'DESC')->paginate(5);

        return response()->json([
            'burgers' => $burgers
        ]);
    }

    /**
     * Display a listing of all orders, burgers, and clients.
     */
    public function commande()
    {
        $orders = Order::with('user', 'burger')->get(); 
        $burgers = Burger::all();
        $clients = User::all();

        return response()->json([
            'orders' => $orders,
            'burgers' => $burgers,
            'clients' => $clients
        ]);
    }

    /**
     * Display daily statistics.
     */
    public function statistic()
    {
        // Date actuelle
        $today = Carbon::today();

        // Commandes en cours de la journée
        $ongoingOrders = Order::whereDate('created_at', $today)
            ->where('status', 'pending')
            ->get();

        // Commandes validées de la journée
        $completedOrders = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->get();

        // Commandes annulées de la journée
        $canceledOrders = Order::whereDate('created_at', $today)
            ->where('status', 'canceled')
            ->get();

        // Recettes journalières
        $dailyRevenue = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('amount'); // Assurez-vous que le champ 'amount' est bien le montant des commandes

        return response()->json([
            'ongoingOrders' => $ongoingOrders,
            'completedOrders' => $completedOrders,
            'canceledOrders' => $canceledOrders,
            'dailyRevenue' => $dailyRevenue
        ]);
    }
    
}
