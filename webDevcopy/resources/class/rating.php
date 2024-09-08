<?php
class Rating extends Comment {
    protected $rating;
    public function __construct($id, $comment, $user_id, $user_name, $date, $rating) {
        parent::__construct($id, $comment, $user_id, $user_name, $date);
        $this->rating = $rating;
    }
    public function getRating() {
        return $this->rating;
    }
    public function setRating($rating) {
        $this->rating = $rating;
    }
}
    

?>