<?php
    require_once  'model_conexion.php';

    class Modelo_Usuario extends conexionBD{
        
        public function Verificar_Usuario($usu,$con){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_VERIFICAR_USUARIO(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$usu);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                if(password_verify($con,$resp['usu_contra'])){
                    $arreglo[]=$resp;                 
                }
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Registrar_Usuario($usu,$con,$ide,$ida,$rol){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_USUARIO(?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$usu);
            $query -> bindParam(2,$con);
            $query -> bindParam(3,$ide);
            $query -> bindParam(4,$ida);
            $query -> bindParam(5,$rol);
            $query->execute();
            if($row = $query->fetchColumn()){
                    return $row;
            }
            conexionBD::cerrar_conexion();
        }

        public function Modificar_Usuario($id,$ide,$ida,$rol){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_USUARIO(?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$ide);
            $query -> bindParam(3,$ida);
            $query -> bindParam(4,$rol);
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }    
        
        public function Modificar_Usuario_Contra($id,$con){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_USUARIO_CONTRA(?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$con);
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }    
        
        public function Modificar_Usuario_Estatus($id,$estatus){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_USUARIO_ESTATUS(?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query -> bindParam(2,$estatus);
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }

        public function Eliminar_Usuario($id){
            $c = conexionBD::conexionPDO();
            try {
                $c->beginTransaction();
                $stmt = $c->prepare("UPDATE movimiento SET usuario_id = NULL WHERE usuario_id = ?");
                $stmt->execute([$id]);
                $stmt = $c->prepare("DELETE FROM usuario WHERE usu_id = ?");
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

        public function Obtener_Foto_Usuario($id){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT e.empl_fotoperfil
                    FROM usuario u
                    LEFT JOIN empleado e ON u.empleado_id = e.empleado_id
                    WHERE u.usu_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $foto = $query->fetchColumn();
            return $foto ? $foto : '';
            conexionBD::cerrar_conexion();
        }

        public function Registrar_Usuario_Publico($usu, $con, $nom, $apepa, $apema, $nro, $movil, $email, $dire){
            $c = conexionBD::conexionPDO();
            try {
                $c->beginTransaction();
                $sql = "SELECT COUNT(*) FROM usuario WHERE usu_usuario = ?";
                $q = $c->prepare($sql);
                $q->execute([$usu]);
                if($q->fetchColumn() > 0){
                    $c->rollBack();
                    return 2;
                }
                $sql = "SELECT COUNT(*) FROM empleado WHERE emple_nrodocumento = ?";
                $q = $c->prepare($sql);
                $q->execute([$nro]);
                if($q->fetchColumn() > 0){
                    $c->rollBack();
                    return 3;
                }
                $sql = "INSERT INTO empleado (emple_nombre, emple_apepat, emple_apemat, emple_feccreacion, emple_fechanacimiento, emple_nrodocumento, emple_movil, emple_email, emple_estatus, emple_direccion)
                        VALUES (?, ?, ?, CURDATE(), CURDATE(), ?, ?, ?, 'ACTIVO', ?)";
                $q = $c->prepare($sql);
                $q->execute([$nom, $apepa, $apema, $nro, $movil, $email, $dire]);
                $idEmpleado = $c->lastInsertId();
                $sql = "INSERT INTO usuario (usu_usuario, usu_contra, empleado_id, area_id, usu_rol, usu_feccreacion, usu_estatus, empresa_id)
                        VALUES (?, ?, ?, 1, 'Secretario (a)', CURDATE(), 'INACTIVO', 1)";
                $q = $c->prepare($sql);
                $q->execute([$usu, $con, $idEmpleado]);
                $c->commit();
                return 1;
            } catch (Exception $e) {
                if($c->inTransaction()) $c->rollBack();
                return 0;
            }
            conexionBD::cerrar_conexion();
        }

        public function Traer_Dashboard(){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT
                (SELECT COUNT(*) FROM documento) AS total,
                (SELECT COUNT(*) FROM documento WHERE doc_estatus='FINALIZADO') AS finalizados,
                (SELECT COUNT(*) FROM documento WHERE doc_estatus='PENDIENTE') AS pendientes,
                (SELECT COUNT(*) FROM documento WHERE doc_estatus='RECHAZADO') AS rechazados,
                (SELECT COUNT(*) FROM usuario WHERE usu_estatus='ACTIVO') AS usuarios,
                (SELECT COUNT(*) FROM area WHERE area_estado='ACTIVO') AS areas,
                (SELECT COUNT(*) FROM documento WHERE MONTH(doc_fecharegistro)=MONTH(CURRENT_DATE()) AND YEAR(doc_fecharegistro)=YEAR(CURRENT_DATE())) AS mes_actual";
            $query = $c->prepare($sql);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
            conexionBD::cerrar_conexion();
        }  

        public function Listar_Usuario(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_USUARIO()";
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

        public function Cargara_Select_Empleado(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SELECT_EMPLEADO()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Traer_Widget(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_TRAER_WIDGET()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Cargara_Select_Area(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SELECT_AREA()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        ///SELECT SEGUIMIENTO///
        public function Cargar_Select_Datos_Seguimiento($numero,$dni){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SEGUIMIENTO_TRAMITE(?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$numero);
            $query -> bindParam(2,$dni);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Traer_Datos_Detalle_Seguimiento($codigo){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SEGUIMIENTO_TRAMITE_DETALLE(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$codigo);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

    }

?>