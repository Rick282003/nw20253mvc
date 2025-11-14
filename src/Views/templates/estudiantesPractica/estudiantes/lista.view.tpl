<section class="px-4 py-4 depth-2">
    <h2>Lista de Incidentes de Estudiantes</h2>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Estudiante</th>
                <th>Fecha de Incidente</th>
                <th>Tipo de Incidente</th>
                <th>Descripción</th>
                <th>Acción Tomada</th>
                <th>Estado</th>
                <th><a href="index.php?page=EstudiantesPractica-EstudiantesForm&mode=INS">Nuevo</a></th>
            </tr>
        </thead>

        <tbody>
            {{foreach estudiantes}}
                <tr>
                    <td>{{id}}</td>
                    <td>{{estudiante_nombre}}</td>
                    <td>{{fecha_incidente}}</td>
                    <td>{{tipo_incidente}}</td>
                    <td>{{descripcion}}</td>
                    <td>{{accion_tomada}}</td>
                    <td>{{estado}}</td>
                    <td>
                        <a href="index.php?page=EstudiantesPractica-EstudiantesForm&mode=UPD&id={{id}}">Editar</a>&nbsp;
                        <a href="index.php?page=EstudiantesPractica-EstudiantesForm&mode=DEL&id={{id}}">Eliminar</a>&nbsp;
                        <a href="index.php?page=EstudiantesPractica-EstudiantesForm&mode=DSP&id={{id}}">Ver</a>
                    </td>
                </tr>
            {{endfor estudiantes}}
        </tbody>
    </table>

</section>