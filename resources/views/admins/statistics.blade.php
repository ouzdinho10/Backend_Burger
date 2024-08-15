@extends('layouts.master')

@section('content')
<div class="container my-4">
    <h2>Statistiques du jour</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commandes en cours</h5>
                    <p class="card-text">{{ $ongoingOrders->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commandes validées</h5>
                    <p class="card-text">{{ $completedOrders->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Commandes annulées</h5>
                    <p class="card-text">{{ $canceledOrders->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recettes journalières</h5>
                    <p class="card-text">{{ number_format($dailyRevenue, 2) }} €</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
