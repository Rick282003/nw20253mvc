<?php

namespace Controllers\EstudiantesPractica;

use Controllers\PublicController;
use Dao\EstudiantesPractica\Estudiantes as DAOEstudiante;
use Views\Renderer;

class EstudiantesList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["estudiantes"] = DAOEstudiante::obtenerEstudiantes();
        Renderer::render("estudiantesPractica/estudiantes/lista", $viewData);
    }
}
