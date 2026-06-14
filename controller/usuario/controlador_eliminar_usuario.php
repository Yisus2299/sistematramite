<?php
    session_start();
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario();
    $id = (int)htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    if(isset($_SESSION['S_ID']) && (int)$_SESSION['S_ID'] === $id){
        echo 5;
        exit;
    }
    $consulta = $MU->Eliminar_Usuario($id);
    echo $consulta;
?>
