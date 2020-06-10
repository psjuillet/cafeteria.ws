<?php
    include "../conn.php";
    $act = $con -> query("UPDATE `productos` SET `nombre`='{$_POST["name"]}',`cantidad`='{$_POST["cant"]}',`marca`='{$_POST["marca"]}',`precio`='{$_POST["precio"]}' WHERE id_producto = '{$_POST["id"]}'");

    if(!$act){
        echo "Ha ocurrido un error al actualizar.";
    }else{
        echo "Se ha actualizado correctamente.";
    }
?>