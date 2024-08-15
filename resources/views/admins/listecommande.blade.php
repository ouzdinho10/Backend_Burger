@extends('layouts.master')

@section('content')
<div class="container my-4">
    <h2>Commandes</h2>
    
    <!-- Formulaire de filtrage -->
    <form action="{{ route('orders.filtre') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="burger_id">Burger</label>
                    <select name="burger_id" id="burger_id" class="form-control">
                        <option value="">Tous les burgers</option>
                        @foreach($burgers as $burger)
                            <option value="{{ $burger->id }}" {{ request('burger_id') == $burger->id ? 'selected' : '' }}>
                                {{ $burger->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="status">État</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Tous les états</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Annulé</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Payé</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="client_id">Client</label>
                    <select name="client_id" id="client_id" class="form-control">
                        <option value="">Tous les clients</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
    </form>

    <a href="{{ route('admins.statistics') }}" class="btn btn-primary mr-2">Statistiques</a>

    <!-- Tableau des commandes -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Utilisateur</th>
                <th scope="col">Burger</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td>{{ $order->user->nom }}</td>
                <td>{{ $order->burger->nom }}</td>
                <td>
                    @switch($order->status)
                        @case('pending') En attente @break
                        @case('completed') Terminé @break
                        @case('canceled') Annulé @break
                        @case('paid') Payé @break
                    @endswitch
                </td>
                <td>
                    @if ($order->status == 'pending')
                        <form action="{{ route('order.complete', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success m-2">Marquer comme terminé</button>
                        </form>
                        <form action="{{ route('order.annuler', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger m-2">Annuler la commande</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Aucune commande trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
