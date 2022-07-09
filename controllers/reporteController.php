<?php

class reporteController extends Controller{
        private $_partidas;
    public function __construct() {
        parent::__construct();
        $this->_partidas = $this->load_model('partida');
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
            
            $this->_view->partidas = $paginador->paginar($this->_partidas->getPartidas(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'partida/index');
            $this->_view->titulo = 'Listar Partidas';   
            $this->_view->renderizar('index', 'partida');
    }
    public function estado(){
        
        Session::acceso('proyecto');
        

        $this->_view->titulo = 'Reporte Estado';
        $this->_view->setJs(array('reporte'));
        
        
        $this->_view->data = array(40,21,17,14,23);        
        $this->_view->renderizar('estado', 'reporte');

    }
    public function nueva(){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Nueva Partida';
        $this->_view->setJs(array('partida'));
        
        if($this->getInt('guardar')== 1){
            
            $this->_partidas->nuevaPartida(
                    $this->getPostParam('codigo_covenin'),
                    $this->getSql('descripcion'),
                    $this->getPostParam('unidad_medida'),
                    $this->getPostParam('mini_descripcion'),
                    $this->getPostParam('codigo_ministerio'),
                    $this->getPostParam('cantidad'),
                    $this->getPostParam('rendimiento')
                    );
            
            $this->redireccionar('partida');
        }
        
        $this->_view->renderizar('nueva', 'partida');
    }
    public function editar($id){
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        if(!$this->_partidas->getPartida($this->filtrarInt($id))){
            $this->redireccionar('partida');
        }
        
        $this->_view->titulo = 'Editar Partida';
        $this->_view->setJs(array('partida'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_partidas->editarPartida(
                    $this->getPostParam('id'),
                    $this->getPostParam('codigo_covenin'),
                    $this->getPostParam('descripcion'),
                    $this->getPostParam('unidad_medida'),
                    $this->getPostParam('mini_descripcion'),
                    $this->getPostParam('codigo_ministerio'),
                    $this->getPostParam('cantidad'),
                    $this->getPostParam('rendimiento')
                    );
            
            $this->redireccionar('partida');
        }
        $this->_view->datos = $this->_partidas->getPartida($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'partida');
    }
    public function eliminar($id){
        
        Session::acceso('admin');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        if(!$this->_partidas->getPartida($this->filtrarInt($id))){
            $this->redireccionar('partida');
        }
        
        $this->_partidas->eliminarPartida($this->filtrarInt($id));
        $this->redireccionar('partida');
    }
    
    
    public function ver($id){
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        if(!$this->_partidas->getPartida($this->filtrarInt($id))){
            $this->redireccionar('partida');
        }
        
        $this->_view->titulo = 'Detalles Partida';
        $this->_view->setJs(array('partida'));
        
        
        $this->_view->datos = $this->_partidas->getPartida($this->filtrarInt($id));
        $this->_view->materiales = $this->_materiales->getMaterialesPartida($this->filtrarInt($id));
        $this->_view->equipos = $this->_equipos->getEquiposPartida($this->filtrarInt($id));
        $this->_view->manos = $this->_manos->getManosPartida($this->filtrarInt($id));
        $this->_view->porcentajes = $this->_partidas->porcentajes();
        $this->_view->presupuesto = $this->partidaPresupuesto($this->filtrarInt($id));
        $this->_view->renderizar('ver', 'partida');
    }
    
    public function partidaPresupuesto($id){
        
        
        $porcentajes = $this->_partidas->porcentajes();
        
        $this->_partidas->actualizarTotales($this->filtrarInt($id));
        
        $partida = $this->_partidas->getPartida($this->filtrarInt($id));
        
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
        
        $this->_partidas->precioUnitario(
                    $id,
                    $presupuesto['precio']
                    );
        
        
        return $presupuesto;
    }   
    
}
?>
