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
		</div>

		<!-- Middle Column: Instructions -->
		<div class="col-md-6">
			<h1>{{ $recipe->recipe }}</h1>
			<h4>Instructions</h4>
			@php $i = 0; @endphp
			@foreach(explode(';', $recipe->instructions) as $instruction)
			<p>Step {{$i+=1}}</p>
			<p>{{ $instruction }}</p>
			@endforeach
		</div>

		<!-- Right Column: Comment Form -->
		<div class="col-md-3">
			<h4>Leave a Comment</h4>
			<form action="/comment/{{$recipe->id}}" method="POST">
			@csrf <!-- This generates the CSRF token for security -->
			<div class="mb-3">
				<label for="name">Your Name</label>
				<input type="text" class="form-control" id="user_name" name="user_name" placeholder="Please input your name" required>
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Your Email</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Please input your email." required>
			</div>
			<div class="mb-3">
				<label for="comment" class="form-label">Comment</label>
				<textarea class="form-control" id="comment" name="comment" rows="4" placeholder="comment..." required></textarea>
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
			<div>
				<h4>Comments</h4>
				<div style="max-height: 300px; overflow-y: auto;">
					<!-- Display existing comments for this recipe -->
					@if (!empty($comments))
						@foreach($comments as $comment)
						<div class="mb-3">
							<p>User: {{ $comment->user_name }}</p>
							<p>Rating: {{ $comment->rating }}</p>
							<p>{{ $comment->comment }}</p>
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
