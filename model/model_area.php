<?php
    require_once  'model_conexion.php';

    class Modelo_Area extends conexionBD{
    

        public function Listar_Area(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_AREA()";
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

        public function Registrar_Area($area){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_AREA(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$area);
            $query->execute();
            if($row = $query->fetchColumn()){
                    return $row;
            }
            conexionBD::cerrar_conexion();
        }

        public function Modificar_Area($id,$area,$esta){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_AREA(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$area);
            $query -> bindParam(3,$esta);
            $query->execute();
            if($row = $query->fetchColumn()){
                    return $row;
            }
            conexionBD::cerrar_conexion();
        }

        public function Eliminar_Area($id){
            if((int)$id === 1){
                return 4;
            }
            $c = conexionBD::conexionPDO();
            $sql = "SELECT COUNT(*) FROM documento WHERE area_origen = ? OR area_destino = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->bindParam(2, $id);
            $query->execute();
            if($query->fetchColumn() > 0){
                return 3;
            }
            try {
                $c->beginTransaction();
                $mesa = 1;
                $stmt = $c->prepare("UPDATE usuario SET area_id = ? WHERE area_id = ?");
                $stmt->execute([$mesa, $id]);
                $stmt = $c->prepare("UPDATE documento SET area_id = ? WHERE area_id = ?");
                $stmt->execute([$mesa, $id]);
                $stmt = $c->prepare("UPDATE movimiento SET area_origen_id = NULL WHERE area_origen_id = ?");
                $stmt->execute([$id]);
                $stmt = $c->prepare("UPDATE movimiento SET areadestino_id = ? WHERE areadestino_id = ?");
                $stmt->execute([$mesa, $id]);
                $stmt = $c->prepare("DELETE FROM area WHERE area_cod = ?");
                $stmt->execute([$id]);
                if($stmt->rowCount() > 0){
                    $c->commit();
                    return 1;
                }
                $c->rollBack();
                return 0;
            } catch (Exception $e) {
                if($c->inTransaction()){
                    $c->rollBack();
                }
                return 0;
            }
            conexionBD::cerrar_conexion();
        }


    }

?>