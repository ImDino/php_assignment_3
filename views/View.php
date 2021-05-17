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

    public function checkoutPage($products = array(), $total = 0)
    {
        foreach ($products as $product) {
            extract($product);
            $html = <<<HTML
            <div class="col-md-6">
                <div class="card m-1">
                    <img class="card-img-top" src="$img" 
                            alt="$name">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h4>$name</h4>
                            <p>$description</p>
                            <p>Antal: $quantity</p>
                            <h5>Pris: $price kr</h5>
                            <a href="?page=checkout&removeFromCart=$id" class="btn btn-primary">Ta bort</a>
                        </div>
                    </div>
                </div>
            </div>
            HTML;
            echo $html;
        }

        if ($total) {
            echo "<h2>Totalt: $total</h2>";
            echo "<a class='btn btn-primary' href='?page=placeOrder'>Beställ</a>";
        } else {
            echo "Här var det tomt!";
        }
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

    public function allProducts($products)
    {
        foreach ($products as $product) {
            extract($product);
            $html = <<<HTML
            <div class="col-md-6">
                <div class="card m-1">
                    <img class="card-img-top" src="$img" 
                            alt="$name">
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h4>$name</h4>
                            <p>$description</p>
                            <h5>Pris: $price kr</h5>
                            <a href="?addToCart=$id" class="btn btn-primary">Köp</a>
                        </div>
                    </div>
                </div>
            </div>
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
