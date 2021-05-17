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
        $this->model->createCart();
        $this->router();
        
        $msgTrigger = $_GET['msgTrigger'] ?? null;
        if ($msgTrigger) {
            $this->checkMsg();
        }
    }

    /*
    TODO session variabeln cart ska istället ha artikel id som nyckel och värde som antal
    TODO check if admin
    TODO lägg beställningen (kolla om man är inloggad bl a)
    TODO logga ut
    
    Rikard
    TODO orderhistorik i order-vyn med möjlighet att ta tillbaka "skickad" beställning
    TODO sub-meny i order sidan för "all - sent - not sent"
    */

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
            case "adminOrders":
                $this->adminOrders($id);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->model->getUser($_POST['email']);
                if (!$user) {
                    $this->view->errorMsg("Felaktigt användarnamn eller lösenord");
                } else {
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['confirmMsg'] = "Välkommen $user[first_name]!";
                    header('location: ?msgTrigger=true');
                }
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
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
        
        if (isset($_GET['removeFromCart'])) {
            if (($key = array_search($_GET['removeFromCart'], $_SESSION['cart'])) !== false) {
                unset($_SESSION['cart'][$key]);
            }
        }
        
        if (!empty($_SESSION['cart'])) {
            $products = array();
            foreach ($_SESSION['cart'] as $productID) {
                $product = $this->model->fetchOneProduct($productID);
                array_push($products, $product);
            }
            $this->view->checkoutPage($products);
        } else $this->view->checkoutPage();
        
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
    
    private function adminOrders($id)
    {
        if ($id) {
            try {
                $action = $_GET['action'];
                if($action == "send"){
                    $this->model->updateOrderSend($id);
                    $_SESSION['confirmMsg'] = 'Order skickad!';
                    header('location: ?page=adminOrders&msgTrigger=true');
                }
                if($action == "unsend"){
                    $this->model->updateOrderUnSend($id);
                    $_SESSION['confirmMsg'] = 'Order oskickad!';
                    header('location: ?page=adminOrders&msgTrigger=true');
                }  
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
        $this->getHeader("Alla ordrar");
        $orders = $this->model->fetchAllOrders();
        $this->view->adminOrdersPage($orders);
        $this->getFooter();
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
        if (isset($_GET['addToCart'])) {
            $product = $_GET['addToCart'];
            $cart = $_SESSION['cart'];
            if (!array_key_exists($product, $cart)) {
                $_SESSION['cart'][$product] ++;
            } else {
                $_SESSION['cart'][$product] = 1;
            }
        }

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
