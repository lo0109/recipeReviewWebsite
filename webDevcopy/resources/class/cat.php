<?php
class Category extends Recipe {
    protected $category;
    public function __construct($id, $name, $description, $ingredients, $instructions, $user_id, $user_name, $date, $category) {
        parent::__construct($id, $name, $description, $ingredients, $instructions, $user_id, $user_name, $date);
        $this->category = [Asian, Western, European, African, American, Other];
    }
    public function getCategory() {
        return $this->category;
    }
    public function setCategory($category) {
        $this->category = $category;
    }
}

?>