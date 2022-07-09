<?php

class registroModel extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function verificarUsuario($email){
        
        $id = $this->_db->query(
                "select id, codigo from usuarios where email = '$email'"
                );
        return $id->fetch();
    }
    
    public function verificarEmail($email){
        
        $id = $this->_db->query(
                "select id from usuarios where email = '$email'"
                );
        if($id->fetch()){
            return true;
        }
        return false;
    }
    
    public function registrarUsuario($cedula, $nombre, $apellido, $nivel, $cargo, $id_parroquia, $municipio, $direccion, $telefono, $email, $role){
        
        $random = rand(123456789, 99999999999);
        $clave = "uatic" . $cedula;
        $pass = Hash::getHash('sha1', $clave, HASH_KEY);
        
        $this->_db->prepare(
                "insert into usuarios values (null, :cedula, :nombre, :apellido, :nivel, :cargo, :id_parroquia, :id_municipio, :direccion, :telefono, :pass, :email, :role, :estado, now(), :codigo, :foto)"
                )
                ->execute(array(
                    'cedula' => $cedula,
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'nivel' => $nivel,
                    'cargo' => $cargo,
                    'id_parroquia' => $id_parroquia,
                    'id_municipio' => $municipio,
                    'direccion' => $direccion,
                    'telefono' => $telefono,
                    'pass' => $pass,
                    'email' => $email,
                    'role' => $role,
                    'estado' => 0,
                    'foto' => '',
                    'codigo' => $random
                ));
    }
    
    public function getUsuario($id, $codigo){
        $usuario = $this->_db->query(
                "select * from usuarios where id = $id and codigo = '$codigo'"
                );
        return $usuario->fetch();
    }

    public function unUsuario($id){
        $usuario = $this->_db->query(
                "select * from estados join municipios using(id_estado) join parroquias using(id_municipio) join usuarios using(id_parroquia) where id = $id"
                );
                return $usuario->fetch();
    }

    public function laboral($id){
        $laboral = $this->_db->query(
                "select * from estados join municipios using(id_estado) join usuarios using (id_municipio) where id = $id"
                );
                return $laboral->fetch();
    }
    
    public function activarUsuario($id, $codigo){
        $usuario = $this->_db->query(
                "update usuarios set estado = 1 " .
                "where id = $id and codigo = '$codigo'"
                );
                return $usuario->fetch();
    }

    public function listar(){
        
        $usuarios = $this->_db->query("select * from usuarios");
        return $usuarios->fetchall();
    }

    public function editarUsuario($id, $cedula, $nombre, $apellido, $nivel, $cargo, $direccion, $telefono){
        $id = (int) $id;
        $this->_db->prepare("UPDATE usuarios SET cedula = :cedula, nombre = :nombre, apellido = :apellido , nivel = :nivel, cargo = :cargo, direccion = :direccion, telefono = :telefono where id = :id")
                ->execute(
                        array(
                            'id' => $id,
                            'cedula' => $cedula,
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'nivel' => $nivel,
                            'cargo' => $cargo,
                            'direccion' => $direccion,
                            'telefono' => $telefono
                        ));
        
    }

    public function eliminar($id){
       
       $this->_db->query("delete from usuarios where id = $id");
                
    }

    public function guardarfoto($cedula, $nombre){
        $this->_db->query(
                "update usuarios set foto = '$nombre'  " .
                "where cedula = '$cedula'"
                );
    }

    public function verificar($id, $vieja){
        $actual = Hash::getHash('sha1', $vieja, HASH_KEY);
        $usuario = $this->_db->query(
                "select * from usuarios where id = '$id' and pass = '$actual'"
                );
        return $usuario->fetch();
    }

    public function password($id, $nueva){
        $nuevo = Hash::getHash('sha1', $nueva, HASH_KEY);
        $this->_db->query(
                "update usuarios set pass = '$nuevo' where id = '$id'"
                );
    }

    public function residencia($id, $id_parroquia){
        
        $this->_db->query(
                "update usuarios set id_parroquia = '$id_parroquia' where id = '$id'"
                );
    }

}
?>
