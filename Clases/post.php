<?php

class post{

      public static function crear_post($cuerpo, $id_usuario_logueado, $id_persona){
            $likes = 0;
            $pk_publicaciones = 1+DB::query('SELECT MAX(PK) AS pkt FROM publicaciones_persona', array())[0]['pkt'];

            if (strlen($cuerpo) > 500 ||  strlen($cuerpo) < 1) {
                  die("mal numero de caracteres");
            }

            $topic = self::obtener_topic($cuerpo);
            if ($id_usuario_logueado == $id_persona) {

                    if (count(notificar::crear_notificacion($cuerpo)) != 0) {

                            foreach (notificar::crear_notificacion($cuerpo) as $key => $p) {
                                  $pk_notificaciones = 1+DB::query('SELECT MAX(PK) AS pkt FROM notificaciones', array())[0]['pkt'];
                                  $r = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',  array(':nombre' => $key ))[0]['id_persona'];
                                  $d = $id_usuario_logueado;

                                  if ($r != 0) {
                                        DB::query('INSERT INTO notificaciones VALUES (:pk, :tipo, :id_destino, :id_destinatario, :informacion)'
                                              ,array(':pk' => $pk_notificaciones, ':tipo'=> $p['tipo'], ':id_destino'=>$r, ':id_destinatario'=>$d, ':informacion'=>$p['informacion'] ));
                                  }

                            }

                    }

                    DB::query('INSERT INTO publicaciones_persona VALUES (:pk, :cuerpo , NOW() , :likes, :id_usuario, NULL, :topic)'
                    ,array(':pk' => $pk_publicaciones, ':cuerpo'=>$cuerpo, ':likes'=>$likes, ':id_usuario'=>$id_usuario_logueado, ':topic' => $topic ));

            }else {
                  die("usuario equivodado");
            }
      }


      public static function crear_post_imagen($cuerpo, $id_usuario_logueado, $id_persona){

            $likes = 0;
            $pk_publicaciones = 1+DB::query('SELECT MAX(PK) AS pkt FROM publicaciones_persona', array())[0]['pkt'];

            if (strlen($cuerpo) > 500) {
                  die("mal numero de caracteres");
            }

            $topic = self::obtener_topic($cuerpo);
            if ($id_usuario_logueado == $id_persona) {

                    if (count(notificar::crear_notificacion($cuerpo)) != 0) {

                            foreach (notificar::crear_notificacion($cuerpo) as $key => $p) {
                                  $pk_notificaciones = 1+DB::query('SELECT MAX(PK) AS pkt FROM notificaciones', array())[0]['pkt'];
                                  $r = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',  array(':nombre' => $key ))[0]['id_persona'];
                                  $d = $id_usuario_logueado;

                                  if ($r != 0) {
                                        DB::query('INSERT INTO notificaciones VALUES (:pk, :tipo, :id_destino, :id_destinatario, :informacion)'
                                              ,array(':pk' => $pk_notificaciones, ':tipo'=> $p['tipo'], ':id_destino'=>$r, ':id_destinatario'=>$d, ':informacion'=>$p['informacion'] ));
                                  }

                            }

                    }

                    DB::query('INSERT INTO publicaciones_persona VALUES (:pk, :cuerpo , NOW() , :likes, :id_usuario, NULL, :topic)'
                    ,array(':pk' => $pk_publicaciones, ':cuerpo'=>$cuerpo, ':likes'=>$likes, ':id_usuario'=>$id_usuario_logueado, ':topic' => $topic));

                    $post_id = DB::query('SELECT pk FROM publicaciones_persona WHERE id_usuario = :id_usuario ORDER BY pk DESC LIMIT 1',  array(':id_usuario' => $id_usuario_logueado ))[0]['pk'];
                    return $post_id;
            }else {
                  die("usuario equivodado");
            }


      }



      public static function like_post($post_id, $id_persona){

            if (!DB::query('SELECT id_persona FROM post_likes WHERE post_id = :post_id AND id_persona = :id_persona',array('post_id' => $post_id, ':id_persona'=>$id_persona))) {

                  $pk_publicaciones_like = 1+DB::query('SELECT MAX(pk) AS pkt FROM post_likes', array())[0]['pkt'];

                  DB::query('UPDATE publicaciones_persona SET likes = likes+1 WHERE PK = :PK',array(':PK'=>$post_id));
                  DB::query('INSERT INTO post_likes VALUES (:pk, :post_id, :id_persona)',  array(':pk' =>$pk_publicaciones_like, ':post_id' => $post_id, ':id_persona'=>$id_persona));
                  notificar::crear_notificacion("",$post_id);
            }else {
                  DB::query('UPDATE publicaciones_persona SET likes = likes-1 WHERE PK = :PK',array(':PK'=>$post_id));
                  DB::query('DELETE FROM post_likes WHERE post_id = :post_id AND id_persona = :id_persona',  array(':post_id' => $post_id, ':id_persona'=>$id_persona));
            }
      }



