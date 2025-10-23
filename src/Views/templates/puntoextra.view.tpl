<h1>Usuarios</h1>
{{foreach items}}
<section>
    <span>Nombre: {{nombre}}</span><br/>
    <span>Cuenta: {{cuenta}}</span><br/>
    <span>Correo: {{correo}}</span><br/>
    <span>Colores Favoritos:</span>
    {{foreach colores}}
        <li>{{this}}</li> <!-- usar this cuando son elementos del mismo arreglo -->
    {{endfor colores}}
</section>
<br/>

{{endfor items}}