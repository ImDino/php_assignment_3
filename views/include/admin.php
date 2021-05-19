<div>
    <a href="admin/create">
        <button class="btn btn-primary">Lägg till ny produkt</button>
    </a>
    <a href="admin/orders">
        <button class="btn btn-primary">Ordrar</button>
    </a>
</div>

<?php

echo "<ul class='mx-auto'>";

foreach ($products as $product) {
    $li = "<li>$product[name]
                <a href='admin/delete?id=$product[id]' class=' btn btn-sm btn-outline-danger'>
                    Tabort
                </a>
                <a href='admin/update?id=$product[id]' class=' btn btn-sm btn-outline-success'>
                    Redigera
                </a>
            </li>";
    echo $li;
}
echo "</ul>";

?>