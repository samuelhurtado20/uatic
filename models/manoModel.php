<?php

class manoModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getManosPartida($id){
        $manos = $this->_db->query("select * from mano_de_obra join mano_partida using (id_mano) where id_partidas=$id");
        return $manos->fetchall();
    }
    public function getMano($term){
        
        $manos = $this->_db->query("select * from mano_de_obra WHERE nombre LIKE '%$term%'");
        return $manos->fetchall();
    }
    public function unaMano($id_mano){
        $id_mano = (int) $id_mano;
        $mano = $this->_db->query("select * from mano_de_obra where id_mano = $id_mano");
        return $mano->fetch();
    }
    public function listar(){
        
        $mano = $this->_db->query("select * from mano_de_obra");
        return $mano->fetchall();
    }
    
    public function agregar($nombre, $unidad, $jornal){
        $this->_db->prepare("insert into mano_de_obra values (null, :nombre, :unidad, :jornal)")
                ->execute(
                        array(
                           'nombre' => $nombre,
                           'unidad' => $unidad,
                           'jornal' => $jornal
                        ));
    }
    
    public function editarMano($id_mano, $nombre, $unidad, $jornal){
        $id_mano = (int) $id_mano;
        $this->_db->prepare("UPDATE mano_de_obra SET nombre = :nombre, unidad = :unidad, jornal =:jornal where id_mano = :id_mano")
                ->execute(
                        array(
                            'id_mano' => $id_mano,
                           'nombre' => $nombre,
                           'unidad' => $unidad,
                           'jornal' => $jornal
                        ));
        
    }
    
    public function eliminar($id_mano){
       
       $this->_db->query("delete from mano_de_obra where id_mano = $id_mano");
                
    }
    
    public function getPrecio($id){
        
        $manos = $this->_db->query("SELECT jornal FROM mano_jornal WHERE id_mano = '$id' order by fecha desc LIMIT 1");
        return $manos->fetch();
    }
    
    public function manoPartida($id_partidas, $id_mano, $cantidad_m, $jornal, $monto_m){
        $this->_db->prepare("insert into mano_partida values (null, :id_partidas, :id_mano, :cantidad, :jornal, :monto)")
                ->execute(
                        array(
                            'id_partidas' => $id_partidas,
                            'id_mano' => $id_mano,
                            'cantidad' => $cantidad_m,
                            'jornal' => $jornal,
                            'monto' => $monto_m
                        ));
    }

    
    public function eliminarManoPartida($id){
       
       $this->_db->query("delete from mano_partida where idManoPartida = $id");
                
    }
    
    public function manoPresupuesto($id_partidas_presupuesto, $id_mano, $cantidad_m, $jornal, $monto_m){
        $this->_db->prepare("insert into mano_part_presu values (null, :id_partidas_presupuesto, :id_mano, :cantidad_m, :jornal, :monto_m)")
                ->execute(
                        array(
                            'id_partidas_presupuesto' => $id_partidas_presupuesto,
                            'id_mano' => $id_mano,
                            'cantidad_m' => $cantidad_m,
                            'jornal' => $jornal,
                            'monto_m' => $monto_m
                        ));
    }
    
    public function eliminarManoPresupuesto($id){
       
       $this->_db->query("delete from mano_part_presu where id = $id");
                
    }
    
}

?>
