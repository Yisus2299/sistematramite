<?php
    require '../../model/model_tramite.php';
    $MT = new Modelo_Tramite();
    $numero = strtoupper(htmlspecialchars($_POST['numero'], ENT_QUOTES, 'UTF-8'));
    $excluir = isset($_POST['excluir']) ? strtoupper(htmlspecialchars($_POST['excluir'], ENT_QUOTES, 'UTF-8')) : '';
    $resultado = $MT->Verificar_Numero_Documento($numero, $excluir);
    echo json_encode($resultado ? $resultado : []);
?>
