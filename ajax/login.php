<?php
    include "../conn.php";


$user= $_POST["usr"];
$pass=$_POST["pass"];
//if(preg_match("^[0-9A-Za-z]+$",$user)&&preg_match("^[0-9A-Za-z]+$",$pass)){
//    $query ="SELECT * FROM `cliente` WHERE id_boleta='".pg_escape_string($user)."' and pass='".sha1(pg_escape_string($pass))"'";
//   
//    $result= $con->query($query);
//    if($result){
//      if($result->num_rows==0){
//          echo "El usuario no existe, por favor verificar o regristarse";
//      }else
//          $_SESSION["user"] = ($result->fetch_row())[0];
//          echo "Pase usted, buena persona";
//    }
//    
//}

    $login = $con->query("SELECT * FROM `cliente` WHERE id_boleta = '".$_POST["usr"]."' AND pass = '".sha1($_POST["pass"])."'");

    if($login->num_rows > 0){
        $_SESSION["user"] = ($login->fetch_row())[0];
    }else{
        echo "El usuario no existe, por favor verificar o registrarse";
    }
?>