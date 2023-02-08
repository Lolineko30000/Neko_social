<?php
include('Clases/DB.php');

if(isset($_POST['login'])){
        $nombre_usuario = $_POST['username'];
        $contrasenia = $_POST['password'];

        if (DB::query('SELECT nombre FROM personas WHERE nombre = :nombre', array(':nombre' => $nombre_usuario ))) {
            $aux = DB::query('SELECT contrasenia FROM personas WHERE nombre = :nombre', array(':nombre' => $nombre_usuario ))[0]['contrasenia'];
            if(password_verify($contrasenia,$aux)){

                $aux_token = True;
                $token = bin2hex(openssl_random_pseudo_bytes(100, $aux_token));
                $id_usuario = DB::query('SELECT id_persona FROM personas WHERE nombre = :nombre', array(':nombre' => $nombre_usuario ))[0]['id_persona'];

                DB::query('INSERT INTO token VALUES (:token , :id_persona)',array(':token'=>sha1($token),':id_persona'=>$id_usuario));

                setcookie("SNID",$token, time() + 2592000, '/', NULL, NULL,TRUE);
                setcookie("SNID_",'1', time() +  604800, '/', NULL, NULL,TRUE);

                header ("Location: index.php?id=".$id_usuario."&name=".$nombre_usuario."");
                //header ("Location: homepage.php");
            }else{
                header ("Location: index.html");
            }
        }else{
            header ("Location: index.html");
        }
}
?>
<!--
<h1>Log in en tu cuentita</h1>
<form action="login.php" method="post">
<input type="text" name="username" value="" placeholder="nombre de usuario..."></p>
<input type="password" name="password" value="" placeholder="Contrasenia..."></p>
<input type="submit" name="login" value="Log in">
</form>
---->
