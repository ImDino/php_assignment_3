<?php
class AdminController
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

    /*
    TODO på main, kolla om isAdmin i session är true annars redirect till index.php.
    */

    private function router()
    {
        $page = explode('/', $_GET['url'])[1] ?? "";
        $id = $_GET['id'] ?? '';
        
        switch ($page) {
            case '':
                $this->admin();
                break;
            case 'update':
                $this->update($id);
                break;
            case 'create':
                $this->create();
                break;
            case 'delete':
                $this->delete($id);
                break;
            case "orders":
                $this->orders($id);
                break;
            default:
                header("location: .");
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

    private function admin()
    {
        $this->view->header('Admin');
        $products = $this->model->fetchAllProducts();
        $this->view->adminPage($products);
        $this->view->footer();
    }

    private function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "hej";
            $product = $_POST;
            try {
                $this->model->updateProduct($product, $id);
                $_SESSION['confirmMsg'] = 'Produkten är uppdaterad!';
                $serverRoot = SERVER_ROOT;
                header("location: $serverRoot/admin?msgTrigger=true");
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
        $this->view->header('Admin Update');
        $product = $this->model->fetchOneProduct($id);
        $this->view->adminUpdatePage($product);
        $this->view->footer();
    }

    private function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = $_POST;
            try {
                $this->model->createProduct($product);
                $_SESSION['confirmMsg'] = 'Ny artikel skapad!';
                $serverRoot = SERVER_ROOT;
                header("location: $serverRoot/admin?msgTrigger=true");
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
        $this->view->header('Lägg till ny produkt');
        $this->view->adminCreatePage();
        $this->view->footer();
    }
    
    private function delete($id)
    {
        try {
            $this->model->deleteProduct($id);
            $_SESSION['confirmMsg'] = 'Artikel borttagen';
            header('location: ?msgTrigger=true');
        } catch (\Throwable $th) {
            $this->view->errorMsg();
        }
    }
    
    private function orders($id)
    {
        if ($id) {
            try {
                $action = $_GET['action'];
                if($action == "send"){
                    $this->model->updateOrderSend($id);
                    $_SESSION['confirmMsg'] = 'Order skickad!';
                    header('location: orders?msgTrigger=true');
                }
                if($action == "unsend"){
                    $this->model->updateOrderUnSend($id);
                    $_SESSION['confirmMsg'] = 'Order återkallad!';
                    header('location: orders?msgTrigger=true');
                }
            } catch (\Throwable $th) {
                $this->view->errorMsg();
            }
        }
        $this->view->header('Alla ordrar');
        $orders = $this->model->fetchAllOrders();
        $this->view->adminOrdersPage($orders);
        $this->view->footer();
    }
}
