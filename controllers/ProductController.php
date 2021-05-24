<?php
class ProductController
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
        $page = $_GET['url'] ?? '';

        switch ($page) {
            case 'details':
                $this->details();
                break;
            default:
                $this->products();
        }
    }

    private function details()
    {
        $id = $_GET['id'] ?? null;
        
        $this->view->header();
        try {
            $product = $this->model->fetchOneProduct($id);
        } catch (\Throwable $th) {
            Message::printError();
        }
        $this->view->productDetails($product);
        $this->view->footer();
    }

    private function products()
    {
        $this->view->header('Välkommen');
        try {
            $products = $this->model->fetchAllProducts();
        } catch (\Throwable $th) {
            Message::printError();
        }
        $this->view->productPage($products);
        $this->view->footer();
    }
}
