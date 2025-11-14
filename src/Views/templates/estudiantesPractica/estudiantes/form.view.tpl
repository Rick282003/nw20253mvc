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

    <form action="index.php?page=EstudiantesPractica-EstudiantesForm&mode={{mode}}&id={{id}}" method="post">
        <div>
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" value="{{id}}" {{idReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="{{estudiante_nombre}}" {{readonly}}/>
        </div>

        <div>
            <label for="fecha">Fecha de Incidente: </label>
            <input type="date" name="fecha" id="fecha" value="{{fecha_incidente}}" {{readonly}}/>
        </div>

        <div>
            <label for="tipo">Tipo de Incidente: </label>
            <input type="text" name="tipo" id="tipo" value="{{tipo_incidente}}" {{readonly}}/>
        </div>

        <div>
            <label for="descripcion">Descripción: </label>
            <input type="text" name="descripcion" id="descripcion" value="{{descripcion}}" {{readonly}}/>
        </div>

        <div>
            <label for="accion">Acción Tomada: </label>
            {{ifnot readonly}}
                <select name="accion" id="accion">
                    <option value="Revisar" {{selectedRevisar}}>Revisar</option>
                    <option value="Corregir" {{selectedCorregir}}>Corregir</option>
                    <option value="Delegar" {{selectedDelegar}}>Delegar</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="accion" id="accion" value="{{accion_tomada}}" {{readonly}}/>
            {{endif readonly}}
        </div>

        <div>
            <label for="estado">Estado: </label>
            {{ifnot readonly}}
                <!-- <select name="estado" id="estado">
                    <option value="Abierto" {{selectedAbierto}}>Abierto</option>
                    <option value="Cerrado" {{selectedCerrado}}>Cerrado</option>
                </select> -->
                <label><input type="radio" name="estado" value="Abierto" {{checkedAbierto}}/> Abierto</label>
                <label><input type="radio" name="estado" value="Cerrado" {{checkedCerrado}}/> Cerrado</label>
            {{endifnot readonly}}

            {{if readonly}}
                <input type="text" name="estado" id="estado" value="{{estado}}" {{readonly}}/>
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
            window.location.assign("index.php?page=EstudiantesPractica-EstudiantesList");
        })
    });
</script>