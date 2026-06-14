<?php
    require '../../model/model_usuario.php';
    $MU = new Modelo_Usuario();
    $usu   = strtoupper(htmlspecialchars($_POST['usu'], ENT_QUOTES, 'UTF-8'));
    $con   = password_hash(htmlspecialchars($_POST['con'], ENT_QUOTES, 'UTF-8'), PASSWORD_DEFAULT, ['cost'=>12]);
    $nom   = strtoupper(htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'));
    $apepa = strtoupper(htmlspecialchars($_POST['apepa'], ENT_QUOTES, 'UTF-8'));
    $apema = strtoupper(htmlspecialchars($_POST['apema'], ENT_QUOTES, 'UTF-8'));
    $nro   = strtoupper(htmlspecialchars($_POST['nro'], ENT_QUOTES, 'UTF-8'));
    $movil = strtoupper(htmlspecialchars($_POST['movil'], ENT_QUOTES, 'UTF-8'));
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $dire  = strtoupper(htmlspecialchars($_POST['dire'], ENT_QUOTES, 'UTF-8'));
    echo $MU->Registrar_Usuario_Publico($usu, $con, $nom, $apepa, $apema, $nro, $movil, $email, $dire);
?>
