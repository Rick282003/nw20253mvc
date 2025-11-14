<?php

namespace Dao\Rutas;

use Dao\Table;

class Rutas extends Table
{
    //Función para obtener todos los registros de rutas
    public static function obtenerRutas()
    {
        $sqlStr = "SELECT * from RutasEntrega;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de rutas
    public static function obtenerRutaPorCodigo(string $id): array
    {
        $sqlstr = "SELECT * from RutasEntrega WHERE id_ruta=:id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    //Función para insertar un registro de rutas
    public static function crearRuta(
        int $id,
        string $origen,
        string $destino,
        float $distancia,
        int $duracion
    ) {
        $insSql = "INSERT INTO RutasEntrega (id_ruta, origen, destino, distancia_km, duracion_min)
        VALUES (:id, :origen, :destino, :distancia, :duracion);";

        $newInsertData = [
            "id" => $id,
            "origen" => $origen,
            "destino" => $destino,
            "distancia" => $distancia,
            "duracion" => $duracion
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }

    //Función para actualizar un registro en rutas
    public static function actualizarRuta(
        int $id,
        string $origen,
        string $destino,
        float $distancia,
        int $duracion
    ) {
        $updSql = "UPDATE RutasEntrega SET origen=:origen, destino=:destino, distancia_km=:distancia, duracion_min=:duracion
        WHERE id_ruta=:id;";

        $newUpdateData = [
            "id" => $id,
            "origen" => $origen,
            "destino" => $destino,
            "distancia" => $distancia,
            "duracion" => $duracion
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en rutas
    public static function eliminarRuta(
        int $id
    ) {
        $delSql = "DELETE FROM RutasEntrega WHERE id_ruta=:id;";

        $delData = [
            "id" => $id
        ];

        return self::executeNonQuery($delSql, $delData);
    }
}
