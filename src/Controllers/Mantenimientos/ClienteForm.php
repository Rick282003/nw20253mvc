<?php
//http://localhost:8080/nw20253mvc/index.php?page=Mantenimientos-ClienteForm&mode=UPD
namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Utilities\Site;
use Exception;
use Views\Renderer;

//CONSTANTES
const CLIENTES_LIST = "index.php?page=Mantenimientos-ClientesL"; //Es la URL de la lista, es constante para no escribir repetidamente
const CLIENT_VIEW = "mantenimientos/clientes/form";
class ClienteForm extends PublicController
{
    /*
    1) Determinar como se llama este controlador (Modo). INS UPD DSP DEL 
    2) Obtener el registro del Modelo de Datos
    3) Si es un postback. Capturar los datos del formulario
    3.1 ) Validar los datos del formulario
    3.2 ) Aplicar el método segun el modo de la acción en la DB
    3.3 ) Enviar devuelta con mensaje a la lista
    4) Preparar la data para la vista
    5) Renderizar la vista
    */

    private $modes = [
        "INS" => "Nuevo Cliente",
        "UPD" => "Editando %s",
        "DPS" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';

    // 1)
    private function page_init() // Aqui vemos cual es el modo
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) //Usamos get porque extraemos de la URL, mode es variable, y validamos que el modo que se envia exista dentro de los modos
        {
            $this->mode = $_GET["mode"]; //El mode es igual a lo que viene en el formulario
        } else {
            throw new Exception("Valor de Mode no es Válido"); //Cortamos ejecucion y mostramos cadena de error
        }
    }

    // 4)
    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode; //La llave mode guarda la string de mode

        return $viewData;
    }


    public function run(): void
    {
        try { //try catch para capturar error
            $this->page_init(); //Aqui lo mandamos a llamar

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
