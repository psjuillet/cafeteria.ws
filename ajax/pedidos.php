<div class="card">
    <div class="card-content">
        <table class="stripped">
            <thead>
                <tr>
                    <td>Usuario</td>
                    <td>Producto</td>
                    <td>Edificio</td>
                    <td>Salon</td>
                    <td>Hora de entrega</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    include "../conn.php";
                    $where ="";
                    if(!isset($_POST["admin"])&&isset($_SESSION["user"])){
                        $where = " WHERE c.id_boleta = '".$_SESSION["user"]."'";
                    }
            
                    $peds = $con -> query("SELECT c.nombre, c.apellido, p.nombre, e.edificio, e.salon, e.hora_entrega FROM `pedido`
                                            INNER JOIN cliente AS c ON c.id_boleta = pedido.id_boleta 
                                            INNER JOIN encargo AS e ON e.id_encargo = pedido.id_encargo
                                            INNER JOIN productos as p ON p.id_producto = pedido.id_producto".$where);

                    while($pedido = $peds -> fetch_row()){
                        echo "<tr>
                            <td>{$pedido[0]} {$pedido[1]}</td>
                            <td>{$pedido[2]}</td>
                            <td>{$pedido[3]}</td>
                            <td>{$pedido[4]}</td>
                            <td>";
                            if(date("Y",strtotime($pedido[5])) > date("Y",strtotime("01/01/2000"))){
                                echo $pedido[5];
                            }else{
                                echo "No aplica";
                            }
                        echo "</td>
                        </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>