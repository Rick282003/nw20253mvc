<?php

namespace Dao\Usuario;

use Dao\Table;

class Usuario extends Table
{
    //Función para obtener todos los registros de usuario
    public static function obtenerUsuarios()
    {
        $sqlStr = "SELECT * from usuario;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de usuario
    public static function obtenerUsuarioPorCodigo(string $idUsuario): array
    {
        $sqlstr = "SELECT * from usuario WHERE usercod=:idUsuario;";
        return self::obtenerUnRegistro($sqlstr, ["idUsuario" => $idUsuario]);
    }


    //Función para insertar un registro en usuario
    public static function crearUsuario(
        int $idUsuario,
        string $correo,
        string $nombreUsuario,
        string $contrasena,
        string $fechaCreacion,
        string $estadoContrasena,
        string $fechaExpContrasena,
        string $estadoUsuario,
        string $codigoActivacion,
        string $codigoCambioContrasena,
        string $tipoUsuario
    ) {
        $insSql = "INSERT INTO usuario (usercod, useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo)
        VALUES (:idUsuario, :correo, :nombreUsuario, :contrasena, :fechaCreacion, :estadoContrasena, :fechaExpContrasena, :estadoUsuario, :codigoActivacion, :codigoCambioContrasena, :tipoUsuario);";

        $newInsertData = [
            "idUsuario" => $idUsuario,
            "correo" => $correo,
            "nombreUsuario" => $nombreUsuario,
            "contrasena" => $contrasena,
            "fechaCreacion" => $fechaCreacion,
            "estadoContrasena" => $estadoContrasena,
            "fechaExpContrasena" => $fechaExpContrasena,
            "estadoUsuario" => $estadoUsuario,
            "codigoActivacion" => $codigoActivacion,
            "codigoCambioContrasena" => $codigoCambioContrasena,
            "tipoUsuario" => $tipoUsuario,

        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }

    //Función para actualizar un registro en usuario
    public static function actualizarUsuario(
        int $idUsuario,
        string $correo,
        string $nombreUsuario,
        string $contrasena,
        string $fechaCreacion,
        string $estadoContrasena,
        string $fechaExpContrasena,
        string $estadoUsuario,
        string $codigoActivacion,
        string $codigoCambioContrasena,
        string $tipoUsuario
    ) {
        $updSql = "UPDATE usuario SET useremail=:correo, username=:nombreUsuario, userpswd=:contrasena, userfching=:fechaCreacion, userpswdest=:estadoContrasena, userpswdexp=:fechaExpContrasena, userest=:estadoUsuario, useractcod=:codigoActivacion, userpswdchg=:codigoCambioContrasena, usertipo=:tipoUsuario
        WHERE usercod=:idUsuario;";

        $newUpdateData = [
            "idUsuario" => $idUsuario,
            "correo" => $correo,
            "nombreUsuario" => $nombreUsuario,
            "contrasena" => $contrasena,
            "fechaCreacion" => $fechaCreacion,
            "estadoContrasena" => $estadoContrasena,
            "fechaExpContrasena" => $fechaExpContrasena,
            "estadoUsuario" => $estadoUsuario,
            "codigoActivacion" => $codigoActivacion,
            "codigoCambioContrasena" => $codigoCambioContrasena,
            "tipoUsuario" => $tipoUsuario,
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en usuario
    public static function eliminarUsuario(
        string $idUsuario
    ) {
        $delSql = "DELETE FROM usuario WHERE usercod=:idUsuario;";

        $delData = [
            "idUsuario" => $idUsuario
        ];

        return self::executeNonQuery($delSql, $delData);
    }
}
