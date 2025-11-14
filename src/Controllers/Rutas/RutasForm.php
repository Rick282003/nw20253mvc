<?php

namespace Controllers\Rutas;

use Controllers\PublicController;
use Dao\Rutas\Rutas as DAORutas;
use Exception;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const RUTASL = "index.php?page=Rutas-RutasList";
const RUTAS_VIEW = "rutas/form";

class RutasForm extends PublicController
{
    private $modes = [
        "INS" => "Nueva Ruta",
        "UPD" => "Editando Ruta %s",
        "DSP" => "Detalle de Ruta %s",
        "DEL" => "Eliminando Ruta %s"
    ];

    private string $mode = '';

    private int $id = 0;
    private string $origen = '';
    private string $destino = '';
    private float $distancia = 0;
    private int $duracion = 0;

    private array $errores = [];

    private string $tokenValidation = '';

    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tempId = '';
                if (isset($_GET["id_ruta"])) {
                    $tempId = $_GET["id_ruta"];
                } else {
                    throw new Exception("El ID no es Válido");
                }
                $tempRuta = DAORutas::obtenerRutaPorCodigo($tempId);
                if (count($tempRuta) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->id = $tempRuta["id_ruta"];
                $this->origen =  $tempRuta["origen"];
                $this->destino =  $tempRuta["destino"];
                $this->distancia = $tempRuta["distancia_km"];
                $this->duracion = $tempRuta["duracion_min"];
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->id);
        }

        $viewData["id_ruta"] = $this->id;
        $viewData["origen"] = $this->origen;
        $viewData["destino"] = $this->destino;
        $viewData["distancia_km"] = $this->distancia;
        $viewData["duracion_min"] = $this->duracion;


        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        // $viewData["selected" . $this->accion] = "selected";    
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
        $this->origen =  $_POST["origen"] ?? '';
        $this->destino =  $_POST["destino"] ?? '';
        $this->distancia = floatval($_POST["distancia"] ?? '');
        $this->duracion = intval($_POST["duracion"] ?? '');

        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->id)) {
            $errores[] = "ID no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->origen)) {
            $errores[] = "Origen no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->destino)) {
            $errores[] = "Destino no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->distancia)) {
            $errores[] = "Distancia no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->duracion)) {
            $errores[] = "Duración no puede ir vacia.";
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
                                $affectedRows = DAORutas::crearRuta(
                                    $this->id,
                                    $this->origen,
                                    $this->destino,
                                    $this->distancia,
                                    $this->duracion
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RUTASL, "Nueva Ruta creada satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAORutas::actualizarRuta(
                                    $this->id,
                                    $this->origen,
                                    $this->destino,
                                    $this->distancia,
                                    $this->duracion
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RUTASL, "Ruta actualizada satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAORutas::eliminarRuta(
                                    $this->id
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RUTASL, "Ruta eliminada satisfactoriamente.");
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
                RUTAS_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(RUTASL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
