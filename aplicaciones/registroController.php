<?php

class registroController extends Controller {
    private $_registro;
    
    public function __construct() {
        parent::__construct();
    
        $this->_registro = $this->load_model('registro');
    }
    
    public function index() {
        
        Session::acceso('admin');
        
        if(!Session::get('autenticado')){
            $this->redireccionar();
        }
        
        $this->_view->titulo = 'Registro De Usuario';
        $this->_view->setJs(array('registro'));
        
        if($this->getInt('enviar') == 1){
            $this->_view->datos = $_POST;
            
                        
                      
            if(!$this->validarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'la direccion de email es invalida';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
            if($this->_registro->verificarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'la direccion de email ya registrada';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            
                      
            $this->getLibrary('class.phpmailer');
            $mail = new PHPMailer();
            
            $this->_registro->registrarUsuario(
                    $this->getPostParam('cedula'),
                    $this->getPostParam('nombre'),
                    $this->getPostParam('apellido'),
                    $this->getPostParam('nivel'),
                    $this->getPostParam('cargo'),
                    $this->getPostParam('id_parroquia'),
                    $this->getPostParam('municipio'),
                    $this->getPostParam('direccion'),
                    $this->getPostParam('telefono'),
                    $this->getPostParam('email'),
                    $this->getPostParam('role')
                    );
            
            $usuario = $this->_registro->verificarUsuario($this->getPostParam('email'));
            
            if(!$usuario){
                $this->_view->_error = 'error al registrar el usuario';
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            /*
            $mail->From = 'www.chaima.org';
            $mail->FromName = 'S.I.S.C.E.P';
            $mail->Subject = 'Activacion De La Cuenta De Usuario';
            $mail->Body = 'Hola Sr(a) <strong>'. strtoupper($this->getSql('nombre')) .' '. strtoupper($this->getSql('apellido')) .'</strong>'.
                    ' usted ha sido registrado en el SISTEMA INTEGRAL DE SEGUIMIENTO, CONTROL, EVALUCION Y PLANIFICACION 
                    de la Unidad De Acompañamiento Tecnico Integral Comunitario (UATIC), perteneciente al Ministerio de Comunas.
                    <br><a href="'. BASE_URL . 'registro/activar/'.$usuario['id']. '/' . $usuario['codigo'] . '">
                    Pulse aqui para activar su cuenta de usuario </a>';
            $mail->AltBody = 'su servidor de correo no soporta codigo html';
            $mail->AddAddress($this->getPostParam('email'));
            $mail->Send();
                        
            $this->_view->datos = false;
            $this->_view->_mensaje = 'Usuario Registrado, Revise Su Email Para Activar Cuenta';*/

            
            $cedula = $this->getPostParam('cedula');
            $destino = 'views/registro/imagenes' ; // Carpeta donde se guardata
                if($sep=explode('image/',$_FILES["files"]["type"])){ // Separamos image/
                    $tipo=$sep[1]; // Optenemos el tipo de imagen que es
                    
                        if(move_uploaded_file ( $_FILES [ 'files' ][ 'tmp_name' ], $destino . '/' .$cedula.'.'.$tipo)){  // Subimos el archivo

                            $nombre = $cedula.".".$tipo;
                            $this->_registro->guardarFoto(
                                    $this->getPostParam('cedula'),
                                    $nombre
                                    );                
                        }
                }
            $this->_view->_mensaje = 'Usuario Registrado.';
        }

        $this->_view->datos = false;
        $this->_view->renderizar('index', 'registro');
    }
    
    public function activar($id, $codigo){
        if (!$this->filtrarInt($id) || !$this->filtrarInt($codigo)){
                $this->_view->_error = 'esta cuenta no existe';
                $this->_view->renderizar('index', 'registro');
                exit;
        }
        
        $row = $this->_registro->getUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        if(!$row){
            $this->_view->_error = 'esta cuenta no existe';
            $this->_view->renderizar('activar', 'registro');
            exit;
        }
        
        if($row['estado']==1){
            $this->_view->_error = 'esta cuenta ya ha sido activada';
            $this->_view->renderizar('activar', 'registro');
            exit;
        }
        
        $this->_registro->activarUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        $row = $this->_registro->getUsuario(
                $this->filtrarInt($id),
                $this->filtrarInt($codigo)
                );
        
        if($row['estado']==0){
            $this->_view->_error = 'intete luego activar su cuanta, hubo un error';
            $this->_view->renderizar('activar', 'registro');
            exit;
        }
        
        $this->_view->_mensaje = 'su cuenta ha sido activada';
        $this->_view->renderizar('activar', 'registro');
    }

    public function listar($pagina = false){
        
        Session::accesoEstricto(array('admin'));
            
            if(!$this->filtrarInt($pagina)){
                $pagina = false;
            }
            else {
                $pagina = (int) $pagina;
            }
            $this->getLibrary('paginador');
            $paginador = new Paginador();
            
            $this->_view->usuarios = $paginador->paginar($this->_registro->listar(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'registro/listar');
            $this->_view->titulo = 'Listar Usuarios';   
            $this->_view->renderizar('listar', 'registro');
    }

    public function editar($id){
        
        Session::acceso('tecnico');

        $id = Session::get('id_usuario');
        
        $this->_view->titulo = 'Administrar Cuenta';
        $this->_view->setJs(array('registro'));
        
        if($this->getInt('guardar') == 1){


            $this->_registro->editarUsuario(
                    $this->getPostParam('id'),
                    $this->getPostParam('cedula'),
                    $this->getPostParam('nombre'),
                    $this->getPostParam('apellido'),
                    $this->getPostParam('nivel'),
                    $this->getPostParam('cargo'),
                    $this->getPostParam('direccion'),
                    $this->getPostParam('telefono')
                    );
            
            $this->_view->_error = 'Cambios Guardados con Exito.';
            
        }
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->laboral = $this->_registro->laboral($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'registro');
    }

    public function eliminar($id){
        
        Session::acceso('admin');
                
        $this->_registro->eliminar($this->filtrarInt($id));        
        $this->redireccionar("registro/listar");
    }


    public function enviarEmail($id, $nombre, $apellido, $email, $codigo){
        
        Session::accesoEstricto(array('admin'));

        $this->getLibrary('class.phpmailer');
        $mail = new PHPMailer();
        
            $mail->From = 'www.chaima.org';
            $mail->FromName = 'S.I.S.C.E.P';
            $mail->Subject = 'Activacion De La Cuenta De Usuario';
            $mail->Body = 'Hola Sr(a) <strong>'. strtoupper($nombre) .' '. strtoupper($apellido) .'</strong>'.
                    ' usted ha sido registrado en el SISTEMA INTEGRAL DE SEGUIMIENTO, CONTROL, EVALUCION Y PLANIFICACION 
                    de la Unidad De Acompa&ntilde;amiento Tecnico Integral Comunitario (UATIC), perteneciente al Ministerio de Comunas.
                    <br><a href="'. BASE_URL . 'registro/activar/'.$id. '/' . $codigo . '">
                    Pulse aqui para activar su cuenta de usuario </a>';
            $mail->AltBody = 'su servidor de correo no soporta codigo html';
            $mail->AddAddress($email);
            $mail->Send();

            echo "<script>alert('EL Email Fue Enviado.')
                    history.back(1);
                </script>";            
    }

    public function change($id){
        
        Session::acceso('tecnico');
        
        $this->_view->titulo = 'Cambiar Imagen';
        $this->_view->setJs(array('registro'));
        
        if($this->getInt('guardar') == 1){

            if($this->getPostParam('imagen')!=""){

                unlink($this->getPostParam('ruta').'/'.$this->getPostParam('imagen'));
            }



            $cedula = $this->getPostParam('cedula');
            $destino = 'views/registro/imagenes' ; 
                if($sep=explode('image/',$_FILES["files"]["type"])){ 
                    $tipo=$sep[1]; 
                    
                        if(move_uploaded_file ( $_FILES [ 'files' ][ 'tmp_name' ], $destino . '/' .$cedula.'.'.$tipo)){  // Subimos el archivo

                            $nombre = $cedula.".".$tipo;
                            $this->_registro->guardarFoto(
                                    $this->getPostParam('cedula'),
                                    $nombre
                                    );
                            Session::set('foto', $nombre);                
                        }
                }
        $this->_view->titulo = 'Administrar Cuenta';
        $this->_view->setJs(array('registro'));
        $this->_view->_error = 'Imagen Cambiada Con Exito.';
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'registro');
        exit;          
        }
       
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->renderizar('change', 'registro');

    }


    public function password($id){
        
        Session::acceso('tecnico');
                
        $this->_view->titulo = 'Cambiar Clave';
        $this->_view->setJs(array('validar'));

        $this->_view->datos = $_POST;
        
        if($this->getInt('guardar') == 1){


            $usuario = $this->_registro->verificar($id, $this->getPostParam('vieja'));
            
            if(!$usuario){
                $this->_view->_error = 'La Clave Actual Es Invalida';
                $this->_view->renderizar('password', 'registro');
                exit;
            }

            $this->_registro->password(
                    $id,
                    $this->getPostParam('nueva')
                    );
            
        $this->_view->titulo = 'Administrar Cuenta';
        $this->_view->setJs(array('registro'));
        $this->_view->_error = 'Clave Cambiada Con Exito.';
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->laboral = $this->_registro->laboral($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'registro');
        exit;
        }
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->renderizar('password', 'registro');
    }

    public function residencia($id){
        
        Session::acceso('tecnico');
        
        $this->_view->titulo = 'Editar Residencia';
        $this->_view->setJs(array('registro2'));
        
        if($this->getInt('guardar') == 1){


            $this->_registro->residencia(
                    $id,
                    $this->getPostParam('id_parroquia')
                    );
            
            $this->_view->titulo = 'Administrar Cuenta';
            $this->_view->setJs(array('registro'));
            $this->_view->_error = 'Residencia Cambiada Con Exito.';
            $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
            $this->_view->renderizar('editar', 'registro'); 
        }
        $this->_view->datos = $this->_registro->unUsuario($this->filtrarInt($id));
        $this->_view->renderizar('residencia', 'registro');
    }

}
?>