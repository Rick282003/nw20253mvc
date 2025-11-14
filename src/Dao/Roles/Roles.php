<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    //Función para obtener todos los registros de roles
    public static function obtenerRoles()
    {
        $sqlStr = "SELECT * from roles;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de roles
    public static function obtenerRolPorCodigo(string $codigoRol): array
    {
        $sqlstr = "SELECT * from roles WHERE rolescod=:codigoRol;";
        return self::obtenerUnRegistro($sqlstr, ["codigoRol" => $codigoRol]);
    }

    //Función para insertar un registro en roles
    public static function crearRol(
        string $codigoRol,
        string $descripcionRol,
        string $estadoRol
    ) {
        $insSql = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
        VALUES (:codigoRol, :descripcionRol, :estadoRol);";

        $newInsertData = [
            "codigoRol" => $codigoRol,
            "descripcionRol" => $descripcionRol,
            "estadoRol" => $estadoRol
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }


    //Función para actualizar un registro en roles
    public static function actualizarRol(
        string $codigoRol,
        string $descripcionRol,
        string $estadoRol
    ) {
        $updSql = "UPDATE roles SET rolesdsc=:descripcionRol, rolesest=:estadoRol
        WHERE rolescod=:codigoRol;";

        $newUpdateData = [
            "codigoRol" => $codigoRol,
            "descripcionRol" => $descripcionRol,
            "estadoRol" => $estadoRol
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en roles
    public static function eliminarRol(
        string $codigoRol
    ) {
        $delSql = "DELETE FROM roles WHERE rolescod=:codigoRol;";

        $delData = [
            "codigoRol" => $codigoRol
        ];

        return self::executeNonQuery($delSql, $delData);
    }
}
