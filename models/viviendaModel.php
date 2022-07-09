<?php

class viviendaModel extends Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getViviendas($id_proyecto){
        $viviendas = $this->_db->query("select * from viviendas where id_proyecto = $id_proyecto");
        return $viviendas->fetchall();
    }
    
    public function getVivienda($id){
        $vivienda = $this->_db->query("select * from viviendas where id = $id");
        return $vivienda->fetch();
    }
    
    public function valuaciones($id){
        $valuaciones = $this->_db->query("select * from valuaciones where id_viviendas = $id ORDER BY inicio ASC");
        return $valuaciones->fetchall();
    }

    public function imagenes($id_valuacion){
        $imagenes = $this->_db->query("select * from imagenValuacion where id_valuacion = $id_valuacion");
        return $imagenes->fetchall();
    }
    
    public function idProyectoVivienda($id){
        $idProyectoVivienda = $this->_db->query("select id_proyecto from viviendas where id = $id");
        return $idProyectoVivienda->fetch();
    }
    
    public function nueva($cod_vivienda, $id_proyecto, $cedula_jefe, $nacionalidad, $nombres, $apellidos, $sexo, $telefono, $correo, $ocupacion, $parentesco, $ubicacion){
        $this->_db->prepare("insert into viviendas values (null, :cod_vivienda, :id_proyecto, :cedula_jefe, :nacionalidad, :nombres, :apellidos, :sexo, :telefono, :correo, :ocupacion, :parentesco, :ubicacion)")
                ->execute(
                        array(
                            'cod_vivienda' => $cod_vivienda,
                            'id_proyecto' => $id_proyecto,
                            'cedula_jefe' => $cedula_jefe,
                            'nacionalidad' => $nacionalidad,
                            'nombres' => $nombres,
                            'apellidos' => $apellidos,
                            'sexo' => $sexo,
                            'telefono' => $telefono,
                            'correo' => $correo,
                            'ocupacion' => $ocupacion,
                            'parentesco' => $parentesco,
                            'ubicacion' => $ubicacion
                        ));
    }
    
    public function editar($id, $cod_vivienda, $id_proyecto, $cedula_jefe, $nacionalidad, $nombres, $apellidos, $sexo, $telefono, $correo, $ocupacion, $parentesco, $ubicacion){
        $id = (int) $id;
        $this->_db->prepare("UPDATE viviendas SET cod_vivienda = :cod_vivienda, id_proyecto = :id_proyecto, cedula_jefe = :cedula_jefe, nacionalidad = :nacionalidad, nombres = :nombres, apellidos = :apellidos, sexo = :sexo, telefono = :telefono, correo = :correo, ocupacion = :ocupacion, parentesco = :parentesco, ubicacion = :ubicacion where id = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'cod_vivienda' => $cod_vivienda,
                            'id_proyecto' => $id_proyecto,
                            'cedula_jefe' => $cedula_jefe,
                            'nacionalidad' => $nacionalidad,
                            'nombres' => $nombres,
                            'apellidos' => $apellidos,
                            'sexo' => $sexo,
                            'telefono' => $telefono,
                            'correo' => $correo,
                            'ocupacion' => $ocupacion,
                            'parentesco' => $parentesco,
                            'ubicacion' => $ubicacion
                        ));
        
    }
    
    public function eliminar($id){
       $id = (int) $id;
       $this->_db->query("delete from viviendas where id = $id");
                
    }
    
    public function valuacion($id, $id_partidas_presupuesto, $f_inicio, $f_final, $ejecutado){
        $this->_db->prepare("insert into valuaciones values (null, :id, :id_partidas_presupuesto, :inicio, :final, :ejecutado)")
                ->execute(
                        array(
                            'id' => $id,
                            'id_partidas_presupuesto' => $id_partidas_presupuesto,
                            'inicio' => $f_inicio,
                            'final' => $f_final,
                            'ejecutado' => $ejecutado
                        ));
    }
    
    public function eliminarValuacion($id){
       $id = (int) $id;
       $this->_db->query("delete from valuaciones where id = $id");
                
    }

    public function imagenValuacion($id_valuacion, $id_vivienda, $nombre){
        $this->_db->prepare("insert into imagenValuacion values (null, :id_valuacion, :id_vivienda, :nombre)")
                ->execute(
                        array(
                            'id_valuacion' => $id_valuacion,
                            'id_vivienda' => $id_vivienda,
                            'nombre' => $nombre
                        ));        
    }
}

?>
