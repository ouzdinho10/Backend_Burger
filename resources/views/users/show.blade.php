@extends('layouts.master')
@section('content')
<div class="row my-4">
        <div class="col-md-4">
                <div class="card text-left">
                    <img src="{{$user->image}}" alt="" class="card-img-top">
                    <div class="card-body">
                        <h4 class="card-title">{{$user->name}}</h4>
                        <p class="card-text d-flex flex-row align-items-center">
                            <span class="badge badge-primary text-primary mr-2">{{$user->tel}}</span>
                            <span class="badge badge-primary text-danger">{{$user->ville}}</span>
                        </p>
                    </div>
                </div>
        </div>
        <div class="col md-8">
            <h3>Mes Commandes</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Marque</th>
                        <th>Type</th>
                        <th>Prix Journée</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Prix TTC</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @if(auth()->user())
                   @foreach(auth()->user()->commands as $command)
                   <tr>
                        <th>{{App\Models\Vehicule::findOrFail($command->vehicule_id)->marque}}</th>
                        <th>{{App\Models\Vehicule::findOrFail($command->vehicule_id)->type}}</th>
                        <th>{{App\Models\Vehicule::findOrFail($command->vehicule_id)->prixJ}}</th>
                        <th>{{$command->dateL}}</th>
                        <th>{{$command->dateR}}</th>
                        <th>{{$command->prixTTC}}</th>
                        <th>
                                <form action="{{route('commands.delete', [$command->id,$command->vehicule_id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" href="" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                 </form>
                        </th>

                       
                    </tr>
                   @endforeach
                   @endif
                </tbody>

            </table>
        </div>
</div>
@endsection