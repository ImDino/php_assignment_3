<?php

require_once('Form.php');
class Model{
    private $db;

    public function __construct($database){
        $this->db = $database;
    }

    public function fetchAllProducts(){
        $products = $this->db->select("SELECT * FROM products");
        return $products;
    }
    
    public function createUser($user)
    {
        try {
            $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES ('$user[email]', '$user[password]', '$user[first_name]', '$user[last_name]')");
        } catch (Exception $e) {
            echo "Något gick snett. Försök igen!";
        }
    }
}