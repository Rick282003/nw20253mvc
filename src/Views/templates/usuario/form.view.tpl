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

    <form action="index.php?page=Usuario-UsuarioForm&mode={{mode}}&usercod={{usercod}}" method="post">
        <div>
            <label for="codigo">Codigo Usuario: </label>
            <input type="number" name="codigo" id="codigo" value="{{usercod}}" {{idReadonly}}/>
            <input type="hidden" name="xrl8" value="{{token}}"/>
        </div>

        <div>
            <label for="correo">Correo: </label>
            <input type="email" name="correo" id="correo" value="{{useremail}}" {{readonly}}/>
        </div>

        <div>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" value="{{username}}" {{readonly}}/>
        </div>

        <div>
            <label for="contrasena">Contraseña: </label>
            <input type="text" name="contrasena" id="contrasena" value="{{userpswd}}" {{readonly}}/>
        </div>

        <div>
            <label for="fechaCreacion">Fecha Creación:</label>
            <input type="datetime" name="fechaCreacion" id="fechaCreacion" value="{{userfching}}" {{readonly}} title="2025-11-11 00:00:00" placeholder="2025-11-11 00:00:00"/>
        </div>

        <div>
            <label for="estadoContrasena">Estado Contraseña: </label>
            {{ifnot readonly}}
                <select name="estadoContrasena" id="estadoContrasena">
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="estadoContrasena" id="estadoContrasena" value="{{userpswdest}}" {{readonly}}/>
            {{endif readonly}}
        </div>

        <div>
            <label for="fechaExpContrasena">Fecha EXP Contraseña: </label>
            <input type="datetime" name="fechaExpContrasena" id="fechaExpContrasena" value="{{userpswdexp}}" {{readonly}} title="2025-11-11 00:00:00" placeholder="2025-11-11 00:00:00"/>
        </div>

        <div>
            <label for="estadoUsuario">Estado Usuario: </label>
            {{ifnot readonly}}
                <select name="estadoUsuario" id="estadoUsuario">
                    <option value="ACT" {{selectedACT}}>Activo</option>
                    <option value="INA" {{selectedINA}}>Inactivo</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="estadoUsuario" id="estadoUsuario" value="{{userest}}" {{readonly}}/>
            {{endif readonly}}
        </div>

        <div>
            <label for="codigoActivacion">Codigo Activación: </label>
            <input type="text" name="codigoActivacion" id="codigoActivacion" value="{{useractcod}}" {{readonly}}/>
        </div>

        <div>
            <label for="codigoCambioContrasena">Codigo Cambio Contraseña: </label>
            <input type="text" name="codigoCambioContrasena" id="codigoCambioContrasena" value="{{userpswdchg}}" {{readonly}}/>
        </div>

        <div>
            <label for="tipoUsuario">Tipo de Usuario: </label>
            {{ifnot readonly}}
                <select name="tipoUsuario" id="tipoUsuario">
                    <option value="NOR" {{selectedNOR}}>Normal</option>
                    <option value="CON" {{selectedCON}}>Consultor</option>
                    <option value="CLI" {{selectedCLI}}>Cliente</option>
                </select>
            {{endifnot readonly}}

            {{if readonly}}
            <input type="text" name="tipoUsuario" id="tipoUsuario" value="{{usertipo}}" {{readonly}}/>
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
            window.location.assign("index.php?page=Usuario-UsuarioList");
        })
    });
</script>