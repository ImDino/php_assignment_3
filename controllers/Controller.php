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
        
        $msgTrigger = $_GET['msgTrigger'] ?? null;
        if ($msgTrigger) {
            $this->checkMsg();
        }
    }

    private function router()
    {
        $page = $_GET['page'] ?? '';
        $id = $_GET['id'] ?? '';

        switch ($page) {
            case 'about':
                $this->about();
                break;
            case 'checkout':
                $this->checkout();
                break;
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            case 'admin':
                $this->admin();
                break;
            case 'adminUpdate':
                $this->adminUpdate($id);
                break;
            case 'adminCreate':
                $this->adminCreate();
                break;
            case 'adminDelete':
                $this->adminDelete($id);
                break;
            default:
                $this->getAllProducts();
        }
    }

    private function checkMsg()
    {
        $confirmMsg = $_SESSION['confirmMsg'] ?? null;
        
        if ($confirmMsg) {
            $this->view->confirmMsg($confirmMsg);
            $_SESSION['confirmMsg'] = null;
        }
    }

    private function about()
    {
        $this->getHeader('Om Oss');
        $this->view->AboutPage();
        $this->getFooter();
    }

    private function login()
    {
        $this->getHeader('Login');
        $this->view->LoginPage();
        $this->getFooter();
    }

    private function register()
    {
        $this->getHeader('Registrera dig');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->createUser($_POST);
                $_SESSION['confirmMsg'] = 'Ny användare skapad!';
                header('location: ?page=login&msgTrigger=true');
            } catch (Exception $e) {
                $this->view->errorMsg();
            }
        }
        $this->view->RegisterPage();
        $this->getFooter();
    }

    private function checkout()
    {
        $this->getHeader('Kassan');
        $this->view->checkoutPage();
        $this->getFooter();
    }

    private function admin()
    {
        $this->getHeader('Admin');
        $products = $this->model->fetchAllProducts();
        $this->view->adminPage($products);
        $this->getFooter();
    }

    private function adminUpdate($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST;
            try {
                $this->model->updateProduct($product, $id);
                $_SESSION['confirmMsg'] = 'Produkten är uppdaterad!';
                header('location: ?page=admin&msgTrigger=true');
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }

        $this->getHeader('Admin Update');
        $product = $this->model->fetchOneProduct($id);
        $this->view->adminUpdatePage($product);
        $this->getFooter();
    }

    private function adminCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST;
            try {
                $this->model->createProduct($product);
                $_SESSION['confirmMsg'] = 'Ny artikel skapad!';
                header('location: ?page=admin&msgTrigger=true');
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
        
        $this->getHeader('Lägg till ny produkt');
        $this->view->adminCreatePage();
        $this->getFooter();
    }
    
    private function adminDelete($id)
    {
        try {
            $this->model->deleteProduct($id);
            $_SESSION['confirmMsg'] = 'Artikel borttagen';
            header('location: ?page=admin&msgTrigger=true');
        } catch (\Throwable $th) {
            $this->view->errorMsg();
        }
    }

    private function getHeader($title)
    {
        $this->view->header($title);
    }

    private function getFooter()
    {
        $this->view->footer();
    }

    private function getAllProducts()
    {
        $this->getHeader('Välkommen');
        try {
            $products = $this->model->fetchAllProducts();
        } catch (\Throwable $th) {
            $this->view->errorMsg();
        }
        $this->view->allProducts($products);
        $this->getFooter();
    }
}
