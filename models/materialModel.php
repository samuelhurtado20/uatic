<?php

class materialModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getMaterialesPartida($id){
        $partidas = $this->_db->query("select * from materiales join materiales_partida using (id_materiales) where id_partidas=$id");
        return $partidas->fetchall();
    }
    public function getMaterial($term){
        
        $materiales = $this->_db->query("select * from materiales WHERE material LIKE '%$term%'");
        return $materiales->fetchall();
    }
    public function unMaterial($id_materiales){
        $id_materiales = (int) $id_materiales;
        $material = $this->_db->query("select * from materiales where id_materiales = $id_materiales");
        return $material->fetch();
    }
    public function listar(){
        
        $materiales = $this->_db->query("select * from materiales");
        return $materiales->fetchall();
    }
    public function getPrecio($id){
        
        $materiales = $this->_db->query("SELECT precio FROM materiales_precio WHERE id_materiales = '$id' order by fecha desc LIMIT 1");
        return $materiales->fetch();
    }
    
    public function materialPartida($id_partidas, $id_materiales, $cantidad, $precio, $monto){
        $this->_db->prepare("insert into materiales_partida values (null, :id_partidas, :id_materiales, :cantidad, :precio, :monto)")
                ->execute(
                        array(
                            'id_partidas' => $id_partidas,
                            'id_materiales' => $id_materiales,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'monto' => $monto
                        ));
    }

    public function agregar($unidad, $material, $precio){
        $this->_db->prepare("insert into materiales values (null, :unidad, :material, :precio)")
                ->execute(
                        array(
                           'unidad' => $unidad,
                           'material' => $material,
                           'precio' => $precio
                        ));
    }
    
    public function editarMaterial($id_materiales, $material, $unidad, $precio){
        
        $this->_db->prepare("UPDATE materiales SET material = :material, unidad = :unidad, precio = :precio where id_materiales = :id_materiales")
                ->execute(
                        array(
                           'id_materiales' => $id_materiales,
                           'material' => $material,
                           'unidad' => $unidad,
                            'precio' => $precio
                        ));
        
    }
    
    public function nuevo($id_partidas, $id_materiales, $cantidad, $precio, $monto){
        $this->_db->prepare("insert into materiales_partida values (null, :id_partidas, :id_materiales, :cantidad, :precio, :monto)")
                ->execute(
                        array(
                            'id_partidas' => $id_partidas,
                            'id_materiales' => $id_materiales,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'monto' => $monto
                        ));
    }
    
    public function eliminarMaterialPartida($id){
       
       $this->_db->query("delete from materiales_partida where idMaterialesPartida = $id");
                
    }
    
    public function materialPresupuesto($id_partidas_presupuesto, $id_materiales, $cantidad, $precio, $monto){
        $this->_db->prepare("insert into materiales_part_presu values (null, :id_partidas_presupuesto, :id_materiales, :cantidad, :precio, :monto)")
                ->execute(
                        array(
                            'id_partidas_presupuesto' => $id_partidas_presupuesto,
                            'id_materiales' => $id_materiales,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'monto' => $monto
                        ));
    }
    
    public function eliminarMaterialPresupuesto($id){
       
       $this->_db->query("delete from materiales_part_presu where id = $id");
                
    }
    
    public function eliminar($id_materiales){
       
       $this->_db->query("delete from materiales where id_materiales = $id_materiales");
                
    }
}

?>
