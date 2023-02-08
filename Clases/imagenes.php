<?php

class imagenes{

      public static function subir_imagen($query, $params, $fuente){

            $imagen = base64_encode(file_get_contents($_FILES[$fuente]['tmp_name']));

            $opciones =  array('http' =>array(
                  'method'=>"POST",
                  'header'=>"Authorization: Bearer 5d01b314dd05e1b046fe3054ffd37119609087a4\n".
                  "Content-Type: application/x-www-form-urlencode",
                  'content'=>$imagen
            ));

            $imgur_URL = "https://api.imgur.com/3/image";
            $context = stream_context_create($opciones);

            if ($_FILES[$fuente]['size'] > 10240000) {
                  die('Imagen demasiado grande, 10Mb <');
            }

            $response = file_get_contents($imgur_URL, false, $context);
            $response = json_decode($response);

            $re_params =  array($fuente => $response->data->link);
            $params = $re_params + $params;

            DB::query($query, $params);


      }

}
?>
