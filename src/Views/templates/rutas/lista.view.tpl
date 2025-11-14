<section class="px-4 py-4 depth-2">
    <h2>Lista de Rutas de Entrega</h2>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Distancia KM</th>
                <th>Duración Minutos</th>
                <th><a href="index.php?page=Rutas-RutasForm&mode=INS">Nueva Ruta</a></th>
            </tr>
        </thead>

        <tbody>
            {{foreach rutas}}
                <tr>
                    <td>{{id_ruta}}</td>
                    <td>{{origen}}</td>
                    <td>{{destino}}</td>
                    <td>{{distancia_km}}</td>
                    <td>{{duracion_min}}</td>
                    <td>
                        <a href="index.php?page=Rutas-RutasForm&mode=UPD&id_ruta={{id_ruta}}">Editar</a>&nbsp;
                        <a href="index.php?page=Rutas-RutasForm&mode=DEL&id_ruta={{id_ruta}}">Eliminar</a>&nbsp;
                        <a href="index.php?page=Rutas-RutasForm&mode=DSP&id_ruta={{id_ruta}}">Ver</a>
                    </td>
                </tr>
            {{endfor rutas}}
        </tbody>
    </table>
</section>