<form action="?page=login" method="post">
    <label for="inputEmail" class="visually-hidden">Email address</label>
    <input
        type="email"
        id="inputEmail"
        name="email"
        class="form-control w-50"
        placeholder="Email address"
        required autofocus>
    
    <label for="inputPassword" class="visually-hidden">Password</label>
    <input
        type="password"
        id="inputPassword"
        name="password"
        class="form-control w-50"
        placeholder="Password"
        required>
    
    <button class="w-50 btn btn-lg btn-primary mb-2" type="submit">Sign in</button>
    <p>Not a user?</p>
    <a class="w-50 btn btn-lg btn-success" href="?page=register">Register</a>
</form>