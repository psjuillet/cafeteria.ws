<?php
    include "../conn.php";

    $borrar = $con -> query("DELETE FROM `pedido` WHERE `id_producto` = ".$_POST["id"]);
    $borrar = $con -> query("DELETE FROM `productos` WHERE `id_producto` = ".$_POST["id"]);

    if(!$borrar){
        echo "No se pudo borrar";
    }
?>