<?php

class Controller
{

    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function main()
    {
        $this->router();
    }

    private function router()
    {
        $page = $_GET['page'] ?? "";
        $id = $_GET['id'] ?? "";

        switch ($page) {
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
            case "adminUpdate":
                $this->adminUpdate($id);
                break;
            case "adminCreate":
                $this->adminCreate();
                break;
            case "adminDelete":
                $this->adminDelete($id);
                break;
            default:
                $this->getAllProducts();
        }
    }

    private function about()
    {
        $this->getHeader("Om Oss");
        $this->view->viewAboutPage();
        $this->getFooter();
    }

    private function login()
    {
        $this->getHeader("Login");
        $this->view->viewLoginPage();
        $this->getFooter();
    }

    private function register()
    {
        $this->getHeader("Registrera dig");
        $this->view->viewRegisterPage();
        $this->getFooter();
    }

    private function checkout()
    {
        $this->getHeader("Kassan");
        $this->view->viewCheckoutPage();
        $this->getFooter();
    }

    private function admin()
    {
        if ($_SESSION["confirmMessage"]) {
            $this->view->viewConfirmMessage();
            $_SESSION["confirmMessage"] = null;
        }
        $this->getHeader("Admin");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAdminPage($products);
        $this->getFooter();
    }

    private function adminUpdate($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST;
            try {
                $this->model->updateProduct($product, $id);
                $_SESSION["confirmMessage"] = true;
                header("location: ?page=admin");
            } catch (\Throwable $th) {
                $this->view->viewErrorMessage();
            }
        }

        $this->getHeader("Admin Update");
        $product = $this->model->fetchOneProduct($id);
        $this->view->viewAdminUpdatePage($product);
        $this->getFooter();
    }


    private function adminCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST;
            try {
                $this->model->createProduct($product);
                $_SESSION["confirmMessage"] = true;
                header("location: ?page=admin");
            } catch (\Throwable $th) {
                $this->view->viewErrorMessage();
            }
        }

        $this->getHeader("Lägg till ny produkt");
        $this->view->viewAdminCreatePage();
        $this->getFooter();
    }

    private function adminDelete($id)
    {
        $this->model->deleteProduct($id);
        $this->view->viewConfirmMessage();
        $this->admin();
    }

    private function getHeader($title)
    {
        $this->view->viewHeader($title);
    }

    private function getFooter()
    {
        $this->view->viewFooter();
    }

    private function getAllProducts()
    {
        $this->getHeader("Välkommen");
        $products = $this->model->fetchAllProducts();
        $this->view->viewAllProducts($products);
        $this->getFooter();
    }

    public function sanitize($text)
    {
        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        return $text;
    }
}
