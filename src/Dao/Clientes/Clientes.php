<?php

namespace Dao\Clientes;

use Dao\Table;

class Clientes extends Table
{
    public static function obtenerClientes(): array
    {
        $sqlstr = "SELECT * from clientes;"; //Este es el querry que ejecutaremos
        return self::obtenerRegistros($sqlstr, []); //De tabla usamos el metodo para ejecutar el querry
    }

    public static function obtenerClientePorCodigo(string $codigo): array
    {
        $sqlstr = "SELECT * from clientes WHERE codigo=:codigo;"; //parametro, evita que usuario haga inyeccion de sql
        return self::obtenerUnRegistro($sqlstr, ["codigo" => $codigo]); //me devuelve el valor de un cliente
    }
}
