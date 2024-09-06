<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Home route - lists all recipes
Route::get('/', function () {
	// Fetch all recipes from the database
	$sql = "SELECT * FROM recipe";
	$recipes = DB::select($sql);
	return view('home', ['recipes' => $recipes]);
});

// Recipe detail route - shows a specific recipe by ID
Route::get('recipe/{id}', function ($id) {
	// Fetch the recipe data by ID
	$sql = "SELECT * FROM recipe WHERE id = ?";
	$recipe = DB::select($sql, [$id]);
	
	if (count($recipe)!=1) {
		die("Something went wrong: $sql");  // database error
	}

	// Fetch the comments for the recipe
	$commentSql = "SELECT * FROM comments WHERE recipe_id = ?";
	$comments = DB::select($commentSql, [$id]);

	// Pass the recipe data to the view
	return view('recipe', ['recipe' => $recipe[0], 'comments' => $comments]);
})->name('recipe');

// Bookmark toggle route - toggles the bookmark status of a recipe
Route::post('bookmark/{id}', function (Request $request, $id) {
	// Fetch the recipe by ID
	$sql = "SELECT * FROM recipe WHERE id = ?";
	$recipe = DB::select($sql, [$id]);

	if (count($recipe)!=1) {
		die("Something went wrong: $sql");  // database error
	}

	// Toggle the bookmark status (0 to 1, or 1 to 0)
	$newBookmarkStatus = $recipe[0]->bookmark ? 0 : 1;
	$updateSql = "UPDATE recipe SET bookmark = ? WHERE id = ?";
	DB::update($updateSql, [$newBookmarkStatus, $id]);

	// Return JSON response to the AJAX request
	return response()->json([
		'success' => true,
		'bookmarked' => $newBookmarkStatus
	]);
});

Route::post('comment/{id}', function ($id) {
	$user_name = request('user_name');
	$email = request('email');
	$comment = request('comment');
	$rating = request('rating');
	$recipe_id = $id;
	$sql = "INSERT INTO comments (user_name, email, comment, rating, recipe_id) VALUES (?, ?, ?, ?,?)";
  DB::insert($sql, [$user_name, $email, $comment, $rating ,$recipe_id]);
	
	$avgRatingSql = "SELECT AVG(rating) as avgRating FROM comments WHERE recipe_id = ?";
	$avg = DB::select($avgRatingSql, [$id]);

	$updateRatingSql = "UPDATE recipe SET rating = ? WHERE id = ?";
	DB::update($updateRatingSql, [$avg[0]->avgRating, $id]);

	return redirect("/recipe/$id");
});

route::get('add_item', function () {
	return view('add_item');
});
Route::post('add_item', function () {
	$recipe = request('recipe');
	$summary = request('summary');
	$ingredients = request('ingredients');
	$instructions = request('instructions');
	$preparation_time = request('preparation_time');
	$cook_time = request('cook_time');
	$img = request('img');
	$calories = request('calories');
	$category_id = request('category_id');
	$bookmark = 0;
	$id = addRecipe($recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $img, $calories, $category_id, $bookmark);
	if ($id) {
		return redirect("/recipe/$id");
	} else {
		die("Something went wrong. Cant add item to database");
	}

});

function addRecipe($recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $img, $calories, $category_id, $bookmark) {
	$sql = "INSERT INTO recipe (recipe, summary, ingredients, instructions, preparation_time, cook_time, img, calories, category_id, bookmark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	DB::insert($sql, [$recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $img, $calories, $category_id, $bookmark]);
	return DB::getPdo()->lastInsertId();
}

