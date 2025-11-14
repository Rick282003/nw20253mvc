<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    //Función para obtener todos los registros de funciones
    public static function obtenerFunciones()
    {
        $sqlStr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de funciones
    public static function obtenerFuncionPorCodigo(string $funcionCodigo): array
    {
        $sqlstr = "SELECT * from funciones WHERE fncod=:funcionCodigo;";
        return self::obtenerUnRegistro($sqlstr, ["funcionCodigo" => $funcionCodigo]);
    }

    //Función para insertar un registro en funciones
    public static function crearFuncion(
        string $funcionCodigo,
        string $funcionDescripcion,
        string $funcionEstado,
        string $funcionTipo
    ) {
        $insSql = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
        VALUES (:funcionCodigo, :funcionDescripcion, :funcionEstado, :funcionTipo);";

        $newInsertData = [
            "funcionCodigo" => $funcionCodigo,
            "funcionDescripcion" => $funcionDescripcion,
            "funcionEstado" => $funcionEstado,
            "funcionTipo" => $funcionTipo
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }


    //Función para actualizar un registro en funciones
    public static function actualizarFunciones(
        string $funcionCodigo,
        string $funcionDescripcion,
        string $funcionEstado,
        string $funcionTipo
    ) {
        $updSql = "UPDATE funciones SET fndsc=:funcionDescripcion, fnest=:funcionEstado, fntyp=:funcionTipo
        WHERE fncod=:funcionCodigo;";

        $newUpdateData = [
            "funcionCodigo" => $funcionCodigo,
            "funcionDescripcion" => $funcionDescripcion,
            "funcionEstado" => $funcionEstado,
            "funcionTipo" => $funcionTipo
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en funciones
    public static function eliminarFuncion(
        string $funcionCodigo
    ) {
        $delSql = "DELETE FROM funciones WHERE fncod=:funcionCodigo;";

        $delData = [
            "funcionCodigo" => $funcionCodigo
        ];

        return self::executeNonQuery($delSql, $delData);
    }
}
