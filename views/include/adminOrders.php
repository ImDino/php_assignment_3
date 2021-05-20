<div class="show-order-types"> //TODO ändra till absolute path?
    <a href="?page=adminOrders"><button>Alla beställningar</button></a>
    <a href="?page=adminOrders&show=unsent_orders"><button>Oskickade beställningar</button></a>
    <a href="?page=adminOrders&show=sent_orders"><button>Skickade beställning</button></a>
</div>

<?php

echo "<div class='container'>";

if(isset($_GET['show'])){ //TODO gör en snyggare lösning
    if($_GET['show'] == "unsent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 0; });
    }
    else if($_GET['show'] == "sent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 1; });
    }
    sort($orders);
}

foreach ($orders as $index => $order) {
    extract($order);
    
    if($is_sent == 0) {
        $statusBtn = "<a href='?action=send&id=$id'>Ändra till skickad</a>"; //TODO ändra till absolute path?
    } else {
        $statusBtn = "<a href='?action=unsend&id=$id'>Återkalla</a>"; //TODO ändra till absolute path?
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