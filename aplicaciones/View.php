<?php

class View {
    private $_controlador;
    private $_js;


    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }
    public function renderizar($vista, $item = false){
        
        if(Session::get('autenticado')){
            $menu = array (
            array (
               'id' => 'inicio',
               'titulo' => 'Inicio',
               'enlace' => BASE_URL
           ),
            array (
               'id' => 'partida',
               'titulo' => 'Listar Partidas',
               'enlace' => BASE_URL . 'partida'
           ), 
            array (
               'id' => 'modelos',
               'titulo' => 'Listar Modelos',
               'enlace' => BASE_URL . 'modelos'
           ),
            array (
               'id' => 'proyecto',
               'titulo' => 'Listar Proyectos',
               'enlace' => BASE_URL . 'proyecto'
           ),
            array (
               'id' => 'material',
               'titulo' => 'Listar Materiales',
               'enlace' => BASE_URL . 'material/listar'
           ),
            array (
               'id' => 'equipo',
               'titulo' => 'Listar Equipos',
               'enlace' => BASE_URL . 'equipo/listar'
           ),
            array (
               'id' => 'mano',
               'titulo' => 'Listar Mano de Obra',
               'enlace' => BASE_URL . 'mano/listar'
           ),
            array (
               'id' => 'proyecto',
               'titulo' => 'Agregar Proyecto',
               'enlace' => BASE_URL . 'proyecto/nuevo'
           ),
            array (
               'id' => 'modelos',
               'titulo' => 'Agregar Modelo',
               'enlace' => BASE_URL . 'modelos/nuevo'
           ),
            array (
               'id' => 'partida',
               'titulo' => 'Agregar Partida',
               'enlace' => BASE_URL . 'partida/nueva'
           ),
            array (
               'id' => 'material',
               'titulo' => 'Agregar Material',
               'enlace' => BASE_URL . 'material/agregar'
           ),
            array (
               'id' => 'equipo',
               'titulo' => 'Agregar Equipo',
               'enlace' => BASE_URL . 'equipo/agregar'
           ),
            array (
               'id' => 'mano',
               'titulo' => 'Agregar Mano de Obra',
               'enlace' => BASE_URL . 'mano/agregar'
           ),
            array (
               'id' => 'registro',
               'titulo' => 'Registrar Usuario',
               'enlace' => BASE_URL . 'registro'
           ),
            array (
               'id' => 'login',
               'titulo' => 'Cerrar Sesion',
               'enlace' => BASE_URL . 'login/cerrar'
           )
            
        );
            
        }
        else{
            $menu[] = array (
               'id' => 'login',
               'titulo' => 'Iniciar Sesion',
               'enlace' => BASE_URL . 'login'
           );
            
        }
        
        $js = array();
        
        if(count($this->_js)){
            $js = $this->_js;
        }
        
        $_layoutParams = array(
          'ruta_css' => BASE_URL  . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
          'ruta_img' => BASE_URL  . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
          'ruta_js' => BASE_URL  . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
          'menu' => $menu,
          'js' => $js
        );
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        if(is_readable($rutaView)){
            
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php' ;
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php' ;
        }
        else {
            throw new Exception('error de vista');
        }
    }
    
    public function setJs(array $js){
        if (is_array($js) && count($js)){
            for ($i=0; $i < count($js); $i++){
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        }
        else {
            throw new Exception('error de js');
        }
    }
}
?>
