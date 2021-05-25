<?php
class UserController
{
    private $model;
    private $view;
    
    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
        $this->main();
    }

    public function main()
    {
        $this->router();
    }

    private function router()
    {
        $page = explode('/', $_GET['url'])[1] ?? '';

        switch ($page) {
            case 'login':
                $this->login();
                break;
            case "logout":
                $this->logout();
                break;
            case 'register':
                $this->register();
                break;
            default:
                exit(header('location: '.SERVER_ROOT));
        }
    }
    
    private function login()
    {
        $isLoggedIn = isset($_SESSION['email']) && $_SESSION['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleLogin();
        } else if ($isLoggedIn) {
            Message::set("Du är redan inloggad!");
            exit(header('location: '.SERVER_ROOT.'/'));
        }
        $this->view->header('Login');
        $this->view->loginPage();
        $this->view->footer();
    }

    private function logout()
    {
        $this->unmapUserSession();
        Message::set("Du är nu utloggad!");
        exit(header('location: '.SERVER_ROOT.'/'));
    }

    private function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleRegistration();
        }
        $this->view->header('Registrera dig');
        $this->view->registerPage();
        $this->view->footer();
    }

    private function handleLogin()
    {
        try {
            $user = $this->model->getUser($_POST['email']);
            if (!$user || $user['password'] !== $_POST['password']) {
                Message::printError("Felaktig epost eller lösenord");
            } else {
                $this->mapUserSession($user);
                Message::set("Välkommen $user[first_name]!");
                exit(header('location: '.SERVER_ROOT.'/'));
            }
        } catch (\Throwable $th) {
            Message::printError();
        }
    }

    private function handleRegistration()
    {
        try {
            $this->model->createUser($_POST);
            Message::set('Ny användare skapad!');
            exit(header('location: '.SERVER_ROOT.'/user/login'));
        } catch (Exception $e) {
            $msgToUser = $this->model->errorMsg ?? null;
            
            if ($msgToUser) {
                Message::printError($msgToUser);
            } else {
                Message::printError();
            }
        }
    }

    private function mapUserSession($user)
    {
        $_SESSION['name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['isAdmin'] = $user['is_admin'];
    }

    private function unmapUserSession()
    {
        $_SESSION['id'] = null;
        $_SESSION['name'] = null;
        $_SESSION['email'] = null;
        $_SESSION['isAdmin'] = null;
    }
}
