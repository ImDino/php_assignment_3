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

}