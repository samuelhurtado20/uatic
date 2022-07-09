<?php

class modelosModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getModelos(){
        $modelos = $this->_db->query("select * from modelo_vivienda");
        return $modelos->fetchall();
    }
    public function getModelo($id){
        $id = (int) $id;
        $post = $this->_db->query("select * from modelo_vivienda where id_modelo_vivienda = $id");
        return $post->fetch();
    }
    
    public function partidasModelo($id){
        $partidaModelo = $this->_db->query("SELECT * FROM partidas_presupuesto where id_modelo_vivienda='$id'");
        return $partidaModelo->fetchall();
    }

    public function getPartidaModelo($id){
        $partidaModelo = $this->_db->query("SELECT * FROM partidas_presupuesto where id_partidas ='$id'");
        return $partidaModelo->fetch();
    }

    public function partidaModelo($id_modelo_vivienda,$cantidad,$id_partidas,$etapa){
        $this->_db->query("insert into partidas_presupuesto select 'null','$id_modelo_vivienda','$cantidad','$id_partidas','$etapa', codigo_covenin, descripcion, unidad_medida, mini_descripcion, codigo_ministerio, cantidad, rendimiento, total_mat, total_equi, total_mano, precio_unitario from partidas where id_partidas = '$id_partidas'");
        $id = $this->_db->lastInsertId();        
        $this->_db->query("insert into materiales_part_presu select 'null','$id', id_materiales, cantidad, precio, monto from materiales_partida where id_partidas = '$id_partidas'");
        $this->_db->query("insert into equipos_part_presu select null,'$id', id_equipo, cantidad, precio, monto from equipos_partida where id_partidas = '$id_partidas'");
        $this->_db->query("insert into mano_part_presu select null,'$id', id_mano, cantidad, jornal, monto from mano_partida where id_partidas = '$id_partidas'");
    }
    
    public function insertarModelo($codigo,$descripcion, $area, $cuartos, $banos, $sala, $salacomedor, $comedor, $cocina){
        $this->_db->prepare("insert into modelo_vivienda values (null, :codigo, :descripcion, :area, :cuartos, :banos, :sala, :salacomedor, :comedor, :cocina)")
                ->execute(
                        array(
                            'codigo' => $codigo,
                            'descripcion' => $descripcion,
                            'area' => $area,
                            'cuartos' => $cuartos,
                            'banos' => $banos,
                            'sala' => $sala,
                            'salacomedor' => $salacomedor,
                            'comedor' => $comedor,
                            'cocina' => $cocina
                        ));
    }
    
    public function editarModelo($id, $descripcion, $area, $cuartos, $banos, $sala, $salacomedor, $comedor, $cocina){
        $id = (int) $id;
        $this->_db->prepare("UPDATE modelo_vivienda SET descripcion = :descripcion, area = :area, cuartos = :cuartos, banos = :banos, sala = :sala, salacomedor = :salacomedor, comedor = :comedor, cocina = :cocina where id_modelo_vivienda = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'descripcion' => $descripcion,
                            'area' => $area,
                            'cuartos' => $cuartos,
                            'banos' => $banos,
                            'sala' => $sala,
                            'salacomedor' => $salacomedor,
                            'comedor' => $comedor,
                            'cocina' => $cocina
                        ));
        
    }

    public function editarPartidaModelo($id, $cantidad, $etapa){
        
        $this->_db->prepare("UPDATE partidas_presupuesto SET cantidad = :cantidad, etapa = :etapa where id_partidas = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'cantidad' => $cantidad,
                            'etapa' => $etapa
                        ));
        
    }
    
    public function editarPorcentaje($id, $iva, $prestaciones,$administracion, $utilidad){
        $id = (int) $id;
        $this->_db->prepare("UPDATE porcentajes SET iva = :iva, prestaciones = :prestaciones, administracion = :administracion, utilidad = :utilidad where id_modelo_vivienda = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'iva' => $iva,
                            'prestaciones' => $prestaciones,
                            'administracion' => $administracion,
                            'utilidad' => $utilidad
                        ));
        
    }
    public function eliminarModelo($id){
       $id = (int) $id;
       $this->_db->query("delete from modelo_vivienda where id_modelo_vivienda = $id");
                
    }
    
    public function eliminarPartidaModelo($id_partidas, $id_modelo_vivienda){
       $id = (int) $id;
       $this->_db->query("delete from partidas_presupuesto where id_modelo_vivienda = $id_modelo_vivienda and id_partidas = $id_partidas");
                
    }
    public function partidaPresupuesto($id_partidas_presupuesto){
        $id_partidas_presupuesto = (int) $id_partidas_presupuesto;
        $partida = $this->_db->query("select * from partidas_presupuesto where id_partidas_presupuesto = $id_partidas_presupuesto");
        return $partida->fetch();
    }
    public function materialesPresupuesto($id_partidas_presupuesto){
        $partidas = $this->_db->query("select * from materiales join materiales_part_presu using (id_materiales) where id_partidas_presupuesto = $id_partidas_presupuesto");
        return $partidas->fetchall();
    }
    public function equiposPresupuesto($id_partidas_presupuesto){
        $partidas = $this->_db->query("select * from equipo join equipos_part_presu using (id_equipo) where id_partidas_presupuesto = $id_partidas_presupuesto");
        return $partidas->fetchall();
    }
    public function manoPresupuesto($id_partidas_presupuesto){
        $partidas = $this->_db->query("select * from mano_de_obra join mano_part_presu using (id_mano) where id_partidas_presupuesto = $id_partidas_presupuesto");
        return $partidas->fetchall();
    }
    public function porcentajes($id){
        $porcentajes = $this->_db->query("select * from porcentajes where aplica = 'modelo' and id_modelo_vivienda = $id");
        return $porcentajes->fetch();
    }
    public function precioUnitario($id, $precio_unitario){
        $this->_db->query("update partidas_presupuesto set precio_unitario = $precio_unitario where id_partidas_presupuesto = $id");
    }
    public function totalMateriales($id){
        $this->_db->query("update partidas_presupuesto set total_mat = (SELECT Sum(monto) FROM materiales_part_presu where id_partidas_presupuesto = $id) where id_partidas_presupuesto = $id");
    }
    public function totalEquipos($id){
        $this->_db->query("update partidas_presupuesto set total_equi = (SELECT Sum(monto) FROM equipos_part_presu where id_partidas_presupuesto = $id) where id_partidas_presupuesto = $id");
    }
    public function totalMano($id){
        $this->_db->query("update partidas_presupuesto set total_mano = (SELECT Sum(monto) FROM mano_part_presu where id_partidas_presupuesto = $id) where id_partidas_presupuesto = $id");
    }
    public function guardarImagen($id_modelo_vivienda, $descripcion, $jpg, $tipo){
        $this->_db->prepare("insert into modelo_imagenes values (null, :id_modelo_vivienda, :descripcion, :jpg, :tipo)")
                ->execute(
                        array(
                            'id_modelo_vivienda' => $id_modelo_vivienda,
                            'descripcion' => $descripcion,
                            'jpg' => $jpg,
                            'tipo' => $tipo
                        ));
    }
    public function imagenesMemoria($id){
        $imagenesMemoria = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='3'");
        return $imagenesMemoria->fetchall();
    }
    public function imagenesPlano($id){
        $imagenesPlano = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='2'");
        return $imagenesPlano->fetchall();
    }
    public function imagenesInfografia($id){
        $imagenesInfografia = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='4'");
        return $imagenesInfografia->fetchall();
    }

    public function etapas(){
        $etapas = $this->_db->query("select * from etapas");
        return $etapas->fetchall();
    }


    public function enlacesMemoria($id){
        $enlacesMemoria = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='7'");
        return $enlacesMemoria->fetchall();
    }

    public function enlacesPlano($id){
        $enlacesPlano = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='5'");
        return $enlacesPlano->fetchall();
    }

    public function enlacesInfografia($id){
        $enlacesInfografia = $this->_db->query("select * from modelo_imagenes where id_modelo_vivienda = $id and tipo='6'");
        return $enlacesInfografia->fetchall();
    }
}

?>
