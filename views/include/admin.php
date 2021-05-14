<div>
    <a href="?page=adminCreate">
        <button class="btn btn-primary">Lägg till ny produkt</button>
    </a>
    <a href="?page=adminOrders">
        <button class="btn btn-primary">Ordrar</button>
    </a>
</div>
<?php

echo $ul = "<ul class='mx-auto'>";
foreach ($products as $product) {
    $li = "<li>$product[name]
  <a href='?page=adminDelete&id=$product[id]' class=' btn btn-sm btn-outline-danger'>
      Tabort</a>
  <a href='?page=adminUpdate&id=$product[id]' class=' btn btn-sm btn-outline-success'>
      Redigera</a>
  </li>";
    echo $li;
}
echo $ul = "</ul>";


?>