<?php

namespace Controllers;

use Controllers\PublicController;
use Views\Renderer;

class PuntoExtra extends PublicController
{
    public function run(): void
    {
        $arrDatos = [
            "items" => [
                [
                    "nombre" => "Richard Galo",
                    "cuenta" => "0615200300421",
                    "correo" => "richardgalo2003@gmail.com",
                    "colores" => [
                        "Rojo",
                        "Negro",
                        "Azul",
                        "Verde",
                        "Amarillo"
                    ]
                ],
                [
                    "nombre" => "Rick Gal",
                    "cuenta" => "0615200300421",
                    "correo" => "rick@gmail.com",
                    "colores" => [
                        "Rojo",
                        "Negro",
                        "Azul",
                        "Verde",
                        "Amarillo"
                    ]
                ]
            ]
        ];
        Renderer::render("puntoextra", $arrDatos);
    }
}
