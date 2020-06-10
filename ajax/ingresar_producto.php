<form action="" class="card" onsubmit="sendData();return false;">
    <div class="card-content">
        <span class="card-title">Ingresar producto</span>
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
        <div class="input-field col s12">
            <input type="text" id="autocomplete-input" name="tipo" class="autocomplete">
            <label for="autocomplete-input">Tipo de producto</label>
        </div>
        <button type="submit" class="btn waves-effect blue accent-2">Enviar</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('input.autocomplete').autocomplete({
            data: {
                <?php 
                    include "../conn.php";
                    $resp = $con -> query("SELECT nombre FROM tipo");
                    while($tipo = $resp -> fetch_row()){
                        echo "'".$tipo[0]."': null,\n";
                    }
                ?>
            },
        });
    });

    function sendData(){
        $(".progress").show();
        $.ajax({
            url: "../ajax/ingresar.form.php",
            method: "POST",
            data: {
                name: $("#name").val(),
                cant: $("#cant").val(),
                marca: $("#marca").val(),
                precio: $("#precio").val(),
                tipo: $("#autocomplete-input").val()
            }
        }).done((resp)=>{
            $(".progress").hide();
            M.toast({html: resp, classes: 'rounded'});
        });
    }
</script>