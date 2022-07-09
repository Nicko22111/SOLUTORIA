<?php
namespace App\Controllers;

class Uf extends BaseController
{
    public function index()
    {
        return view('header').view('uf/historico');
        
    }

    public function listar()
    {
        $apiUrl = 'https://mindicador.cl/api/uf';
        $json = file_get_contents($apiUrl);

        $data = json_decode($json);
        $cantidad = count($data->serie);

        for ($i=0; $i < $cantidad; $i++) { 

            $valores[] = array(
                'indicador' => $data->codigo,
                'unidad' => $data->unidad_medida,
                'valor' => $data->serie[$i]->valor,
                'fecha' => date('d-m-Y', strtotime($data->serie[$i]->fecha))          
            );
        }
        
        echo json_encode($valores);
    }
}
