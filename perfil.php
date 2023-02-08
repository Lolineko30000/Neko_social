<?php

include('Clases/DB.php');
include('Clases/log_check.php');
include('Clases/post.php');
include('Clases/imagenes.php');
include('Clases/notificar.php');
include('Clases/comentario.php');

$nombre_usuario = "";
$seguido = false;

if (isset($_POST['postear'])) {
      if ($_FILES['foto']['size'] == 0) {
                post::crear_post($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
            }else {
                $post_id = post::crear_post_imagen($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
                imagenes::subir_imagen('UPDATE publicaciones_persona SET foto = :foto WHERE pk = :pk',  array(':pk' => $post_id), 'foto');
      }
}

if (isset($_GET['post_id'])) {
        post::like_post($_GET['post_id'],$id_persona);
}
if(isset($_GET['nombre'])){

      if(DB::query('SELECT nombre FROM personas WHERE nombre = :nombre',array(':nombre'=>$_GET['nombre']))){

            $nombre_usuario = DB::query('SELECT nombre FROM personas WHERE nombre = :nombre',array(':nombre'=>$_GET['nombre']))[0]['nombre'];
            $id_persona = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',array(':nombre'=>$_GET['nombre']))[0]['id_persona'];
            $id_seguidor = log_check::logeado();


            if (isset($_POST['seguir'])) {
                    if ($id_persona != $id_seguidor) {
                          if(!DB::query('SELECT id_seguidor FROM seguir WHERE id_persona = :id_persona  AND id_seguidor = :id_seguidor',array(':id_persona'=> $id_persona, ':id_seguidor'=> $id_seguidor ))){

                                  $pk_seguir = 1+DB::query('SELECT MAX(PK) AS pkt FROM seguir', array())[0]['pkt'];
                                  DB::query('INSERT INTO seguir VALUES (:pk, :id_persona, :id_seguidor)',array(':pk' => $pk_seguir, ':id_persona'=> $id_persona, ':id_seguidor'=> $id_seguidor ));
                          }else{
                                  echo "yastabas";
                          }
                          $seguido = True;
                    }else{
                          echo "aki";
                    }
            }

            elseif (isset($_POST['no_seguir'])) {
                  if ($id_persona != $id_seguidor) {
                        if(DB::query('SELECT id_seguidor FROM seguir WHERE id_persona = :id_persona  AND id_seguidor = :id_seguidor',array(':id_persona'=> $id_persona, ':id_seguidor'=> $id_seguidor )))
                                DB::query('DELETE FROM seguir WHERE id_persona = :id_persona AND id_seguidor = :id_seguidor',array(':id_persona'=> $id_persona, ':id_seguidor'=> $id_seguidor ));
                  }
                  $seguido = False;
            }

            if (isset($_POST['postea'])) {

                  if ($_FILES['foto']['size'] == 0) {
                        post::crear_post($_POST['cuerpo'], log_check::logeado(), $id_persona);
                  }else {
                        $post_id = post::crear_post_imagen($_POST['cuerpo'], log_check::logeado(), $id_persona);
                        imagenes::subir_imagen('UPDATE publicaciones_persona SET foto = :foto WHERE pk = :pk',  array(':pk' => $post_id), 'foto');
                  }

            }

            if (isset($_GET['post_id']) && !isset($_POST['eliminar_post'])) {
                    post::like_post($_GET['post_id'],$id_seguidor);
            }

            $posts = post::mostrar_posts($id_persona,$nombre_usuario,$id_seguidor);

            if(DB::query('SELECT id_seguidor FROM seguir WHERE id_persona = :id_persona  AND id_seguidor = :id_seguidor',array(':id_persona'=> $id_persona, ':id_seguidor'=> $id_seguidor ))){
                  $seguido = True;
            }

            if (isset($_POST['eliminar_post'])) {
                  if (DB::query('SELECT pk FROM publicaciones_persona WHERE pk = :pk AND id_usuario = :id_usuario', array(':pk' => $_GET['post_id'] , ':id_usuario'=> log_check::logeado() ))) {

                        DB::query('DELETE FROM publicaciones_persona WHERE  pk = :pk AND id_usuario = :id_usuario', array(':pk' => $_GET['post_id'] , ':id_usuario'=> log_check::logeado() ));
                        DB::query('DELETE FROM post_likes WHERE post_id = :post_id', array(':post_id' =>  $_GET['post_id']));
                  }
            }

      }else{
            die("Not found");
      }

}else{
    $nombre_usuario = DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',array(':id_persona'=>log_check::logeado()))[0]['nombre'];
    $id_persona = log_check::logeado();
    $id_seguidor = log_check::logeado();
    $posts = post::mostrar_posts($id_persona,$nombre_usuario,$id_seguidor);
}
if (isset($_POST['postear'])) {
      if ($_FILES['foto']['size'] == 0) {
                post::crear_post($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
            }else {
                $post_id = post::crear_post_imagen($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
                imagenes::subir_imagen('UPDATE publicaciones_persona SET foto = :foto WHERE pk = :pk',  array(':pk' => $post_id), 'foto');
      }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nekoSocial - f</title>
    <!--- Styleshet --->
    <link rel="stylesheet" href="./assets/css/estilosHome.css">
    <!--- iconscout cdn --->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
</head>
<body>
    <nav>
        <div class="container">
            <h2 class="log">
                nekoSocial
            </h2>
            <div class="search-bar">

            </div>
            <div class="create">

                <?php

                if (isset($_GET['nombre'])) {
                    if ($seguido) {
                          echo "<form action='perfil.php?nombre=".$_GET['nombre']."' method='post'>
                          <input type='submit' name='no_seguir'  value='Dejar de seguir a ".$_GET['nombre']."'   class='btn btn-primary'>
                          </from>";
                    }else{
                          echo "<form action='perfil.php?nombre=".$_GET['nombre']."' method='post'>
                          <input type='submit' name='seguir'  value=' Seguir a ".$_GET['nombre']."'   class='btn btn-primary'>
                          </from>";
                    }
                }

                ?>
                <div class="profile-picture">
                    <img src=<?php  echo DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['foto_perfil'];  ?>>
                </div>
            </div>
        </div>
    </nav>
    <!------------ MAIN ---------------->
    <main>
        <div class="container">
            <!----================ LEFT ==================--->
            <div class="left">
                <a class="profile">
                    <div class="profile-photo">
                        <img src=<?php  echo DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['foto_perfil'];  ?>>
                    </div>
                    <div class="handle">
                        <h4><?php  echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre'];  ?></h4>
                        <p class="text-muted">
                            @<?php  echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre'];  ?>
                        </p>
                    </div>
                </a>
                <!----================= SIDEBAR =================--->
                <div class="sidebar">
                    <a class="menu-item" id="home">
                        <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                    </a>
                    <a class="menu-item active" id="profile">
                        <span><i class="uil uil-user-circle"></i></span> <h3>Perfil</h3>
                    </a>
                    
                    <a class="menu-item" id="sub-photo">
                        <span><i class="uil uil-image-redo"></i></i></span> <h3>Subir foto</h3>
                    </a>
                    <a class="menu-item" id="password">
                        <span><i class="uil uil-key-skeleton"></i></span> <h3>Cambiar contrasña</h3>
                    </a>
                    <a class="menu-item" id="out">
                        <span><i class="uil uil-sign-out-alt"></i></span> <h3>Cerrar sesion</h3>
                    </a>
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span> <h3>Theme</h3>
                    </a>
                </div>
                <!----================= END OF SIDEBAR =================--->
                <label for="create-post" class="btn btn-primary">Create Post</label>
            </div>
            <!----================= END OF LEFT =================--->



            <!----================ MIDDLE ==================--->
            <div class="middle">
                <!----================ STORIES ==================--->
                                <!----================= END STORIES =================--->

                  <?php
                  if (!isset( $_GET['nombre'])) {
                      $fotito = DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['foto_perfil'];
                      echo "<form class='create-post' action='perfil.php' method='post' enctype='multipart/form-data'>
                          <div class='profile-photo'>
                              <img src=".$fotito.">
                          </div>
                          <input type='text' name='cuerpo_pst' placeholder='Postea uwu' id='create-post'>
                          <input type='file' name='foto'>
                          <input type='submit' name='postear' value='Post' class='btn btn-primary'>
                          <br>
                      </form>";

                  }
                  ?>

                <!----================= FEEDS =================--->

                <div class="feeds">
                    <!----================= FEED =================--->
                    <?php

                    echo $posts;

                    ?>
                    <!----================= END FEED =================--->
                </div>
                <!----================= END FEEDS =================--->
            </div>
            <!----================= END OF MIDDLE =================--->


            <!----================ RIGHT ==================--->
            <div class="right">


            </div>
            <!----================= END OF FRIENDS REQUESTS =================--->
            <!----================= END OF RIGHT =================--->
        </div>
    </main>
    <!----================= END OF MAIN =================--->
    <!----================= THEME CUSTOM =================--->
    <div class="customize-theme">
        <div class="card">
            <h2>Cutomize you view</h2>
            <p class="text-muted">Manage your font size, color, and background</p>
            <!----================= FONT SIZES =================--->
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2 active"></span>
                        <span class="font-size-3"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                <h3>Aa</h3>
                </div>
            </div>
            <!----================= PRIMARY COLORS =================--->
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>
            <!----================= BACKGROUND COLORS =================--->
            <div class="background">
                <h4>background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5>Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Light Out</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/homeScript.js"></script>
</body>
</html>
