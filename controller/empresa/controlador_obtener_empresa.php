<?php
    require '../../model/model_empresa.php';
    $ME = new Modelo_Empresa();
    $consulta = $ME->Obtener_Empresa();
    echo json_encode($consulta ? $consulta : []);
?>
