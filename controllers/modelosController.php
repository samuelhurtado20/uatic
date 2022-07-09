<?php

class modelosController extends Controller{
        private $_modelos;
    public function __construct() {
        
        parent::__construct();
        $this->_modelos = $this->load_model('modelos');
    }

    public function index($pagina = false){
            
        Session::acceso('proyecto');
        
            if(!$this->filtrarInt($pagina)){
                $pagina = false;
            }
            else {
                $pagina = (int) $pagina;
            }
            $this->getLibrary('paginador');
            $paginador = new Paginador();
            
            $this->_view->modelos = $paginador->paginar($this->_modelos->getModelos(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'modelos/index');
            $this->_view->titulo = 'Listar Modelos';   
            $this->_view->renderizar('index', 'modelos');
    }
    public function nuevo(){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Agregar Modelo';
        //$this->_view->setJs(array('nuevo'));
        
        if($this->getInt('guardar')== 1){            
            $this->_modelos->insertarModelo(
                    $this->getPostParam('codigo'),
                    $this->getPostParam('descripcion'),
                    $this->getPostParam('area'),
                    $this->getPostParam('cuartos'),
                    $this->getPostParam('banos'),
                    $this->getPostParam('sala'),
                    $this->getPostParam('salacomedor'),
                    $this->getPostParam('comedor'),
                    $this->getPostParam('cocina')
                    );            
            $this->redireccionar('modelos');
        }        
        $this->_view->renderizar('nuevo', 'modelos');
    }
    public function editar($id){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('modelos');
        }        
        if(!$this->_modelos->getModelo($this->filtrarInt($id))){
            $this->redireccionar('modelos');
        }        
        $this->_view->titulo = 'editar modelos';
        $this->_view->setJs(array('nuevo'));
        
        if($this->getInt('guardar') == 1){
            
            //$this->_view->datos = $_POST;
            
            $this->_modelos->editarModelo(
                    $this->getPostParam('id'),
                    $this->getPostParam('descripcion'),
                    $this->getPostParam('area'),
                    $this->getPostParam('cuartos'),
                    $this->getPostParam('banos'),
                    $this->getPostParam('sala'),
                    $this->getPostParam('salacomedor'),
                    $this->getPostParam('comedor'),
                    $this->getPostParam('cocina')
                    );
            
            $this->_modelos->editarPorcentaje(
                    $this->getPostParam('id'),
                    $this->getPostParam('iva'),
                    $this->getPostParam('prestaciones'),
                    $this->getPostParam('administracion'),
                    $this->getPostParam('utilidad')
                    );

            $this->actualizar($this->filtrarInt($id));
                        
            $this->redireccionar('modelos');
        }
        $this->_view->datos = $this->_modelos->getModelo($this->filtrarInt($id));
        $this->_view->porcentajes = $this->_modelos->porcentajes($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'modelos');
    }

