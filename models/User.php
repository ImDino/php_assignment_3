<?php

class RegisterUser {
    public $errors =[];

    public function __construct() {
        $this->errors = [];
    }

    public function newUser($user) {
        $email = htmlspecialchars($user['email']) ?? null;
        $firstName = htmlspecialchars($user['first_name']) ?? null;
        $lastName = htmlspecialchars($user['last_name']) ?? null;
        $password = htmlspecialchars($user['password']) ?? null;

        if (!$firstName || !$lastName || !$email || !$password || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errors,"Bad request");
        }
        if ($password < 6) array_push($this->errors,"Lösenordet måste bestå av minst 6 tecken.");
        //if ($this->emailExists($email)) array_push($errors,"Denna epost adress används redan.");
        
    }
}