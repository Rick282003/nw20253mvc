<?php

namespace Controllers\Rutas;

use Controllers\PublicController;
use Dao\Rutas\Rutas as DAORutas;
use Views\Renderer;

class RutasList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["rutas"] = DAORutas::obtenerRutas();
        Renderer::render("rutas/lista", $viewData);
    }
}
