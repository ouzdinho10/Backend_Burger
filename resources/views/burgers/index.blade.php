@extends('layouts.master')
@section('content')
<div class="row my-4">
        <div class="col-md-4">
            <div class="card bg-light border border-primary">
                    <h3 class="card-header">
                        Recherche
                    </h3>
                    <div class="card-body">
                        <form action="{{route('burgers.index')}}" method="get">
                            @csrf
                            <div class="form-group">
                                <label for="search">Recherche</label>
                                <input type="text" name="search" id="" class="form-control" placeholder="Recherche..." aria-describedby="helpId">
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
            <h3 class="card-header">{{$title}} <span class="badge badge-primary text-primary">{{$count}}</span></h3>    
            <div class="card-body">
                        <div class="media mb-2">
                        @foreach($burgers as $burger)
<div class="media mb-2">
    <div class="media-left">
        <img src="{{ $burger->image }}" width="100" height="100" alt="" class="img-fluid rounded-circle">
    </div>
    <div class="media-body">
        <h3 class="text-info">
            <a href="{{route('burgers.show', $burger->id)}}" class="btn btn-link">{{ $burger->nom }}</a>
        </h3>
        <p class="d-flex flex-row justify-content-start">
            <span class="badge badge-danger mx-2 text-danger">prix: {{ $burger->prix }} FCFA</span>
            
        </p>
    </div>
    <hr>
</div>
@endforeach
                               
                        </div>
                        <div class="d-flex justify-content-center">
                        <div class="row">
                                <div class="col-md-12">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item {{ $burgers->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $burgers->previousPageUrl() }}" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            @for ($i = 1; $i <= $burgers->lastPage(); $i++)
                                                <li class="page-item {{ $burgers->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $burgers->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor
                                            <li class="page-item {{ $burgers->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $burgers->nextPageUrl() }}" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
        </div>
                

</div>
@endsection