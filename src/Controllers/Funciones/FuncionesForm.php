<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones as DAOFunciones;
use Exception;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const FUNCIONESL = "index.php?page=Funciones-FuncionesList";
const FUNCIONES_VIEW = "funciones/form";


class FuncionesForm extends PublicController
{
    private $modes = [
        "INS" => "Nueva Función",
        "UPD" => "Editando Función %s",
        "DSP" => "Detalle de Función %s",
        "DEL" => "Eliminando Función %s"
    ];

    private string $mode = '';

    private string $funcionCodigo = '';
    private string $funcionDescripcion = '';
    private string $funcionEstado = '';
    private string $funcionTipo = '';

    private array $errores = [];

    private string $tokenValidation = '';


    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tempCodigo = '';
                if (isset($_GET["fncod"])) {
                    $tempCodigo = $_GET["fncod"];
                } else {
                    throw new Exception("El Codigo no es Válido");
                }
                $tempFuncion = DAOFunciones::obtenerFuncionPorCodigo($tempCodigo);
                if (count($tempFuncion) === 0) {
                    throw new Exception("No se encontro función");
                }
                $this->funcionCodigo = $tempFuncion["fncod"];
                $this->funcionDescripcion = $tempFuncion["fndsc"];
                $this->funcionEstado = $tempFuncion["fnest"];
                $this->funcionTipo = $tempFuncion["fntyp"];
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->funcionCodigo);
        }

        $viewData["fncod"] = $this->funcionCodigo;
        $viewData["fndsc"] = $this->funcionDescripcion;
        $viewData["fnest"] = $this->funcionEstado;
        $viewData["fntyp"] = $this->funcionTipo;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->funcionEstado] = "selected";
        $viewData["selected" . $this->funcionTipo] = "selected";
        return $viewData;
    }

    private function validarPostData(): array
    {
        $errores = [];

        $this->tokenValidation = $_POST["xrl8"] ?? "";
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->tokenValidation) {
            throw new Exception("Error de Validación de Token, no hackeable :(");
        }

        $this->funcionCodigo = $_POST["codigo"] ?? '';
        $this->funcionDescripcion = $_POST["descripcion"] ?? '';
        $this->funcionEstado = $_POST["estado"] ?? 'Activo';
        $this->funcionTipo = $_POST["tipo"] ?? 'ADM';


        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->funcionCodigo)) {
            $errores[] = "El codigo no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->funcionDescripcion)) {
            $errores[] = "La descripcion no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->funcionEstado)) {
            $errores[] = "El estado no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->funcionTipo)) {
            $errores[] = "El tipo no puede ir vacio.";
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
                                $affectedRows = DAOFunciones::crearFuncion(
                                    $this->funcionCodigo,
                                    $this->funcionDescripcion,
                                    $this->funcionEstado,
                                    $this->funcionTipo
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FUNCIONESL, "Nueva Función creada satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAOFunciones::actualizarFunciones(
                                    $this->funcionCodigo,
                                    $this->funcionDescripcion,
                                    $this->funcionEstado,
                                    $this->funcionTipo
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FUNCIONESL, "Función actualizada satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAOFunciones::eliminarFuncion(
                                    $this->funcionCodigo
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FUNCIONESL, "Función eliminada satisfactoriamente.");
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
                FUNCIONES_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(FUNCIONESL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
