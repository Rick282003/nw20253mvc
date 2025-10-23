<?php

namespace Controllers;

use Controllers\PublicController;
use Views\Renderer;

//Nombre con Letra inicial mayuscula
class mantenimientoMenu extends PublicController
{
    public function run(): void
    {
        $arrmenus = [
            "items" => [
                [
                    "label" => "Productos",
                    "description" => "Productos de la Empresa",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Productos"
                ],
                [
                    "label" => "Categorias",
                    "description" => "Categoria del Producto de la Empresa",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Categorias"
                ],
                [
                    "label" => "Ofertas",
                    "description" => "Oferta del Producto de la Empresa",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Ofertas"
                ],
                [
                    "label" => "Cupones", //"Vouchers"
                    "description" => "Cupon de Producto de la Empresa",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Cupones"
                ],
            ]
        ];
        Renderer::render("mantenimientos", $arrmenus);
    }
}
