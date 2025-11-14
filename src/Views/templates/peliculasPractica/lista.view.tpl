<section class="px-4 py-4 depth-2">
    <h2>Lista de Peliculas en el Cine</h2>
</section>


<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Director</th>
                <th>Genero</th>
                <th>Año Estreno</th>
                <th>Duración Minutos</th>
                <th>Sinopsis</th>
                <th>Clasificacion</th>
                <th>Estado</th>
                <th><a href="index.php?page=PeliculasPractica-PeliculasForm&mode=INS">Nueva Pelicula</a></th>
            </tr>
        </thead>

        <tbody>
            {{foreach peliculas}}
                <tr>
                    <td>{{id}}</td>
                    <td>{{titulo}}</td>
                    <td>{{director}}</td>
                    <td>{{genero}}</td>
                    <td>{{anio_estreno}}</td>
                    <td>{{duracion}}</td>
                    <td>{{sinopsis}}</td>
                    <td>{{clasificacion}}</td>
                    <td>{{estado}}</td>
                    <td>
                        <a href="index.php?page=PeliculasPractica-PeliculasForm&mode=UPD&id={{id}}">Editar</a>&nbsp;
                        <a href="index.php?page=PeliculasPractica-PeliculasForm&mode=DEL&id={{id}}">Eliminar</a>&nbsp;
                        <a href="index.php?page=PeliculasPractica-PeliculasForm&mode=DSP&id={{id}}">Ver</a>
                    </td>
                </tr>
            {{endfor peliculas}}
        </tbody>
    </table>
</section>