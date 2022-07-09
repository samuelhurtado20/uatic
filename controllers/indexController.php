<?php

class indexController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }

        public function index(){
            
            
            if (!Session::get('autenticado')){
            header('location:' . BASE_URL . 'login');
            exit;
        }
            
            $this->_view->titulo = 'Inicio';   
            $this->_view->renderizar('index', 'inicio');
    }
    
}
?>
