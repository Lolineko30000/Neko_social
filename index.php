<?php
//C:\xampp\mysql\bin
//mysql.exe -u root -p

//https://imgur.com/#access_token=5d01b314dd05e1b046fe3054ffd37119609087a4&expires_in=315360000&token_type=bearer&refresh_token=bd17b106e26ef60347d3d98233f2ae7586c17ebc&account_username=Databasepyf&account_id=162414629

//access_token:5d01b314dd05e1b046fe3054ffd37119609087a4
//refresh_token:bd17b106e26ef60347d3d98233f2ae7586c17ebc
//id_client:4caf8023bd27940
//id_client_secret:6ac27941ab81b79350bd01b00446395f16f55c91

include('Clases/DB.php');
include('Clases/log_check.php');
include('Clases/post.php');
include('Clases/comentario.php');
include('Clases/notificar.php');
include('Clases/imagenes.php');

$mostrar_timeline = False;

if (isset($_POST['search'])) {
    $uwu = $_POST['busqueda'] ;
    header("Location: buscar.php?search=".$uwu."");
}


if (isset($_GET['none'])) {

        DB::query( 'DELETE FROM token WHERE id_persona = :id_persona' , array(':id_persona' => log_check::logeado()));
        setcookie('SNID','1',time()-1);
        setcookie('SNID_','1',time()-1);
        header ("Location: index.html");

}

