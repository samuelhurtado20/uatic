<?php

class proyectoController extends Controller{
        private $_proyecto;
    public function __construct() {
        parent::__construct();
        $this->_proyecto = $this->load_model('proyecto');
        $this->_modelos = $this->load_model('modelos');
        $this->_viviendas = $this->load_model('vivienda');
    }

    public function index($pagina = false){
        
        Session::acceso('tecnico');
        
            if(!$this->filtrarInt($pagina)){
                $pagina = false;
            }
            else {
                $pagina = (int) $pagina;
            }
            $this->getLibrary('paginador');
            $paginador = new Paginador();
            
            $this->_view->proyectos = $paginador->paginar($this->_proyecto->getProyectos(), $pagina);
            $this->_view->paginacion = $paginador->getView('prueba', 'proyecto/index');
            $this->_view->titulo = 'Listar Proyectos';   
            $this->_view->renderizar('index', 'proyecto');
    }

    public function nuevo(){        
        
        Session::acceso('admin');
        
        $this->_view->titulo = 'Nuevo Proyecto';
        $this->_view->setJs(array('proyecto'));
        
        if($this->getInt('guardar')== 1){
            
            $this->_proyecto->nuevoProyecto(
                    $this->getPostParam('consejo'),
                    $this->getPostParam('nombre_proyecto'),
                    $this->getPostParam('monto_financiamiento'),
                    $this->getPostParam('viviendas_sustituir'),
                    $this->getPostParam('viviendas_rehabilitar'),
                    $this->getPostParam('modelo_vivienda'),
                    $this->fechaMysql('fecha_inicio'),
                    $this->fechaMysql('fecha_culminacion'),
                    $this->getPostParam('id'),
                    $this->getPostParam('responsable_consejo'),
                    $this->getPostParam('telefono_consejo')
                    );            
                    $this->redireccionar('proyecto');
        }        
        $this->_view->renderizar('nuevo', 'proyecto');
    }
    
    public function editar($id_proyecto){
        
        Session::acceso('tecnico');
        
        if(!$this->filtrarInt($id_proyecto)){
            $this->redireccionar('proyecto');
        }
        
        if(!$this->_proyecto->getProyecto($this->filtrarInt($id_proyecto))){
            $this->redireccionar('proyecto');
        }
        
        $this->_view->titulo = 'Editar Proyecto';
        $this->_view->setJs(array('proyecto'));
        
        if($this->getInt('guardar') == 1){
            
            $this->_proyecto->editarProyecto(
                    $this->getPostParam('id_proyecto'),            
                    $this->getPostParam('nombre_proyecto'),
                    $this->getPostParam('monto_financiamiento'),
                    $this->getPostParam('viviendas_sustituir'),
                    $this->getPostParam('viviendas_rehabilitar'),
                    $this->getPostParam('fecha_inicio'),
                    $this->getPostParam('fecha_culminacion'),
                    $this->getPostParam('responsable_uatic'),
                    $this->getPostParam('telefono_uatic'),
                    $this->getPostParam('responsable_consejo'),
                    $this->getPostParam('telefono_consejo')
                    );
            
            $this->redireccionar('proyecto');
        }
        $this->_view->datos = $this->_proyecto->getProyecto($this->filtrarInt($id_proyecto));
        $this->_view->renderizar('editar', 'proyecto');
    }
    public function eliminar($id){
        
        Session::acceso('proyecto');
        
        Session::acceso('admin');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('partida');
        }
        
        $this->_proyecto->eliminarProyecto($this->filtrarInt($id));
        $this->redireccionar('proyecto');
    }
    
    public function verProyecto($id){
        
        Session::acceso('tecnico');
        
        if(!$this->filtrarInt($id)){
            $this->redireccionar('proyecto');
        }
        
        if(!$this->_proyecto->getProyecto($this->filtrarInt($id))){
            $this->redireccionar('proyecto');
        }
        
        $this->_view->titulo = 'Detalles Proyecto';
        $this->_view->setJs(array('proyecto'));
        
        
        $this->_view->proyecto = $this->_proyecto->getProyecto($this->filtrarInt($id));
        $this->_view->viviendas = $this->_viviendas->getViviendas($this->filtrarInt($id));
        $this->_view->presupuestoProyecto = $this->_proyecto->presupuestoProyecto($this->filtrarInt($id));
        $this->_view->renderizar('verProyecto', 'proyecto');
    }
    
    public function estados(){
            $row = $this->_proyecto->estados();
            for($i=-1; $i < count($row); $i++)
            { 
                $estados .= "<option value='".$row[$i]['id_estado']."'>".$row[$i]['Estado']."</option>";
            } 
       echo $estados;
    }
    
    public function municipios(){
            $row = $this->_proyecto->municipios($_POST['elegido']);
            for($i=-1; $i < count($row); $i++)
            { 
                $municipios .= "<option value='".$row[$i]['id_municipio']."'>".$row[$i]['municipio']."</option>";
            } 
       echo $municipios;
    }
    
    public function parroquias(){
            $row = $this->_proyecto->parroquias($_POST['elegido']);
            for($i=-1; $i < count($row); $i++)
            { 
                $parroquias .= "<option value='".$row[$i]['id_parroquia']."'>".$row[$i]['Parroquia']."</option>";
            } 
       echo $parroquias;
    }
    
    public function consejos(){
            $row = $this->_proyecto->consejos($_POST['elegido']);
            for($i=-1; $i < count($row); $i++)
            { 
                $consejos .= "<option value='".$row[$i]['idConsejoComunal']."'>".$row[$i]['ConsejoComunal']."</option>";
            } 
       echo $consejos;
    }
    
    public function modelos(){
        
            $row = $this->_modelos->getModelos();
            for($i=-1; $i < count($row); $i++)
            { 
                $modelos .= "<option value='".$row[$i]['id_modelo_vivienda']."'>".$row[$i]['descripcion']."</option>";
            } 
       echo $modelos;
    }
    public function responsables(){
            $row = $this->_proyecto->responsables($_POST['elegido']);
            $responsables = "<option></option>";
            for($i=0; $i < count($row); $i++)
            { 
                $responsables .= "<option value='".$row[$i]['id']."'>".ucwords(strtolower($row[$i]['apellido'])).", ".ucwords(strtolower($row[$i]['nombre']))."</option>";
            } 
       echo $responsables;
    }

    public function telefono_uatic(){
        $row = $this->_proyecto->telefono_uatic($_POST['id']);
        echo $row['9'];
    }
    
    public function area(){
        $row = $this->_modelos->getModelo($_POST['id']);
        echo $row['3'];
    }
    public function cuartos(){
        $row = $this->_modelos->getModelo($_POST['id']);
        echo $row['4'];
    }
    public function banos(){
        $row = $this->_modelos->getModelo($_POST['id']);
        echo $row['5'];
    }

    public function consejo($id){
        
        Session::acceso('proyecto');
        
        $this->_view->titulo = 'Editar Consejo Comunal';
        $this->_view->setJs(array('proyecto2'));
        
        if($this->getInt('guardar') == 1){


            $this->_proyecto->consejo(
                    $id,
                    $this->getPostParam('idConsejoComunal')
                    );
            
           echo "<script>alert('Consejo Comunal Actualizado.')
                    history.back(1);
                </script>";
        }
        $this->_view->datos = $this->_proyecto->getProyecto($this->filtrarInt($id));
        $this->_view->renderizar('consejo', 'proyecto');
    }
}
?>
