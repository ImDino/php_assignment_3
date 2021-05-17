<div class="show-order-types">
    <a href="?page=adminOrders"><button>Alla beställningar</button></a>
    <a href="?page=adminOrders&show=unsent_orders"><button>Oskickade beställningar</button></a>
    <a href="?page=adminOrders&show=sent_orders"><button>Skickade beställning</button></a>
</div>

<?php

echo "<div class='container'>";

if(isset($_GET['show'])){
    if($_GET['show'] == "unsent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 0; });
    }
    if($_GET['show'] == "sent_orders") {
        $orders = array_filter($orders, function($x) { return $x['is_sent'] == 1; });
    }
    sort($orders);
}

for ($i = 0; $i < count($orders); $i++) {

        $products = json_decode($orders[$i]['products'], true);
        $id = $orders[$i]['id'];
        echo "<div class='row'>";
        echo "Order nr: " . ($i + 1) . "<br/>";
        echo "Användar ID: " . $orders[$i]['user_id'] . "<br/>";
        echo "Order datum: " . $orders[$i]['date'] . "<br/>";
        echo "Produkter: " . $products['key'] . "<br/>";
        echo "Totalt: " . $orders[$i]['total'] . " SEK" . "<br/>";
        echo "Status: " . $orders[$i]['is_sent'] . "<br/>";

        if($orders[$i]['is_sent'] == 0) {
            echo "<a href='?page=adminOrders&action=send&id=$id'>
            Ändra till skickad</a>" . "<br/>";
        }
        if($orders[$i]['is_sent'] == 1) {
            echo "<a href='?page=adminOrders&action=unsend&id=$id'>
            Ångra skickad</a>" . "<br/>";
        }
       


        echo "</div>";
        echo "<br>";
        echo "<br>";

}
echo "</div>";