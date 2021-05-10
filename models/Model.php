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

    public function createProduct($name, $description, $price, $img, $in_stock)
    {
        $addProduct = $this->db->insert("INSERT INTO products (name, description, price, img, instock) VALUES ('$name', '$description', '$price', '$img', '$in_stock')");
        return $addProduct;
    }

    public function deleteProduct($id)
    {
        $this->db->insert("DELETE FROM products WHERE id = $id");
    }

    public function updateProduct($name, $description, $price, $img, $in_stock, $id)
    {
        $addProduct = $this->db->update("UPDATE products SET name= '$name', description = '$description', price = '$price', img = '$img', instock = '$in_stock'  WHERE id = '$id'");

        return $addProduct;
    }

    public function fetchOneProduct($id)
    {
        $products = $this->db->select("SELECT * FROM products WHERE id = $id");
        return $products;
    }

    // validation här eller en annan controller?
}
