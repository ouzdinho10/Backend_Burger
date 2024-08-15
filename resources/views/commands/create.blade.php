@extends('layouts.master')
@section('content')
<div class="row my-4">
    <div class="col-md-8 mx-auto">
        <div class="card border border-primary shadow-sm">
            <h3 class="card-header">Commander cette voiture</h3>  
            <div class="row my-3">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <div class="card">
                            <h3 class="text-info p-4">{{$burger->nom}}</h3> 
                            <div class="card-img-top">
                                <img src="{{ $burger->image }}" alt="" class="img-fluid rounded m-2">
                            </div>   
                            <div class="media-body">
                                <p class="d-flex flex-row justify-content-start">
                                    <span class="badge badge-danger mx-2 text-danger">Description: {{ $burger->description }}</span>
                                    <span class="badge badge-primary text-primary">Prix: {{ $burger->prix }} FCFA</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <div>
                <form action="{{route('commands.store')}}" method="post">
                    @csrf
                    <div class="form-group m-2">
                        <label for="dateL">Date Début</label>
                        <input type="date" name="dateL" id="" class="form-control" placeholder="Date Début..." aria-describedby="helpId">
                    </div>
                    <div class="form-group m-2">
                        <label for="dateR">Date Fin</label>
                        <input type="date" name="dateR" id="" class="form-control" placeholder="Date Fin..." aria-describedby="helpId">
                        <input type="hidden" name="vehicule_id" value="{{$vehicule->id}}">   
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>     
            </div>
        </div>
    </div>
</div>
@endsection
