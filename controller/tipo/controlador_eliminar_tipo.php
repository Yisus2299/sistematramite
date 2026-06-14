<?php
    require '../../model/model_tipo.php';
    $MU = new Modelo_Tipo();
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $consulta = $MU->Eliminar_Tipo($id);
    echo $consulta;
?>
