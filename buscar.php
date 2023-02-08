<?php
include('Clases/DB.php');
include('Clases/log_check.php');
include('Clases/post.php');

if (isset($_GET['search'])) {
      $aux = explode(" ", $_GET['search']);

      if (count($aux) == 1) {
            $aux = str_split($aux[0],2);
      }

      $where_cond = "";
      $params_arr = array(':nombre' => '%'.$_GET['search'].'%' );

      for ($i=0; $i < count($aux); $i++) {
            $where_cond .= " OR nombre LIKE :u$i";
            $params_arr[":u$i"] =  $aux[$i];
      }
      $personas = DB::query('SELECT nombre,foto_perfil FROM personas WHERE nombre LIKE :nombre '.$where_cond.'', $params_arr);
}

if (isset($_POST['seguir'])) {
      $aux_p = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',array(':nombre'=>$p['nombre']))[0]['id_persona'];
      $pk_seguir = 1+DB::query('SELECT MAX(PK) AS pkt FROM seguir', array())[0]['pkt'];
      DB::query('INSERT INTO seguir VALUES (:pk, :id_persona, :id_seguidor)',array(':pk' => $pk_seguir, ':id_persona'=> $aux_p, ':id_seguidor'=> log_check::logeado() ));
}

elseif (isset($_POST['no_seguir'])) {
      $aux_p = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',array(':nombre'=>$p['nombre']))[0]['id_persona'];
      DB::query('DELETE FROM seguir WHERE id_persona = :id_persona AND id_seguidor = :id_seguidor',array(':id_persona'=> $aux_p, ':id_seguidor'=> log_check::logeado() ));
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
            <form class="create-post" action="index.php" method="post">
                    <i class="uil uil-search"></i>
                    <input type="text" name="busqueda" placeholder="Search" id="create-post">
                    <input type="submit" name="search" value="Buscar" class="btn btn-primary">
            </form>
            <div class="create">
                <form action="login.php" method="post">
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
                            <?php  echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre'];  ?>
                        </p>
                    </div>
                </a>
                <!----================= SIDEBAR =================--->
                <div class="sidebar">
                    <a class="menu-item active" id="home">
                        <span><i class="uil uil-home"></i></span> <h3>Home</h3>
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



                <!----================= FEEDS =================--->

                <div class="feeds">
                    <!----================= FEED =================--->
                    <!---post-->

                    <!---post-->
                    <!---Personas a seguir-->
                    <?php
                    if ($personas) {
                        foreach ($personas as $p) {
                            $aux_p = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre',array(':nombre'=>$p['nombre']))[0]['id_persona'];

                            echo "<form class='create-post' action=?search".$_GET['search'].">
                                    <div class='profile-photo' >
                                        <img src=".$p['foto_perfil'].">
                                    </div>
                                        <h4><a href='perfil.php?nombre=".$p['nombre']."'>@".$p['nombre']."</a></h4>
                                  </form>";

                        }
                    }
                    ?>
                    <!--
                    <form class="create-post">
                            <div class="profile-photo" >
                                <img src="./assets/images/profile-1.jpg">
                            </div>
                                <h4>Diana Ayi</h4>
                                <p class="text-muted">
                                    @dayi
                                </p>
                        <input type="submit" value="Seguir" class="btn btn-primary">
                    </form>-->
                    <!---Personas a seguir-->

                    <!----================= END FEED =================--->
                </div>
                <!----================= END FEEDS =================--->
            </div>
            <!----================= END OF MIDDLE =================--->


            <!----================ RIGHT ==================--->
            <div class="right">

                </div>
                <!----================= END OF MESSAGES =================--->

                <!----================= FRIENDS REQUESTS =================--->

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
