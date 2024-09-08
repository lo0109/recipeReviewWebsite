<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Home route - lists all recipes
Route::get('/', function () {
	// Fetch all recipes from the database
	$sql = "SELECT * FROM category as c, recipe as r
	WHERE c.id = r.category_id";	
	$sort = request('sort_by');
	switch ($sort) {
		case '1':
			$sql .= " ORDER BY recipe";
			break;
		case '2':
			$sql .= " ORDER BY recipe DESC";
			break;
		case '3':
			$sql .= " ORDER BY rating";
			break;
		case '4':
			$sql .= " ORDER BY rating DESC";
			break;
		case '5':
			$sql .= " ORDER BY total_time";
			break;
		case '6':
			$sql .= " ORDER BY total_time DESC";
			break;
		case '7':
			$sql .= " ORDER BY calories";
			break;
		case '8':
			$sql .= " ORDER BY calories DESC";
			break;
		case '9':
			$sql .= " ORDER BY review";
			break;
		case '10':
			$sql .= " ORDER BY review DESC";
			break;
		default:
			$sql .= " ORDER BY id";
			break;
	}
	$recipes = DB::select($sql);
	return view('home', ['recipes' => $recipes]);
});

// Recipe detail route - shows a specific recipe by ID
Route::get('recipe/{id}', function ($id) {
	// Fetch the recipe data by ID
	$sql = "SELECT * FROM category as c, recipe as r
	WHERE r.category_id = c.id
	and r.id = ?";
	$recipe = DB::select($sql, [$id]);
	
	if (count($recipe)!=1) {
		die("Something went wrong: $sql");  // database error
	}	elseif ($recipe[0]->user_id != null) {
			$user = DB::select("SELECT * FROM users WHERE id = ?", [$recipe[0]->user_id]);
			$author_name = $user[0]->user_name;
		};

	// Fetch the comments for the recipe
	$commentSql = "SELECT * FROM comments as c, users as u 
								WHERE c.user_id = u.id
								and recipe_id = ?";
	$comments = DB::select($commentSql, [$id]);

	// Check if the user has commented on the recipe
	$userHasCommented = false;
	if (session()->has('user_id')) {
		foreach ($comments as $comment) {
			if ($comment->user_id == session('user_id')) {
				$userHasCommented = true;
				break;
			}
		}
	}
	// Pass the recipe data to the view
	return view('recipe', ['recipe' => $recipe[0], 'userHasCommented' => $userHasCommented,'author_name'=>$author_name ?? null, 'comments' => $comments]);
});

// Bookmark toggle route - toggles the bookmark status of a recipe
// Route::post('bookmark/{id}', function (Request $request, $id) {
// 	// Fetch the recipe by ID
// 	$sql = "SELECT * FROM recipe WHERE id = ?";
// 	$recipe = DB::select($sql, [$id]);

// 	if (count($recipe)!=1) {
// 		die("Something went wrong: $sql");  // database error
// 	}

// 	// Toggle the bookmark status (0 to 1, or 1 to 0)
// 	$newBookmarkStatus = $recipe[0]->bookmark ? 0 : 1;
// 	$updateSql = "UPDATE recipe SET bookmark = ? WHERE id = ?";
// 	DB::update($updateSql, [$newBookmarkStatus, $id]);

// 	// Return JSON response to the AJAX request
// 	return response()->json([
// 		'success' => true,
// 		'bookmarked' => $newBookmarkStatus
// 	]);
// });

Route::post('comment/{id}', function () {

	$comment = request('comment');
	$rating = request('rating');
	$recipe_id = request('recipe_id');
	$date = date('Y-m-d');
	//Find user_id
	$user_id = session('user_id');
	//Insert comment
	$sql = "INSERT INTO comments (user_id, comment, rating, c_date, recipe_id) VALUES (?, ?, ?, ?,?)";
  DB::insert($sql, [ $user_id, $comment, $rating,$date ,$recipe_id]);
	//Update rating for recipe
	$avgRatingSql = "SELECT AVG(rating) as avgRating FROM comments WHERE recipe_id = ?";
	$avg = DB::select($avgRatingSql, [$recipe_id]);

	$review = DB::select("SELECT count(*) as count FROM comments WHERE recipe_id = ?", [$recipe_id]);

	$updateRatingSql = "UPDATE recipe SET rating = ?, review = ? WHERE id = ?";
	DB::update($updateRatingSql, [$avg[0]->avgRating, $review[0]->count, $recipe_id]);

	//update rating for category
	$catRatingSql = "SELECT AVG(c.rating) as avgRating FROM comments as c, recipe as r, category as cat 
	WHERE c.recipe_id = r.id and r.category_id = cat.id
	and cat.id = (select category_id from recipe where id = ?)";
	$cat_avg = DB::select($catRatingSql, [$recipe_id]);

	$category = DB::select("SELECT category_id FROM recipe WHERE id = ?", [$recipe_id]);

	$updateRatingSql = "UPDATE category SET rating = ? WHERE id = ?";
	DB::update($updateRatingSql, [$cat_avg[0]->avgRating, $category[0]->category_id]);

	return redirect("/recipe/$recipe_id");
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
	// $img = request('img');
	$calories = request('calories');
	$category_id = request('category_id');
	$bookmark = 0;
	$id = addRecipe($recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $calories, $category_id, $bookmark);
	if ($id) {
		$file = request()->file('img');
		// Generate a unique filename using the recipe ID
		$filename = $id . '.jpg';
		// Store the image in the 'public/images' directory
		$file->move(public_path('img'), $filename);

		// Update the recipe with the image path
		DB::update('UPDATE recipe SET img = ? WHERE id = ?', ["img/$filename", $id]);
		return redirect("/recipe/$id");
	} else {
		die("Something went wrong. Cant add item to database");
	}

});

