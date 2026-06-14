<?php
    require '../../model/model_tramite.php';
    $MT = new Modelo_Tramite();
    $dni = strtoupper(htmlspecialchars($_POST['dni'], ENT_QUOTES, 'UTF-8'));
    $resultado = $MT->Buscar_Remitente_Por_Dni($dni);
    echo json_encode($resultado ? $resultado : []);
?>
