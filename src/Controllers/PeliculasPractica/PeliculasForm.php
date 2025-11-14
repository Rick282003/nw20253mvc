<?php

namespace Controllers\PeliculasPractica;

use Controllers\PublicController;
use Dao\PeliculasPractica\Peliculas as DAOPeliculas;
use Exception;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const PELICULASL = "index.php?page=PeliculasPractica-PeliculasList";
const PELICULAS_VIEW = "peliculasPractica/form";
class PeliculasForm extends PublicController
{

    private $modes = [
        "INS" => "Nueva Pelicula",
        "UPD" => "Editando Pelicula %s",
        "DSP" => "Detalle de Pelicula %s",
        "DEL" => "Eliminando Pelicula %s"
    ];

    private string $mode = '';

    private int $id = 0;
    private string $titulo = '';
    private string $director = '';
    private string $genero = '';
    private int $anio = 0;
    private int $duracionMinutos = 0;
    private string $sinopsis = '';
    private string $clasificacion = '';
    private string $estado = '';

    private array $errores = [];

    private string $tokenValidation = '';


    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tempId = '';
                if (isset($_GET["id"])) {
                    $tempId = $_GET["id"];
                } else {
                    throw new Exception("El ID no es Válido");
                }
                $tempPelicula = DAOPeliculas::obtenerPeliculaPorCodigo($tempId);
                if (count($tempPelicula) === 0) {
                    throw new Exception("No se encontro registro");
                }

                $this->id = $tempPelicula["id"];
                $this->titulo = $tempPelicula["titulo"];
                $this->director = $tempPelicula["director"];
                $this->genero = $tempPelicula["genero"];
                $this->anio = $tempPelicula["anio_estreno"];
                $this->duracionMinutos = $tempPelicula["duracion"];
                $this->sinopsis = $tempPelicula["sinopsis"];
                $this->clasificacion = $tempPelicula["clasificacion"];
                $this->estado = $tempPelicula["estado"];
            }
        } else {
            throw new Exception("Valor de Mode no es Válido");
        }
    }

    private function generarTokenDeValidacion()
    {
        $this->tokenValidation = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->tokenValidation;
    }


    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode;

        $viewData["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->titulo);
        }

        $viewData["id"] = $this->id;
        $viewData["titulo"] = $this->titulo;
        $viewData["director"] = $this->director;
        $viewData["genero"] = $this->genero;
        $viewData["anio_estreno"] = $this->anio;
        $viewData["duracion"] = $this->duracionMinutos;
        $viewData["sinopsis"] = $this->sinopsis;
        $viewData["clasificacion"] = $this->clasificacion;
        $viewData["estado"] = $this->estado;


        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->estado] = "selected";

        return $viewData;
    }

    private function validarPostData(): array
    {
        $errores = [];

        $this->tokenValidation = $_POST["xrl8"] ?? "";
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->tokenValidation) {
            throw new Exception("Error de Validación de Token, no hackeable :(");
        }
        $this->id = intval($_POST["id"] ?? '');
        $this->titulo = $_POST["titulo"] ?? '';
        $this->director = $_POST["director"] ?? '';
        $this->genero = $_POST["genero"] ?? '';
        $this->anio = intval($_POST["anio"] ?? '');
        $this->duracionMinutos = intval($_POST["duracion"] ?? '');
        $this->sinopsis = $_POST["sinopsis"] ?? '';
        $this->clasificacion = $_POST["clasificacion"] ?? '';
        $this->estado = $_POST["estado"] ?? 'Disponible';

        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->id)) {
            $errores[] = "ID no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->titulo)) {
            $errores[] = "Titulo no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->director)) {
            $errores[] = "Director no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->genero)) {
            $errores[] = "Genero no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->anio)) {
            $errores[] = "Año no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->duracionMinutos)) {
            $errores[] = "Duración no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->sinopsis)) {
            $errores[] = "Sinopsis no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->clasificacion)) {
            $errores[] = "Clasificación no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->estado)) {
            $errores[] = "Estado no puede ir vacio.";
        }

        return $errores;
    }



    public function run(): void
    {
        try {
            $this->page_init();
            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();
                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case "INS":
                                //Llamar a Dao para Ingresar
                                $affectedRows = DaoPeliculas::crearPelicula(
                                    $this->id,
                                    $this->titulo,
                                    $this->director,
                                    $this->genero,
                                    $this->anio,
                                    $this->duracionMinutos,
                                    $this->sinopsis,
                                    $this->clasificacion,
                                    $this->estado
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(PELICULASL, "Nueva Pelicula creada satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DaoPeliculas::actualizarPelicula(
                                    $this->id,
                                    $this->titulo,
                                    $this->director,
                                    $this->genero,
                                    $this->anio,
                                    $this->duracionMinutos,
                                    $this->sinopsis,
                                    $this->clasificacion,
                                    $this->estado
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(PELICULASL, "Pelicula actualizada satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DaoPeliculas::eliminarPelicula(
                                    $this->id
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(PELICULASL, "Pelicula eliminada satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                        $this->errores[] = $err;
                    }
                }
            }

            Renderer::render(
                PELICULAS_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(PELICULASL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
