<?php

class View{

    public function viewHeader($title){
        include_once ("views/include/header.php");
    }

    public function viewFooter(){
        include_once ("views/include/footer.php");
    }

    public function viewAboutPage(){
        include_once ("views/include/about.php");
    }
    
    public function viewLoginPage(){
        include_once ("views/include/login.php");
    }
    
    public function viewRegisterPage(){
        include_once ("views/include/register.php");
    }

    public function viewCheckoutPage(){
        include_once ("views/include/checkout.php");
    }

    public function viewAllProducts($products)
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
}