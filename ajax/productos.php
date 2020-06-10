<div class="card">
    <div class="card-content row">
        <span class="card-title">Productos</span>
        <?php 
        include "../conn.php";
        $prod = $con -> query("SELECT * FROM productos WHERE cantidad > 0");

        while($card = $prod -> fetch_row()){
            echo "<div class='col s12 m3' style='padding: 8px'>
                    <div class='card hoverable'>
                            <div class='card-image waves-effect waves-block waves-light' style='height: 200px;'>
                            <img class='activator' src='../assets/{$card[0]}.jpeg'>
                        </div>
                        <div class='card-content'>
                            <span class='card-title activator grey-text text-darken-4 truncate'>{$card[1]}</span>
                        </div>
                        <div class='card-reveal'>
                            <span class='card-title grey-text text-darken-4'>{$card[1]}<i class='material-icons right'>close</i></span>
                            <h5>\${$card[4]}</h5>
                            ".((!isset($_POST["admin"])&&isset($_SESSION["user"]))?"<button class='btn waves-effect blue accent-2 col s12' style='margin-top:20px' onclick='pedirProducto({$card[0]})'>Encargar</button>":((!isset($_POST["admin"])?"":"<button class='btn waves-effect blue accent-2 col s12' style='margin-top:20px' onclick='updateProducto({$card[0]})'>Actualizar</button><button class='btn waves-effect red accent-2 col s12' style='margin-top:20px' onclick='borrarProducto({$card[0]}, this)'>Borrar</button>")))."
                        </div>
                    </div>
                    </div>";
        }
    ?>
    </div>
</div>
<form id="modalPedir" class="modal" onsubmit="M.Modal.getInstance($('#modalPedir')).close();pedir();return false;">
    <div class="modal-content">
        <h5>Pedido</h5>
        <label>
            <input type="checkbox" id="encargoCB" />
            <span>Llevar a mi salon</span>
        </label>
        <blockquote id="encargo">
            <div class="input-field">
                <input type="text" name="" id="edificio" required>
                <label for="edificio">Edificio</label>
            </div>
            <div class="input-field">
                <input type="text" name="" id="salon" required>
                <label for="salon">Salon</label>
            </div>
            <div class="input-field">
                <input type="text" class="timepicker" id="hora">
                <label for="hora">Hora de entrega</label>
            </div>
        </blockquote>
    </div>
    <div class="modal-footer">
        <button type="submit" class="waves-effect waves-green btn-flat">Encargar</button>
    </div>
</form>
<form id="modalUpdate" class="modal" onsubmit="M.Modal.getInstance($('#modalUpdate')).close();actualizarProducto();return false;">
    <div class="modal-content">
        <span class="card-title">Actualizar producto</span>
        <div class="input-field">
            <input type="text" name="name" id="name" required>
            <label for="name">Nombre*</label>
        </div>
        <div class="input-field">
            <input type="number" name="cant" id="cant" min="0" required>
            <label for="cant">Cantidad*</label>
        </div>
        <div class="input-field">
            <input type="text" name="marca" id="marca">
            <label for="marca">Marca</label>
        </div>
        <div class="input-field">
            <input type="number" step="0.5" name="precio" id="precio" min="0" required>
            <label for="precio">Precio*</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="waves-effect waves-green btn-flat">Actualizar</button>
    </div>
</form>
<script>
    var index;

    function pedirProducto(ind) {
        M.Modal.getInstance($('#modalPedir')).open();
        index = ind;
    }
    
    function updateProducto(ind){
        index = ind;
        M.Modal.getInstance($('#modalUpdate')).open();
    }


    if (!$("#encargoCB")[0].checked) {
        for (var i = 0; i < $($("#encargo").find("input")).length; ++i)
            $($("#encargo").find("input")[i]).attr("disabled", "");
    } else {
        for (var i = 0; i < $($("#encargo").find("input")).length; ++i)
            $($("#encargo").find("input")[i]).removeAttr("disabled");
    }

    $("#encargoCB").change((e) => {
        if (!$("#encargoCB")[0].checked) {
            for (var i = 0; i < $($("#encargo").find("input")).length; ++i)
                $($("#encargo").find("input")[i]).attr("disabled", "");
        } else {
            for (var i = 0; i < $($("#encargo").find("input")).length; ++i)
                $($("#encargo").find("input")[i]).removeAttr("disabled");
        }
    });

    function pedir() {
        $.ajax({
            url: "../ajax/encargar.php",
            method: "POST",
            data: {
                id: index,
                edificio: $('#edificio').val(),
                salon: $('#salon').val(),
                hora: $('#hora').val(),
            }
        }).done((resp) => {
            M.toast({
                html: resp,
                classes: 'rounded'
            });
        });
    }

    function borrarProducto(ind, el){
        $.ajax({
            url: "../ajax/borrarProducto.php",
            method: "POST",
            data: {
                id: ind
            }
        }).done((resp) => {
            if(resp == ""){
                $($($(el).parent()).parent()).fadeOut().done(()=>{$($($(el).parent()).parent()).remove()});
                toAjax(0);
            }else{
                M.toast({
                    html: resp,
                    classes: 'rounded'
                });
            }
        });
    }
    
    function actualizarProducto(){
        $.ajax({
            url: "../ajax/actualizarProducto.php",
            method: "POST",
            data: {
                id: index,
                marca:$('#marca').val(),
                cant:$('#cant').val(),
                name:$('#name').val(),
                precio: $('#precio').val()
            }
        }).done((resp) => {
            if(resp == ""){
                toAjax(0);
            }else{
                M.toast({
                    html: resp,
                    classes: 'rounded'
                });
            }
        });
    }

    $(document).ready(function () {
        $('.modal').modal();
        $('.timepicker').timepicker();
    });
</script>