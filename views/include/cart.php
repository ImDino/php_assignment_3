<?php

$serverRoot = SERVER_ROOT;
$user = $_SESSION['id'] ?? null;

foreach ($products as $product) {
    extract($product);
    $html = <<<HTML
    <div class="row d-flex align-items-center w-100">
        <div class="col-2 p-0">
            <img class="img-fluid" src="$img" alt="$name">
        </div>
        <div class="d-flex justify-content-between col-10">
            <h5 class="align-self-center">$name</h5>
            <div class="d-flex justify-content-between align-items-center">
                <p class="font-weight-bold pt-3">Pris: $price kr</p>
                <div class="d-flex flex-column ml-5">
                    <div class="row mt-3">
                        <a href="$serverRoot/cart?removeFromCart=$id" class="btn btn-primary">-</a>
                        <a href="$serverRoot/cart?addToCart=$id" class="btn btn-primary ml-1">+</a>
                    </div>
                    <p class="row">Antal: $quantity</p>
                </div>
            </div>
        </div>
        <hr style="width: 100%;">
    </div> 
    HTML;
    echo $html;
}

$checkoutBtn = $user ?
                "<a class='btn btn-lg btn-success btn-block' style='max-width: 200px;' href='$serverRoot/cart/checkout'>Beställ</a>"
                :
                "<a class='btn btn-lg btn-success btn-block' style='max-width: 200px;' href='$serverRoot/user/login'>Logga in för att beställa</a>";

if ($total) {
    echo "<div class='d-flex flex-column'>
            <div>
                <h2>Totalt: $total kr</h2>
                $checkoutBtn
            </div>
        </div>";
} else {
    echo "Här var det tomt!";
}

?> 
