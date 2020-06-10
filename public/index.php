<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cafetería</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <nav>
    <div class="nav-wrapper deep-purple darken-4">
        <ul id="nav-mobile" class="hide-on-med-and-down">
            <li><a href="javascript: toAjax(0);">Productos</a></li>
            <li><a href="javascript: toAjax(1);">Mis pedidos</a></li>
        </ul>
        <?php
            session_start();
            if(isset($_SESSION["user"])){
                echo '<ul class="hide-on-med-and-down right">
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">'.$_SESSION["user"].'</a></li>
                    </ul>
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="logout.php">Cerrar sesion</a></li>
                    </ul>';
            }else{
                echo '<ul class="hide-on-med-and-down right">
                        <li><a href="#modalLogin" class="modal-trigger">Iniciar sesion</a></li>
                    </ul>';
            }
            
        ?>
    </div>
  </nav>
    <div class="container" id="content">
    </div>
    <form id="modalLogin" class="modal" onsubmit="logIn();return false;" style="width: 400px">
        <div class="modal-content">
            <h4>Iniciar sesion</h4>
            <div class="input-field">
                <input type="text" name="boleta" id="boleta" required>
                <label for="boleta">Numero de boleta</label>
            </div>
            <div class="input-field">
                <input type="password" name="pass" id="pass" required>
                <label for="pass">Contraseña</label>
            </div>
        </div>
        <div class="modal-footer">
        <a href="javascript: M.Modal.getInstance($('#modalLogin')).close(); M.Modal.getInstance($('#modalSignin')).open();" class="modal-trigger waves-effect waves-green btn-flat">Registrarse</a>
            <button type="submit" class="waves-effect waves-green btn-flat">Enviar</button>
        </div>
    </form>
    <form id="modalSignin" class="modal" onsubmit="signIn();return false;" style="width: 400px">
        <div class="modal-content">
            <div>
                <h4>Registrar</h4>
                <div class="input-field">
                    <input type="text" name="boleta" id="boletaS" required>
                    <label for="boletaS">Numero de boleta</label>
                </div>
                <div class="input-field">
                    <input type="text" name="name" id="nameS" required>
                    <label for="boleta">Nombre</label>
                </div>
                <div class="input-field">
                    <input type="text" name="lastP" id="lastPS" required>
                    <label for="boleta">Apellido Paterno</label>
                </div>
                <div class="input-field">
                    <input type="text" name="lastM" id="lastMS" required>
                    <label for="boleta">Apellido Materno</label>
                </div>
                <div class="input-field">
                    <input type="password" name="pass" id="passS" required>
                    <label for="pass">Contraseña</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript: M.Modal.getInstance($('#modalSignin')).close(); M.Modal.getInstance($('#modalLogin')).open();" class="modal-trigger waves-effect waves-green btn-flat">Iniciar sesion</a>
            <button type="submit" class="waves-effect waves-green btn-flat">Enviar</button>
        </div>
    </form>
    <script src="../js/jquery.js"></script>
    <script src="../js/materialize.min.js"></script>
    <script>
        toAjax(0);

        function toAjax(index){
            var pagina = "../ajax/";

            switch (index) {
                case 0:
                    pagina+="productos.php";
                    break;
                case 1:
                    pagina+="pedidos.php";
                    break;
            }
            
            $.ajax({
                url: pagina
            }).done((resp) => {
                $("#content").html(resp);
            });
        }
        $(document).ready(function(){
            $('.modal').modal();
            $('.dropdown-trigger').dropdown({constrainWidth: false, coverTrigger: false});
        });

        function logIn(){
            $.ajax({
                url: "../ajax/login.php",
                method: "POST",
                data: {
                    usr: $("#boleta").val(),
                    pass: $("#pass").val()
                }
            }).done((resp)=>{
                if(resp == ""){
                    location.reload();
                }else{
                    M.toast({html: resp, classes: 'rounded'});
                }
            });
        }

        function signIn(){
            $.ajax({
                url: "../ajax/signIn.php",
                method: "POST",
                data: {
                    usr: $("#boletaS").val(),
                    pass: $("#passS").val(),
                    name: $("#nameS").val(),
                    last1: $("#lastPS").val(),
                    last2: $("#lastMS").val()
                }
            }).done((resp)=>{
                if(resp == ""){
                    M.Modal.getInstance($('#modalSignin')).close();
                    M.toast({html: "Registrado con exito.", classes: 'rounded'});
                }else{
                    M.toast({html: resp, classes: 'rounded'});
                }
            });
        }
            
    </script>
</body>
</html>