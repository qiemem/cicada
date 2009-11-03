<?php
require_once 'models/SqlModel.php';

class SubmissionsModel extends SqlModel{
    public function defaults() {
        $this->orderBy = 'dateAdded';
        $this->direction = 'DESC';
        $this->fetchType = 'all';
        $this->startIndex = 0;
        $this->numRows = 10;
        $this->whereArray = array();
    }

    protected function table() {
        return 'submissions';
    }

    public function add($user, $body) {
        $sql = "INSERT INTO submissions (user, body) VALUES ($user, '$body')";
        $affected = getDBConnection()->exec($sql);
        if(PEAR::isError($affected)){
            die($affected->getMessage());
        }
    }

    public function orderBy($col) {
        $this->orderBy = $col;
        return $this;
    }

    public function withId($id) {
        $this->whereConditions[]="id=$id";
        return $this;
    }

    public function withUser($userId) {
        $this->whereConditions[]="user='$userId'";
        return $this;
    }

    public function withBody($body) {
        $this->whereArray[] = "body='$body'";
        return $this;
    }
}
