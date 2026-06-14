<?php
    require_once  'model_conexion.php';

    class Modelo_Tramite extends conexionBD{


        public function Registrar_Tramite($dni,$nom,$apt,$apm,$cel,$ema,$dir,$vpresentacion,$ruc,$raz,$arp,$ard,$tip,$ndo,$asu,$ruta,$fol,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_TRAMITE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$dni);
            $query -> bindParam(2,$nom);
            $query -> bindParam(3,$apt);
            $query -> bindParam(4,$apm);
            $query -> bindParam(5,$cel);
            $query -> bindParam(6,$ema);
            $query -> bindParam(7,$dir);
            $query -> bindParam(8,$vpresentacion);
            $query -> bindParam(9,$ruc);
            $query -> bindParam(10,$raz);
            $query -> bindParam(11,$arp);
            $query -> bindParam(12,$ard);
            $query -> bindParam(13,$tip);
            $query -> bindParam(14,$ndo);
            $query -> bindParam(15,$asu);
            $query -> bindParam(16,$ruta);
            $query -> bindParam(17,$fol);   
            $query -> bindParam(18,$idusu);            
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
        



        public function Listar_Tramite(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_TRAMITE()";
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

        public function Listar_Tramite_Seguimiento($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_TRAMITE_SEGUIMIENTO(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query -> bindParam(1,$id);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Cargara_Select_Tipo(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SELECT_TIPO()";
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

        public function Buscar_Remitente_Por_Dni($dni){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT doc_dniremitente, doc_nombreremitente, doc_apepatremitente, doc_apematremitente,
                           doc_celularremitente, doc_emailremitente, doc_direccionremitente, doc_representacion, doc_ruc, doc_empresa
                    FROM documento WHERE doc_dniremitente = ? ORDER BY doc_fecharegistro DESC LIMIT 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $dni);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
            conexionBD::cerrar_conexion();
        }

        public function Verificar_Numero_Documento($numero, $excluir = ''){
            $c = conexionBD::conexionPDO();
            if($excluir !== ''){
                $sql = "SELECT documento_id, doc_asunto, doc_estatus FROM documento WHERE doc_nrodocumento = ? AND documento_id != ?";
                $query = $c->prepare($sql);
                $query->bindParam(1, $numero);
                $query->bindParam(2, $excluir);
            } else {
                $sql = "SELECT documento_id, doc_asunto, doc_estatus FROM documento WHERE doc_nrodocumento = ?";
                $query = $c->prepare($sql);
                $query->bindParam(1, $numero);
            }
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
            conexionBD::cerrar_conexion();
        }

        public function Modificar_Tramite($id,$dni,$nom,$apt,$apm,$cel,$ema,$dir,$vpresentacion,$ruc,$raz,$arp,$ard,$tip,$ndo,$asu,$fol,$estatus){
            $c = conexionBD::conexionPDO();
            $dup = $this->Verificar_Numero_Documento($ndo, $id);
            if($dup){
                return 2;
            }
            $sql = "UPDATE documento SET
                doc_dniremitente=?, doc_nombreremitente=?, doc_apepatremitente=?, doc_apematremitente=?,
                doc_celularremitente=?, doc_emailremitente=?, doc_direccionremitente=?, doc_representacion=?,
                doc_ruc=?, doc_empresa=?, tipodocumento_id=?, doc_nrodocumento=?, doc_folio=?, doc_asunto=?,
                area_origen=?, area_destino=?, area_id=?, doc_estatus=?
                WHERE documento_id=?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $dni);
            $query->bindParam(2, $nom);
            $query->bindParam(3, $apt);
            $query->bindParam(4, $apm);
            $query->bindParam(5, $cel);
            $query->bindParam(6, $ema);
            $query->bindParam(7, $dir);
            $query->bindParam(8, $vpresentacion);
            $query->bindParam(9, $ruc);
            $query->bindParam(10, $raz);
            $query->bindParam(11, $tip);
            $query->bindParam(12, $ndo);
            $query->bindParam(13, $fol);
            $query->bindParam(14, $asu);
            $query->bindParam(15, $arp);
            $query->bindParam(16, $ard);
            $query->bindParam(17, $ard);
            $query->bindParam(18, $estatus);
            $query->bindParam(19, $id);
            return $query->execute() ? 1 : 0;
            conexionBD::cerrar_conexion();
        }

        public function Eliminar_Tramite($id){
            $c = conexionBD::conexionPDO();
            $sql = "SELECT doc_archivo FROM documento WHERE documento_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $archivo = $query->fetchColumn();
            if(!$archivo){
                return 0;
            }
            $sql = "SELECT mov_archivo FROM movimiento WHERE documento_id = ? AND mov_archivo IS NOT NULL AND mov_archivo != ''";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $archivosMov = $query->fetchAll(PDO::FETCH_COLUMN);
            $sql = "DELETE FROM documento WHERE documento_id = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            if($query->execute()){
                $base = dirname(__DIR__) . '/';
                if($archivo && file_exists($base . $archivo)){
                    @unlink($base . $archivo);
                }
                foreach($archivosMov as $movArchivo){
                    if($movArchivo && file_exists($base . $movArchivo)){
                        @unlink($base . $movArchivo);
                    }
                }
                return 1;
            }
            return 0;
            conexionBD::cerrar_conexion();
        }


    }

?>