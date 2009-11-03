<?php
require_once 'models/SqlModel.php';

class UsersModel extends SqlMode {
    public function defaults() {
        $this->orderBy = 'dateAdded';
        $this->direction = 'DESC';
        $this->fetchType = 'one';
        $this->startIndex = 0;
        $this->numRows = 1;
        $this->whereCondition = array();
    }

    protected function table() {
        return 'users';
    }

    public function add($user, $password){

