<?php
require_once 'config/dbconfig.php';

abstract class SqlModel {
    protected $orderBy = false;     //Should be a col name. If it evaluates to false, there will be no 'ORDER BY' clause.
    protected $direction = 'ASC';   //'ASC' or 'DESC'
    protected $fetchType = 'all';   //'all' or 'one'
    protected $startIndex = 0;
    protected $numRows = 10;
    protected $whereConditions = array();

    abstract protected function table();

    public function defaults() {
        $this->orderBy = false;
        $this->direction = 'ASC';
        $this->fetchType = 'all';
        $this->startIndex = 0;
        $this->numRows = 10;
        $this->whereConditions = array();
    }

    protected function setLimit($mdb2) {
        $mdb2->setLimit($this->numRows, $this->startIndex);
    }

    protected function getWhereClause() {
        if($this->whereConditions) {
            $clause = "WHERE ".$this->whereConditions[0];
        }else{
            return "";
        }
        for($i=1; $i<sizeOf($this->whereConditions); $i++) {
            $clause.=" AND ".$this->whereConditions[i];
        }
        return $clause;
    }

    protected function getOrderClause() {
        if($this->orderBy){
            return "ORDER BY $this->orderBy $this->direction";
        }else{
            return "";
        }
    }

    protected function fetchFromQueryResult($res) {
        if(PEAR::isError($res)){
            die($res->getMessage());
        }
        if($this->fetchType == 'all'){
            return $res->fetchAll();
        }else if($this->fetchType == 'row'){
            return $res->fetchRow();
        }else if($this->fetchType == 'one'){
            return $res->fetchOne();
        }

    }

    protected function doQuery($mdb2, $sql) {
        $res = $mdb2->query($sql);
        $return = $this->fetchFromQueryResult($res);
        $this->defaults();
        return $return;
    }

    public function get() {
        $mdb2 = getDBConnection();
        $this->setLimit($mdb2);
        $sql = "SELECT * FROM ".$this->table();
        $sql .= " ".$this->getWhereClause();
        $sql .= " ".$this->getOrderClause();
        return $this->doQuery($mdb2, $sql);
    }

    public function count() {
        $mdb2 = getDBConnection();
        $this->fetchType = 'one';
        $this->setLimit($mdb2);
        $sql = "SELECT COUNT(*) FROM ".$this->table();
        return $this->doQuery($mdb2, $sql);
    }

    protected function orderBy($col) {
        $this->orderBy = $col;
        return $this;
    }

    public function shuffle($seed = -1){
        if($seed < 0) {
            $this->orderBy = "RAND()";
        }else{
            $this->orderBy = "RAND($seed)";
        }
        return $this;
    }

    public function descending() {
        $this->direction = 'DESC';
        return $this;
    }
    
    public function ascending() {
        $this->direction = 'ASC';
        return $this;
    }

    public function all() {
        $this->fetchType = 'all';
        return $this;
    }

    public function first() {
        $this->fetchType = 'row';
        return $this;
    }

    public function from($index) {
        $this->startIndex = $index;
        return $this;
    }

    public function atMost($num) {
        $this->numRows = $num;
        return $this;
    }
}
