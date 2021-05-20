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
        $this->checkMsg();  // TODO ta bort
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
                header('location: '.SERVER_ROOT);
        }
    }

    private function checkMsg()  // TODO ta bort
    {
        $confirmMsg = $_SESSION['confirmMsg'] ?? null;
        
        if ($confirmMsg) {
            $this->view->confirmMsg($confirmMsg);
            $_SESSION['confirmMsg'] = null;
        }
    }

    private function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->model->getUser($_POST['email']);
                if (!$user || $user['password'] !== $_POST['password']) {
                    $this->view->errorMsg("Felaktig epost eller lösenord");
                } else {
                    $this->mapUserSession($user);
                    $_SESSION['confirmMsg'] = "Välkommen $user[first_name]!";
                    header('location: '.SERVER_ROOT);
                }
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        } else if (isset($_SESSION['email']) && $_SESSION['email']) {
            $_SESSION['confirmMsg'] = "Du är redan inloggad!";
            header('location: '.SERVER_ROOT);
        }
        $this->view->header('Login');
        $this->view->LoginPage();
        $this->view->footer();
    }

    private function logout()
    {
        $this->unmapUserSession();
        $_SESSION['confirmMsg'] = "Du är nu utloggad!";
        header('location: '.SERVER_ROOT);
    }

    private function register()
    {
        $this->view->header('Registrera dig');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->createUser($_POST);
                $_SESSION['confirmMsg'] = 'Ny användare skapad!';
                header('location: login');
            } catch (Exception $e) {
                $this->view->errorMsg();
            }
        }
        $this->view->RegisterPage();
        $this->view->footer();
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
