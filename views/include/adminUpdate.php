<form action="<?php echo SERVER_ROOT?>/admin/update?id=<?php echo $id?>" method="post" class="d-flex justify-content-center col-sm-8 col-md-6 col-lg-4">
    <div class="w-100">
        <label for="name">Namn:</label>
        <input required class="form-control " type="text" name="name" value="<?= $name ?>">

        <div class="form-group">
            <label for="Beskrivning">Beskrivning:</label>
            <textarea required class="form-control" id="exampleFormControlTextarea1" name="description" rows="5"><?= $description ?></textarea>
            
            <label for="image">Bild:</label>
            <input required class="form-control " type="text" name="img" value="<?= $img ?>">
        </div>

        <label for="price">Pris:</label>
        <input required class="form-control" type="number" placeholder="Pris" name="price" value="<?= $price ?>">

        <label for="instock">Lager saldo:</label>
        <input required class="form-control" type="number" placeholder="Lager saldo" name="instock" value="<?= $instock ?>">

        <button class=" btn btn-primary mt-3 w-100" type="submit">Uppdatera</button>
    </div>
</form>