<?php
include('Clases/DB.php');
include('Clases/log_check.php');
include('Clases/imagenes.php');

if(log_check::logeado()){
      $id_persona = log_check::logeado();
      $mostrar_timeline = True;
}else
      header ("Location: index.html");

if (isset($_POST['subir_imagen'])) {

      imagenes::subir_imagen('UPDATE personas SET foto_perfil = :foto_perfil WHERE id_persona = :id_persona',array(':id_persona' => log_check::logeado()),'foto_perfil');

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
                    <a class="menu-item" id="profile">
                        <span><i class="uil uil-user-circle"></i></span> <h3>Perfil</h3>
                    </a>
                    
                    <a class="menu-item active" id="sub-photo">
                        <span><i class="uil uil-image-redo"></i></i></span> <h3>Subir foto</h3>
                    </a>
                    <a class="menu-item" id="password">
                        <span><i class="uil uil-key-skeleton"></i></span> <h3>Cambiar contras??a</h3>
                    </a>
                    <a class="menu-item" id="out">
                        <span><i class="uil uil-sign-out-alt"></i></span> <h3>Cerrar sesion</h3>
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
                <form class="create-post">
                    <div class="profile-photo">
                        <img src=<?php  echo DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['foto_perfil'];  ?>>
                    </div>


                </form>
                <form action="mi_cuenta.php" method="post" enctype="multipart/form-data" class="create-post">
                Subir una imagen de perfil:
                <input type="file" name="foto_perfil">
                <br>
                <input type="submit" name="subir_imagen" value="Subir" class="btn btn-primary">
                </form>

                <!----================= FEEDS =================--->



                <!----================= END OF FEEDS =================--->
                </div>
                <!----================= END FEEDS =================--->
            </div>
            <!----================= END OF MIDDLE =================--->


            <!----================ RIGHT ==================--->
            <div class="right">

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
