<?php
    include "../conn.php";

    $login = $con->query("SELECT * FROM `cliente` WHERE id_boleta = '".$_POST["usr"]."' AND pass = '".sha1($_POST["pass"])."'");

    if($login->num_rows > 0){
        $_SESSION["user"] = ($login->fetch_row())[0];
    }else{
        echo "El usuario no existe, por favor verificar o registrarse";
    }
 <script src="https://www.google.com/recaptcha/api.js"></script>
      <script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
     <button class="g-recaptcha" 
        data-sitekey="reCAPTCHA_site_key" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>
 
?>