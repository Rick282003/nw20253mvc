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

    <form action="index.php?page=Roles-RolesForm&mode={{mode}}&rolescod={{rolescod}}" method="post">
        <div>
            <label for="codigo">Codigo de Rol: </label>
            <input type="text" name="codigo" id="codigo" value="{{rolescod}}" {{idReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="descripcion">Descripción de Rol: </label>
            <input type="text" name="descripcion" id="descripcion" value="{{rolesdsc}}" {{readonly}}/>
        </div>

        <div>
            <label for="estadoRol">Estado de Rol: </label>
            {{ifnot readonly}}
                <select name="estadoRol" id="estadoRol">
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="estadoRol" id="estadoRol" value="{{rolesest}}" {{readonly}}/>
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
            window.location.assign("index.php?page=Roles-RolesList");
        })
    });
</script>