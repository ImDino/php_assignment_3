<?php

class View
{
    public function header($title)
    {
        include_once('views/include/header.php');
    }

    public function footer()
    {
        include_once('views/include/footer.php');
    }

    public function loginPage()
    {
        include_once('views/include/login.php');
    }

    public function registerPage()
    {
        include_once('views/include/register.php');
    }
    
    public function cartPage($products = array(), $total = 0)
    {
        include_once('views/include/cart.php');
    }

    public function adminUpdatePage($product)
    {
        extract($product);
        include_once('views/include/adminUpdate.php');
    }

    public function adminCreatePage()
    {
        include_once('views/include/adminCreate.php');
    }

    public function adminOrdersPage($orders)
    {
        include_once("views/include/adminOrders.php");
    }

    public function adminPage($products)
    {
        include_once('views/include/admin.php');
    }
    
    public function productPage($products)
    {
        include_once('views/include/products.php');
    }

    public function confirmMsg($text)
    {
        $html = <<< HTML
                <div class="my-2 alert alert-success message message-animation">
                    <h4>$text</h4>
                </div>
                HTML;
        echo $html;
    }
    
    public function errorMsg($message = 'Något gick snett! Försök igen.')
    {
        $html = <<< HTML
                <div class="my-2 alert alert-danger message message-animation">
                    <h4>$message</h4>
                </div>
                HTML;
        echo $html;
    }
}