    public function editarPartidaModelo($id, $id_modelo_vivienda){
        
        Session::acceso('proyecto');
        
        
        $this->_view->titulo = 'Editar Partida Presupuesto';
        $this->_view->setJs(array('partidaModelo'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_modelos->editarPartidaModelo(
                    $this->getPostParam('id'),
                    $this->getPostParam('cantidad'),
                    $this->getPostParam('etapa')
                    ); 

            
            $this->redireccionar('modelos/verModelo/$id_modelo_vivienda');
        }
        $this->_view->datos = $this->_modelos->getPartidaModelo($id);
        $this->_view->etapas = $this->_modelos->etapas();        
        $this->_view->renderizar('editarPartidaModelo', 'modelos');
    }


    public function guardarImagen(){
        
        Session::acceso('proyecto');
        
        if($this->getInt('guardar')== 1){
            // Creamos la cadena aletoria
            $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $cad = "";
            for($i=0;$i<12;$i++) { $cad .= substr($str,rand(0,62),1); }
            // Fin de la creacion de la cadena aletoria
            $tamano = $_FILES [ 'file' ][ 'size' ]; // Leemos el tamaño del fichero
            $tamaño_max="500000000000000000000000000000"; // Tamaño maximo permitido
            if( $tamano < $tamaño_max)
                { // Comprovamos el tamaño 
                    $destino = 'views/modelos/imagenes' ; // Carpeta donde se guardata
                    $sep=explode('image/',$_FILES["file"]["type"]); // Separamos image/
                    $tipo=$sep[1]; // Optenemos el tipo de imagen que es
                    if($tipo == "gif" || $tipo == "jpeg" || $tipo == "bmp"  || $tipo == "jpg")
                        { // Si el tipo de imagen a subir es el mismo de los permitidos, segimos. Puedes agregar mas tipos de imagen
                        move_uploaded_file ( $_FILES [ 'file' ][ 'tmp_name' ], $destino . '/' .$cad.'.'.$tipo);  // Subimos el archivo

                            $nombre = $cad.".".$tipo;
                            $this->_modelos->guardarImagen(
                                    $this->getPostParam('id_modelo_vivienda'),
                                    $this->getPostParam('descripcion'),
                                    $nombre,
                                    $this->getPostParam('tipo')
                                    );
                            $this->redireccionar("modelos/verModelo/$_POST[id_modelo_vivienda]");
                        }
                        $this->redireccionar("modelos/verModelo/$_POST[id_modelo_vivienda]");
                }
            $this->redireccionar("modelos/verModelo/$_POST[id_modelo_vivienda]");
        }        
        $this->_view->renderizar('nuevo', 'modelos');
    }
    
    public function eliminar($id){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('modelos');
        }
        
        if(!$this->_modelos->getModelo($this->filtrarInt($id))){
            $this->redireccionar('modelos');
        }
        
        $this->_modelos->eliminarModelo($this->filtrarInt($id));
        $this->redireccionar('modelos');
    }
    
    public function verModelo($id){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('modelos');
        }
        
        if(!$this->_modelos->getModelo($this->filtrarInt($id))){
            $this->redireccionar('partida');
        }
        
