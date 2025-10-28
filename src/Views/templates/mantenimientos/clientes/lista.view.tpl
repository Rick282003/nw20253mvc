<section class="px-4 py-4 depth-2"><!-- En la vista no va php ni calculos, solo mostramos resultados -->
    <h2>Listado de Clientes</h2>
</section>
<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Estado</th>
                <td>Nota</td>

            </tr>
        </thead>
        <tbody>
            {{foreach clientes}}
            <tr>
                <td>{{codigo}}</td>
                <td>{{nombre}}</td>
                <td>{{direccion}}</td>
                <td>{{telefono}}</td>
                <td>{{correo}}</td>
                <td>{{estado}}</td>
                <td>{{nota}} | {{grado}}</td>
            </tr>
            {{endfor clientes}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="right">
                    Registros: {{total}}
                </td> <!-- colspan es para la columna -->
                <td>Nota Total: {{totalNota}}</td>
            </tr>
            <tr>
                <td colspan="6" class="right">Promedio: {{promedioNota}}</td>
            </tr>
        </tfoot>
    </table>
</section>