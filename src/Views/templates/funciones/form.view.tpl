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

    <form action="index.php?page=Funciones-FuncionesForm&mode={{mode}}&fncod={{fncod}}" method="post">
        <div>
            <label for="codigo">Codigo de Función: </label>
            <input type="text" name="codigo" id="codigo" value="{{fncod}}" {{codigoReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="descripcion">Descripción: </label>
            <input type="text" name="descripcion" id="descripcion" value="{{fndsc}}" {{readonly}}/>
        </div>

        <!-- textarea solo para probar, arriba esta el funcional -->
        <!-- <div>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion" {{readonly}}>{{fndsc}}</textarea>        
        </div> -->

        <div>
            <label for="estado">Estado Función: </label>
            {{ifnot readonly}}
                <select name="estado" id="estado">
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="estado" id="estado" value="{{fnest}}" {{readonly}}/>
            {{endif readonly}}
        </div>

        <div>
            <label for="tipo">Tipo Función: </label>
            {{ifnot readonly}}
                <select name="tipo" id="tipo">
                    <option value="ADM" {{selectedADM}}>Administrador</option>
                    <option value="USR" {{selectedUSR}}>Usuario</option>
                    <option value="CLI" {{selectedCLI}}>Cliente</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="tipo" id="tipo" value="{{fntyp}}" {{readonly}}/>
            {{endif readonly}}
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
            window.location.assign("index.php?page=Funciones-FuncionesList");
        })
    });
</script>