<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario();
    $consulta = $MU->Traer_Dashboard();
    echo json_encode($consulta ? $consulta : []);
?>
