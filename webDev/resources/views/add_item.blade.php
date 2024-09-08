@extends('layouts.main')

@section('title')
  Add New Recipe
@endsection

@section('content')
<div class="container">
  
	  <form action="add_item" method="POST" enctype="multipart/form-data">
			@csrf <!-- This generates the CSRF token for security -->
			<!-- Left Column: Ingredients -->
			<div class="row">
				<div class="col-md-3">
					<h4>Ingredients</h4>
					<div class="mb-3">
						<label for="name" class="form-label">Please input the ingredients:</label>
						<textarea type="text" class="form-control" name="ingredients" rows="8" required></textarea>
						<label for="name" class="form-label">Please input the preparation time:</label>
						<input type="integer" class="form-control" name="preparation_time" required></textarea>
						<label for="name" class="form-label">Please input the cooking time:</label>
						<input type="integer" class="form-control" name="cook_time" required></textarea>
						<label for="name" class="form-label">Please input the calories:</label>
						<input type="integer" class="form-control" name="calories" required></textarea>
					</div>
				</div>
				<!-- Middle Column: Instructions -->
				<div class="col-md-6">
					<label for="name" class="form-label">Please input the Recipe Name:</label>
					<input type="text" class="form-control" name="recipe" required></textarea>	
					<h4>Summary</h4>
					<label for="name" class="form-label">Please input the summary of the recipe:</label>
					<textarea type="text" class="form-control" name="summary" required></textarea>
					<h4>Instructions</h4>
					<label for="name" class="form-label">Please input the instructions of the recipe:</label>
					<textarea type="text" class="form-control" name="instructions" rows="10" required></textarea>
				</div>
				<!-- Right Column -->
				<div class="col-md-3">
				<h4>Catagory:</h4>	
				<label for="name" class="form-label">Please select the category:</label>
					<select class="form-select" name="category_id" required>
						<option selected>Category:</option>
						<option value="1">Pasta</option>
						<option value="2">Salad</option>
						<option value="3">Soup</option>
						<option value="4">Risotto</option>
						<option value="5">Dessert</option>
						<option value="6">Breakfast</option>
						<option value="7">Snack</option>
						<option value="8">Other</option>
					</select>
					<h4>Upload Image</h4>
					<div class="mb-3">
						<label for="name" class="form-label">Please upload an image:</label>
						<!-- restrict file uploads to images only -->
						<input type="file" class="form-control" name="img" accept="*.jpg"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
</div>
@endsection
