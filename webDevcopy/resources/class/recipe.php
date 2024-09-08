<?php

namespace pp;
class Recipe {
    protected $id;
    protected $recipe;
    protected $summary;
    protected $ingredients;
    protected $instructions;
    protected $preparation_time;
    protected $cook_time;
    protected $img;
    protected $calories;

    public function __construct($id, $recipe, $summary, $ingredients, $instructions, $preparation_time, $cook_time, $image, $calories) {
        $this->id = $id;
        $this->recipe = $recipe;
        $this->summary = $summary;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->preparation_time = $preparation_time;
        $this->cook_time = $cook_time;
        $this->image = $image;
        $this->calories = $calories;

    }

    public function getId() {
        return $this->id;
    }

    public function getRecipe() {
        return $this->recipe;
    }

    public function getSummary() {
        return $this->summary;
    }

    public function getIngredients() {
        return $this->ingredients;
    }

    public function getInstructions() {
        return $this->instructions;
    }

    public function getPreparationTime() {
        return $this->preparation_time;
    }

    public function getCookTime() {
        return $this->cook_time;
    }

    public function getImg() {
        return $this->img;
    }

    public function getCalories() {
        return $this->calories;
    }

  
}
?>