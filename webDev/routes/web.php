<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $sql = "SELECT * FROM recipe";
    $recipes = DB::select($sql);
    return view('home', ['recipes' => $recipes]);
});

Route::get('recipe/{id}', function ($id) {
    return view('recipe', ['id' => $id]);
});

Route::get('recipe', function () {

    return view('recipe');
    
});

Route::post('comment', function () {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $email = $_POST['email'];
    return view('comment', ['name' => $name, 'comment' => $comment, 'email' => $email]);
});