if (isset($_POST['postear'])) {
      if ($_FILES['foto']['size'] == 0) {
                post::crear_post($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
            }else {
                $post_id = post::crear_post_imagen($_POST['cuerpo_pst'], log_check::logeado(), log_check::logeado());
                imagenes::subir_imagen('UPDATE publicaciones_persona SET foto = :foto WHERE pk = :pk',  array(':pk' => $post_id), 'foto');
      }
}

if(log_check::logeado()){
      $id_persona = log_check::logeado();
      $mostrar_timeline = True;
}else
      header ("Location: index.html");

if (isset($_GET['post_id'])) {
        post::like_post($_GET['post_id'],$id_persona);
}

if (isset($_POST['comenta'])) {
        comentario::crear_comentario($_POST['comentario'],$_GET['post_id'],$id_persona);
}
if (isset($_POST['busqueda'])) {
      $aux = explode(" ", $_POST['busqueda']);

      if (count($aux) == 1) {
            $aux = str_split($aux[0],2);
      }

      $where_cond = "";
      $params_arr = array(':nombre' => '%'.$_POST['busqueda'].'%' );

      for ($i=0; $i < count($aux); $i++) {
            $where_cond .= " OR nombre LIKE :u$i";
            $params_arr[":u$i"] =  $aux[$i];
      }
      $personas = DB::query('SELECT nombre FROM personas WHERE nombre LIKE :nombre '.$where_cond.'', $params_arr);
      //imprimir personas

      $where_cond = "";
      $params_arr = array(':cuerpo' => '%'.$_POST['busqueda'].'%' );
      for ($i=0; $i < count($aux); $i++) {
            $where_cond .= " OR cuerpo LIKE :p$i";
            $params_arr[":p$i"] =  $aux[$i];
      }
      $post = DB::query('SELECT cuerpo FROM publicaciones_persona WHERE cuerpo LIKE :cuerpo '.$where_cond.'', $params_arr);
      //imprimir post

}



?>
<!--
<form action="index.php" method="post">
  <input type="text" name="busqueda" value="">
  <input type="submit" name="buscar" value="Buscar">
</form>
-->

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
            <form class="create-post" action="index.php" method="post">
                    <i class="uil uil-search"></i>
                    <input type="text" name="busqueda" placeholder="Search" id="create-post">
                    <input type="submit" name="search" value="Buscar" class="btn btn-primary">
            </form>
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
                            @<?php  echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre'];   ?>
                        </p>
                    </div>
                </a>
                <!----================= SIDEBAR =================--->
                <div class="sidebar">
                    <a class="menu-item active">
                        <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                    </a>
                    <a class="menu-item" id="profile">
                        <span><i class="uil uil-user-circle"></i></span> <h3>Perfil</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                        <span><i class="uil uil-bell"></i></span> <h3>Notifications</h3>
                    </a>



                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span> <h3>Theme</h3>
                    </a>

                </div>
                <!----================= END OF SIDEBAR =================--->

            </div>
            <!----================= END OF LEFT =================--->



            <!----================ MIDDLE ==================--->
            <div class="middle">
                <!----================ STORIES ==================--->

                <!----================= END STORIES =================--->
                <form class="create-post" action="index.php" method="post" enctype="multipart/form-data">
                    <div class="profile-photo">
                        <img src=<?php  echo DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['foto_perfil'];  ?>>
                    </div>
                    <input type="text" name="cuerpo_pst" placeholder="Postea uwu" id="create-post">
                    <input type="file" name="foto">
                    <input type="submit" name="postear" value="Post" class="btn btn-primary">
                    <br>
                </form>


                <!----================= FEEDS =================--->

                <div class="feeds">
                    <!----================= FEED =================--->



                    <?php

                    $post_seguidos = DB::query('SELECT publicaciones_persona.cuerpo, publicaciones_persona.pk ,personas.nombre, publicaciones_persona.likes, publicaciones_persona.foto FROM personas, publicaciones_persona, seguir
                              WHERE publicaciones_persona.id_usuario = seguir.id_persona
                              AND personas.id_persona = publicaciones_persona.id_usuario
                              AND (seguir.id_seguidor = :id_seguidor)
                              ORDER BY publicaciones_persona.likes DESC',
                              array(':id_seguidor' => log_check::logeado() ));

                    $aux_nombre = DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre'];

                    foreach ($post_seguidos as $post) {
                            $aux_foto = DB::query('SELECT foto_perfil FROM personas WHERE nombre = :nombre', array(':nombre' => $post['nombre'] ))[0]['foto_perfil'];
                            $aux_foto_1 = DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona', array(':id_persona' => log_check::logeado() ))[0]['foto_perfil'];

                            echo "<div class='feed'>
                                <div class='head'>
                                    <div class='user'>
                                        <div class='profile-photo'>
                                            <img src='".$aux_foto."'>
                                        </div>
                                        <div class='ingo'>
                                            <h3>".$post['nombre']."</h3>
                                        </div>
                                    </div>
                                    <span class='edit'>
                                        <i class='uil uil-ellipsis-h'></i>
                                    </span>
                                </div>";

                                if ($post['foto'] || strlen($post['foto'])>1) {
                                    echo "<div class='photo'>
                                        <img src='".$post['foto']."'>
                                        </div>";
                                }

                                echo "<div class='action-buttons'>
                                    <div class='interaction button'>
                                    <form action='index.php?post_id=".$post['pk']."&name=".$aux_nombre."' method='post'></div>
                                    <div class='bookmark'>
                                        <span><i class='uil uil-bookmark-full'></i></span>
                                    </div>
                                </div>
                                <div class='caption'>
                                    <p><b>".$post['nombre'].":</b> ".$post['cuerpo'].".
                                </div>
                                <div class='liked-by'>
                                    <p>Liked ".$post['likes']." personas</b></p>
                                </div>
                                <div class='comments text-muted'>
                                </div>";

                                echo "<form action='index.php?post_id=".$post['pk']."' method='post'>";
                                if (!DB::query('SELECT post_id FROM post_likes WHERE post_id = :post_id AND id_persona = :id_persona',array('post_id' => $post['pk'], ':id_persona'=> $id_persona))){

                                        echo "<input type='submit' name='like' value='Me gusta' class='btn btn-primary'></div>";
                                }else{
                                        echo "<input type='submit' name='dislike' value='Ya no me gusta' class='btn btn-primary'></div>";
                                }
                                echo "<span>" .$post['likes']." likes</span>
                                </form>";

                            /*
                            <form action='index.php?postid=".$post['pk']."' method='post'>
                            <textarea name='comentario' rows='3' cols='50'></textarea>
                            <input type='submit' name='comenta' value='Comentar'>
                            </form>";*/
                            comentario::mostrar_comentarios($post['pk']);

                            echo "<form action='index.php?post_id=".$post['pk']."' class='create-post' method='post' style='display:flex;'>
                                  <div class='profile-photo' style='display:flex;'>
                                    <img src=".$aux_foto_1.">
                                  </div>
                                <input type='text' name='comentario' placeholder='Que piensas?' id='create-post'>
                                <input type='submit' name='comenta' value='enviar' class='btn btn-primary'>
                            </form>";


                    }

                    ?>

                    <!----================= END FEED =================--->
                </div>
                <!----================= END FEEDS =================--->
            </div>
            <!----================= END OF MIDDLE =================--->


            <!----================ RIGHT ==================--->
            <div class="right">

                    <!----================= MESSAGE =================--->

                <!----================= END OF MESSAGES =================--->

                <!----================= FRIENDS REQUESTS =================--->

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
