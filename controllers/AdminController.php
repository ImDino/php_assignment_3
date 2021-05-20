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
        $this->checkIfAdmin();
        $this->router();
    }

    private function router()
    {
        $page = explode('/', $_GET['url'])[1] ?? '';
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
                header('location: '.SERVER_ROOT.'/admin');
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
            $this->handleUpdate($id);
        }
        $this->view->header('Redigera produkten');
        $product = $this->model->fetchOneProduct($id);
        $this->view->adminUpdatePage($product);
        $this->view->footer();
    }

    private function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleCreation();
        }
        $this->view->header('Ny produkt');
        $this->view->adminCreatePage();
        $this->view->footer();
    }
    
    private function delete($id)
    {
        try {
            $this->model->deleteProduct($id);
            Message::set('Artikel borttagen');
            header('location: '.SERVER_ROOT.'/admin');
        } catch (\Throwable $th) {
            Message::printError();
        }
    }
    
    private function orders($id)
    {
        if (isset($_GET['action'])) {
            $this->handleOrderAction($id);
        }
        $this->view->header('Alla ordrar');
        $orders = $this->model->fetchAllOrders();
        $this->view->adminOrdersPage($orders);
        $this->view->footer();
    }

    private function checkIfAdmin()
    {
        $isAdmin = $_SESSION['isAdmin'] ?? null;
        if (!$isAdmin) {
            exit(header('location: '.SERVER_ROOT));
        }
    }

    private function handleOrderAction($id)
    {
        $action = $_GET['action'] ?? null;

        if ($action == "send") {
            try {
                $this->model->updateShippingStatus($id, 1);
                Message::set('Order skickad!');
                exit(header('location: orders'));
            } catch (\Throwable $th) {
                Message::printError();
            }
        }
        else if ($action == "unsend") {
            try {
                $this->model->updateShippingStatus($id, 0);
                Message::set('Order återkallad!');
                exit(header('location: orders'));
            } catch (\Throwable $th) {
                Message::printError();
            }
        }
    }

    private function handleUpdate($id)
    {
        $product = $_POST;
        try {
            $this->model->updateProduct($product, $id);
            Message::set('Produkten är uppdaterad!');
            exit(header('location: '.SERVER_ROOT.'/admin'));
        } catch (\Throwable $th) {
            Message::printError();
        }
    }

    private function handleCreation()
    {
        $product = $_POST;
        try {
            $this->model->createProduct($product);
            Message::set('Ny artikel skapad!');
            exit(header('location: '.SERVER_ROOT.'/admin'));
        } catch (\Throwable $th) {
            Message::printError();
        }
    }
}
