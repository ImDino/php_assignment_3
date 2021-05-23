
<form action="<?php echo SERVER_ROOT?>/user/register" method="post" class="d-flex justify-content-center col-sm-8 col-md-6 col-lg-4">
    <div class="w-100">
        <label for="inputEmail" class="visually-hidden">Epost</label>
        <input
            type="email"
            id="inputEmail"
            name="email"
            class="form-control"
            placeholder="Ange Epost"
            value="<?php echo $_POST['email'] ?? ''?>"
            required autofocus>
        
        <label for="first_name" class="visually-hidden">Förnamn</label>
        <input
            type="text"
            id="first_name"
            name="first_name"
            class="form-control"
            placeholder="Ange förnamn"
            value="<?php echo $_POST['first_name'] ?? ''?>"
            required>
            
        <label for="last_name" class="visually-hidden">Efternamn</label>
        <input
            type="text"
            id="last_name"
            name="last_name"
            class="form-control"
            placeholder="Ange efternamn"
            value="<?php echo $_POST['last_name'] ?? ''?>"
            required>
            
        <label for="password" class="visually-hidden">Lösenord</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            placeholder="Ange lösenord"
            required>
        
        <button class="w-100 btn btn-lg btn-primary mt-5" type="submit">Skapa konto</button>
    </div>
</form>
