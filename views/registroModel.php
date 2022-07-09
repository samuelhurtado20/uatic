<?php

class registroModel extends Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function verificarUsuario($usuario){
        
        $id = $this->_db->query(
                "select id, codigo from usuarios where usuario = '$usuario'"
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
    
    public function registrarUsuario($cedula, $nombre, $apellido, $nivel, $cargo, $municipio, $direccion, $telefono, $usuario, $pass, $email, $role){
        
        $random = rand(123456789, 99999999999);
        
        $this->_db->prepare(
                "insert into usuarios values" .
                "(null, :cedula, :nombre, :apellido, :nivel, :cargo, :municipio, :direccion, :telefono, :usuario, :pass, :email, :role, 0, now(), :codigo)"
                )
                ->execute(array(
                    ':cedula' => $cedula,
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':nivel' => $nivel,
                    ':cargo' => $cargo,
                    ':municipio' => $municipio,
                    ':direccion' => $direccion,
                    ':telefono' => $telefono,
                    ':usuario' => $usuario,
                    ':pass' => Hash::getHash('sha1', $pass, HASH_KEY),
                    ':email' => $email,
                    ':role' => $role,
                    'codigo' => $random
                ));
    }
    
    public function getUsuario($id, $codigo){
        $usuario = $this->_db->query(
                "select * from usuarios where id = $id and codigo = '$codigo'"
                );
                return $usuario->fetch();
    }
    
    public function activarUsuario($id, $codigo){
        $usuario = $this->_db->query(
                "update usuarios set estado = 1 " .
                "where id = $id and codigo = '$codigo'"
                );
                return $usuario->fetch();
    }
}
?>
