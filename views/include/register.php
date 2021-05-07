<form action="/users/register" method="post">    
    <label for="inputEmail" class="visually-hidden">Email</label>
    <input
        type="email"
        id="inputEmail"
        name="email"
        class="form-control"
        placeholder="Email address"
        required autofocus>
    
    <label for="inputEmail" class="visually-hidden">First Name</label>
    <input
        type="text"
        id="inputName"
        name="name"
        class="form-control"
        placeholder="Name"
        required>
        
    <label for="inputEmail" class="visually-hidden">Last Name</label>
    <input
        type="text"
        id="inputName"
        name="name"
        class="form-control"
        placeholder="Name"
        required>
        
    <label for="inputPassword" class="visually-hidden">Password</label>
    <input
        type="password"
        id="inputPassword"
        name="password"
        class="form-control"
        placeholder="Password"
        required>
    
    <button class="w-100 btn btn-lg btn-primary" type="submit">Skapa konto</button>
</form>