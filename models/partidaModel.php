<?php

class partidaModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getPartidas(){
        $partidas = $this->_db->query("select * from partidas");
        return $partidas->fetchall();
    }
    public function getPartida($id){
        $id = (int) $id;
        $partida = $this->_db->query("select * from partidas where id_partidas = $id");
        return $partida->fetch();
    }
    
    public function listar($term){
        
        $partidas = $this->_db->query("select * from partidas WHERE descripcion LIKE '%$term%'");
        return $partidas->fetchall();
    }
    
    public function porcentajes(){
        $porcentajes = $this->_db->query("select * from porcentajes where aplica = 'partidas'");
        return $porcentajes->fetch();
    }
    
    public function precioUnitario($id, $precio_unitario){
        $this->_db->query("update partidas set precio_unitario = $precio_unitario where id_partidas = $id");
    }

    public function nuevaPartida($codigo_covenin, $descripcion, $unidad_medida, $mini_descripcion, $codigo_ministerio, $cantidad, $rendimiento ){
        $this->_db->prepare("insert into partidas values (null, :codigo_covenin, :descripcion, :unidad_medida, :mini_descripcion, :codigo_ministerio, :cantidad, :rendimiento, '0', '0', '0', '0')")
                ->execute(
                        array(
                            'codigo_covenin' => $codigo_covenin,
                            'descripcion' => $descripcion,
                            'unidad_medida' => $unidad_medida,
                            'mini_descripcion' => $mini_descripcion,
                            'codigo_ministerio' => $codigo_ministerio,
                            'cantidad' => $cantidad,
                            'rendimiento' => $rendimiento
                        ));
    }
    
    public function editarPartida($id, $codigo_covenin,$descripcion,$unidad_medida,$mini_descripcion,$codigo_ministerio,$cantidad,$rendimiento){
        $id = (int) $id;
        $this->_db->prepare("UPDATE partidas SET codigo_covenin = :codigo_covenin, descripcion = :descripcion, unidad_medida = :unidad_medida , mini_descripcion = :mini_descripcion, codigo_ministerio = :codigo_ministerio, cantidad = :cantidad, rendimiento = :rendimiento where id_partidas = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'codigo_covenin' => $codigo_covenin,
                            'descripcion' => $descripcion,
                            'unidad_medida' => $unidad_medida,
                            'mini_descripcion' => $mini_descripcion,
                            'codigo_ministerio' => $codigo_ministerio,
                            'cantidad' => $cantidad,
                            'rendimiento' => $rendimiento
                        ));
        
    }
    public function eliminarPartida($id){
       $id = (int) $id;
       $this->_db->query("delete from partidas where id_partidas = $id");
                
    }
    
    public function actualizarTotales($id){
       $id = (int) $id;
       $this->_db->query("update partidas set total_equi = (SELECT Sum(monto) FROM equipos_partida where id_partidas = $id)  where id_partidas = $id");
       $this->_db->query("update partidas set total_mat = (SELECT Sum(monto) FROM materiales_partida where id_partidas = $id)  where id_partidas = $id");
       $this->_db->query("update partidas set total_mano = (SELECT Sum(monto) FROM mano_partida where id_partidas = $id)  where id_partidas = $id");
    }
    
    
}

?>
