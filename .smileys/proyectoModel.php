<?php

class proyectoModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getProyectos(){
        $proyectos = $this->_db->query("select * from estados join municipios using(id_estado) join parroquias using(id_municipio) join consejoscomunales using(id_parroquia)  join proyecto using (idConsejoComunal)");
        return $proyectos->fetchall();
    }
    
    public function getProyecto($id){
        $id = (int) $id;
        $proyecto = $this->_db->query("select * from estados join municipios using(id_estado) join parroquias using(id_municipio) join consejoscomunales using(id_parroquia)  join proyecto using (idConsejoComunal) join modelo_vivienda using(id_modelo_vivienda) where id_proyecto = $id");
        return $proyecto->fetch();
    }
    
    public function presupuestoProyecto($id){
        $id = (int) $id;
        $proyecto = $this->_db->query("select * from  proyecto join modelo_vivienda using(id_modelo_vivienda) join partidas_presupuesto using(id_modelo_vivienda) where id_proyecto = $id");
        return $proyecto->fetchall();
    }
    
    public function nuevoProyecto($consejo, $nombre_proyecto, $monto_financiamiento, $viviendas_sustituir, $viviendas_rehabilitar, $modelo_vivienda, $fecha_inicio, $fecha_culminacion, $responsable_uatic, $telefono_uatic, $responsable_consejo, $telefono_consejo)
    {
        $this->_db->prepare("insert into proyecto values (null, :idConsejoComunal, :nombre_proyecto, :monto_financiamiento, :viviendas_sustituir, :viviendas_rehabilitar, :id_modelo_vivienda, :fecha_inicio, :fecha_culminacion, :responsable_uatic, :telefono_uatic, :responsable_consejo, :telefono_consejo)")
                ->execute(
                        array(
                            'idConsejoComunal' => $consejo,
                            'nombre_proyecto' => $nombre_proyecto,
                            'monto_financiamiento' => $monto_financiamiento,
                            'viviendas_sustituir' => $viviendas_sustituir,
                            'viviendas_rehabilitar' => $viviendas_rehabilitar,
                            'id_modelo_vivienda' => $modelo_vivienda,
                            'fecha_inicio' => $fecha_inicio,
                            'fecha_culminacion' => $fecha_culminacion,
                            'responsable_uatic' => $responsable_uatic,
                            'telefono_uatic' => $telefono_uatic,
                            'responsable_consejo' => $responsable_consejo,
                            'telefono_consejo' => $telefono_consejo
                        ));
    }
    
    public function eliminarProyecto($id){
       $id = (int) $id;
       $this->_db->query("delete from proyecto where id_proyecto = $id");
                
    }
    
    public function estados(){
        
        $estados = $this->_db->query("select * from estados");
        return $estados->fetchall();
    }
    
    public function municipios($id){
        
        $municipios = $this->_db->query("select * from municipios where id_estado = $id");
        return $municipios->fetchall();
    }
    
    public function parroquias($id){
        
        $municipios = $this->_db->query("select * from parroquias where id_municipio = $id");
        return $municipios->fetchall();
    }
    
    public function consejos($id){
        
        $municipios = $this->_db->query("select * from consejoscomunales where id_parroquia = $id order by ConsejoComunal asc");
        return $municipios->fetchall();
    }
}

?>
