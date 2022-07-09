<?php

class manoController extends Controller{
        private $_partidas;
        private $_manos;
        public $term;
        public $row = array();
        public $results = array();
    public function __construct() {
        parent::__construct();
        $this->_manos = $this->load_model('mano');
    }

    public function index(){
        Session::acceso('proyecto');
            $term = $_GET['term'];
            $row = $this->_manos->getMano($term);
            for($i=0; $i < count($row); $i++){ 
        
        $results[] = array('label' => $row[$i]['nombre'],'unidad' => $row[$i]['unidad'],'id_mano' => $row[$i]['id_mano'],'jornal' => $row[$i]['jornal']);
        
       } 
       echo json_encode($results);
    }
    
    public function listar($pagina = false){
        
        Session::acceso('proyecto');
            
            if(!$this->filtrarInt($pagina)){
                $pagina = false;
            }
            else {
                $pagina = (int) $pagina;
            }
            $this->getLibrary('paginador');
            $paginador = new Paginador();
            
            $this->_view->manos = $paginador->paginar($this->_manos->listar(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'mano/listar');
            $this->_view->titulo = 'Listar Mano de Obra';   
            $this->_view->renderizar('listar', 'mano');
    }
    
    public function agregar(){
        
        Session::acceso('proyecto');
                
        $this->_view->titulo = 'Nueva Mano De Obra';
        $this->_view->setJs(array('mano'));
        
        if($this->getInt('guardar')== 1){
            
            $this->_manos->agregar(
                    $this->getPostParam('nombre'),
                    $this->getPostParam('unidad'),
                    $this->getPostParam('jornal')
                    );
            
            $this->redireccionar('mano/listar');
        }
        
        $this->_view->renderizar('agregar', 'mano');
    }
    
    public function editar($id_mano){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Editar Mano de Obra';
        $this->_view->setJs(array('mano'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_manos->editarMano(
                    $this->getPostParam('id_mano'),
                    $this->getPostParam('nombre'),
                    $this->getPostParam('unidad'),
                    $this->getPostParam('jornal')
                    );
            
           $this->redireccionar('mano/listar');
        }
        $this->_view->datos = $this->_manos->unaMano($this->filtrarInt($id_mano));
        $this->_view->renderizar('editar', 'mano');
    }
    public function eliminar($id_mano){
        
        Session::acceso('proyecto');
                
        $this->_manos->eliminar($this->filtrarInt($id_mano));        
        $this->redireccionar("mano/listar");
    }
    
    public function Precio(){
        $row = $this->_manos->getPrecio($this->getInt('id'));
        echo $row['jornal']; 
    }
    public function nuevo(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas');
       if($this->getInt('guardar')== 1){             
            $this->_manos->manoPartida(
                    $this->getInt('id_partidas'),
                    $this->getInt('id_mano'),
                    $this->getFloat('cantidad_m'),
                    $this->getFloat('jornal'),
                    $this->getFloat('monto_m')
                    );            
            $this->redireccionar("partida/ver/$id");
       }
    }
    public function eliminarManoPartida($id, $part){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        $this->_manos->eliminarManoPartida($this->filtrarInt($id));        
        $this->redireccionar("partida/ver/$part");
    }
    
    public function manoPresupuesto(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas_presupuesto');
       if($this->getInt('guardar')== 1){             
            $this->_manos->manoPresupuesto(
                    $this->getInt('id_partidas_presupuesto'),
                    $this->getInt('id_mano'),
                    $this->getFloat('cantidad_m'),
                    $this->getFloat('jornal'),
                    $this->getFloat('monto_m')
                    );            
            $this->redireccionar("modelos/verPartidaModelo/$id");
       }
    }
    
    public function eliminarManoPresupuesto($id, $id_presu){
        
        Session::acceso('proyecto');
                
        $this->_manos->eliminarManoPresupuesto($this->filtrarInt($id));        
        $this->redireccionar("modelos/verPartidaModelo/$id_presu");
    }
}
?>
