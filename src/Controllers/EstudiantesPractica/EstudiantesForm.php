<?php

namespace Controllers\EstudiantesPractica;

use Controllers\PublicController;
use Exception;
use Dao\EstudiantesPractica\Estudiantes as DAOEstudiantes;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const ESTUDIANTESL = "index.php?page=EstudiantesPractica-EstudiantesList";
const ESTUDIANTES_VIEW = "estudiantesPractica/estudiantes/form";

class EstudiantesForm extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Estudiante",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';

    private int    $id = 0;
    private string $nombre = '';
    private string $fecha = '';
    private string $tipo = '';
    private string $descripcion = '';
    private string $accion = '';
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
                $tempEstudiante = DAOEstudiantes::obtenerEstudiantePorCodigo($tempId);
                if (count($tempEstudiante) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->id = $tempEstudiante["id"];
                $this->nombre = $tempEstudiante["estudiante_nombre"];
                $this->fecha = $tempEstudiante["fecha_incidente"];
                $this->tipo = $tempEstudiante["tipo_incidente"];
                $this->descripcion = $tempEstudiante["descripcion"];
                $this->accion = $tempEstudiante["accion_tomada"];
                $this->estado = $tempEstudiante["estado"];
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombre);
        }

        $viewData["id"] = $this->id;
        $viewData["estudiante_nombre"] = $this->nombre;
        $viewData["fecha_incidente"] = $this->fecha;
        $viewData["tipo_incidente"] = $this->tipo;
        $viewData["descripcion"] = $this->descripcion;
        $viewData["accion_tomada"] = $this->accion;
        $viewData["estado"] = $this->estado;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->accion] = "selected";
        $viewData["selected" . $this->estado] = "selected"; //Este no lo uso porque mando para radio button para probar

        $viewData["checkedAbierto"] = $this->estado === "Abierto" ? "checked" : "";
        $viewData["checkedCerrado"] = $this->estado === "Cerrado" ? "checked" : "";
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
        $this->nombre = $_POST["nombre"] ?? '';
        $this->fecha = $_POST["fecha"] ?? '';
        $this->tipo = $_POST["tipo"] ?? '';
        $this->descripcion = $_POST["descripcion"] ?? '';
        $this->accion = $_POST["accion"] ?? 'Revisar';
        $this->estado = $_POST["estado"] ?? 'Abierto';

        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->id)) {
            $errores[] = "ID no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->nombre)) {
            $errores[] = "Nombre no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->fecha)) {
            $errores[] = "Fecha no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->tipo)) {
            $errores[] = "Tipo no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->descripcion)) {
            $errores[] = "Descripcion no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->accion)) {
            $errores[] = "Accion no puede ir vacio.";
        }

        if (!in_array($this->estado, ["Abierto", "Cerrado"])) {
            $errores[] = "Estado Incorrecto.";
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
                                $affectedRows = DAOEstudiantes::crearEstudiante(
                                    $this->id,
                                    $this->nombre,
                                    $this->fecha,
                                    $this->tipo,
                                    $this->descripcion,
                                    $this->accion,
                                    $this->estado
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ESTUDIANTESL, "Nuevo Estudiante creado satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAOEstudiantes::actualizarEstudiante(
                                    $this->id,
                                    $this->nombre,
                                    $this->fecha,
                                    $this->tipo,
                                    $this->descripcion,
                                    $this->accion,
                                    $this->estado
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ESTUDIANTESL, "Estudiante actualizado satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAOEstudiantes::eliminarEstudiante(
                                    $this->id
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ESTUDIANTESL, "Estudiante eliminado satisfactoriamente.");
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
                ESTUDIANTES_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(ESTUDIANTESL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
