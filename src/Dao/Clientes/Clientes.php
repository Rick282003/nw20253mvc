<?php

namespace Dao\Clientes;

use Dao\Table;

//Aqui estamos usando datos dummy, simulación a falta de base de datos
class Clientes extends Table
{
    public static function obtenerClientes(): array
    {
        $sqlstr = "SELECT * from clientes;"; //Este es el querry que ejecutaremos
        return self::obtenerRegistros($sqlstr, []); //De tabla usamos el metodo para ejecutar el querry
    }
}
