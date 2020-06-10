<?php
    include "../conn.php";
    date_default_timezone_set("America/Mexico_City");
    $cant = $con -> query("SELECT `cantidad` FROM `productos` WHERE id_producto = {$_POST["id"]}");
    $num = $cant->fetch_row()[0] -1;
    
    $con -> query("UPDATE `productos` SET `cantidad`={$num} WHERE id_producto = {$_POST["id"]}");
    
    $con -> query("INSERT INTO `encargo`(`edificio`, `salon`, `hora`, `hora_entrega`) VALUES ('{$_POST["edificio"]}','{$_POST["salon"]}','".date('Y-m-d h:i:s', strtotime("now"))."','".date('Y-m-d h:i:s', strtotime($_POST["hora"]))."')");
    $pedido = $con -> query("INSERT INTO `pedido`(`id_boleta`, `id_encargo`, `id_producto`) VALUES ({$_SESSION["user"]},{$con->insert_id},{$_POST["id"]})");
    
    if(!$pedido){
        echo "Ha ocurrido un error";
    }else{
        echo "Pedido hecho!";
    }
?>