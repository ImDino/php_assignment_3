<?php


print_r($product); ?>

<form action="#" method="post" class="row">
    <input class="form-control" type="text" value="<?= $product[0]['name'] ?>" >
    <div class="form-group">
        <label for="Beskrivning">Beskrivning</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5">
        <?= $product[0]['description'] ?>
        </textarea>
    </div>
    <input class="form-control" type="number" placeholder="Pris" value="<?= $product[0]['price'] ?>">
    <input class="form-control" type="number" placeholder="Lager saldo">
    <button class="btn btn-primary" type="submit">Submit</button>

</form>
