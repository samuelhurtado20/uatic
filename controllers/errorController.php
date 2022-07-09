<?php

class errorController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->_view->titulo = 'error';
        $this->_view->mensaje = $this->_getError();
        $this->_view->renderizar('index');
    }
    
    public function access($codigo){
        $this->_view->titulo = 'error';
        $this->_view->mensaje = $this->_getError($codigo);
        $this->_view->renderizar('access'); 
    }

        private function _getError($codigo = false){
        
        if($codigo){
            $codigo = $this->filtrarInt($codigo);
            if (is_int($codigo))
                $codigo = $codigo;
        }
        else{
            $codigo = 'default';
        }
        
        
        $error['default'] = 'Ha Ocurrido Un Error';
        $error['5050'] = 'Acceso Restringido';
        $error['8080'] = 'Tiempo De La Session Expirado';
        
        if (array_key_exists($codigo, $error)){
            return $error[$codigo];
        }
        else{
            return $error['default'];
        }
    }
}

?>
