<!-- <div class="row d-flex justify-content-center"> -->

<div class="row">



<?php

$serverRoot = SERVER_ROOT;

foreach ($products as $product) {
    extract($product);
    $html = <<<HTML
    <a href="$serverRoot/details?id=$id">
        <div class="col-lg-3 col-md-6 col-sm-12 p-0 mb-2">
            <div class="card m-1 h-100">
                <img class="card-img-top img-fluid p-4" src="$img" alt="$name">
                <div class="card-body">
                    <div class="card-title">
                        <h5>$name</h5>
                    </div>
                    <div class="card-text">
                        <div class="mt-2">
                            <h6>Pris: $price kr</h6>
                        </div>
                    </div>
                    <div class="cart-add">
                        <a href="$serverRoot/cart/?addToCart=$id" class="btn  rounded-circle p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </a>
    HTML;
        
    echo $html;
}

?>
</div>