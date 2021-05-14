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
        $addProduct = $this->db->insert("INSERT INTO products (name, description, price, img, instock) VALUES ('$product[name]', '$product[description]', '$product[price]', '$product[img]', '$product[instock]')");
        return $addProduct;
    }

    public function deleteProduct($id)
    {
        $this->db->insert("DELETE FROM products WHERE id = $id");
    }

    public function updateProduct($product, $id)
    {
        $addProduct = $this->db->update("UPDATE products SET name= '$product[name]', description = '$product[description]', price = '$product[price]', img = '$product[img]', instock = '$product[instock]'  WHERE id = '$id'");

        return $addProduct;
    }

    public function updateOrder($id)
    {
        $addProduct = $this->db->update("UPDATE orders SET is_sent = 1  WHERE id = '$id'");

        return $addProduct;
    }

    public function fetchOneProduct($id)
    {
        $products = $this->db->select("SELECT * FROM products WHERE id = $id");
        return $products;
    }

    public function fetchAllOrders()
    {
        $orders = $this->db->select("SELECT * FROM orders");
        return $orders;
    }



    // validation här eller en annan controller?
}
