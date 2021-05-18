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
    TODO Dela upp controllers (Admin (update/delete/etc), User (login, logout, register), Other?
    TODO i Admin controllern på main, kolla om isAdmin i session är true annars redirect till index.php.
    TODO ta reda på hur vi ska rensa alla controllers så mycket som möjligt.
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
            case 'placeOrder':
                $this->placeOrder();
                break;
            case 'login':
                $this->login();
                break;
            case "logout":
                $this->logout();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->model->getUser($_POST['email']);
                if (!$user) {
                    $this->view->errorMsg("Felaktigt användarnamn eller lösenord");
                } else {
                    $_SESSION['name'] = $user['first_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['isAdmin'] = $user['is_admin'];
                    $_SESSION['confirmMsg'] = "Välkommen $user[first_name]!";
                    header('location: ?msgTrigger=true');
                }
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        } else if (isset($_SESSION['email']) && $_SESSION['email']) {
            header('location: index.php');
        }
        $this->getHeader('Login');
        $this->view->LoginPage();
        $this->getFooter();
    }

    private function logout() {
        $_SESSION['id'] = null;
        $_SESSION['name'] = null;
        $_SESSION['email'] = null;
        $_SESSION['isAdmin'] = null;
        $_SESSION['confirmMsg'] = "Du är nu utloggad!";
        header('location: ?msgTrigger=true');
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
            $productID = $_GET['removeFromCart'];
            if (array_key_exists($productID, $_SESSION['cart'])) {
                $_SESSION['cart'][$productID]--;
                if ($_SESSION['cart'][$productID] == 0) {
                    unset($_SESSION['cart'][$productID]);
                }
            }
        }
        
        if (!empty($_SESSION['cart'])) {
            $total = 0;
            $products = array();
            foreach ($_SESSION['cart'] as $productID => $quantity) {
                $product = $this->model->fetchOneProduct($productID);
                $product['quantity'] = $quantity;
                array_push($products, $product);
                $total += $product['price']*$quantity;
            }
            $this->view->checkoutPage($products, $total);
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
                    $_SESSION['confirmMsg'] = 'Order återkallad!';
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

    private function placeOrder() {
        if (empty($_SESSION['cart'])) {
            header('location: index.php');
        }
        if (!isset($_SESSION['email']) && !$_SESSION['email']) {
            $_SESSION['confirmMsg'] = 'Vänligen logga in för att beställa din order!';
            header('location: ?page=login&msgTrigger=true');
        } else {
            $total = 0;
            $productsView = array();
            $productsDB = array();
            
            foreach ($_SESSION['cart'] as $productID => $quantity) {
                $productView = $this->model->fetchOneProduct($productID);
                $productView['quantity'] = $quantity;
                array_push($productsView, $productView);
                
                $productDB = array('id' => $productID, 'qty' => $quantity);
                array_push($productsDB, $productDB);

                $total += $productView['price']*$quantity;
            }

            try {
                $this->model->createOrder($_SESSION['id'], json_encode($productsDB), $total);
                $_SESSION['cart'] = array();
                $_SESSION['confirmMsg'] = 'Din order är beställd!';
                header('location: index.php?msgTrigger=true');
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
    }

    private function getAllProducts()
    {
        if (isset($_GET['addToCart'])) {
            $productID = $_GET['addToCart'];
            $cart = $_SESSION['cart'];
            if (array_key_exists($productID, $cart)) {
                $_SESSION['cart'][$productID] ++;
            } else {
                $_SESSION['cart'][$productID] = 1;
            }
            $this->view->confirmMsg('Tillagd i varukorgen!');
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
