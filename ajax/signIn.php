<?php
    include "../conn.php";
    $signin = $con->query("INSERT INTO `cliente`(`id_boleta`, `nombre`, `apellido`, `apellido_mat`, `pass`) 
                VALUES ('{$_POST["usr"]}','{$_POST["name"]}','{$_POST["last1"]}','{$_POST["last2"]}','".sha1($_POST["pass"])."')");

    if(!$signin){
        echo "No se ha podido registrar";
    }
?>