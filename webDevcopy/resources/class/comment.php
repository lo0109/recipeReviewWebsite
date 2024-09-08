<?php

namespace pp;
class Comment {
    protected $id;
    protected $comment;
    protected $user_id;
    protected $user_name;
    protected $date;

    public function __construct($id, $comment, $user_id, $user_name, $date) {
        $this->id = $id;
        $this->comment = $comment;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->date = $date;
    }

    public function getId() {
        return $this->id;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getDate() {
        return $this -> date;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function setDate($date) {
        $this->date = $date;
    }

    public function setComment($user_id, $comment, ) {
        $this->comment = $comment;
    }
}
?>