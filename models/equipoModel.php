<?php

class equipoModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getEquiposPartida($id){
        $equipos = $this->_db->query("select * from equipo join equipos_partida using (id_equipo) where id_partidas=$id");
        return $equipos->fetchall();
    }
    public function getEquipo($term){
        
        $equipos = $this->_db->query("select * from equipo WHERE nombre LIKE '%$term%'");
        return $equipos->fetchall();
    }
    public function unEquipo($id_equipo){
        $id_equipo = (int) $id_equipo;
        $equipo = $this->_db->query("select * from equipo where id_equipo = $id_equipo");
        return $equipo->fetch();
    }
    public function listar(){
        
        $equipos = $this->_db->query("select * from equipo");
        return $equipos->fetchall();
    }
    public function getPrecio($id){
        
        $equipos = $this->_db->query("SELECT precio FROM equipo_precio WHERE id_equipo = '$id' order by fecha_e_precio desc LIMIT 1");
        return $equipos->fetch();
    }
    
    public function equipoPartida($id_partidas, $id_equipos, $fecha, $cantidad, $precio, $monto){
        $this->_db->prepare("insert into equipos_partida values (null, :id_partidas, :id_equipos, :cantidad, :precio, :monto)")
                ->execute(
                        array(
                            'id_partidas' => $id_partidas,
                            'id_equipos' => $id_equipos,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'monto' => $monto
                        ));
    }
    
    public function agregar($nombre, $cop ,$unidad, $precio){
        $this->_db->prepare("insert into equipo values (null, :nombre, :cop, :unidad, :precio)")
                ->execute(
                        array(
                           'nombre' => $nombre,
                           'cop' => $cop,
                           'unidad' => $unidad,
                           'precio' => $precio
                        ));
    }
    
    public function editarEquipo($id_equipo, $nombre, $cop ,$unidad, $precio){
        
        $this->_db->prepare("UPDATE equipo SET nombre = :nombre, unidad = :unidad , COP = :cop, precio = :precio where id_equipo = :id_equipo")
                ->execute(
                        array(
                           'id_equipo' => $id_equipo,
                           'nombre' => $nombre,
                           'cop' => $cop,
                           'unidad' => $unidad,
                           'precio' => $precio
                        ));
        
    }
    
    public function nuevo($id_partidas, $id_equipo, $cantidad_e, $precio_e, $monto_e){
        $this->_db->prepare("insert into equipos_partida values (null, :id_partidas, :id_equipo, :cantidad_e, :precio_e, :monto_e)")
                ->execute(
                        array(
                            'id_partidas' => $id_partidas,
                            'id_equipo' => $id_equipo,
                            'cantidad_e' => $cantidad_e,
                            'precio_e' => $precio_e,
                            'monto_e' => $monto_e
                        ));
    }
    
    public function eliminarEquipoPartida($id){
       
       $this->_db->query("delete from equipos_partida where idEquiposPartida = $id");
                
    }
    
    public function equipoPresupuesto($id_partidas_presupuesto, $id_equipo, $cantidad_e, $precio_e, $monto_e){
        $this->_db->prepare("insert into equipos_part_presu values (null, :id_partidas_presupuesto, :id_equipo, :cantidad_e, :precio_e, :monto_e)")
                ->execute(
                        array(
                            'id_partidas_presupuesto' => $id_partidas_presupuesto,
                            'id_equipo' => $id_equipo,
                            'cantidad_e' => $cantidad_e,
                            'precio_e' => $precio_e,
                            'monto_e' => $monto_e
                        ));
    }
    
    public function eliminarEquipoPresupuesto($id){
       
       $this->_db->query("delete from equipos_part_presu where id = $id");
                
    }
    
    public function eliminar($id_equipo){
       
       $this->_db->query("delete from equipo where id_equipo = $id_equipo");
                
    }

}

?>
