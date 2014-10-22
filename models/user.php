<?php
class User extends \Model {
    protected $_table = "users";
    public function posts() {
        return $this->has_many('Post', 'user_id');
    }
}
