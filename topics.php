<?php
include('Clases/DB.php');
include('Clases/log_check.php');
include('Clases/post.php');
include('Clases/imagenes.php');

$nombre_usuario = "";
$seguido = false;
if(isset($_GET['topic'])){

      if (DB::query('SELECT topic FROM publicaciones_persona WHERE FIND_IN_SET(:topic, topic)',  array(':topic' => $_GET['topic']))) {
            $posts = DB::query('SELECT * FROM publicaciones_persona WHERE FIND_IN_SET(:topic, topic)',  array(':topic' => $_GET['topic']));
            foreach ($posts as $post) {
                echo $post['cuerpo']."<br />";
            }
      }
}

 ?>
