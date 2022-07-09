<?php

class viviendaController extends Controller{
        private $_vivienda;
    public function __construct() {
        parent::__construct();
        $this->_vivienda = $this->load_model('vivienda');
        $this->_proyecto = $this->load_model('proyecto');
    }

    public function index($pagina = false){
            
            if(!$this->filtrarInt($pagina)){
                $pagina = false;
            }
            else {
                $pagina = (int) $pagina;
            }
            $this->getLibrary('paginador');
            $paginador = new Paginador();
            
            //$this->_view->partidas = $paginador->paginar($this->_partidas->getPartidas(), $pagina);
            //$this->_view->paginacion = $paginador->getView('prueba', 'partida/index');
            $this->_view->titulo = 'Listar Partidas';   
            $this->_view->renderizar('index', 'partida');
    }
    
    public function nueva(){
        
        Session::acceso('tecnico');
        //Session::accesoEstricto(array('proyecto'));
        
        $id_proyecto = $this->getInt('id_proyecto');
        
        if($this->getInt('guardar')== 1){

            $nombre = explode(' ', $this->getPostParam('nombres'));
            $apellido = $this->getPostParam('apellidos');
            $cedula = $this->getPostParam('cedula_jefe');
            $codigo = $nombre[0] ."-". $apellido[0] ."-". $cedula[0].$cedula[1].$cedula[2].$cedula[3];
            
            $this->_vivienda->nueva(
                    $codigo,
                    $this->getPostParam('id_proyecto'),
                    $this->getPostParam('cedula_jefe'),
                    $this->getPostParam('nacionalidad'),
                    $this->getPostParam('nombres'),
                    $this->getPostParam('apellidos'),
                    $this->getPostParam('sexo'),
                    $this->getPostParam('telefono'),
                    $this->getPostParam('correo'),
                    $this->getPostParam('ocupacion'),
                    $this->getPostParam('parentesco'),
                    $this->getPostParam('ubicacion')
                    );
            
            $this->redireccionar("proyecto/verProyecto/$id_proyecto");
        }
        
        $this->redireccionar("proyecto/verProyecto/$id_proyecto");
    }
    
    public function editar($id, $id_proyecto){
        
        $id_proyecto = $this->getInt('id_proyecto');
                        
        $this->_view->titulo = 'Editar Vivienda';
        $this->_view->setJs(array('nuevo'));
        
        if($this->getInt('guardar')== 1){

            $nombre = explode(' ', $this->getPostParam('nombres'));
            $apellido = $this->getPostParam('apellidos');
            $cedula = $this->getPostParam('cedula_jefe');
            $codigo = $nombre[0] ."-". $apellido[0] ."-". $cedula[0].$cedula[1].$cedula[2].$cedula[3];

            $this->_vivienda->editar(
                    $this->getPostParam('id'),
                    $codigo,
                    $this->getPostParam('id_proyecto'),
                    $this->getPostParam('cedula_jefe'),
                    $this->getPostParam('nacionalidad'),
                    $this->getPostParam('nombres'),
                    $this->getPostParam('apellidos'),
                    $this->getPostParam('sexo'),
                    $this->getPostParam('telefono'),
                    $this->getPostParam('correo'),
                    $this->getPostParam('ocupacion'),
                    $this->getPostParam('parentesco'),
                    $this->getPostParam('ubicacion')
                    );
            
            $this->redireccionar("proyecto/verProyecto/$id_proyecto");
        }
        $this->_view->viviendas = $this->_vivienda->getVivienda($id);
        $this->_view->renderizar('editar', 'vivienda');
    }
    
    public function ver($id, $id_proyecto){
        if(!$this->filtrarInt($id)){
            $this->redireccionar('proyecto');
        }
                
        $this->_view->titulo = 'Detalles de la Vivienda';
        $this->_view->setJs(array('vivienda'));
        
        
        $this->_view->viviendas = $this->_vivienda->getVivienda($this->filtrarInt($id));
        $this->_view->presupuestoProyecto = $this->_proyecto->presupuestoProyecto($id_proyecto);
        $this->_view->valuaciones = $this->_vivienda->valuaciones($this->filtrarInt($id));
        $this->_view->renderizar('ver', 'vivienda');
    }
    
