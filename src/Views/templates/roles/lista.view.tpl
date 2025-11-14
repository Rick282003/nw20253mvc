<section class="px-4 py-4 depth-2">
    <h2>Lista de Roles</h2>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Codigo de Rol</th>
                <th>Descripción de Rol</th>
                <th>Estado de Rol</th>
                <th><a href="index.php?page=Roles-RolesForm&mode=INS">Nuevo Rol</a></th>
            </tr>
        </thead>

        <tbody>
            {{foreach roles}}
                <tr>
                    <td>{{rolescod}}</td>
                    <td>{{rolesdsc}}</td>
                    <td>{{rolesest}}</td>
                    <td>
                        <a href="index.php?page=Roles-RolesForm&mode=UPD&rolescod={{rolescod}}">Editar</a>&nbsp;
                        <a href="index.php?page=Roles-RolesForm&mode=DEL&rolescod={{rolescod}}">Eliminar</a>&nbsp;
                        <a href="index.php?page=Roles-RolesForm&mode=DSP&rolescod={{rolescod}}">Ver</a>
                    </td>
                </tr>
            {{endfor roles}}
        </tbody>
    </table>

</section>