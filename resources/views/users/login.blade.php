@extends('layouts.master')
@section('content')
<div class="row my-4">
        <div class="col-md-8 mx-auto">
            <div class="card border border-primary shadow-sm">
            <h3 class="card header">Connexion</h3>    
            <div class="card body">
            <form action="{{route('users.auth')}}" method="post">
                @csrf
                
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