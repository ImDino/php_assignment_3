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

    public function updateOrderSend($id)
    {
        $addProduct = $this->db->update("UPDATE orders SET is_sent = 1  WHERE id = '$id'");
        return $addProduct;
    }
    public function updateOrderUnSend($id)
    {
        $addProduct = $this->db->update("UPDATE orders SET is_sent = 0  WHERE id = '$id'");
        return $addProduct;
    }

    public function fetchOneProduct($id)
    {
        $data = $this->db->select("SELECT * FROM products WHERE id = $id");
        return $data ? $data[0] : $data;
    }

    public function userIsValid($user)
    {
        extract($user);
        if (!$first_name || !$last_name || !$email || !$password || strlen($password) < 6 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($this->getUser($email))) {
            return false;
        }
        return true;
    }

    public function getUser($email)
    {
        $data = $this->db->select("SELECT * FROM users WHERE email = '$email'");
        return $data ? $data[0] : $data;
    }
    
    public function fetchAllOrders()
    {
        $orders = $this->db->select("SELECT * FROM orders");
        return $orders;
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
        $_SESSION['cart'] = array();
    }
}
