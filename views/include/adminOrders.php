<div class="w-100 d-flex justify-content-center mb-5">
    <a href="<?php echo SERVER_ROOT?>/admin/orders?page=adminOrders" class="col-md-2 btn btn-primary">
        Alla
    </a>
    <a href="<?php echo SERVER_ROOT?>/admin/orders?show=unsent_orders" class="col-md-2 btn btn-primary mr-1 ml-1">
        Ej skickade
    </a>
    <a href="<?php echo SERVER_ROOT?>/admin/orders?show=sent_orders" class="col-md-2 btn btn-primary">
        Skickade
    </a>
</div>

<?php



if (isset($_GET['show'])) {
    if ($_GET['show'] == "unsent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 0; });
    }
    else if ($_GET['show'] == "sent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 1; });
    }
    sort($orders);
}

foreach ($orders as $order) {
    extract($order);
    
    if($is_sent == 0) {
        $statusBtn = "<a href='?action=send&id=$id' class='btn btn-sm btn-outline-success'>Ändra till skickad</a>";
    } else {
        $statusBtn = "<a href='?action=unsend&id=$id' class='btn btn-sm btn-outline-success'>Återkalla</a>";
    }

    $html = <<< HTML
                <div style="width: 18rem;">
                    <div>
                        <h5>Order nr: $id</h5>
                        <p>Användar ID: $user_id</p>
                        <p>Order datum: $date</p>
                        <p>Totalt: $total</p>
                        <p>Status: $is_sent</p>
                        $statusBtn
                    </div>
                </div>
                HTML;
    echo $html;
    echo "<hr  class='w-100'>";
}
