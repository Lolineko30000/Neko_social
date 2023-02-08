<?php
//C:\xampp\mysql\bin
include('Clases/DB.php');

if(isset($_POST['create'])){
        $nombre_usuario = $_POST['username'];
        $contrasenia = $_POST['password'];
        $correo = $_POST['correo'];


        if(DB::query('SELECT nombre FROM personas WHERE nombre = :nombre', array(':nombre' => $nombre_usuario ))){
            header ("Location: index.html");
        }elseif(DB::query('SELECT correo FROM correo_Persona WHERE correo = :correo', array(':correo' => $correo ))){
            header ("Location: index.html");
        }elseif ((strlen($nombre_usuario) < 3 || strlen($nombre_usuario) > 40)  && !(preg_match('/[a-zA-Z0-9_]+/', $nombre_usuario))) {
            header ("Location: index.html");
        }elseif (strlen($contrasenia) < 6 || strlen($contrasenia) > 40) {
            header("Location: index.html");
        }
        else{

            $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT );

            $pk_persona = 1+DB::query('SELECT MAX(id_persona) AS pkt FROM personas', array())[0]['pkt'];
            $pk_correo = 1+DB::query('SELECT MAX(PK) AS pkt FROM correo_persona', array())[0]['pkt'];
            $pk_seguir = 1+DB::query('SELECT MAX(PK) AS pkt FROM seguir', array())[0]['pkt'];

            DB::query('INSERT INTO PERSONAS  VALUES (:id_persona, :nombre , :contrasenia, NULL)',array(':id_persona'=>$pk_persona,':nombre'=>$nombre_usuario, ':contrasenia'=>$contrasenia));
            DB::query('INSERT INTO Correo_Persona VALUES (:pk, :correo, :id_persona)',array('pk'=>$pk_correo,':correo'=>$correo, ':id_persona'=>$pk_persona));
            DB::query('INSERT INTO seguir VALUES (:pk,:id_persona,:id_seguidor)',array('pk'=>$pk_seguir, ':id_persona'=>$pk_persona,':id_seguidor'=>$pk_persona));
            header ("Location: index.html");
        }
}


?>

<!--
<h1>Registro</h1>
<form action= "crear_cuenta.php" method= "post" >

<input type="text" name="username" value="" placeholder="Nombre de usuario..."></p>
<input type="password" name="password" value="" placeholder="contrasenia..."></p>
<input type="email" name="correo" value="" placeholder="Email..."></p>
<input type="submit" name="create" value="Crear cuenta"></p>

</form>
--->