    public function eliminar($id, $id_proyecto){
        
        Session::acceso('admin');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('proyecto');
        }
                
        $this->_vivienda->eliminar($this->filtrarInt($id));
        $this->redireccionar("proyecto/verProyecto/$id_proyecto");
    }
    
    public function valuacion(){
        
        Session::acceso('tecnico');
        
        $id_viviendas = $this->getInt('id');
        $id_proyecto = $this->getInt('id_proyecto');
                   
        if($this->getInt('guardar')== 1){
            
            $this->_vivienda->valuacion(
                    $this->getPostParam('id'),
                    $this->getPostParam('id_partidas_presupuesto'),
                    $this->getPostParam('f_inicio'),
                    $this->getPostParam('f_final'),
                    $this->getPostParam('ejecutado')
                    );
            
            $this->redireccionar("vivienda/ver/$id_viviendas/$id_proyecto");
        }
        
        $this->redireccionar("vivienda/ver/$id_viviendas/$id_proyecto");
    }
    
    public function eliminarValuacion($id_valuacion, $id_viviendas ,$id_proyecto){
        
        Session::acceso('admin');
                        
        $this->_vivienda->eliminarValuacion($this->filtrarInt($id_valuacion));
        $this->redireccionar("vivienda/ver/$id_viviendas/$id_proyecto");
    }

    public function imagenValuacion($id_valuacion, $id_vivienda){        
        Session::acceso('tecnico');
        $this->_view->titulo = 'Imagenes Valuaci&oacute;n';
        $this->_view->setJs(array('vivienda'));        
        if($this->getInt('guardar')== 1){
            if (!empty($_FILES["file"])) {
             $tot = count($_FILES["file"]["name"]);//este for recorre el arreglo
             for ($a = 0; $a < $tot; $a++){
                // Creamos la cadena aletoria
                $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                $cad = "";
                for($i=0;$i<12;$i++) { $cad .= substr($str,rand(0,62),1); }// Fin de la creacion de la cadena aletoria
                $tamano = $_FILES [ 'file' ][ 'size' ][$a]; // Leemos el tamaño del fichero
                $tamaño_max="500000002222222222"; // Tamaño maximo permitido
                if( $tamano < $tamaño_max){ // Comprovamos el tamaño 
                        $destino = 'views/vivienda/imagenes' ; // Carpeta donde se guardata
                        $sep=explode('image/',$_FILES["file"]["type"][$a]); // Separamos image/
                        $tipo=$sep[1]; // Optenemos el tipo de imagen que es
                        if(($tipo == "gif") || ($tipo == "jpeg") || ($tipo == "bmp")  || ($tipo == "jpg") || ($tipo == "png"))
                            { // Si el tipo de imagen a subir es el mismo de los permitidos, segimos. Puedes agregar mas tipos de imagen
                            move_uploaded_file ( $_FILES [ 'file' ][ 'tmp_name' ][$a], $destino . '/' .$cad.'.'.$tipo);  // Subimos el archivo
                                $nombre = $cad.".".$tipo;
                                $this->_vivienda->imagenValuacion(
                                        $id_valuacion,
                                        $id_vivienda,
                                        $nombre
                                        );                                                                
                            }                                                        
                    }
                    else{
                        $this->_view->_mensaje = 'error en tamaño.';
                        $this->_view->renderizar('imagen', 'vivienda');
                        exit;
                    } 
                }
                $this->_view->_mensaje = 'Carga Exitosa.';
                $this->_view->renderizar('imagen', 'vivienda');
                exit;                                
            }
            $this->_view->_mensaje = 'No Se Seleccionaron Imagenes';
            $this->_view->renderizar('imagen', 'vivienda');
            exit;   
        }
        $this->_view->renderizar('imagen', 'vivienda');
    }

    public function verImagenes($id_valuacion, $id_vivienda){
                        
        $this->_view->titulo = 'Imagenes de la Valuacion';
        $this->_view->setJs(array('vivienda'));
        
        
        $this->_view->imagenes = $this->_vivienda->imagenes($id_valuacion);
        $this->_view->renderizar('verImagenes', 'vivienda');
    }

}
?>
