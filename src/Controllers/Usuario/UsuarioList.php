<?php

namespace Controllers\Usuario;

use Controllers\PublicController;
use Dao\Usuario\Usuario as DAOUsuario;
use Views\Renderer;

class UsuarioList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["usuario"] = DAOUsuario::obtenerUsuarios();
        Renderer::render("usuario/lista", $viewData);
    }
}
