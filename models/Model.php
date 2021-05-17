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

    public function createUser($user)
    {
        array_map('htmlspecialchars', $user);
        if ($this->userIsValid($user)) {
            extract($user);
            $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES ('$email', '$password', '$first_name', '$last_name')");
        } else throw new Exception;
    }
    
    public function createProduct($product)
    {
        extract($product);
        $addProduct = $this->db->insert("INSERT INTO products (name, description, price, img, instock) VALUES ('$name', '$description', '$price', '$img', '$instock')");
        return $addProduct;
    }
    
    public function deleteProduct($id)
    {
        $this->db->insert("DELETE FROM products WHERE id = $id");
    }
    
    public function updateProduct($product, $id)
    {
        extract($product);
        $addProduct = $this->db->update("UPDATE products SET name = '$name', description = '$description', price = '$price', img = '$img', instock = '$instock'  WHERE id = '$id'");
        return $addProduct;
    }

    public function fetchOneProduct($id)
    {
        $product = $this->db->select("SELECT * FROM products WHERE id = $id")[0];
        return $product;
    }

    public function userIsValid($user)
    {
        extract($user);
        if (!$first_name || !$last_name || !$email || !$password || strlen($password) < 6 || !filter_var($email, FILTER_VALIDATE_EMAIL) || $this->db->emailExists($email)) { //REVIEW testa utan att validera emailexists
            return false;
        }
        return true;
    }

    public function sanitize($text) // REVIEW skräp?
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }

    public function createCart() {
        if (isset($_SESSION['cart'])) {
            return;
        }
        $_SESSION['cart'] = [];
    }
}
