<?php

class Controller{

    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }

    public function main(){
        $this->router();
    }

    private function router(){
        $page = $_GET['page'] ?? "";

        switch ($page){
            case "about":
                $this->about();
                break;
            case "checkout":
                $this->checkout();
                break;
            case "login":
                $this->login();
                break;
            case "register":
                $this->register();
                break;
            case "admin":
                $this->admin();
                break;
            default:
                $this->getAllProducts();
        }
    }

    private function about(){
        $this->getHeader("Om Oss");
        $this->view->viewAboutPage();
        $this->getFooter();
    }
    
    private function login(){
        $this->getHeader("Login");
        $this->view->viewLoginPage();
        $this->getFooter();
    }
    
    private function register(){
        $this->getHeader("Registrera dig");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->newUser($_POST);
                // routa till login, skicka meddelande om lyckad registrering
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage());
                foreach ($errors as $error) {
                    echo $error;
                }
            }
        }
        $this->view->viewRegisterPage();
        $this->getFooter();
    }

    private function checkout(){
        $this->getHeader("Kassan");
        $this->view->viewCheckoutPage();
        $this->getFooter();
    }
    
    private function admin(){
        $this->getHeader("Admin");
        $this->view->viewAdminPage();
        $this->getFooter();
    }

    private function getHeader($title){
        $this->view->viewHeader($title);
    }

    private function getFooter(){
        $this->view->viewFooter();
    }

    private function getAllProducts(){
        $this->getHeader("Välkommen");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
        $this->getFooter();
    }
    public function newUser($user) {
        $email = htmlspecialchars($user['email']) ?? null;
        $firstName = htmlspecialchars($user['first_name']) ?? null;
        $lastName = htmlspecialchars($user['last_name']) ?? null;
        $password = htmlspecialchars($user['password']) ?? null;

        if (!$firstName || !$lastName || !$email || !$password || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errors,"Bad request");
        }
        if ($password < 6) array_push($this->errors,"Lösenordet måste bestå av minst 6 tecken.");
        if ($this->db->emailExists($email)) array_push($errors,"Denna epost adress används redan.");
    }
}