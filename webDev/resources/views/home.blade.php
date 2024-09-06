@extends('layouts.main')

@section('title')
  Home
@endsection

@section('content')

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
    <div class="col-sm-1">
      <select class="form-select" aria-label="Default select example">
        <option selected>Sort by</option>
        <option value="1">Name</option>
        <option value="2">Rating</option>
        <option value="3">Calories</option>
        <option value="4">Time</option>

      </select>
    </div>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach($recipes as $recipe)
          <div class="col">
            <div class="card shadow-sm">
              @php $rating = $recipe->rating; 
              $colour = $rating>=4 ? "text-bg-success" : ($rating>=3? "text-bg-warning" : "text-bg-secondary");
              @endphp
              <span class="position-absolute top-10 start-10 badge rounded-pill {{$colour}}">
                {{$rating ? "Avg rating: $rating" : 'no rating'}}
              </span>  
              <img src="{{$recipe->img}}" alt="{{$recipe->recipe}}" class="img-fluid">
              <div class="card-body">
                <p class="card-text">{{$recipe->recipe}}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <!-- View button - links to recipe/{id} page -->
                    <a href="{{ route('recipe', $recipe->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    <!-- Bookmark button with AJAX toggle -->
                    <button type="button" class="btn btn-sm btn-outline-secondary bookmark-btn" data-id="{{ $recipe->id }}">
                      {{ $recipe->bookmark ? 'Bookmarked' : 'Bookmark' }}
                    </button>
                 
                  </div>
                  <div>
                    <small>{{$recipe->calories}} kcal</small><br>
                    <small class="text-body-secondary">Total time: {{$recipe->preparation_time + $recipe->cook_time}} mins</small>
                  </div>
                  </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- CSRF Token for AJAX -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Event listener for bookmark buttons
    document.querySelectorAll('.bookmark-btn').forEach(button => {
      button.addEventListener('click', function () {
        let recipeId = this.dataset.id;
        let button = this;

        fetch(`/bookmark/${recipeId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update button label based on the new bookmark status
            button.textContent = data.bookmarked ? 'Bookmarked' : 'Bookmark';
          }
        });
      });
    });
  });
</script>
@endsection
