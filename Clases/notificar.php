<?php

class notificar{

      public static function crear_notificacion($texto = "", $post_id = 0){

            $aux = False;
            if ($texto == "") {$aux = True;}

            $texto = explode(" ", $texto);
            $notificara = array();

            foreach ($texto as $palabra) {
                  if (substr($palabra,0,1) == '@') {
                        $notificara[substr($palabra,1)] = array("tipo" => 1, "informacion"=> '{  "cuerpo": "'.htmlentities(implode(" ",$texto)).'"  }');
                  }
            }

            if ($aux && $post_id != 0) {
                  $temp = DB::query('SELECT publicaciones_persona.id_usuario AS destino , post_likes.id_persona AS destinatario FROM publicaciones_persona, post_likes WHERE publicaciones_persona.pk = post_likes.post_id AND publicaciones_persona.pk = :post_id', array(':post_id' => $post_id ));
                  $pk_notificaciones = 1+DB::query('SELECT MAX(pk) AS pkt FROM notificaciones', array())[0]['pkt'];
                  DB::query('INSERT INTO notificaciones VALUES (:pk, :tipo, :id_destino, :id_destinatario, :informacion)',array(':pk' => $pk_notificaciones, ':tipo'=> 2, ':id_destino'=>$temp[0]['destino'], ':id_destinatario'=>$temp[0]['destinatario'], ':informacion'=>"" ));
            }
            return $notificara;
      }

}

 ?>