      public static function link_add($texto){

            $texto = explode(" ", $texto);
            $aux_string = "";

            foreach ($texto as $palabra) {
                  if (substr($palabra,0,1) == '@') {
                        $aux_string .= "<a href='perfil.php?nombre=".substr($palabra,1)."'>".htmlspecialchars ($palabra)."</a>";
                  }elseif (substr($palabra,0,1) == '#') {
                        $aux_string .= "<a href='topics.php?topic=".substr($palabra,1)."'>".htmlspecialchars ($palabra)."</a>";
                  }else{
                        $aux_string .= htmlspecialchars ($palabra)." ";
                  }
            }
            return  $aux_string;
      }


      public static function obtener_topic($texto){

            $texto = explode(" ", $texto);
            $topics = "";

            foreach ($texto as $palabra) {
                  if (substr($palabra,0,1) == '#') {
                        $topics .= substr($palabra,1).",";
                  }
            }

            return  $topics;
      }



      public static function mostrar_posts($id_persona, $nombre_usuario, $id_usuario_logueado){

            $dbposts = DB::query('SELECT * FROM publicaciones_persona WHERE id_usuario = :id_usuario ORDER BY pk DESC',  array(':id_usuario' => $id_persona));
            $posts = "";
            foreach ($dbposts as $p) {
                    $aux_nombre =  DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => $p['id_usuario']))[0]['nombre'];
                    if (!DB::query('SELECT post_id FROM post_likes WHERE post_id = :post_id AND id_persona = :id_persona',array('post_id' => $p['PK'], ':id_persona'=> $id_usuario_logueado))){
                          $post.= "<div class='feed'>
                                <div class='head'>
                                    <div class='user'>
                                        <div class='profile-photo'>
                                            <img src='".$p['foto']."'>
                                        </div>
                                        <div class='ingo'>
                                            <h3>".$aux_nombre."</h3>
                                        </div>
                                    </div>
                                    <span class='edit'>
                                        <i class='uil uil-ellipsis-h'></i>
                                    </span>
                                </div>";

                          if (strlen($p['foto'])>1) {
                              $posts.="
                                    <div class='bookmark' style='float:right;'>
                                    <span><i class='uil uil-bookmark-full'></i></span>
                                    </div>
                                          <div class='photo'>
                                        <img src='".$p['foto']."' >
                                        </div>";
                          }

                          $posts .= "<div class='action-buttons'>
                                    <div class='interaction button'>
                                    
                                </div>
                                <div class='caption'>
                                    <p><b>".$aux_nombre.":</b> ".$p['cuerpo'].".
                                </div>
                                <div class='liked-by'>
                                    <p>Liked ".$p['likes']." personas</b></p>
                                </div>
                                <div class='comments text-muted'>
                                </div></div>";

                          //-----------------------------------------
                          /*
                          $posts .= "<img src='".$p['foto']."'>".self::link_add($p['cuerpo'])."
                          <form action='perfil.php?nombre=$nombre_usuario&post_id=".$p['PK']."' method='post'>
                          <input type='submit' name='like' value='Like'>
                          <span>" .$p['likes']." likes</span>";
                          if ($id_persona == $id_usuario_logueado) {
                                $posts .="<input type='submit' name='eliminar_post' value='Eliminar'>";
                          }
                          $posts .="
                          </form><hr /></br />";*/
                    }else{
                      $post.= "<div class='feed'>
                            <div class='head'>
                                <div class='user'>
                                    <div class='profile-photo'>
                                        <img src='".$p['foto']."'>
                                    </div>
                                    <div class='ingo'>
                                        <h3>".$aux_nombre."</h3>
                                    </div>
                                </div>
                                <span class='edit'>
                                    <i class='uil uil-ellipsis-h'></i>
                                </span>
                            </div>";

                      if (strlen($p['foto'])>1) {
                          $posts.="<div class='photo'>
                                    <img src='".$p['foto']."' >
                                    </div>";
                      }

                      $posts .= "<div class='action-buttons'>
                                <div class='interaction button'>
                                <div class='bookmark'>
                                    <span><i class='uil uil-bookmark-full'></i></span>
                                </div>
                            </div>
                            <div class='caption'>
                                <p><b>".$aux_nombre.":</b> ".$p['cuerpo'].".
                            </div>
                            <div class='liked-by'>
                                <p>Liked ".$p['likes']." personas</b></p>
                            </div>
                            <div class='comments text-muted'>
                            </div></div>";


                          //----------------------------------
                          /*
                          $posts .=  "<img src='".$p['foto']."'>".self::link_add($p['cuerpo'])."
                          <form action='perfil.php?nombre=$nombre_usuario&post_id=".$p['PK']."' method='post'>
                          <input type='submit' name='dislike' value='Dislike'>
                          <span>" .$p['likes']." likes</span>";
                          if ($id_persona == $id_usuario_logueado) {
                                $posts .="<input type='submit' name='eliminar_post' value='Eliminar'>";
                          }
                          $posts .="
                          </form><hr /></br />";*/
                    }


            }

            return $posts;
      }




}

?>
