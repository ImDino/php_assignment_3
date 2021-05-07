<?php

class Model{

    private $db;

    public function __construct($database){
        $this->db = $database;
    }

    public function fetchAllProducts(){
        $movies = $this->db->select("SELECT * FROM products");
        return $movies;
    }
}