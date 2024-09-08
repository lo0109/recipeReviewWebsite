@extends('layouts.main')

@section('title')
  Edit Comment
@endsection

@section('content')
<div class="container">
    <h1>Edit Comment</h1>
    
    <form action="/comment/update/{{ $comment->id }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <input class="form-control" id="comment" name="comment" rows="4" placeholder="Pleaes enter at least 3 words." pattern="(\b[A-Za-z]+\b[\s]*){3,}" title="Please enter at least 3 words." required>{{ $comment->comment }}</input>
        </div>
        
        <div class="mb-3">
            <label>Rating: </label>
            @for ($i = 1; $i <= 5; $i++)
                <input class="form-check-input" type="radio" name="rating" value="{{ $i }}" 
                    {{ $comment->rating == $i ? 'checked' : '' }} required>
                <label>{{ $i }}</label>
            @endfor
        </div>
        
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
@endsection
