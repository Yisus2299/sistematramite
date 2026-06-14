<?php
    session_start();
    if(!isset($_SESSION['S_ID'])){
        echo 0;
        exit;
    }
    require '../../model/model_empleado.php';
    $ME = new Modelo_Empleado();
    $id = (int)htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

    if(!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK){
        echo 0;
        exit;
    }

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    if(!in_array($ext, ['jpg','jpeg','png','webp'])){
        echo 2;
        exit;
    }

    $baseDir = dirname(__DIR__, 2) . '/uploads/empleados/';
    if(!is_dir($baseDir)){
        mkdir($baseDir, 0777, true);
    }

    $nombre = 'emp_' . $id . '_' . time() . '.' . $ext;
    if(move_uploaded_file($_FILES['foto']['tmp_name'], $baseDir . $nombre)){
        $ruta = 'uploads/empleados/' . $nombre;
        $ok = $ME->Actualizar_Foto_Empleado($id, $ruta);
        echo json_encode(['status' => $ok, 'ruta' => $ruta]);
    }else{
        echo json_encode(['status' => 0]);
    }
?>
