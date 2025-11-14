<?php

namespace Dao\PeliculasPractica;

use Dao\Table;

class Peliculas extends Table
{
    //Función para obtener todos los registros de peliculas
    public static function obtenerPeliculas()
    {
        $sqlStr = "SELECT * from peliculas;";
        return self::obtenerRegistros($sqlStr, []);
    }

    //Función para obtener un registro de peliculas
    public static function obtenerPeliculaPorCodigo(string $id): array
    {
        $sqlstr = "SELECT * from peliculas WHERE id=:id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    //Función para insertar un registro de peliculas
    public static function crearPelicula(
        int $id,
        string $titulo,
        string $director,
        string $genero,
        int $anio,
        int $duracionMinutos,
        string $sinopsis,
        string $clasificacion,
        string $estado,
    ) {
        $insSql = "INSERT INTO peliculas (id, titulo, director, genero, anio_estreno, duracion, sinopsis, clasificacion, estado)
        VALUES (:id, :titulo, :director, :genero, :anio, :duracionMinutos, :sinopsis, :clasificacion, :estado);";

        $newInsertData = [
            "id" => $id,
            "titulo" => $titulo,
            "director" => $director,
            "genero" => $genero,
            "anio" => $anio,
            "duracionMinutos" => $duracionMinutos,
            "sinopsis" => $sinopsis,
            "clasificacion" => $clasificacion,
            "estado" => $estado
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }

    //Función para actualizar un registro en peliculas
    public static function actualizarPelicula(
        int $id,
        string $titulo,
        string $director,
        string $genero,
        int $anio,
        int $duracionMinutos,
        string $sinopsis,
        string $clasificacion,
        string $estado,
    ) {
        $updSql = "UPDATE peliculas SET titulo=:titulo, director=:director, genero=:genero, anio_estreno=:anio, duracion=:duracionMinutos, sinopsis=:sinopsis, clasificacion=:clasificacion, estado=:estado
        WHERE id=:id;";

        $newUpdateData = [
            "id" => $id,
            "titulo" => $titulo,
            "director" => $director,
            "genero" => $genero,
            "anio" => $anio,
            "duracionMinutos" => $duracionMinutos,
            "sinopsis" => $sinopsis,
            "clasificacion" => $clasificacion,
            "estado" => $estado
        ];


        return self::executeNonQuery($updSql, $newUpdateData);
    }

    //Función para eliminar un registro en peliuclas
    public static function eliminarPelicula(
        string $id
    ) {
        $delSql = "DELETE FROM peliculas WHERE id=:id;";

        $delData = [
            "id" => $id
        ];

        return self::executeNonQuery($delSql, $delData);
    }
}
