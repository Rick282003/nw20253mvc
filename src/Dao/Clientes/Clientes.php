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

    //Función para insertar un registro en la tabla
    public static function crearCliente(
        string $codigo,
        string $nombre,
        string $direccion,
        string $correo,
        string $telefono,
        string $estado,
        int $evaluacion
    ) {
        $insSql = "INSERT INTO clientes (codigo, nombre, direccion, correo, telefono, estado, evaluacion)
        VALUES (:codigo, :nombre, :direccion, :correo, :telefono, :estado, :evaluacion);"; //esta es el querry sql, :indica que es parametro

        $newInsertData = [
            "codigo" => $codigo,
            "nombre" => $nombre,
            "direccion" => $direccion,
            "correo" => $correo,
            "telefono" => $telefono,
            "estado" => $estado,
            "evaluacion" => $evaluacion
        ]; //estos son los parametros para el querry

        return self::executeNonQuery($insSql, $newInsertData); //aqui ejectutamos el querry, mandando los parametros
    }

    //Función para actualizar un registro en la tabla
    public static function actualizarCliente(
        string $codigo,
        string $nombre,
        string $direccion,
        string $correo,
        string $telefono,
        string $estado,
        int $evaluacion
    ) {
        $updSql = "UPDATE clientes SET nombre=:nombre, direccion=:direccion, correo=:correo, telefono=:telefono, estado=:estado, evaluacion=:evaluacion
        WHERE codigo=:codigo;"; //esta es el querry sql, :indica que es parametro

        $newUpdateData = [
            "codigo" => $codigo,
            "nombre" => $nombre,
            "direccion" => $direccion,
            "correo" => $correo,
            "telefono" => $telefono,
            "estado" => $estado,
            "evaluacion" => $evaluacion
        ]; //estos son los parametros para el querry

        return self::executeNonQuery($updSql, $newUpdateData); //aqui ejectutamos el querry, mandando los parametros
    }

    //Función para eliminar un registro en la tabla
    public static function eliminarCliente(
        string $codigo
    ) {
        $delSql = "DELETE FROM clientes WHERE codigo=:codigo;"; //este es querry sql para eleminar registro

        $delData = [
            "codigo" => $codigo
        ]; //parametros

        return self::executeNonQuery($delSql, $delData); //aqui se ejecuta el querry, y se manda el delete y paramatros
    }
}
