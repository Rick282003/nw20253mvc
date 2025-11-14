<?php

namespace Dao\EstudiantesPractica;

use Dao\Table;

class Estudiantes extends Table
{
    //Función para obtener todos los registros de estudiantes
    public static function obtenerEstudiantes()
    {
        $sqlStr = "SELECT * from incidentes_estudiantiles;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de estudiantes
    public static function obtenerEstudiantePorCodigo(string $id): array
    {
        $sqlstr = "SELECT * from incidentes_estudiantiles WHERE id=:id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    //Función para insertar un registro en la incidentes_estudiantiles
    public static function crearEstudiante(
        int $id,
        string $nombre,
        string $fecha,
        string $tipo,
        string $descripcion,
        string $accion,
        string $estado
    ) {
        $insSql = "INSERT INTO incidentes_estudiantiles (id, estudiante_nombre, fecha_incidente, tipo_incidente, descripcion, accion_tomada, estado)
        VALUES (:id, :nombre, :fecha, :tipo, :descripcion, :accion, :estado);";

        $newInsertData = [
            "id" => $id,
            "nombre" => $nombre,
            "fecha" => $fecha,
            "tipo" => $tipo,
            "descripcion" => $descripcion,
            "accion" => $accion,
            "estado" => $estado
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }

    //Función para actualizar un registro en incidentes_estudiantiles
    public static function actualizarEstudiante(
        int $id,
        string $nombre,
        string $fecha,
        string $tipo,
        string $descripcion,
        string $accion,
        string $estado
    ) {
        $updSql = "UPDATE incidentes_estudiantiles SET estudiante_nombre=:nombre, fecha_incidente=:fecha, tipo_incidente=:tipo, descripcion=:descripcion, accion_tomada=:accion, estado=:estado
        WHERE id=:id;";

        $newUpdateData = [
            "id" => $id,
            "nombre" => $nombre,
            "fecha" => $fecha,
            "tipo" => $tipo,
            "descripcion" => $descripcion,
            "accion" => $accion,
            "estado" => $estado
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en la tabla
    public static function eliminarEstudiante(
        string $id
    ) {
        $delSql = "DELETE FROM incidentes_estudiantiles WHERE id=:id;";

        $delData = [
            "id" => $id
        ]; //parametros

        return self::executeNonQuery($delSql, $delData);
    }
}
