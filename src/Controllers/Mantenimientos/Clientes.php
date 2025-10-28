<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Clientes\Clientes as ClienteDao;

class Clientes extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $tmpClientes = ClienteDao::obtenerClientes(); //le asignamos una llave a los datos obtenidos del metodo de dao
        $viewData["clientes"] = [];
        $totalNota = 0;
        foreach ($tmpClientes as $cliente) {
            $clienteNormalizado = $cliente;
            $clienteNormalizado["nota"] = $cliente["evaluacion"] / 100 * 5;
            $totalNota += $clienteNormalizado["nota"]; //totalNota = totalNota+clienteNormalizado["nota"]

            //La valoracion en 100 la convertimos a valoracion en 5 para categorizar en letras alfabeticas
            if ($clienteNormalizado["nota"] > 4.5) {
                $clienteNormalizado["grado"] = "A";
            } elseif ($clienteNormalizado["nota"] > 4.0) {
                $clienteNormalizado["grado"] = "B";
            } elseif ($clienteNormalizado["nota"] > 3.5) {
                $clienteNormalizado["grado"] = "C";
            } elseif ($clienteNormalizado["nota"] > 3.0) {
                $clienteNormalizado["grado"] = "D";
            } elseif ($clienteNormalizado["nota"] > 2.5) {
                $clienteNormalizado["grado"] = "E";
            } else {
                $clienteNormalizado["grado"] = "F";
            }

            $viewData["clientes"][] = $clienteNormalizado; //adjuntamos un nuevo elemento
        }
        $viewData["total"] = count($viewData["clientes"]); //contamos la cantidad de elementos con una llave diferente para su uso en la vista
        $viewData["totalNota"] = $totalNota;
        $viewData["promedioNota"] = number_format($totalNota / $viewData["total"], 2);

        Renderer::render("mantenimientos/clientes/lista", $viewData); //la direccion de la vista
    }
}
