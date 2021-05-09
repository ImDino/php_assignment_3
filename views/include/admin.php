<form>
    <input class="form-control" type="text" placeholder="Produkt namn">
    <div class="form-group">
        <label for="Beskrivning">Beskrivning</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
    </div>
    <input class="form-control" type="number" placeholder="Pris">
    <input class="form-control" type="number" placeholder="Lager saldo">
    <button class="btn btn-primary" type="submit">Submit</button>

</form>
<?php

echo $ul = "<ul>";
foreach ($products as $product) {
    $li = "<li>$product[name]
  <a href='#?id=$product[id]' class='btn btn-sm btn-outline-danger'>
      Tabort</a>
  <a href='page=admin_update?id=$product[id]' class='btn btn-sm btn-outline-success'>
      Redigera</a>
  </li>";
    echo $li;
}
echo $ul = "</ul>";


?>