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

    <form action="index.php?page=PeliculasPractica-PeliculasForm&mode={{mode}}&id={{id}}" method="post">
        <div>
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" value="{{id}}" {{idReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="titulo">Titulo: </label>
            <input type="text" name="titulo" id="titulo" value="{{titulo}}" {{readonly}}/>
        </div>

        <div>
            <label for="director">Director: </label>
            <input type="text" name="director" id="director" value="{{director}}" {{readonly}}/>
        </div>

        <div>
            <label for="genero">Genero: </label>
            <input type="text" name="genero" id="genero" value="{{genero}}" {{readonly}}/>
        </div>

        <div>
            <label for="anio">Año Estreno: </label>
            <input type="number" name="anio" id="anio" value="{{anio_estreno}}" {{readonly}}/>
        </div>

        <div>
            <label for="duracion">Duración Minutos: </label>
            <input type="number" name="duracion" id="duracion" value="{{duracion}}" {{readonly}}/>
        </div>

        <div>
            <label for="sinopsis">Sinopsis: </label>
            <textarea name="sinopsis" id="sinopsis" {{readonly}}>{{sinopsis}}</textarea>        
            </div>
        <div>

        <div>
            <label for="clasificacion">Clasificaciónn: </label>
            <input type="text" name="clasificacion" id="clasificacion" value="{{clasificacion}}" {{readonly}}/>
        </div>

        <div>
            <label for="estado">Estado: </label>
            {{ifnot readonly}}
                <select name="estado" id="estado">
                    <option value="DIS" {{selectedDIS}}>Disponile</option>
                    <option value="AGO" {{selectedAGO}}>Agotado</option>
                </select>
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
            window.location.assign("index.php?page=PeliculasPractica-PeliculasList");
        })
    });
</script>