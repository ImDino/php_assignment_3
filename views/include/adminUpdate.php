<form action="update" method="post" class="mx-auto">
    <label for="title">Titel</label>
    <input required class="form-control " type="text" name="name" value="<?= $name ?>">
    <div class="form-group">
        <label for="Beskrivning">Beskrivning</label>
        <textarea required class="form-control" id="exampleFormControlTextarea1" name="description" rows="5">
        <?= $description ?>
        </textarea>
        <label for="image">Bild</label>

        <input required class="form-control " type="text" name="img" value="<?= $img ?>">
    </div>
    <label for="price">Pris</label>

    <input required class="form-control" type="number" placeholder="Pris" name="price" value="<?= $price ?>">
    <label for="instock">Lager saldo</label>

    <input required class="form-control" type="number" placeholder="Lager saldo" name="instock" value="<?= $instock ?>">

    <button class=" btn btn-primary" type="submit">Uppdatera</button>
</form>