@extends('layouts.main')

@section('title')
  Home
@endsection

@section('content')

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      @if (session('name_altered'))
      <div class="alert alert-warning">
          {{ session('name_altered') }}
      </div>
      @endif
      @if(!empty($select_category))
        <div class="alert alert-primary" role="alert">
          Showing recipes for category: {{ $select_category }}
        </div>
      @endif
      @if(empty($recipes))
        <div class="alert alert-danger" role="alert">
          No recipes found
        </div>
      @else
        <div class="col-sm-2 mb-3">
          <form method="GET" action="/">
            <select class="form-select" name="sort_by" onchange="this.form.submit()">
              <option selected>Default sorting</option>
              <option value="1" {{ request('sort_by') == '1' ? 'selected' : '' }}>Name(asc)</option>
              <option value="2"{{ request('sort_by') == '2' ? 'selected' : '' }}>Name(dsc)</option>
              <option value="3"{{ request('sort_by') == '3' ? 'selected' : '' }}>Rating(asc)</option>
              <option value="4"{{ request('sort_by') == '4' ? 'selected' : '' }}>Rating(dsc)</option>
              <option value="5" {{ request('sort_by') == '5' ? 'selected' : '' }}>Time(asc)</option>
              <option value="6"{{ request('sort_by') == '6' ? 'selected' : '' }}>Time(dsc)</option>
              <option value="7"{{ request('sort_by') == '7' ? 'selected' : '' }}>Calories(asc)</option>
              <option value="8"{{ request('sort_by') == '8' ? 'selected' : '' }}>Calories(dsc)</option>
              <option value="9"{{ request('sort_by') == '9' ? 'selected' : '' }}>No. of Reviews (asc)</option>
              <option value="10"{{ request('sort_by') == '10' ? 'selected' : '' }}>No. of Reviews (dsc)</option>

            </select>
          </form>
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
                <img src="{{url("$recipe->img")}}" alt="{{$recipe->recipe}}" class="img-fluid">
                <div class="card-body">
                  <p class="card-text">{{$recipe->recipe}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <!-- View button - links to recipe/{id} page -->
                      <a href="/recipe/{{$recipe->id}}" class="btn btn-sm btn-outline-secondary">View</a>
                      <!-- Bookmark button with AJAX toggle -->
                      <a href="/category/{{$recipe->category_id}}" class="btn btn-sm btn-outline-secondary">
                        Category:{{ $recipe->category}}
                      </a>      
                  
                    </div>
                    <div>
                    <small>No. of reviews: {{$recipe->review}} </small><br>
                      
                      <small>{{$recipe->calories}} kcal</small><br>
                      <small class="text-body-secondary">Total time: {{$recipe->total_time}} mins</small>
                    </div>
                    </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection

<!-- @section('scripts')
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
@endsection -->
