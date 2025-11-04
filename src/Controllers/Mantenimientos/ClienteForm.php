<?php
//http://localhost:8080/nw20253mvc/index.php?page=Mantenimientos-ClienteForm&mode=UPD
namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Exception;
use Views\Renderer;
use Dao\Clientes\Clientes as DAOClientes;

//CONSTANTES
const CLIENTES_LIST = "index.php?page=Mantenimientos-ClientesL"; //Es la URL de la lista, es constante para no escribir repetidamente
const CLIENT_VIEW = "mantenimientos/clientes/form";
class ClienteForm extends PublicController
{
    /*
    ✅1) Determinar como se llama este controlador (Modo). INS UPD DSP DEL 
    ✅2) Obtener el registro del Modelo de Datos
    ✅3) Si es un postback. Capturar los datos del formulario
    ✅3.1 ) Validar los datos del formulario
    3.2 ) Aplicar el método segun el modo de la acción en la DB
    3.3 ) Enviar devuelta con mensaje a la lista
    ✅4) Preparar la data para la vista
    ✅5) Renderizar la vista
    */

    private $modes = [
        "INS" => "Nuevo Cliente",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';

    private string $codigo = '';
    private string $nombre = '';
    private string $direccion = '';
    private string $telefono = '';
    private string $correo = '';
    private string $estado = '';
    private int    $evaluacion = 0;

    private array $errores = [];

    // 1)
    private function page_init() // Aqui vemos cual es el modo
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) //Usamos get porque extraemos de la URL, mode es variable, y validamos que el modo que se envia exista dentro de los modos
        {
            $this->mode = $_GET["mode"]; //El mode es igual a lo que viene en el formulario, obtenemos el modo
            //dependiendo del modo
            if ($this->mode !== "INS") { //si no es igual a insert extraemos la informacion
                $tempCodigo = '';
                if (isset($_GET["codigo"])) { //extraemos codigo si existe
                    $tempCodigo = $_GET["codigo"]; //si fuera numero se convierte con xval
                } else {
                    throw new Exception("Código no es Válido");
                }
                //Extraer dato de la DATABASE
                $tempCliente = DAOClientes::obtenerClientePorCodigo($tempCodigo); // devuelve un arreglo
                if (count($tempCliente) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->codigo = $tempCliente["codigo"];
                $this->nombre = $tempCliente["nombre"];
                $this->direccion = $tempCliente["direccion"];
                $this->telefono = $tempCliente["telefono"];
                $this->correo = $tempCliente["correo"];
                $this->estado = $tempCliente["estado"];
                $this->evaluacion = $tempCliente["evaluacion"];
            }
        } else {
            throw new Exception("Valor de Mode no es Válido"); //Cortamos ejecucion y mostramos cadena de error
        }
    }

    // 4)
    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode; //La llave mode guarda la string de mode

        $viewData["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") { //para mostrar el titulo
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombre);
        }

        $viewData["codigo"] = $this->codigo;
        $viewData["nombre"] = $this->nombre;
        $viewData["direccion"] = $this->direccion;
        $viewData["telefono"] = $this->telefono;
        $viewData["correo"] = $this->correo;
        $viewData["estado"] = $this->estado;
        $viewData["evaluacion"] = $this->evaluacion;

        $viewData["errores"] = $this->errores; //Para ver los errores
        $viewData["hasErrores"] = count($this->errores) > 0;

        return $viewData;
    }

    private function validarPostData(): array
    {
        $errores = [];

        //Capturamos datos del post
        $this->codigo = $_POST["codigo"] ?? ''; //si no existe se le asigna un valor por defecto
        $this->nombre = $_POST["nombre"] ?? '';
        $this->direccion = $_POST["direccion"] ?? '';
        $this->telefono = $_POST["telefono"] ?? '';
        $this->correo = $_POST["correo"] ?? '';
        $this->estado = $_POST["estado"] ?? 'ACT';
        $this->evaluacion = intval($_POST["evaluacion"] ?? '');

        //Hacemos las validaciones
        if (Validators::IsEmpty($this->nombre)) {
            $errores[] = "Nombre no puede ir vacio.";
        }

        if (!in_array($this->estado, ["ACT", "INA"])) {
            $errores[] = "Estado Incorrecto.";
        }
        //.........

        return $errores;
    }


    public function run(): void
    {
        try { //try catch para capturar error
            $this->page_init(); //Aqui lo mandamos a llamar
            if ($this->isPostBack()) { //metodo del framework
                $this->errores = $this->validarPostData();
                if (count($this->errores) === 0) {
                    try { //try catch para capturar error al hacer CRUD
                        switch ($this->mode) {
                            case "INS":
                                //Llamar a Dao para Ingresar
                                $affectedRows = DAOClientes::crearCliente(
                                    $this->codigo,
                                    $this->nombre,
                                    $this->direccion,
                                    $this->correo,
                                    $this->telefono,
                                    $this->estado,
                                    $this->evaluacion
                                ); //si es INS llamamos a la funcion de insertar en la tabla de clientes

                                if ($affectedRows > 0) { //si la variable que llama la funcion de insertar devuelve mas de 0 ejecuciones redirreciona a la lista y da un mensaje
                                    Site::redirectToWithMsg(CLIENTES_LIST, "Nuevo Cliente creado satisfactoriamente.");
                                }
                                break;

                            case "UPD":
                                //Llamar a Dao para Actualizar
                                $affectedRows = DAOClientes::actualizarCliente(
                                    $this->codigo,
                                    $this->nombre,
                                    $this->direccion,
                                    $this->correo,
                                    $this->telefono,
                                    $this->estado,
                                    $this->evaluacion
                                ); //si es UPD llamamos a la funcion de atualizar en la tabla de clientes

                                if ($affectedRows > 0) { //si la variable que llama la funcion de actualizar devuelve mas de 0 ejecuciones redirreciona a la lista y da un mensaje
                                    Site::redirectToWithMsg(CLIENTES_LIST, "Cliente actualizado satisfactoriamente.");
                                }
                                break;

                            case "DEL":
                                //Llamar a Dao para Eliminar
                                $affectedRows = DAOClientes::eliminarCliente(
                                    $this->codigo
                                ); //si es DEL llamamos a la funcion de eliminar en la tabla de clientes

                                if ($affectedRows > 0) { //si la variable que llama la funcion de eliminar devuelve mas de 0 ejecuciones redirreciona a la lista y da un mensaje
                                    Site::redirectToWithMsg(CLIENTES_LIST, "Cliente eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                        $this->errores[] = $err;
                    }
                }
            }

            // 5)
            Renderer::render(
                CLIENT_VIEW,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage()); //Propio de PHP
            Site::redirectToWithMsg(CLIENTES_LIST, "Sucedió un problema. Reintente de nuevo."); //Metodo propio del framework, es utilidad
            //Sirve para que muestre error como js y redireccione a la lista
        }
    }
}
