<?php
    require '../../model/model_tramite.php';
    $MU = new Modelo_Tramite();
    $id = strtoupper(htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8'));
    $consulta = $MU->Eliminar_Tramite($id);
    echo $consulta;
?>
