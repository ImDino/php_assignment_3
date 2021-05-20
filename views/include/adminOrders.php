<div class="show-order-types">
    <a href="<?php echo SERVER_ROOT?>/admin/orders?page=adminOrders">
        <button>Alla beställningar</button>
    </a>
    <a href="<?php echo SERVER_ROOT?>/admin/orders?show=unsent_orders">
        <button>Oskickade beställningar</button>
    </a>
    <a href="<?php echo SERVER_ROOT?>/admin/orders?show=sent_orders">
        <button>Skickade beställning</button>
    </a>
</div>

<?php

echo "<div class='container'>";

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
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Order nr: $id</h5>
                        <p class="card-text">Användar ID: $user_id</p>
                        <p class="card-text">Order datum: $date</p>
                        <p class="card-text">Totalt: $total</p>
                        <p class="card-text">Status: $is_sent</p>
                        $statusBtn
                    </div>
                </div>
                HTML;
    echo $html;
}

echo "</div>";