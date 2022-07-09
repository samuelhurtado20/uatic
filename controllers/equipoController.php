<?php

class equipoController extends Controller{
        private $_equipos;
        public $term;
        public $row = array();
        public $results = array();
    public function __construct() {
        parent::__construct();
        $this->_equipos = $this->load_model('equipo');
    }

    public function index(){
        Session::acceso('proyecto');
            $term = $_GET['term'];
            $row = $this->_equipos->getEquipo($term);
            for($i=0; $i < count($row); $i++){ 
        
        $results[] = array('label' => $row[$i]['nombre'],'unidad' => $row[$i]['unidad'],'id_equipo' => $row[$i]['id_equipo'],'cop' => $row[$i]['COP'],'precio_e' => $row[$i]['precio']);
        
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
            
            $this->_view->equipos = $paginador->paginar($this->_equipos->listar(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'equipo/listar');
            $this->_view->titulo = 'Listar Equipos';   
            $this->_view->renderizar('listar', 'equipos');
    }
    
    public function agregar(){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Nuevo Equipo';
        $this->_view->setJs(array('equipo'));
        
        if($this->getInt('guardar')== 1){
            
            $this->_equipos->agregar(
                    $this->getPostParam('nombre'),
                    $this->getPostParam('cop'),
                    $this->getPostParam('unidad'),
                    $this->getPostParam('precio')
                    );
            
            $this->redireccionar('equipo/listar');
        }
        
        $this->_view->renderizar('agregar', 'equipo');
    }
    
    public function editar($id_equipo){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Editar Equipo';
        $this->_view->setJs(array('equipo'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_equipos->editarEquipo(
                    $this->getPostParam('id_equipo'),
                    $this->getPostParam('nombre'),
                    $this->getPostParam('cop'),
                    $this->getPostParam('unidad'),
                    $this->getPostParam('precio')
                    );
            
           $this->redireccionar('equipo/listar');
        }
        $this->_view->datos = $this->_equipos->unEquipo($this->filtrarInt($id_equipo));
        $this->_view->renderizar('editar', 'equipo');
    }
    
    public function eliminar($id_equipo){
        
        Session::acceso('proyecto');
                
        $this->_equipos->eliminar($this->filtrarInt($id_equipo));        
        $this->redireccionar("equipo/listar");
    }
    
    public function nuevo(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas');
       if($this->getInt('guardar')== 1){             
            $this->_equipos->nuevo(
                    $this->getInt('id_partidas'),
                    $this->getInt('id_equipo'),
                    $this->getFloat('cantidad_e'),
                    $this->getFloat('precio_e'),
                    $this->getFloat('monto_e')
                    );            
            $this->redireccionar("partida/ver/$id");
       }
    }
    
    public function Precio(){
        $row = $this->_equipos->getPrecio($this->getInt('id'));
        echo $row['precio']; 
    }
    
    public function eliminarEquipoPartida($id, $part){
        
        Session::acceso('proyecto');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        $this->_equipos->eliminarEquipoPartida($this->filtrarInt($id));        
        $this->redireccionar("partida/ver/$part");
    }
    
    public function eliminarEquipoPresupuesto($id, $id_presu){
        
        Session::acceso('proyecto');
                
        $this->_equipos->eliminarEquipoPresupuesto($this->filtrarInt($id));        
        $this->redireccionar("modelos/verPartidaModelo/$id_presu");
    }
    
    public function equipoPresupuesto(){
        
        Session::acceso('proyecto');
        
        $id = $this->getInt('id_partidas_presupuesto');
       if($this->getInt('guardar')== 1){             
            $this->_equipos->equipoPresupuesto(
                    $this->getInt('id_partidas_presupuesto'),
                    $this->getInt('id_equipo'),
                    $this->getFloat('cantidad_e'),
                    $this->getFloat('precio_e'),
                    $this->getFloat('monto_e')
                    );            
            $this->redireccionar("modelos/verPartidaModelo/$id");
       }
    }
}
?>
