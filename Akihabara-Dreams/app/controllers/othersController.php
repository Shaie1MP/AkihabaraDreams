<?php

class OtthersController {
    protected OthersRepository $othersRepository;


    public function __construct(OthersRepository $othersRepository)
    {
        $this->othersRepository = $othersRepository;
    }

    public function admin(){
        include '../app/views/admin.php';
    }

    public function catalog(){
        $products = $this->othersRepository->catalog();
        include '../app/views/catalog.php';
    }

    public function mangas(){
        $products = $this->othersRepository->mangas();
        include '../app/views/catalog.php';
    }

    public function figures(){
        $products = $this->othersRepository->figures();
        include '../app/views/catalog.php';
    }

    public function merchandising(){
        $products = $this->othersRepository->merchandising();
        include '../app/views/catalog.php';
    }

    public function promotions(){
        $products = $this->othersRepository->promotions();
        include '../app/views/catalog.php';
    }

    public function index(){
        $products = $this->othersRepository->index();
        include '../app/views/index.php';
    }
}
?>