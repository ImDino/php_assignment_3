


<form action="<?php echo SERVER_ROOT?>/user/login" method="post" class="d-flex justify-content-center col-sm-8 col-md-6 col-lg-4">
    <div class="w-100">
        <label for="inputEmail" class="visually-hidden">Epost</label>
        <input
            type="email"
            id="inputEmail"
            name="email"
            class="form-control"
            placeholder="Epost"
            required autofocus>
        
        <label for="inputPassword" class="visually-hidden mt-2">Lösenord</label>
        <input
            type="password"
            id="inputPassword"
            name="password"
            class="form-control"
            placeholder="Lösenord"
            required>
        
        <button class="w-100 btn btn-lg btn-primary mb-2 mt-5" type="submit">Logga in</button>
        <p class="text-center font-weight-bold mt-2">Ny användare?</p>
        <a class="w-100 btn btn-lg btn-success" href="register">Skapa konto</a>
    </div>
</form>
