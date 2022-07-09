<?php

abstract class Controller{
    protected $_view;
    
    public function __construct() {
        $this->_view = new View(new Request);
    }
    
    abstract public function index();
    protected function load_model($modelo){
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
        
        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else {
            throw new Exception('error de modelo');
        }
    }
    
    protected function getLibrary ($libreria){
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        
        if (is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            throw new Exception('error de alguna libreria');
        }
        
    }
    
    protected function getTexto($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
        return '';
    }

    protected function getInt($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST[$clave];
        }
        return 0;
    }
    protected function getFloat($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_FLOAT);
            return $_POST[$clave];
        }
        return 0;
    }
    
    protected function redireccionar($ruta = false){
        if($ruta){
            header('Location: ' . BASE_URL . $ruta );
        }
        else{
            header('Location: ' . BASE_URL);
        }
    }
    protected function filtrarInt($int){
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else {
            return 0;
        }
    }
    public function getPostParam($clave){
        if(isset($_POST[$clave])){
            return $_POST[$clave];
        }
    }
    
    protected function getSql($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])){
            
            $_POST[$clave] = strip_tags($_POST[$clave]);
            
            if (!get_magic_quotes_gpc()){
                $_POST[$clave] = mysql_escape_string($_POST[$clave]);
            }
            
            return trim($_POST[$clave]);
        }
    }
    
    protected function getAlphaNum($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }
    
    public function validarEmail($email){
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        return true;
    }
    
    public function fechaMysql($clave){
        if(isset($_POST[$clave])){
            
            $fecha=date("Y-m-d",strtotime($_POST[$clave]));
            
            return $fecha;
        }
    }
    
    public function fechaVista($clave){
        
            
            $fecha=date("d-m-y",strtotime($clave));
            
            return $fecha;
        
    }
}
?>
