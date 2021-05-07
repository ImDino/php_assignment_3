<?php

class View{

    public function viewHeader($title){
        include_once ("views/include/header.php");
    }

    public function viewFooter(){
        include_once ("views/include/footer.php");
    }

    public function viewAboutPage(){
        include_once ("views/include/about.php");
    }

    

    // Bra att läsa om PHP Templating och HEREDOC syntax!
    // https://css-tricks.com/php-templating-in-just-php/

    public function viewOneMovie($movie)
    {
        $html = <<<HTML
        
            <div class="col-md-6">
                    <div class="card m-1">
                        <img class="card-img-top" src="images/$movie[image]" 
                             alt="$movie[title]">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h4>$movie[title]</h4>
                                <h5>Pris: $movie[price] kr</h5>
                            </div>
                        </div>
                    </div>
            </div>  <!-- col -->

        HTML;

        echo $html;
    }


    public function viewAllMovies($movies)
    {
        foreach ($movies as $movie) {
            $this->viewOneMovie($movie);
        }
    }


}