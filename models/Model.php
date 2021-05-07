<?php

class Model{

    private $db;

    public function __construct($database){
        $this->db = $database;
    }

    public function fetchAllProducts(){
        $products = $this->db->select("SELECT * FROM products");
        return $products;
    }
    
    public function addNewUser($user){
        // $addUser = $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES ($user->email, $user->password, $user->first_name, $user->last_name)");
        $addUser = $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES (epost, lösen, förnamn, efternamn)");
        return $addUser;
    }
}