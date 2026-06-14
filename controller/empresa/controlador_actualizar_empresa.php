<?php
    session_start();
    if(!isset($_SESSION['S_ID']) || $_SESSION['S_ROL'] !== 'Administrador'){
        echo 0;
        exit;
    }
    require '../../model/model_empresa.php';
    $ME = new Modelo_Empresa();

    $razon = strtoupper(htmlspecialchars($_POST['razon'], ENT_QUOTES, 'UTF-8'));
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $direccion = strtoupper(htmlspecialchars($_POST['direccion'], ENT_QUOTES, 'UTF-8'));

    $baseDir = dirname(__DIR__, 2) . '/uploads/empresa/';
    if(!is_dir($baseDir)){
        mkdir($baseDir, 0777, true);
    }

    $respuesta = $ME->Actualizar_Datos($razon, $email, $telefono, $direccion);
    $logoOk = 0;
    $fondoOk = 0;

    if(isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg','png','webp'])){
            $nombre = 'logo_' . time() . '.' . $ext;
            if(move_uploaded_file($_FILES['logo']['tmp_name'], $baseDir . $nombre)){
                $logoOk = $ME->Actualizar_Logo('uploads/empresa/' . $nombre);
            }
        }
    }

    if(isset($_FILES['fondo']) && $_FILES['fondo']['error'] === UPLOAD_ERR_OK){
        $ext = strtolower(pathinfo($_FILES['fondo']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg','png','webp'])){
            $nombre = 'fondo_' . time() . '.' . $ext;
            if(move_uploaded_file($_FILES['fondo']['tmp_name'], $baseDir . $nombre)){
                $fondoOk = $ME->Actualizar_Fondo('uploads/empresa/' . $nombre);
            }
        }
    }

    echo ($respuesta || $logoOk || $fondoOk) ? 1 : 0;
?>
