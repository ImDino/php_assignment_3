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
        $this->cart = $_SESSION['cart'];
        $this->main();
    }

    public function main()
    {
        $this->createCart();
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

    private function addToCart() {
        $productID = $_GET['addToCart'];
        
        if (array_key_exists($productID, $this->cart)) {
            $_SESSION['cart'][$productID] ++;
        } else {
            $_SESSION['cart'][$productID] = 1;
        }
        $this->updateCart();
        
    }
    
    private function removeFromCart() {
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
        $email = $_SESSION['email'] ?? null;

        if (empty($this->cart)) {
            header('location: '.SERVER_ROOT);
        }
        if (!$email) {
            $_SESSION['confirmMsg'] = 'Vänligen logga in för att beställa din order!';
            header('location: '.SERVER_ROOT.'/user/login');
        }

        $products = $this->getProducts();
        try {
            $userID = $_SESSION['id'];

            $this->formatProductsForDB($products);
            /* $this->model->createOrder($userID, $this->formatProductsForDB($products) , $this->total);
            $_SESSION['cart'] = array();
            $_SESSION['confirmMsg'] = 'Din order är beställd!';
            header('location: '.SERVER_ROOT); */
        } catch (\Throwable $th) {
            $this->view->errorMsg();
        }
    }

    private function getProducts()
    {
        $output = array();
        foreach ($_SESSION['cart'] as $productID => $quantity) {
            $product = $this->model->fetchOneProduct($productID);
            array_push($output, $product);
            $this->total += $product['price']*$quantity;
        }
        return $output;
    }

    private function formatProductsForDB($products)
    {
        $output = array();
        foreach ($products as $productID => $value) {
            echo $productID;
            echo $value;
            //$product = array('id' => $productID, 'qty' => $quantity);
            //array_push($output, $product);
        }
        return json_encode($output);
    }

    private function checkForUpdates() {
        if (isset($_GET['addToCart'])) {
            $this->addToCart();
            $this->view->confirmMsg('Tillagd i varukorgen!');
        } else if (isset($_GET['removeFromCart'])) {
            $this->removeFromCart();
        }
    }

    private function updateCart() {
        $this->cart = $_SESSION['cart'];
    }
}

?>