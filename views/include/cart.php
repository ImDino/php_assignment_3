<?php

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
                    <a href="cart?removeFromCart=$id" class="btn btn-primary">Ta bort</a>
                </div>
            </div>
        </div>
    </div>
    HTML;
    echo $html;
}

if ($total) {
    echo "<h2>Totalt: $total</h2>";
    echo "<a class='btn btn-primary' href='placeOrder'>Beställ</a>";
} else {
    echo "Här var det tomt!";
}

?>