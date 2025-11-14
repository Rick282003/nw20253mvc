<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Dao\Roles\Roles as DAORoles;
use Views\Renderer;

class RolesList extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["roles"] = DAORoles::obtenerRoles();
        Renderer::render("roles/lista", $viewData);
    }
}
