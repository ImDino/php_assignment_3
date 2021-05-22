<div class="col-12 d-flex justify-content-center mb-5">
    <div class="col-6 float-right">
        <a href="<?php echo SERVER_ROOT ?>/admin/create">
            <button class="w-75 btn btn-primary ">Lägg till ny produkt</button>
        </a>
    </div>
    <div class="col-6">
        <a href="<?php echo SERVER_ROOT ?>/admin/orders">
            <button class="w-75 btn btn-primary">Ordrar</button>
        </a>
    </div>
</div>

<?php

$serverRoot = SERVER_ROOT;


foreach ($products as $product) {

    $html =
        "<div class='col-12 d-flex justify-content-between'>
                <h5>$product[name]</h5>
                    <div class='row '>
                            <a href='$serverRoot/admin/delete?id=$product[id]' class='mr-2 btn btn-sm btn-outline-danger'>
                            Tabort
                            </a>
                            <a href='$serverRoot/admin/update?id=$product[id]' class=' btn btn-sm btn-outline-success'>
                            Redigera
                            </a>
                    </div>
            </div>
            <hr style='margin:1px,0,10px,0'>";
    echo $html;
}
?>