function addRecipe($recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $calories, $category_id, $bookmark) {
	$sql = "INSERT INTO recipe (recipe, summary, ingredients, instructions, preparation_time, cook_time, total_time, calories, category_id, bookmark) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?)";
	DB::insert($sql, [$recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $preparation_time+$cook_time, $calories, $category_id, $bookmark]);
	return DB::getPdo()->lastInsertId();
}

Route::get('search', function () {
	$search = request('search');
	$sql = "SELECT * FROM recipe WHERE recipe LIKE ?";
	$recipes = DB::select($sql, ["%$search%"]);
	return view('home', ['recipes' => $recipes]);
});

Route::post('/login', function() {
	$email = trim(request('email'));
	$sql = "SELECT * FROM users WHERE email = ?";
	$users = DB::select($sql, [$email]);
	if (!empty($users)) {
		$user = $users[0];
		session(['user_id' => $user->id, 'user_name' => $user->user_name]);
		return back();
	} else {
		return view('signup',['email' => $email]);
	}
});

// Route::get('/signup', function(){
// 	$email = session('email');
// 	return view('signup', ['email' => $email]);
// });

Route::post('/signup', function() {
	$user_name = request('user_name');
	$email = request('email');

	// A name (user, item, and manufacturer) must have more than 2 characters and cannot have the following symbols: -, _, +, ". 
	$name_errors = [];
	$email_errors = [];
	if (strlen(trim($user_name)) < 3) {
		$name_errors[] = "Name must be at least 2 characters long";
	} else if (preg_match('/[-_+".]/', $user_name)) {
		$name_errors[] = "Name cannot contain the following symbols: -, _, +, \" and .";
	}

	$new_name = preg_replace('/\d*[13579]/', '', $user_name);
	if ($new_name != $user_name) {
		session()->flash('name_altered', "Your username was automatically changed from '$user_name' to '$new_name'.");
		$user_name = trim($new_name);
	}
	if (check_email($email)) {
		$email_errors[] = "Email already exists";
	};
// return dd($user_name);
	if (empty($name_errors) && empty($email_errors)) {
		$sql = "INSERT INTO users (user_name, email) VALUES (?, ?)";
		DB::insert($sql, [$user_name, $email]);
		session(['user_id'=>DB::getPdo()->lastInsertId(),'user_name' => $user_name, 'email' => $email]);
		return redirect('/');
	} else {
		return view('signup', ['name_errors' => $name_errors, 'email_errors' => $email_errors]);
	}
});

Route::get('/logout', function() {
	session()->flush();
	return redirect('/');
});

function check_email($email) {
	$sql = "SELECT * FROM users WHERE email = ?";
	$users = DB::select($sql, [$email]);
	return !empty($users);
}

Route::get('/category/{id}', function($id) {
	$sql = "SELECT * FROM category as c, recipe as r 
	WHERE c.id = r.category_id 
	and c.id = ?"; 
	$recipes = DB::select($sql, [$id]);
	return view('home', ['recipes' => $recipes, 'select_category' => $recipes[0]->category ?? '']);
});

Route::get('/category', function() {
	$sql = "SELECT * FROM category";
	$categories = DB::select($sql);
	return view('category', ['categories' => $categories]);
});

Route::get('/edit_item/{id}', function ($id) {
	// Fetch the recipe data by ID to pre-fill the form
	$recipe = DB::select("SELECT * FROM recipe WHERE id = ?", [$id]);
	$categories = DB::select("SELECT * FROM category");

	// Pass the recipe data to the form
	return view('edit_item', ['recipe' => $recipe[0], 'categories' => $categories]);
});

Route::post('/edit_item/{id}', function ($id) {
	$recipe = request('recipe');
	$summary = request('summary');
	$ingredients = request('ingredients');
	$instructions = request('instructions');
	$preparation_time = request('preparation_time');
	$cook_time = request('cook_time');
	$calories = request('calories');
	$category_id = request('category_id');
	$update_time = date('Y-m-d');
	$user_id = session('user_id');	
	 // Check if a new image has been uploaded
	 if (request()->hasFile('img')) {
		$file = request()->file('img');
		$filename = $id . '.jpg';
		$file->move(public_path('img'), $filename);	
		DB::update('UPDATE recipe SET img = ? WHERE id = ?', ["img/$filename", $id]);
		}
	// Update the recipe in the database
	$sql = "UPDATE recipe SET recipe = ?, summary = ?, ingredients = ?, instructions = ?, preparation_time = ?, cook_time = ?, calories = ?, category_id = ?, update_time =?, user_id =? WHERE id = ?";
	DB::update($sql, [$recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $calories, $category_id, $update_time,$user_id, $id]);
		// return dd($recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $calories, $category_id, $update_time,$user_id, $id);
	return redirect("/recipe/$id");
});

Route::post('/delete_item/{id}', function ($id) {
	// Delete the recipe from the database
	DB::delete("DELETE FROM recipe WHERE id = ?", [$id]);

	return redirect('/');
});
