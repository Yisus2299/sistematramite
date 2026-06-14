<?php
    session_start();
    $idusuario = htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8');   
    $usuario = htmlspecialchars($_POST['usuario'],ENT_QUOTES,'UTF-8');  
    $rol = htmlspecialchars($_POST['rol'],ENT_QUOTES,'UTF-8'); 
    $_SESSION['S_ID']=$idusuario;
    $_SESSION['S_USU']=$usuario;
    $_SESSION['S_ROL']=$rol;
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario();
    $_SESSION['S_FOTO'] = $MU->Obtener_Foto_Usuario($idusuario);
?>