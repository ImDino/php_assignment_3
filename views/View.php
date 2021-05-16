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

    public function aboutPage()
    {
        include_once('views/include/about.php');
    }

    public function loginPage()
    {
        include_once('views/include/login.php');
    }

    public function registerPage()
    {
        include_once('views/include/register.php');
    }

    public function checkoutPage()
    {
        include_once('views/include/checkout.php');
    }

    public function adminUpdatePage($product)
    {
        include_once('views/include/adminUpdate.php');
    }

    public function adminCreatePage()
    {
        include_once('views/include/adminCreate.php');
    }

    public function adminPage($products)
    {
        include_once('views/include/admin.php');
    }

    public function allProducts($products)
    {
        foreach ($products as $product) {
            $html = <<<HTML
        
            <div class="col-md-6">
                <div class="card m-1">
                    <img class="card-img-top" src="$product[img]" 
                            alt="$product[name]">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h4>$product[name]</h4>
                            <p>$product[description]</p>
                            <h5>Pris: $product[price] kr</h5>
                            <button>Köp</button>
                        </div>
                    </div>
                </div>
            </div>  <!-- col -->

            HTML;

            echo $html;
        }
    }

    public function confirmMsg($text) //REVIEW måste det vara såhär indenterat???
    {
        $html = <<< HTML
                <div class="my-2 alert alert-success message message-animation">
                    <h4>$text</h4>
                </div>
                HTML;
        echo $html;
    }
    
    public function errorMsg() //REVIEW måste det vara såhär indenterat???
    {
        $html = <<< HTML
                <div class="my-2 alert alert-danger message message-animation">
                    <h4>Något gick snett! Försök igen.</h4>
                </div>
                HTML;
        echo $html;
    }
}
