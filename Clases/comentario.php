<?php

class comentario{

      public static function crear_comentario($comentario, $post_id, $id_persona){

            $pk_comentarios = 1+DB::query('SELECT MAX(PK) AS pkt FROM comentarios', array())[0]['pkt'];

            if (strlen($comentario) > 500 ||  strlen($comentario) < 1) {
                  die("mal numero de caracteres");
            }

            if (!DB::query('SELECT pk FROM publicaciones_persona WHERE pk = :post_id',  array(':post_id' => $post_id ))) {
                  echo "ID de post malo";
            }else {
                  DB::query('INSERT INTO comentarios VALUES (:pk , :comentario ,:id_escritor , NOW(), :post_id)',
                  array(':pk' => $pk_comentarios, ':comentario'=> $comentario,':id_escritor'=>$id_persona ,':post_id'=>$post_id  ));
            }
      }


      public static function mostrar_comentarios($post_id){

          $comentarios = DB::query('SELECT comentarios.comentario, personas.nombre FROM comentarios, personas
            WHERE comentarios.post_id = :post_id AND comentarios.id_escritor = personas.id_persona '
            ,  array(':post_id' => $post_id ));

            echo "<div class='comments text-muted'>";

            foreach ($comentarios as $comentario) {

                  echo "<b>".$comentario["nombre"]."</b> ".$comentario["comentario"]."
                      <br>";
            }
            echo "</div>";

            //echo $comentario["comentario"]." ~ ".$comentario["nombre"]."<hr />";


      }


}

?>
