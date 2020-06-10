<?php
    $con = new mysqli("localhost", "root", "", "cafeteria");
    session_start();
    if($con->connect_errno){
        throw $con->connect_error;
    }
?>