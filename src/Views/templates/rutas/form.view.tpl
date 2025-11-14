<section class="container">
    <section class="depth-2">
        <h2>{{mode}} {{modeDsc}}</h2>
    </section>

    {{if hasErrores}}
        <ul class="error">
        {{foreach errores}}
            <li>{{this}}</li>
        {{endfor errores}}
        </ul>
    {{endif hasErrores}}

    <form action="index.php?page=Rutas-RutasForm&mode={{mode}}&id_ruta={{id_ruta}}" method="post">
        <div>
            <label for="id">ID de Ruta: </label>
            <input type="number" name="id" id="id" value="{{id_ruta}}" {{idReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="origen">Origen: </label>
            <input type="text" name="origen" id="origen" value="{{origen}}" {{readonly}}/>
        </div>

        <div>
            <label for="destino">Destino: </label>
            <input type="text" name="destino" id="destino" value="{{destino}}" {{readonly}}/>
        </div>

        <div>
            <label for="distancia">Distancia en KM: </label>
            <input type="number" name="distancia" id="distancia" value="{{distancia_km}}" {{readonly}}/>
        </div>

        <div>
            <label for="duracion">Duración: </label>
            <input type="number" name="duracion" id="duracion" value="{{duracion_min}}" {{readonly}}/>
        </div>


        <div>
            <button id="btnCancelar">Cancelar</button>
            {{ifnot isDisplay}}
                <button id="btnConfirmar" type="submit">Confirmar</button>
            {{endifnot isDisplay}}
        </div>

    </form>
</section>


<script>
    document.addEventListener("DOMContentLoaded", ()=>{
        document.getElementById("btnCancelar").addEventListener("click", (e)=>{
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Rutas-RutasList");
        })
    });
</script>