<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Dao\Roles\Roles as DAORoles;
use Exception;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const ROLESL = "index.php?page=Roles-RolesList";
const ROLES_VIEW = "roles/form";


class RolesForm extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Rol",
        "UPD" => "Editando Rol de %s",
        "DSP" => "Detalle de Rol de %s",
        "DEL" => "Eliminando Rol de %s"
    ];

    private string $mode = '';

    private string $codigoRol = '';
    private string $descripcionRol = '';
    private string $estadoRol = '';

    private array $errores = [];

    private string $tokenValidation = '';


    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tempCodigo = '';
                if (isset($_GET["rolescod"])) {
                    $tempCodigo = $_GET["rolescod"];
                } else {
                    throw new Exception("El ID no es Válido");
                }
                $tempRol = DAORoles::obtenerRolPorCodigo($tempCodigo);
                if (count($tempRol) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->codigoRol = $tempRol["rolescod"];
                $this->descripcionRol = $tempRol["rolesdsc"];
                $this->estadoRol = $tempRol["rolesest"];
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->codigoRol);
        }

        $viewData["rolescod"] = $this->codigoRol;
        $viewData["rolesdsc"] = $this->descripcionRol;
        $viewData["rolesest"] = $this->estadoRol;


        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->estadoRol] = "selected";

        return $viewData;
    }


    private function validarPostData(): array
    {
        $errores = [];

        $this->tokenValidation = $_POST["xrl8"] ?? "";
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->tokenValidation) {
            throw new Exception("Error de Validación de Token, no hackeable :(");
        }

        $this->codigoRol = ($_POST["codigo"] ?? '');
        $this->descripcionRol = $_POST["descripcion"] ?? '';
        $this->estadoRol = $_POST["estadoRol"] ?? 'ACT';

        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->codigoRol)) {
            $errores[] = "El codigo no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->descripcionRol)) {
            $errores[] = "La descripción no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->estadoRol)) {
            $errores[] = "El estado no puede ir vacio.";
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
                                $affectedRows = DAORoles::crearRol(
                                    $this->codigoRol,
                                    $this->descripcionRol,
                                    $this->estadoRol
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ROLESL, "Nuevo Rol creado satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAORoles::actualizarRol(
                                    $this->codigoRol,
                                    $this->descripcionRol,
                                    $this->estadoRol
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ROLESL, "Rol actualizado satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAORoles::eliminarRol(
                                    $this->codigoRol
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ROLESL, "Rol eliminado satisfactoriamente.");
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
                ROLES_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(ROLESL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
