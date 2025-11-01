<section class="container">
    <section class="depth-2">
        <h2>{{mode}} {{modeDsc}}</h2>
    </section>
    {{if hasErrores}}<!-- ponemos los errores -->
        <ul class="error">
        {{foreach errores}}
            <li>{{this}}</li>
        {{endfor errores}}
        </ul>
    {{endif hasErrores}}
    <form action="index.php?page=Mantenimientos-ClienteForm&mode={{mode}}&codigo={{codigo}}" method="post"><!-- hacemos postback -->
        <div>
            <label for="codigo">Código: </label>
            <input type="text" name="codigo" id="codigo" value="{{codigo}}"/>
        </div>

        <div>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="{{nombre}}"/>
        </div>

        <div>
            <label for="direccion">Dirección: </label>
            <input type="text" name="direccion" id="direccion" value="{{direccion}}"/>
        </div>

        <div>
            <label for="telefono">Telefono: </label>
            <input type="text" name="telefono" id="telefono" value="{{telefono}}"/>
        </div>

        <div>
            <label for="correo">Correo: </label>
            <input type="email" name="correo" id="correo" value="{{correo}}"/>
        </div>

        <div>
            <label for="estado">Estado: </label>
            <input type="text" name="estado" id="estado" value="{{estado}}"/>
        </div>

        <div>
            <label for="evaluacion">Evaluación: </label>
            <input type="text" name="evaluacion" id="evaluacion" value="{{evaluacion}}"/>
        </div>

        <div>
            <button id="btnCancelar">Cancelar</button>
            <button id="btnConfirmar" type="submit">Confirmar</button>
        </div>

    </form>
</section>
<!-- Se puede usar JS en este handlebars -->
<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancelar").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mantenimientos-ClientesL");
        })
    });
</script>