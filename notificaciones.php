<?php

include('Clases/DB.php');
include('Clases/log_check.php');


if(log_check::logeado()){
      $id_persona = log_check::logeado();
}else
      header ("Location: index.html");

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
                         <h4><?php echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre']; ?></h4>
                         <p class="text-muted">
                             @<?php echo DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => log_check::logeado()))[0]['nombre']; ?>
                         </p>
                     </div>
                 </a>
                 <!----================= SIDEBAR =================--->
                 <div class="sidebar">
                     <a class="menu-item"  id="home">
                         <span><i class="uil uil-home"></i></span> <h3>Home</h3>
                     </a>
                     
                     <a class="menu-item active" id="notifications">
                         <span><i class="uil uil-bell"></i></span> <h3>Notifications</h3>
                     </a>

                     

                     <!--<a class="menu-item">
                         <span><i class="uil uil-bookmark"></i></span> <h3>Bookmarks</h3>
                     </a>


                     <a class="menu-item">
                         <span><i class="uil uil-chart-line"></i></span> <h3>Analytics</h3>
                     </a>-->

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
                 <!--
                 <div class="stories">
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-1.jpg">
                         </div>
                         <p class="name">Your Story</p>
                     </div>
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-9.jpg">
                         </div>
                         <p class="name">Lilla James</p>
                     </div>
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-10.jpg">
                         </div>
                         <p class="name">Winnie Hale</p>
                     </div>
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-11.jpg">
                         </div>
                         <p class="name">Daniel Bale</p>
                     </div>
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-12.jpg">
                         </div>
                         <p class="name">Jane Doe</p>
                     </div>
                     <div class="story">
                         <div class="profile-photo">
                             <img src="./assets/images/profile-13.jpg">
                         </div>
                         <p class="name">Tina White</p>
                     </div>
                 </div>
                 <!----================= END STORIES =================--->
                 


                 <!----================= FEEDS =================--->

                 <div class="feeds">
                     <!----================= FEED =================--->


                     <?php
                     if (DB::query('SELECT * FROM notificaciones WHERE id_destino = :destino',  array(':destino' => $id_persona))) {
                           $notificaciones = DB::query('SELECT * FROM notificaciones WHERE id_destino = :destino ORDER BY pk',  array(':destino' => $id_persona));

                           foreach ($notificaciones as $notificacion) {
                                 if ($notificacion['tipo'] == 1) {
                                       $destinatario = DB::query('SELECT nombre,foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => $notificacion['id_destinatario']))[0];
                                       if ($notificacion['informacion'] == "") {
                                              $aux_foto = DB::query('SELECT foto_perfil FROM personas WHERE id_persona = :id_persona', array(':id_persona' => $id_persona ))[0]['foto_perfil'];

                                             echo "<div class='feed'>
                                                 <div class='head'>
                                                     <div class='user'>
                                                         <div class='profile-photo'>
                                                             <img src='".$aux_foto."'>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class='caption'>
                                                     <p><b> Tienes una notificacion.
                                                 </div>
                                                 </div>";

                                       }else{
                                             $info = json_decode($notificacion['informacion']);
                                            // echo $destinatario." te ha mencionado en un post - ".$info->cuerpo."<hr />";

                                             echo "<div class='feed'>
                                                 <div class='head'>
                                                     <div class='user'>
                                                         <div class='profile-photo'>
                                                             <img src='".$destinatario['foto_perfil']."'>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class='caption'>
                                                     <p><b>".$destinatario['nombre']." te ha mencionado en un post - ".$info->cuerpo.".
                                                 </div>
                                                 </div>";
                                       }
                                 }elseif ($notificacion['tipo'] == 2){
                                     //$destinatario = DB::query('SELECT nombre FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => $notificacion['id_destinatario']))[0]['nombre'];
                                     $destinatario = DB::query('SELECT nombre,foto_perfil FROM personas WHERE id_persona = :id_persona',  array(':id_persona' => $notificacion['id_destinatario']))[0];

                                     echo "<div class='feed'>
                                         <div class='head'>
                                             <div class='user'>
                                                 <div class='profile-photo'>
                                                     <img src='".$destinatario['foto_perfil']."'>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class='caption'>
                                             <p><b>A ".$destinatario['nombre']." le gusta tu post .
                                         </div>
                                         </div>";
                                 }
                           }
                     }


                      ?>


                     <!----================= END FEED =================--->
                 </div>
                 <!----================= END FEEDS =================--->
             </div>
             <!----================= END OF MIDDLE =================--->


             <!----================ RIGHT ==================--->
             <div class="right">
                 
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
