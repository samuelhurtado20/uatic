<?php

class materialController extends Controller{
        private $_materiales;
        public $term;
        public $row = array();
        public $results = array();
    public function __construct() {
        
        Session::acceso('proyecto');
        
        parent::__construct();
        $this->_materiales = $this->load_model('material');
        
    }

    public function index(){
        
            $term = $_GET['term'];
            $row = $this->_materiales->getMaterial($term);
            for($i=0; $i < count($row); $i++){ 
        
        $results[] = array('label' => $row[$i]['material'],'unidad' => $row[$i]['unidad'],'id_materiales' => $row[$i]['id_materiales'],'precio' => $row[$i]['precio']);
        
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
            
            $this->_view->materiales = $paginador->paginar($this->_materiales->listar(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'material/listar');
            $this->_view->titulo = 'Listar Materiales';   
            $this->_view->renderizar('listar', 'material');
    }
    
    public function agregar(){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Nuevo Material';
        $this->_view->setJs(array('material'));
        
        if($this->getInt('guardar')== 1){
            
            $this->_materiales->agregar(
                    $this->getPostParam('unidad'),
                    $this->getPostParam('material'),
                    $this->getPostParam('precio')
                    );
            
            $this->redireccionar('material/listar');
        }
        
        $this->_view->renderizar('agregar', 'material');
    }
    
    public function editar($id_materiales){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Editar Material';
        $this->_view->setJs(array('material'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_materiales->editarMaterial(
                    $this->getPostParam('id_materiales'),
                    $this->getPostParam('material'),
                    $this->getPostParam('unidad'),
                    $this->getPostParam('precio')
                    );
            
           $this->redireccionar('material/listar');
        }
        $this->_view->datos = $this->_materiales->unMaterial($this->filtrarInt($id_materiales));
        $this->_view->renderizar('editar', 'material');
    }
    public function eliminar($id_materiales){
        
        Session::acceso('proyecto');
                
        $this->_materiales->eliminar($this->filtrarInt($id_materiales));        
        $this->redireccionar("material/listar");
    }
    
    public function nuevo(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas');
       if($this->getInt('guardar')== 1){             
            $this->_materiales->nuevo(
                    $this->getInt('id_partidas'),
                    $this->getInt('id_materiales'),
                    $this->getFloat('cantidad'),
                    $this->getFloat('precio'),
                    $this->getFloat('monto')
                    );            
            $this->redireccionar("partida/ver/$id");
       }
    }
    
    public function Precio(){
        $row = $this->_materiales->getPrecio($this->getInt('id'));
        echo $row['precio']; 
    }
    
    public function eliminarMaterialPartida($id, $part){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        $this->_materiales->eliminarMaterialPartida($this->filtrarInt($id));        
        $this->redireccionar("partida/ver/$part");
    }
    
    public function materialPresupuesto(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas_presupuesto');
       if($this->getInt('guardar')== 1){             
            $this->_materiales->materialPresupuesto(
                    $this->getInt('id_partidas_presupuesto'),
                    $this->getInt('id_materiales'),
                    $this->getFloat('cantidad'),
                    $this->getFloat('precio'),
                    $this->getFloat('monto')
                    );            
            $this->redireccionar("modelos/verPartidaModelo/$id");
       }
    }
    
    public function eliminarMaterialPresupuesto($id, $id_presu){
        
        Session::acceso('proyecto');
                
        $this->_materiales->eliminarMaterialPresupuesto($this->filtrarInt($id));        
        $this->redireccionar("modelos/verPartidaModelo/$id_presu");
    }
    
    
}
?>
