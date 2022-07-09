<?php

class loginController extends Controller{
    
    private $_login;
    public function __construct() {
        parent::__construct();
        $this->_login = $this->load_model('login');
    }
    
    public function index() {
        
        if(Session::get('autenticado')){
            $this->redireccionar();
        }
        
        $this->_view->titulo = 'Iniciar Sesion';
        $this->_view->setJs(array('login'));
        
        if($this->getInt('enviar')==1){
            
            $this->_view->datos = $_POST;
            
            if(!$this->getPostParam('email')){
                $this->_view->_error = 'Debe Introducir Su Email';
                $this->_view->renderizar('index', 'login');
                exit;
            }
            
            if(!$this->getSql('pass')){
                $this->_view->_error = 'Debe Introducir Su Password';
                $this->_view->renderizar('index', 'login');
                exit;
            }

            if(!$this->getSql('captcha')){
                $this->_view->_error = 'Debe Introducir el codigo de la Imagen';
                $this->_view->renderizar('index', 'login');
                exit;
            }
            
            if($this->getSql('captcha') != $_SESSION['tmptxt']){
                $this->_view->_error = 'El codigo Introducido no coincide con el de la imagen';
                $this->_view->renderizar('index', 'login');
                exit;
            }

            $row = $this->_login->getUsuario(
                    $this->getPostParam('email'),
                    $this->getSql('pass')
                    );
            
            if(!$row){
                $this->_view->_error = 'Usuario y / o Password Incorectos';
                $this->_view->renderizar('index','login');
                exit;
            }
            
            if($row['estado']!=1){
                $this->_view->_error = 'Usuario No Esta Habilitado';
                $this->_view->renderizar('index','login');
                exit;
            }
            
            Session::set('autenticado', true);
            Session::set('level', $row['role']);
            Session::set('email', $row['email']);
            Session::set('nivel', $row['nivel']);
            Session::set('foto', $row['foto']);
            Session::set('id_usuario', $row['id']);
            Session::set('nombre', $row['nombre']);
            Session::set('apellido', $row['apellido']);

            Session::set('tiempo', time());
            
            $this->redireccionar();
        }
        
        $this->_view->renderizar('index', 'login');
    }

    public function cerrar(){
        Session::destroy();
        $this->redireccionar();
        exit;
    }
}

?>
