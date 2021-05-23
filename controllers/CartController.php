<?php

class CartController
{
    private $model;
    private $view;
    private $total;
    private $cart;
    
    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
        $this->total = 0;
        $this->cart = $_SESSION['cart'] ?? $this->createCart();
        $this->main();
    }

    public function main()
    {
        $this->checkForUpdates();
        $this->router();
    }

    private function router()
    {
        $page = explode('/', $_GET['url'])[1] ?? '';

        switch ($page) {
            case '':
                $this->cart(); 
                break;
            case 'checkout':
                $this->checkout();
                break;
            default:
                header('location: '.SERVER_ROOT);
        }
    }

    private function addToCart()
    {
        $productID = $_GET['addToCart'];
        
        if (array_key_exists($productID, $this->cart)) {
            $_SESSION['cart'][$productID] ++;
        } else {
            $_SESSION['cart'][$productID] = 1;
        }
        $this->updateCart();
    }
    
    private function removeFromCart()
    {
        $productID = $_GET['removeFromCart'];
        
        if (array_key_exists($productID, $this->cart)) {
            $_SESSION['cart'][$productID]--;
            
            if ($_SESSION['cart'][$productID] == 0) {
                unset($_SESSION['cart'][$productID]);
            }
        }
        $this->updateCart();
    }

    private function cart()
    {
        $this->view->header('Kassan');

        if (empty($this->cart)) {
            $this->view->cartPage();  
        } else {
            $products = $this->getProducts();
            $this->view->cartPage($products, $this->total);
        }
        $this->view->footer();
    }
    
    private function checkout()
    {
        $userID = $_SESSION['id'] ?? null;
        
        if (empty($this->cart)) {
            header('location: '.SERVER_ROOT);
        }
        else if (!$userID) {
            Message::set('Vänligen logga in för att beställa!');
            exit(header('location: '.SERVER_ROOT.'/user/login'));
        }

        $products = $this->getProducts();
        try {
            $this->model->createOrder($userID, $this->formatProductsForDB($products) , $this->total);
            $_SESSION['cart'] = array();
            Message::set('Tack för din beställning!');
            header('location: '.SERVER_ROOT);
        } catch (\Throwable $th) {
            Message::printError();
        }
    }

    private function getProducts()
    {
        $output = array();

        foreach ($this->cart as $productID => $quantity) {
            $product = $this->model->fetchOneProduct($productID);
            $product['quantity'] = $quantity;
            $this->total += $product['price']*$quantity;
            array_push($output, $product);
        }
        return $output;
    }

    private function formatProductsForDB($products)
    {
        $output = array();
        
        foreach ($products as $product) {
            $temp = array('id' => $product['id'], 'qty' => $product['quantity']);
            array_push($output, $temp);
        }
        return json_encode($output);
    }

    private function checkForUpdates()
    {
        if (isset($_GET['addToCart'])) {
            $this->addToCart();
            if (!$this->isRequestFromCart()) {
                Message::set('Tillagd i varukorgen!');
                exit(header('Location: ' . $_SERVER["HTTP_REFERER"]));
            }
        } else if (isset($_GET['removeFromCart'])) {
            $this->removeFromCart();
        }
    }

    private function updateCart()
    {
        $this->cart = $_SESSION['cart'];
    }

    private function createCart()
    {
        $_SESSION['cart'] = array();
        return array();
    }

    private function isRequestFromCart() {
        $origin = $_SERVER['HTTP_REFERER'];
        return strpos($origin, 'cart');
    }
}

?>