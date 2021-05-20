<?php

class Model
{
    private $db;
    public $errorMsg;
    
    public function __construct($database)
    {
        $this->db = $database;
        $this->errorMsg = null;
    }

    public function fetchAllProducts()
    {
        $products = $this->db->select("SELECT * FROM products");
        return $products;
    }

    public function fetchOneProduct($id)
    {
        $data = $this->db->select("SELECT * FROM products WHERE id = $id");
        return $data ? $data[0] : array();
    }

    public function createProduct($product)
    {
        extract($product);
        $addProduct = $this->db->insert("INSERT INTO products (name, description, price, img, instock) VALUES ('$name', '$description', '$price', '$img', '$instock')");
        return $addProduct;
    }
    
    public function updateProduct($product, $id)
    {
        extract($product);
        $addProduct = $this->db->update("UPDATE products SET name = '$name', description = '$description', price = '$price', img = '$img', instock = '$instock' WHERE id = '$id'");
        return $addProduct;
    }
    
    public function fetchAllOrders()
    {
        $orders = $this->db->select("SELECT * FROM orders");
        return $orders;
    }

    public function createOrder($user_id, $products, $total)
    {
        $this->db->insert("INSERT INTO orders (user_id, products, total) VALUES ('$user_id', '$products', '$total')");
    }
    
    public function updateShippingStatus($id, $status)
    {
        $addProduct = $this->db->update("UPDATE orders SET is_sent = '$status'  WHERE id = '$id'");
        return $addProduct;
    }
    
    public function deleteProduct($id)
    {
        $this->db->insert("DELETE FROM products WHERE id = $id");
    }
    
    public function newUserIsValid($user) // TODO lägg i user controller
    {
        $error = false;
        extract($user);
        
        if (!empty($this->getUser($email))) {
            $this->errorMsg = "Denna epost används redan!";
            $error = true;
        }
        if (!$first_name || !$last_name || !$email || !$password || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = true;
        }

        return $error ? false : true;
    }

    public function getUser($email)
    {
        $email = htmlspecialchars($email);
        $data = $this->db->select("SELECT * FROM users WHERE email = '$email'");
        return $data ? $data[0] : array();
    }
    
    public function createUser($user)
    {
        $sanitized = array_map(array($this, 'sanitize'), $user);
        
        if ($this->newUserIsValid($user) && $user === $sanitized) {
            extract($user);
            $this->db->insert("INSERT INTO users (email, password, first_name, last_name) VALUES ('$email', '$password', '$first_name', '$last_name')");
        } else throw new Exception;
    }
    
    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
