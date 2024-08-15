@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-8 mx-auto">
                    <div class="card bg-light">
                        <h3 class="card-header">Modifier une voiture</h3>
                        <div class="card-body">
                                    <form action="{{ route('burgers.update', $burger->id) }}" method="post"  enctype="multipart/form-data">
                                @csrf
                                {{method_field('put')}}
                                <!-- Add form fields here -->
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" name="nom" class="form-control" id="" value="{{$burger->nom}}" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea  name="description" class="form-control" id="" value="{{$burger->description}}" placeholder="Description"></textarea>
                                </div>
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="status" id=""  class="form-control">
                                                <option value="" selected disabled>Veillez choisir le status</option>
                                                <option value="active" {{$burger->status == 'Active' ? 'selected' : ''}}>Active</option>
                                                <option value="archived" {{$burger->status == 'Archived' ? 'selected' : ''}}>Archived</option>
                                        </select>
                                    </div>

                                <div class="form-group">
                                    <label for="model">Prix</label>
                                    <input type="number" name="prix" class="form-control" id="" value="{{$burger->prix}}" placeholder="Prix">
                                </div>
        
                                    <div class="form-group">
                                    <img src="{{ asset($burger->image)}}" width="100" height="100" alt="" class="img-fluid">
                                    </div>
                                    <div class="form-group">
                                    <label for="image">Photo</label>
                                    <input type="file" name="image" class="form-control" id="">
                                    </div>
                   
                                <!-- Add other form fields as needed -->
                                <!-- Add submit button -->
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection