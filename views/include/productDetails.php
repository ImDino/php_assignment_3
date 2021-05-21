<?php

$serverRoot = SERVER_ROOT;

extract($product);
$html = <<<HTML
<div class="row d-flex justify-content-center align-items-center" style="margin-top: 100px;">
    <div class="col-md-6">
        <img class="card-img-top mb-5" src="$img" alt="$name">
    </div>
    <div class="col-md-6">
        <h4>$name</h4>
        <p class="pr-4">$description</p>
        <h5>Pris: $price kr</h5>
        <a href="$serverRoot/cart/?addToCart=$id" class="btn btn-primary">Köp</a>
    </div>
</div>
HTML;

echo $html;


?>