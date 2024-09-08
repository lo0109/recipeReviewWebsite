@extends('layouts.main')

@section('title')
  Categories
@endsection

@section('content')

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach($categories as $cat)
          <div class="col">
            <div class="card shadow-sm">
              @php $rating = $cat->rating; 
              $colour = $rating>=4 ? "text-bg-success" : ($rating>=3? "text-bg-warning" : "text-bg-secondary");
              @endphp
              <span class="{{$colour}}">
                {{$rating ? "Avg rating: $rating" : 'no rating'}}
              </span>  
              <div class="card-body">
                <p class="card-text">{{$cat->category}}</p>
                <p class="card-text">No. of recipes: {{$cat->item_count}}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <a href="/category/{{$cat->id}}" class="btn btn-sm btn-outline-secondary">View</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
