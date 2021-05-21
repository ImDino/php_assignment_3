<?php

$serverRoot = SERVER_ROOT;

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
                <a href="$serverRoot/cart/?addToCart=$id" class="btn btn-primary">Köp</a>
            </div>
        </div>
    </div>
</div>
HTML;

echo $html;


?>