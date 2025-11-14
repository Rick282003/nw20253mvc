<section class="px-4 py-4 depth-2">
    <h2>Lista de Funciones</h2>
</section>

<section class="WWList">
<table>
    <thead>
        <tr>
            <th>Codigo de Función</th>
            <th>Descripción de Función</th>
            <th>Estado de Función</th>
            <th>Tipo de Función</th>
            <th><a href="index.php?page=Funciones-FuncionesForm&mode=INS">Nueva Función</a>
        </tr>
    </thead>

    <tbody>
        {{foreach funciones}}
        <tr>
            <td>{{fncod}}</td>
            <td>{{fndsc}}</td>
            <td>{{fnest}}</td>
            <td>{{fntyp}}</td>
            <td>
                <a href="index.php?page=Funciones-FuncionesForm&mode=UPD&fncod={{fncod}}">Editar</a>&nbsp;
                <a href="index.php?page=Funciones-FuncionesForm&mode=DEL&fncod={{fncod}}">Eliminar</a>&nbsp;
                <a href="index.php?page=Funciones-FuncionesForm&mode=DSP&fncod={{fncod}}">Ver</a>
            </td>
        </tr>
        {{endfor funciones}}
    </tbody>
</table>

</section>