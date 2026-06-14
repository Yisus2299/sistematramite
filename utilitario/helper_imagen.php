<?php
    function ruta_imagen($ruta, $contexto = 'view', $tipo = 'avatar'){
        $defectos = [
            'avatar' => ['view' => '../plantilla/dist/img/avatar.png', 'root' => 'plantilla/dist/img/avatar.png'],
            'logo'   => ['view' => '../plantilla/dist/img/logo.jpeg',  'root' => 'plantilla/dist/img/logo.jpeg'],
            'fondo'  => ['view' => '../plantilla/dist/img/fondo.jpg',   'root' => 'plantilla/dist/img/fondo.jpg'],
        ];
        $defecto = $defectos[$tipo][$contexto] ?? $defectos['avatar'][$contexto];
        if(empty($ruta) || trim($ruta) === ''){
            return $defecto;
        }
        if(preg_match('/^https?:\/\//i', $ruta)){
            return $ruta;
        }
        if(strpos($ruta, '../') === 0){
            return $ruta;
        }
        $prefijo = ($contexto === 'view') ? '../' : '';
        return $prefijo . ltrim($ruta, '/');
    }
?>
