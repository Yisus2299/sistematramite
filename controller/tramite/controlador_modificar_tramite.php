<?php
    require '../../model/model_tramite.php';
    $MT = new Modelo_Tramite();
    $id   = strtoupper(htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8'));
    $dni  = strtoupper(htmlspecialchars($_POST['dni'], ENT_QUOTES, 'UTF-8'));
    $nom  = strtoupper(htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'));
    $apt  = strtoupper(htmlspecialchars($_POST['apt'], ENT_QUOTES, 'UTF-8'));
    $apm  = strtoupper(htmlspecialchars($_POST['apm'], ENT_QUOTES, 'UTF-8'));
    $cel  = strtoupper(htmlspecialchars($_POST['cel'], ENT_QUOTES, 'UTF-8'));
    $ema  = htmlspecialchars($_POST['ema'], ENT_QUOTES, 'UTF-8');
    $dir  = strtoupper(htmlspecialchars($_POST['dir'], ENT_QUOTES, 'UTF-8'));
    $vp   = strtoupper(htmlspecialchars($_POST['vpresentacion'], ENT_QUOTES, 'UTF-8'));
    $ruc  = strtoupper(htmlspecialchars($_POST['ruc'], ENT_QUOTES, 'UTF-8'));
    $raz  = strtoupper(htmlspecialchars($_POST['raz'], ENT_QUOTES, 'UTF-8'));
    $arp  = strtoupper(htmlspecialchars($_POST['arp'], ENT_QUOTES, 'UTF-8'));
    $ard  = strtoupper(htmlspecialchars($_POST['ard'], ENT_QUOTES, 'UTF-8'));
    $tip  = strtoupper(htmlspecialchars($_POST['tip'], ENT_QUOTES, 'UTF-8'));
    $ndo  = strtoupper(htmlspecialchars($_POST['ndo'], ENT_QUOTES, 'UTF-8'));
    $asu  = strtoupper(htmlspecialchars($_POST['asu'], ENT_QUOTES, 'UTF-8'));
    $fol  = strtoupper(htmlspecialchars($_POST['fol'], ENT_QUOTES, 'UTF-8'));
    $est  = strtoupper(htmlspecialchars($_POST['estatus'], ENT_QUOTES, 'UTF-8'));
    echo $MT->Modificar_Tramite($id,$dni,$nom,$apt,$apm,$cel,$ema,$dir,$vp,$ruc,$raz,$arp,$ard,$tip,$ndo,$asu,$fol,$est);
?>
