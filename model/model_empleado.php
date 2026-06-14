<?php
    require_once  'model_conexion.php';

    class Modelo_Empleado extends conexionBD{
    

        public function Listar_Empleado(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EMPLEADO()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Registrar_Empleado($nro,$nom,$apepa,$apema,$fnac,$movil,$dire,$email){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_EMPLEADO(?,?,?,?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$nro);
            $query -> bindParam(2,$nom);
            $query -> bindParam(3,$apepa);
            $query -> bindParam(4,$apema);
            $query -> bindParam(5,$fnac);
            $query -> bindParam(6,$movil);
            $query -> bindParam(7,$dire);
            $query -> bindParam(8,$email);
            $query->execute();
            if($row = $query->fetchColumn()){
                    return $row;
            }
            conexionBD::cerrar_conexion();
        }

        public function Modificar_Empleado($id,$nro,$nom,$apepa,$apema,$fnac,$movil,$dire,$email,$esta){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_EMPLEADO(?,?,?,?,?,?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$nro);
            $query -> bindParam(3,$nom);
            $query -> bindParam(4,$apepa);
            $query -> bindParam(5,$apema);
            $query -> bindParam(6,$fnac);
            $query -> bindParam(7,$movil);
            $query -> bindParam(8,$dire);
            $query -> bindParam(9,$email);
            $query -> bindParam(10,$esta);
            $query->execute();
            if($row = $query->fetchColumn()){
                    return $row;
            }
            conexionBD::cerrar_conexion();
        }

        public function Eliminar_Empleado($id){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT COUNT(*) FROM usuario WHERE empleado_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            if($query->fetchColumn() > 0){
                return 2;
            }
            $sql = "SELECT empl_fotoperfil FROM empleado WHERE empleado_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $foto = $query->fetchColumn();
            $sql = "DELETE FROM empleado WHERE empleado_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            if($query->execute()){
                if($foto && strpos($foto, 'uploads/empleados/') === 0){
                    $ruta = dirname(__DIR__) . '/' . $foto;
                    if(file_exists($ruta)){
                        @unlink($ruta);
                    }
                }
                return 1;
            }
            return 0;
            conexionBD::cerrar_conexion();
        }

        public function Actualizar_Foto_Empleado($id, $ruta){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT empl_fotoperfil FROM empleado WHERE empleado_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $anterior = $query->fetchColumn();
            $sql = "UPDATE empleado SET empl_fotoperfil = ? WHERE empleado_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $ruta);
            $query->bindParam(2, $id);
            if($query->execute()){
                if($anterior && strpos($anterior, 'uploads/empleados/') === 0){
                    $rutaAnt = dirname(__DIR__) . '/' . $anterior;
                    if(file_exists($rutaAnt)){
                        @unlink($rutaAnt);
                    }
                }
                return 1;
            }
            return 0;
            conexionBD::cerrar_conexion();
        }


    }

?>