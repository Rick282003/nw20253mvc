<?php

namespace Controllers\PeliculasPractica;

use Controllers\PublicController;
use Dao\PeliculasPractica\Peliculas as DAOPeliculas;
use Views\Renderer;

class PeliculasList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["peliculas"] = DAOPeliculas::obtenerPeliculas();
        Renderer::render("peliculasPractica/lista", $viewData);
    }
}
