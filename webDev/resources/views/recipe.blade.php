@extends('layouts.main')

@section('title')
  Recipe: {{$recipe->recipe}}
@endsection

@section('content')
<div class="container">
  <div class="row">
	
		<!-- Left Column: Ingredients -->
		<div class="col-md-3">
			<img src="{{url("$recipe->img")}}" alt="{{$recipe->recipe}}" class="img-fluid">
			<h4>Ingredients</h4>
			<ul>
				@foreach(explode(';', $recipe->ingredients) as $ingredient)
					<li>{{ $ingredient }}</li>
				@endforeach
			</ul>
			<p>Preparation Time: {{$recipe->preparation_time}} mins</p>
			<p>Cooking Time: {{$recipe->cook_time}} mins</p>
			<p>Calories: {{$recipe->calories}} kcal</p>
			<p>Category: {{$recipe->category}}</p>

		</div>

		<!-- Middle Column: Instructions -->
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-9">
					<h1>{{ $recipe->recipe}}</h1>
				</div>
				<div class="col-md-3">
					<small>Updated by: {{$author_name ?? 'Admin'}}</small><br>
					<small>On: {{$recipe->update_time ?? 'No update'}}</small>
					@if(session()->has('user_name'))
						<a class="btn btn-warning" href='/edit_item/{{$recipe->id}}'>Edit Recipe</a>
						<form action="/delete_item/{{$recipe->id}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
							@csrf
							<button type="submit" class="btn btn-danger">Delete Recipe</button>
						</form>
					@endif
				</div>
			</div>
			<h4>Instructions</h4>
			@php $i = 0; @endphp
			@foreach(explode(';', $recipe->instructions) as $instruction)
			<p>Step {{$i+=1}}</p>
			<p>{{ $instruction }}</p>
			@endforeach
		</div>

		<!-- Right Column: Comment Form -->
		
		<div class="col-md-3">
			<!-- Display login form if user is not logged in -->
			@if(!session()->has('user_name'))
				<h5>Login/SignUp to leave a comment</h5>
				<form action="/login" method="POST">
					@csrf
					<div class="mb-3">
						<input type="email" class="form-control" name="email" placeholder="Enter your email" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Login/SignUp</button>
				</form>
			@elseif($userHasCommented)
				<h5>You have already left a comment.</h5>
			@else
				<form action="/comment/{{$recipe->id}}" method="POST">
				@csrf <!-- This generates the CSRF token for security -->
				<input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
				<p>{{$recipe->id}}</p>
				<div class="mb-3">
					<h4>Leave a Comment</h4>
					<strong>Your Name: {{session('user_name')}}</strong>
				</div>
				<div class="mb-3">
					<label for="comment" class="form-label">Comment</label>
					<input class="form-control" id="comment" name="comment" rows="4" placeholder="Pleaes enter at least 3 words." pattern="(\b[A-Za-z]+\b[\s]*){3,}" title="Please enter at least 3 words." required></input>
					@if (!empty($error))
						<div class="alert alert-danger">{{ $error }}</div>
					@endif
				</div>
				<div class="mb-3">
					<label>Rating: </label>
					@for ($i = 1; $i <= 5; $i++)
						<input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value="{{$i}}" required>
						<label>{{$i}}</label>
					@endfor
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
				</form><br>
			@endif
			<div>
				<h4>Comments</h4>
				<div style="max-height: 300px; overflow-y: auto;">
					<!-- Display existing comments for this recipe -->
					@if (!empty($comments))
						@foreach($comments as $comment)
						<div class="mb-3">
							<p>User: {{ $comment->user_name }}	Rating: {{ $comment->rating }}</p>
							<p>Comment date:{{$comment-> c_date}}</p>
							<p>{{ $comment->comment }}</p>
							@if (session()->has('user_id') && session('user_id') == $comment->user_id)
									<button class="btn btn-warning" href="">Edit</button>
									<button type="submit" class="btn btn-danger" href="">Delete</button>
							@endif
							<hr>
						</div>
						@endforeach
					@else
					<div class="mb-3">
						<strong>Be the first one to comment.</strong><br>
					</div>
					@endif
				</div>
			</div>
		</div>
  </div>
</div>
@endsection

<!-- @section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const commentInput = document.getElementById('comment');
        commentInput.addEventListener('input', function () {
            const pattern = /(\b[A-Za-z]+\b[\s]*){3,}/;
            if (commentInput.validity.patternMismatch) {
                commentInput.setCustomValidity("Please enter at least 3 words in your comment.");
            } else {
                commentInput.setCustomValidity(''); // Reset the message
            }
        });
        

    });
</script>
@endsection -->