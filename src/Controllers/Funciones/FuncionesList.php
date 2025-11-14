<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Dao\Funciones\Funciones as DAOFunciones;
use Views\Renderer;

class FuncionesList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["funciones"] = DAOFunciones::obtenerFunciones();
        Renderer::render("funciones/lista", $viewData);
    }
}
