<form action="<?php echo SERVER_ROOT?>/admin/create" method="post" class="d-flex justify-content-center col-sm-8 col-md-6 col-lg-4">
    <div class="w-100">
        <label for="name">Namn:</label>
        <input required class="form-control" type="text" name="name" placeholder="Namn">
        <label for="description">Beskrivning:</label>
        <div class="form-group">
            <textarea required class="form-control" id="exampleFormControlTextarea1" rows="5" name="description" placeholder="Beskrivning"></textarea>
        </div>
        <label for="price">Pris:</label>
        <input required class="form-control" type="number" placeholder="Pris" name="price" step=".01">
        <label for="image">Bild:</label>
        <input required class="form-control" type="text" placeholder="Bild" name="img">
        <label for="stock">Lager saldo:</label>
        <input required class="form-control" type="number" placeholder="Lager saldo" name="instock">
        <button class="btn btn-primary mt-3 w-100" type="submit">Skapa produkt</button>
    </div>
</form>