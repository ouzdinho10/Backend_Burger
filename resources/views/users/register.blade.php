@extends('layouts.master')
@section('content')
<div class="row my-4">
        <div class="col-md-8 mx-auto">
            <div class="card border border-primary shadow-sm">
            <h3 class="card header">Inscription</h3>    
            <div class="card body">
            <form action="{{route('users.register')}}" method="post">
                @csrf
                
                 <div class="form-group m-2">
                  <label for="prenom">Prenom</label>
                 <input type="text" name="prenom" id="" class="form-control" placeholder="Prénom..." aria-describedby="helpId">
                   </div>
                 <div class="form-group m-2">
                  <label for="nom">Nom</label>
                 <input type="text" name="nom" id="" class="form-control" placeholder="Nom..." aria-describedby="helpId">
                   </div>
                 <div class="form-group m-2">
                  <label for="tel">Téléphone</label>
                 <input type="tel" name="tel" id="" class="form-control" placeholder="Téléphone..." aria-describedby="helpId">
                   </div>
                 <div class="form-group m-2">
                  <label for="ville">Ville</label>
                 <input type="text" name="ville" id="" class="form-control" placeholder="Ville..." aria-describedby="helpId">
                   </div>
                 <div class="form-group m-2">
                  <label for="email">Email</label>
                 <input type="email" name="email" id="" class="form-control" placeholder="Email..." aria-describedby="helpId">
                   </div>
                   <hr>
                 <div class="form-group">
                  <label for="password">Mot de Passe</label>
                 <input type="password" name="password" id="" class="form-control" placeholder="Mot de Passe..." aria-describedby="helpId">
                   <hr>
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