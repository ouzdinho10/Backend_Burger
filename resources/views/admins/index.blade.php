<!-- resources/views/burgers/index.blade.php -->
@extends('layouts.master')

@section('content')
<div class="row my-4">
    <div class="col-md-12">
        @if(auth()->user()->role == 'admin')
            <div class="form-group">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addCar"><i class="fa fa-plus"></i></button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($burgers as $burger)
                        <tr>
                            <td>{{$burger->id}}</td>
                            <td>{{$burger->nom}}</td>
                            <td>{{$burger->description}}</td>
                            <td>{{$burger->prix}}</td>
                            <td>{{$burger->status}}</td>
                            <td>
                                <img src="{{$burger->image}}" width="60" height="60" class="img-fluid" alt="">
                            </td>
                            <td class="d-flex flex-row justify-content-center">
                                <a href="{{route('burgers.edit', $burger->id)}}" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></a>
                                <form action="{{route('burgers.destroy', $burger->id)}}" method="post">
                                    @csrf
                                    {{method_field('delete')}}
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="justify-content-center">
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

<!-- Modal -->
<div class="modal fade" id="addCar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une voiture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding car -->
                <form action="{{ route('burgers.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Add form fields here -->
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="" selected disabled>Veuillez choisir un status</option>
                            <option value="active">Active</option>
                            <option value="archived">Archivé</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="number" name="prix" class="form-control" placeholder="Prix">
                    </div>
                    <div class="form-group">
                        <label for="image">Photo</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <!-- Add submit button -->
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
