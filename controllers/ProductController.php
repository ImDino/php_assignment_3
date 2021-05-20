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
            // TODO fixa route för productDetails
            default:
                $this->products();
        }
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

    private function product() {
        // TODO detaljsida för produkt, med description och större bild m.m.
    }
}
