<?php

namespace Controllers\Usuario;

use Controllers\PublicController;
use Dao\Usuario\Usuario as DAOUsuario;
use Exception;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

//CONSTANTES
const USUARIOL = "index.php?page=Usuario-UsuarioList";
const USUARIO_VIEW = "usuario/form";

class UsuarioForm extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Usaurio :)",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';

    private int    $idUsuario = 0;
    private string $correo = '';
    private string $nombreUsuario = '';
    private string $contrasena = '';
    private string $fechaCreacion = '';
    private string $estadoContrasena = '';
    private string $fechaExpContrasena = '';
    private string $estadoUsuario = '';
    private string $codigoActivacion = '';
    private string $codigoCambioContrasena = '';
    private string $tipoUsuario = '';

    private array $errores = [];

    private string $tokenValidation = '';

    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tempUsuario = '';
                if (isset($_GET["usercod"])) {
                    $tempUsuario = $_GET["usercod"];
                } else {
                    throw new Exception("El ID no es Válido");
                }
                $tempUsuario = DAOUsuario::obtenerUsuarioPorCodigo($tempUsuario);
                if (count($tempUsuario) === 0) {
                    throw new Exception("No se encontro registro de usuario");
                }
                $this->idUsuario = $tempUsuario["usercod"];
                $this->correo = $tempUsuario["useremail"];
                $this->nombreUsuario = $tempUsuario["username"];
                $this->contrasena = $tempUsuario["userpswd"];
                $this->fechaCreacion = $tempUsuario["userfching"];
                $this->estadoContrasena = $tempUsuario["userpswdest"];
                $this->fechaExpContrasena = $tempUsuario["userpswdexp"];
                $this->estadoUsuario = $tempUsuario["userest"];
                $this->codigoActivacion = $tempUsuario["useractcod"];
                $this->codigoCambioContrasena = $tempUsuario["userpswdchg"];
                $this->tipoUsuario = $tempUsuario["usertipo"];
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombreUsuario);
        }

        $viewData["usercod"] = $this->idUsuario;
        $viewData["useremail"] = $this->correo;
        $viewData["username"] = $this->nombreUsuario;
        $viewData["userpswd"] = $this->contrasena;
        $viewData["userfching"] = $this->fechaCreacion;
        $viewData["userpswdest"] = $this->estadoContrasena;
        $viewData["userpswdexp"] = $this->fechaExpContrasena;
        $viewData["userest"] = $this->estadoUsuario;
        $viewData["useractcod"] = $this->codigoActivacion;
        $viewData["userpswdchg"] = $this->codigoCambioContrasena;
        $viewData["usertipo"] = $this->tipoUsuario;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;


        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->tokenValidation;


        $viewData["idReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->estadoContrasena] = "selected";
        $viewData["selected" . $this->estadoUsuario] = "selected";
        $viewData["selected" . $this->tipoUsuario] = "selected";

        return $viewData;
    }

    private function validarPostData(): array
    {
        $errores = [];

        $this->tokenValidation = $_POST["xrl8"] ?? "";
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->tokenValidation) {
            throw new Exception("Error de Validación de Token, no hackeable :(");
        }

        $this->idUsuario = intval($_POST["codigo"] ?? '');
        $this->correo = $_POST["correo"] ?? '';
        $this->nombreUsuario = $_POST["nombre"] ?? '';
        $this->contrasena = $_POST["contrasena"] ?? '';
        $this->fechaCreacion = $_POST["fechaCreacion"] ?? '';
        $this->estadoContrasena = $_POST["estadoContrasena"] ?? '';
        $this->fechaExpContrasena = $_POST["fechaExpContrasena"] ?? '';
        $this->estadoUsuario = $_POST["estadoUsuario"] ?? '';
        $this->codigoActivacion = $_POST["codigoActivacion"] ?? '';
        $this->codigoCambioContrasena = $_POST["codigoCambioContrasena"] ?? '';
        $this->tipoUsuario = $_POST["tipoUsuario"] ?? '';


        //Validaciones de campos vacios
        if (Validators::IsEmpty($this->idUsuario)) {
            $errores[] = "ID no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->correo)) {
            $errores[] = "Correo no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->nombreUsuario)) {
            $errores[] = "Nombre no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->contrasena)) {
            $errores[] = "Contraseña no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->fechaCreacion)) {
            $errores[] = "Fecha no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->estadoContrasena)) {
            $errores[] = "Estado no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->fechaExpContrasena)) {
            $errores[] = "Fecha EXP no puede ir vacia.";
        }
        if (Validators::IsEmpty($this->estadoUsuario)) {
            $errores[] = "Estado no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->codigoActivacion)) {
            $errores[] = "Codigo Activación no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->codigoCambioContrasena)) {
            $errores[] = "Codigo Cambio no puede ir vacio.";
        }
        if (Validators::IsEmpty($this->tipoUsuario)) {
            $errores[] = "Tipo no puede ir vacio.";
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
                                $affectedRows = DAOUsuario::crearUsuario(
                                    $this->idUsuario,
                                    $this->correo,
                                    $this->nombreUsuario,
                                    $this->contrasena,
                                    $this->fechaCreacion,
                                    $this->estadoContrasena,
                                    $this->fechaExpContrasena,
                                    $this->estadoUsuario,
                                    $this->codigoActivacion,
                                    $this->codigoCambioContrasena,
                                    $this->tipoUsuario,
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(USUARIOL, "Nuevo Usuario creado satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAOUsuario::actualizarUsuario(
                                    $this->idUsuario,
                                    $this->correo,
                                    $this->nombreUsuario,
                                    $this->contrasena,
                                    $this->fechaCreacion,
                                    $this->estadoContrasena,
                                    $this->fechaExpContrasena,
                                    $this->estadoUsuario,
                                    $this->codigoActivacion,
                                    $this->codigoCambioContrasena,
                                    $this->tipoUsuario,
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(USUARIOL, "Usuario actualizado satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAOUsuario::eliminarUsuario(
                                    $this->idUsuario
                                );

                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(USUARIOL, "Usuario eliminado satisfactoriamente.");
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
                USUARIO_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(USUARIOL, "Sucedió un problema. Reintente de nuevo.");
        }
    }
}
