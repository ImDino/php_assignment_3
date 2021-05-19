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
        $this->model->createCart();
        $this->router();
        
        $msgTrigger = $_GET['msgTrigger'] ?? null;
        if ($msgTrigger) {
            $this->checkMsg();
        }
    }

    private function router()
    {
        $page = explode('/', $_GET['url'])[1] ?? "";

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
                /* header('location: .'); */
        }
    }

    private function checkMsg()
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
                if (!$user) {
                    $this->view->errorMsg("Felaktigt användarnamn eller lösenord");
                } else {
                    $_SESSION['name'] = $user['first_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['isAdmin'] = $user['is_admin'];
                    $_SESSION['confirmMsg'] = "Välkommen $user[first_name]!";
                    $serverRoot = SERVER_ROOT;
                    header("location: $serverRoot?msgTrigger=true");
                }
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        } else if (isset($_SESSION['email']) && $_SESSION['email']) {
            header('location: index.php');
        }
        $this->view->header('Login');
        $this->view->LoginPage();
        $this->view->footer();
    }

    private function logout() {
        $_SESSION['id'] = null;
        $_SESSION['name'] = null;
        $_SESSION['email'] = null;
        $_SESSION['isAdmin'] = null;
        $_SESSION['confirmMsg'] = "Du är nu utloggad!";
        $serverRoot = SERVER_ROOT;
        header("location: $serverRoot?msgTrigger=true");
    }

    private function register()
    {
        $this->view->header('Registrera dig');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->createUser($_POST);
                $_SESSION['confirmMsg'] = 'Ny användare skapad!';
                header('location: ?page=login&msgTrigger=true');
            } catch (Exception $e) {
                $this->view->errorMsg();
            }
        }
        $this->view->RegisterPage();
        $this->view->footer();
    }
}
