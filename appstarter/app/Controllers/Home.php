<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('header').view('Grafico');
    }

    public function listar()
    {
        $indicador = $this->request->getVar('indicador');
        $fechaInicio = $this->request->getVar('fechaInicio');
        $fechaFin = $this->request->getVar('fechaFin');

        $dates = array();
        $inicio = strtotime($fechaInicio);
        $fin = strtotime($fechaFin);

        while( $inicio <= $fin ) {

            $dates = date('d-m-Y', $inicio);
            $inicio = strtotime('+1 day', $inicio);

            $apiUrl = 'https://mindicador.cl/api/'.$indicador."/".$dates;
            $json = file_get_contents($apiUrl);

            $valores[] = "";

            $data = json_decode($json);
            if ( count($data->serie) <= 0) {
                
            }else {
                $valores[] = array(
                    'indicador' => $data->codigo,
                    'unidad' => $data->unidad_medida,
                    'valor' => $data->serie[0]->valor,
                    'fecha' => $data->serie[0]->fecha          
                );
            }

            
        }

        echo json_encode($valores);
    }
}
