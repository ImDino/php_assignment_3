<?php
class Controller
{
    private $model;
    private $view;
    
    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
        $this->main();
    }

    public function main()
    {
        $this->model->createCart();
        $this->checkMsg();
        $this->router();
    }

    private function router()
    {
        $page = $_GET['url'] ?? '';

        switch ($page) {
            case 'cart':
                $this->cart();
                break;
            case 'placeOrder':
                $this->placeOrder();
                break;
            default:
                $this->products();
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

    private function cart()
    {
        $this->view->header('Kassan');
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
            $this->view->cartPage($products, $total);
        } else $this->view->cartPage();
        
        $this->view->footer();
    }

    private function placeOrder()
    {
        if (empty($_SESSION['cart'])) {
            header('location: '.SERVER_ROOT.'/login');
        }
        if (!isset($_SESSION['email']) && !$_SESSION['email']) {
            $_SESSION['confirmMsg'] = 'Vänligen logga in för att beställa din order!';
            header('location: '.SERVER_ROOT.'/user/login');
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
                header('location: '.SERVER_ROOT);
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
    }

    private function products()
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
        $this->view->header('Välkommen');
        try {
            $products = $this->model->fetchAllProducts();
        } catch (\Throwable $th) {
            $this->view->errorMsg();
        }
        $this->view->productPage($products);
        $this->view->footer();
    }
}