        $this->_view->titulo = 'Detalles Modelo';
        $this->_view->setJs(array('modelo'));
        
        
        $this->_view->datos = $this->_modelos->getModelo($this->filtrarInt($id));
        $this->_view->partidasModelo = $this->_modelos->partidasModelo($this->filtrarInt($id));
        $this->_view->etapas = $this->_modelos->etapas();
        $this->_view->imagenesMemoria = $this->_modelos->imagenesMemoria($this->filtrarInt($id));
        $this->_view->enlacesMemoria = $this->_modelos->enlacesMemoria($this->filtrarInt($id));
        $this->_view->imagenesPlano = $this->_modelos->imagenesPlano($this->filtrarInt($id));
        $this->_view->enlacesPlano = $this->_modelos->enlacesPlano($this->filtrarInt($id));
        $this->_view->imagenesInfografia = $this->_modelos->imagenesInfografia($this->filtrarInt($id));
        $this->_view->enlacesInfografia = $this->_modelos->enlacesInfografia($this->filtrarInt($id));
        $this->_view->renderizar('verModelo', 'modelos');
    }
    
    public function partidaModelo(){
        
        Session::acceso('proyecto');
                
        if($this->getInt('guardar')== 1){            
            $this->_modelos->partidaModelo(
                    $this->getPostParam('id_modelo_vivienda'),
                    $this->getPostParam('cantidad'),
                    $this->getPostParam('id_partidas'),
                    $this->getPostParam('etapa')                    
                    );
            
            $this->redireccionar("modelos/verModelo/$_POST[id_modelo_vivienda]");
        }        
        $this->_view->renderizar('nuevo', 'modelos');
    }
    
    public function eliminarPartidaModelo($id_partidas, $id_modelo_vivienda){
        
        Session::acceso('proyecto');
                     
        $this->_modelos->eliminarPartidaModelo($id_partidas, $id_modelo_vivienda);
        $this->redireccionar("modelos/verModelo/$id_modelo_vivienda");
    }
    
    public function verPartidaModelo($id){
        
        Session::acceso('proyecto');
                
        $this->_view->titulo = 'Detalles Partida';
        $this->_view->setJs(array('partidaModelo'));
        
        
        $partida = $this->_view->partidaPresupuesto = $this->_modelos->partidaPresupuesto($this->filtrarInt($id));
        $this->_view->materialesPresupuesto = $this->_modelos->materialesPresupuesto($this->filtrarInt($id));
        $this->_view->equiposPresupuesto = $this->_modelos->equiposPresupuesto($this->filtrarInt($id));
        $this->_view->manoPresupuesto = $this->_modelos->manoPresupuesto($this->filtrarInt($id));
        $this->_view->porcentajes = $this->_modelos->porcentajes($partida['id_modelo_vivienda']);
        $this->_view->presupuesto = $this->modeloPartidaPresupuesto($this->filtrarInt($id));
        $this->_view->renderizar('verPartida', 'modelos');
    }
    
    public function modeloPartidaPresupuesto($id){
        
        Session::acceso('proyecto');        
        
        $this->_modelos->totalMateriales($this->filtrarInt($id));
        $this->_modelos->totalEquipos($this->filtrarInt($id));
        $this->_modelos->totalMano($this->filtrarInt($id));
        $partida = $this->_modelos->partidaPresupuesto($this->filtrarInt($id));
        $porcentajes = $this->_modelos->porcentajes($partida['id_modelo_vivienda']);
        
        $presupuesto['total_materiales'] = $partida['total_mat'];
        $presupuesto['total_mano'] = $partida['total_mano'];
        $presupuesto['total_equipos'] = $partida['total_equi'] / $partida['rendimiento'];
        $presupuesto['prestaciones'] = $partida['total_mano'] * $porcentajes['prestaciones'] / 100;
        $presupuesto['total_mano_obra'] = $partida['total_mano'] + $presupuesto['prestaciones'];
        $presupuesto['total_mano_obra_f'] = $presupuesto['total_mano_obra'] / $partida['rendimiento'];        
        $presupuesto['costo_unidad'] = $presupuesto['total_materiales'] + $presupuesto['total_equipos'] + $presupuesto['total_mano_obra_f'];
        $presupuesto['administracion'] =  $presupuesto['costo_unidad'] * $porcentajes['administracion'] / 100;
        $presupuesto['subtotal_a'] = $presupuesto['costo_unidad'] + $presupuesto['administracion'];
        $presupuesto['utilidad'] = $presupuesto['subtotal_a'] * $porcentajes['utilidad'] / 100;        
        $presupuesto['subtotal_b'] = $presupuesto['subtotal_a'] + $presupuesto['utilidad'];        
        $presupuesto['iva'] = $presupuesto['subtotal_b'] * $porcentajes['iva'] / 100;        
        $presupuesto['precio'] = $presupuesto['subtotal_b'] + $presupuesto['iva'];
        
        $this->_modelos->precioUnitario(
                    $id,
                    $presupuesto['precio']
                    );       
        
        return $presupuesto;
    }


    public function subirPDF (){
        if($_FILES['pdf']['tmp_name']!=""){

            //obtengo la extension de un archivo
            $aux=$_FILES['pdf']['name'];
            $extension=strtolower(array_pop(explode(".",$aux)));

              // si es pdf sigo sino le alerto al usuario.
                    if($extension=="pdf" || $extension=="dwg"){ 
                            move_uploaded_file($_FILES['pdf']['tmp_name'],"views/modelos/imagenes/".str_replace(" ","_",$_FILES['pdf']['name']));
                            $mensaje="El archivo fu&eacute; subido con &eacute;xito.";

                            $nombre = str_replace(" ","_",$_FILES['pdf']['name']);
                                            $this->_modelos->guardarImagen(
                                                    $this->getPostParam('id_modelo_vivienda'),
                                                    $this->getPostParam('descripcion'),
                                                    $nombre,
                                                    $this->getPostParam('tipo')
                                                    );
                    }
                $this->redireccionar("modelos/verModelo/$_POST[id_modelo_vivienda]");
        }
    }

    public function actualizar ($id_modelo_vivienda){

        $this->partidasModelo = $this->_modelos->partidasModelo($this->filtrarInt($id_modelo_vivienda));

        for ($i = 0; $i < count($this->partidasModelo); $i++){

            $this->modeloPartidaPresupuesto($this->filtrarInt($this->partidasModelo[$i]['id_partidas_presupuesto']));      

        }

    }
}
?>
