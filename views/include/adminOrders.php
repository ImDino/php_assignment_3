<?php


// $test = json_decode($orders[2]['products'], true);
// echo "<pre>";
// print_r($test);
// echo "</pre>";



echo "<div class='container'>";
for ($i = 0; $i < count($orders); $i++) {

    if ($orders[$i]['is_sent'] == 0) {


        $products = json_decode($orders[$i]['products'], true);
        $id = $orders[$i]['id'];
        echo "<div class='row'>";
        echo "Order nr: " . ($i + 1) . "<br/>";
        echo "Användar ID: " . $orders[$i]['user_id'] . "<br/>";
        echo "Order datum: " . $orders[$i]['date'] . "<br/>";
        echo "Produkter: " . $products['key'] . "<br/>";
        echo "Totalt: " . $orders[$i]['total'] . " SEK" . "<br/>";
        echo $orders[$i]['is_sent'] ? "Status 1" : " Status 0" . "<br/>";
        echo "<a href='?page=adminUpdateOrder&id=$id'>
            Ändra till skickad</a>" . "<br/>";
        echo "</div>";
        echo "<br>";
        echo "<br>";
    }
}
echo "</div>";
