<?php

class Model
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM products");
        return $products;
    }

    public function addNewUser($user)
    {
        $addUser = $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES ('$user[email]', '$user[password]', '$user[first_name]', '$user[last_name]')");
        return $addUser;
    }

    public function createProduct($product)
    {
        $addProduct = $this->db->insert("INSERT INTO products (name, description, price) VALUES ('$product[name]', '$product[description]', '$product[price]')");
        return $addProduct;
    }

    public function fetchOneProduct($id)
    {
        $products = $this->db->select("SELECT * FROM products WHERE id = $id");
        return $products;
    }

    // validation här eller en annan controller?
}
