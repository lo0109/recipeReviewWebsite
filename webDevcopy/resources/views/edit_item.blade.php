@extends('layouts.main')

@section('title')
  Edit Recipe: {{$recipe->recipe}}
@endsection

@section('content')
<div class="container">
  <h1>Edit Recipe: {{$recipe->recipe}}</h1>

  <form action="/edit_item/{{$recipe->id}}" method="POST" enctype="multipart/form-data">
      @csrf
      <!-- Recipe Name -->
      <div class="mb-3">
          <label for="recipe" class="form-label">Recipe Name</label>
          <input type="text" class="form-control" id="recipe" name="recipe" value="{{ $recipe->recipe }}" required>
      </div>

      <!-- Summary -->
      <div class="mb-3">
          <label for="summary" class="form-label">Summary</label>
          <textarea class="form-control" id="summary" name="summary" rows="4" required>{{ $recipe->summary }}</textarea>
      </div>

      <!-- Ingredients -->
      <div class="mb-3">
          <label for="ingredients" class="form-label">Ingredients</label>
          <textarea class="form-control" id="ingredients" name="ingredients" rows="4" required>{{ $recipe->ingredients }}</textarea>
      </div>

      <!-- Instructions -->
      <div class="mb-3">
          <label for="instructions" class="form-label">Instructions</label>
          <textarea class="form-control" id="instructions" name="instructions" rows="4" required>{{ $recipe->instructions }}</textarea>
      </div>

      <!-- Preparation Time -->
      <div class="mb-3">
          <label for="preparation_time" class="form-label">Preparation Time (minutes)</label>
          <input type="number" class="form-control" id="preparation_time" name="preparation_time" min="1" value="{{ $recipe->preparation_time }}" required>
      </div>

      <!-- Cooking Time -->
      <div class="mb-3">
          <label for="cook_time" class="form-label">Cooking Time (minutes)</label>
          <input type="number" class="form-control" id="cook_time" name="cook_time"  min="1" value="{{ $recipe->cook_time }}" required>
      </div>

      <!-- Calories -->
      <div class="mb-3">
          <label for="calories" class="form-label">Calories</label>
          <input type="number" class="form-control" id="calories" name="calories" min="1" value="{{ $recipe->calories }}" required>
      </div>

      <!-- Category -->
      <div class="mb-3">
          <label for="category_id" class="form-label">Category</label>
          <select class="form-control" id="category_id" name="category_id" required>
              @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ $recipe->category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
              @endforeach
          </select>
      </div>

      <!-- Image -->
      <div class="mb-3">
          <label for="img" class="form-label">Upload Image (Optional)</label>
          <input type="file" class="form-control" id="img" name="img">
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Update Recipe</button>
  </form>
</div>
@endsection
