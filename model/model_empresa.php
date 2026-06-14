<?php
    require_once 'model_conexion.php';

    class Modelo_Empresa extends conexionBD{

        public function Obtener_Empresa(){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT empresa_id, emp_razon, emp_email, emp_telefono, emp_direccion, emp_logo, emp_fondo FROM empresa WHERE empresa_id = 1";
            $query = $c->prepare($sql);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
            conexionBD::cerrar_conexion();
        }

        public function Actualizar_Logo($ruta){
            $c = conexionBD::conexionPDO();
            $anterior = $c->query("SELECT emp_logo FROM empresa WHERE empresa_id = 1")->fetchColumn();
            $sql = "UPDATE empresa SET emp_logo = ? WHERE empresa_id = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $ruta);
            $ok = $query->execute();
            if($ok && $anterior && strpos($anterior, 'uploads/') === 0){
                $path = dirname(__DIR__) . '/' . $anterior;
                if(file_exists($path)) @unlink($path);
            }
            return $ok ? 1 : 0;
            conexionBD::cerrar_conexion();
        }

        public function Actualizar_Fondo($ruta){
            $c = conexionBD::conexionPDO();
            $anterior = $c->query("SELECT emp_fondo FROM empresa WHERE empresa_id = 1")->fetchColumn();
            $sql = "UPDATE empresa SET emp_fondo = ? WHERE empresa_id = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $ruta);
            $ok = $query->execute();
            if($ok && $anterior && strpos($anterior, 'uploads/') === 0){
                $path = dirname(__DIR__) . '/' . $anterior;
                if(file_exists($path)) @unlink($path);
            }
            return $ok ? 1 : 0;
            conexionBD::cerrar_conexion();
        }

        public function Actualizar_Datos($razon, $email, $telefono, $direccion){
            $c = conexionBD::conexionPDO();
            $sql = "UPDATE empresa SET emp_razon=?, emp_email=?, emp_telefono=?, emp_direccion=? WHERE empresa_id = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $razon);
            $query->bindParam(2, $email);
            $query->bindParam(3, $telefono);
            $query->bindParam(4, $direccion);
            return $query->execute() ? 1 : 0;
            conexionBD::cerrar_conexion();
        }
    }
?>
