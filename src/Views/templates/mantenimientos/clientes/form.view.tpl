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
            <input type="text" name="codigo" id="codigo" value="{{codigo}}" {{codigoReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/><!-- token hash-->
        </div>

        <div>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="{{nombre}}" {{readonly}}/> <!-- readonly es propio de html en input, segun lo que se mande del controlador podemos resivir un readonly o cadena vacia -->
        </div>

        <div>
            <label for="direccion">Dirección: </label>
            <input type="text" name="direccion" id="direccion" value="{{direccion}}" {{readonly}}/>
        </div>

        <div>
            <label for="telefono">Telefono: </label>
            <input type="text" name="telefono" id="telefono" value="{{telefono}}" {{readonly}}/>
        </div>

        <div>
            <label for="correo">Correo: </label>
            <input type="email" name="correo" id="correo" value="{{correo}}" {{readonly}}/>
        </div>

        <div>
            <label for="estado">Estado: </label>
            {{ifnot readonly}}<!-- Esto para que al no ser readonly aparezca los options -->
                <select name="estado" id="estado">
                    <option value="ACT" {{selectedACT}}>Activo</option><!-- Aqui asignaremos que option tiene selected, radio buttons igual pero con checked -->
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
                <input type="text" name="estado" id="estado" value="{{estado}}" {{readonly}}/>
            {{endif readonly}}
        </div>

        <div>
            <label for="evaluacion">Evaluación: </label>
            <input type="text" name="evaluacion" id="evaluacion" value="{{evaluacion}}" {{readonly}}/>
        </div>

        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}} <!-- si no es display muestre el boton de confirmar, si es DSP no lo muestra-->
                <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
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