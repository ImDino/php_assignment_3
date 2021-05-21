<!-- <div class="row d-flex justify-content-center"> -->
<div class="row">
<?php

$serverRoot = SERVER_ROOT;

foreach ($products as $product) {
    extract($product);
    $html = <<<HTML
    <a href="$serverRoot/details?id=$id">
        <div class="col-md-4-sm-6 d-flex align-items-stretch">
            <div class="card m-1" style="width: 16rem;">
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
                        <a href="$serverRoot/cart/?addToCart=$id" class="btn btn-primary rounded-circle p-2">Köp</a>
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