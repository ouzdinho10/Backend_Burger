@extends('layouts.master')

@section('content')
<div class="row my-4">
    <div class="col-md-4">
        <div class="card bg-light border border-primary">
            <h3 class="card-header">Recherche</h3>
            <div class="card-body">
                <form action="{{ route('burgers.index') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="search">Recherche</label>
                        <input type="text" name="search" class="form-control" placeholder="Recherche..." aria-describedby="helpId">
                        <small id="helpId" class="text-muted">&nbsp;</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border border-primary">
            <h3 class="card-header">{{ $burger->nom }}</h3>
            <div class="card-img-top">
                <img src="{{ $burger->image }}" alt="" class="img-fluid rounded m-2">
            </div>
            <div class="media-body">
                <p class="d-flex flex-row justify-content-start">
                    <span class="badge badge-danger mx-2 text-danger">Description: {{ $burger->description }}</span><br>
                    <span class="badge badge-primary text-primary">Prix: {{ $burger->prix }} FCFA</span>

                    @if($burger->status == 'active')
                        @auth
                            @php
                                $order = App\Models\Order::where('user_id', auth()->id())
                                            ->where('burger_id', $burger->id)
                                            ->where('status', '!=', 'canceled')
                                            ->first();
                            @endphp

                            @if($order)
                                @if($order->status == 'pending')
                                    <p>
                                        <span class="badge badge-info">Merci de patienter</span>
                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger m-2">Annuler Commande</button>
                                        </form>
                                    </p>
                                @elseif($order->status == 'completed')
                                    <p>
                                        <span class="badge badge-success">Commande terminée</span>
                                        <form action="{{ route('order.pay', $order->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="montant" value="{{ $burger->prix }}">
                                            <input type="hidden" name="payment_date" value="{{ now() }}">
                                            <button type="submit" class="btn btn-success m-2">Payer</button>
                                        </form>
                                    </p>
                                @elseif($order->status == 'paid')
                                    <p>
                                        <span class="badge badge-success">Commande payée</span>
                                        <form action="{{ route('command.create', $burger->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary m-2">Commander</button>
                                        </form>
                                    </p>
                                @endif
                            @else
                                <form action="{{ route('command.create', $burger->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary m-2">Commander</button>
                                </form>
                            @endif
                        @else
                            <p>
                                <a href="{{ route('users.login') }}" class="btn btn-primary m-2">Réserver</a>
                            </p>
                        @endauth
                    @else
                        <span class="badge badge-warning text-warning">Réservé</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
