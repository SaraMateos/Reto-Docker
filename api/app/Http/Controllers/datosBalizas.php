<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baliza;

class datosBalizas extends Controller {
    
    public function cogerDatos() {

        $aino = date("Y");
        $mes = date("m");
        $dia = date("d");

        /*$curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, "https://euskalmet.beta.euskadi.eus/vamet/stations/stationList/stationList.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = utf8_encode(curl_exec($curl));
        if (curl_errno($curl)) { 
            print curl_error($curl); 
        } 
        curl_close($curl);*/

        $url = 'https://euskalmet.beta.euskadi.eus/vamet/stations/stationList/stationList.json'; // ruta de ref. al JSON
        $data = file_get_contents($url); // put the contents of the file into a variable
        $balizas = json_decode($data, true, 512, JSON_INVALID_UTF8_IGNORE);

       // $balizas = json_decode($response, true);

        foreach($balizas as $baliza) {

            if ($baliza["stationType"]=="METEOROLOGICAL") {
                
                $datBalizas = [
                    'id' => $baliza["id"],
                    'nombre' => $baliza["name"],
                    'municipio' => $baliza["municipality"],
                    'provincia' => $baliza["province"],
                    'altitud' => $baliza["altitude"],
                    'longitud' => $baliza["x"],
                    'latitud' => $baliza["y"],
                    'tipo' => $baliza["stationType"]
                ];

                //return Baliza::all();

                Baliza::create($datBalizas);

                $datBalizas = json_decode($response, true);
                var_dump($datBalizas);

            }

            /*if ($baliza["stationType"]=="METEOROLOGICAL") {
                
                $nomBaliza = $baliza["id"];

                $curl2 = curl_init();

                curl_setopt($curl2, CURLOPT_URL, "https://euskalmet.beta.euskadi.eus/vamet/stations/readings/" . $nomBaliza . "/" . $aino . "/" . $mes . "/" . $dia . "/readingsData.json");
                curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);

                $response = utf8_encode(curl_exec($curl2));

                if (curl_errno($curl2)) { 
                    print curl_error($curl2); 
                } 

                curl_close($curl2);

                $datosBalizas = json_decode($response, true);
                var_dump($datosBalizas);
            }*/
        }
    }
}