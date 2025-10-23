<h1>Menú de Mantenimientos</h1>
{{foreach items}}
<section>
    <span>{{label}}: </span> <br/>
    <span>{{description}}</span> <br/>
    <a href="{{url}}">Ir a {{label}}</a>
</section>
<br/>
{{endfor items}}
