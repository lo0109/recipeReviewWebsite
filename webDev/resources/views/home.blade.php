@extends('layouts.main')

@section('title')
  Home
@endsection

@section('content')

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach($recipes as $recipe)
          <div class="col">
            <div class="card shadow-sm">
              <img src="{{$recipe->img}}" alt="{{$recipe->recipe}}" class="img-fluid">
              <div class="card-body">
                <p class="card-text">{{$recipe->recipe}}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Bookmark</button>
                  </div>
                  <small class="text-body-secondary">Total time: {{$recipe->preparation_time + $recipe->cook_time}} mins</small>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection