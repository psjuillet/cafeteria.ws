<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cafetería | Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/palette.css">
</head>

<body>
    <nav>
        <div class="nav-wrapper deep-purple darken-4">
            <ul id="nav-mobile" class="hide-on-med-and-down">
                <li>
                    <a href="javascript: toAjax(0);">Productos</a>
                </li>
                <li>
                    <a href="javascript: toAjax(1);">Pedidos</a>
                </li>
                <li>
                    <a href="javascript: toAjax(2);">Ingresar productos</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="progress" style="margin: 0 0 0 0">
        <div class="indeterminate blue accent-2"></div>
    </div>
    <div class="container">
    </div>
    <script src="../js/jquery.js"></script>
    <script src="../js/materialize.min.js"></script>
    <script>
        toAjax(0);

        function toAjax(index) {
            var pagina = "../ajax/";
            $(".progress").show();

            switch (index) {
                case 0:
                    pagina += "productos.php";
                    break;
                case 1:
                    pagina += "pedidos.php";
                    break;
                case 2:
                    pagina += "ingresar_producto.php";
                    break;
            }

            $.ajax({
                url: pagina,
                method: "POST",
                data: {
                    admin: true
                }
            }).done((resp) => {
                $(".container").html(resp);
                $(".progress").hide();
            });
        }

        function perdirProducto(index){
            $.ajax({
                url: "../ajax/pedir.query.php"
            }).done((resp)=>{
                
            });
        }
    </script>
</body>

</html>