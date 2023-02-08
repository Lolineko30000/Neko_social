<?php
include('Clases/DB.php');

if (isset($_POST['contrasenia'])) {

      $aux_token = True;
      $token = bin2hex(openssl_random_pseudo_bytes(100, $aux_token));
      $id_usuario = DB::query('SELECT id_persona FROM Correo_Persona WHERE correo = :correo', array(':correo' => $_POST['correo'] ))[0]['id_persona'];
      DB::query('INSERT INTO token_contrasenia VALUES (:token , :id_persona)',array(':token'=>sha1($token),':id_persona'=>$id_usuario));

      echo $token;


}

?>
<h1>Contrasenia olvidada</h1>
<form action="contrasenia_olvidada.php" method="post">
<input type="text" name="correo" value="" placeholder="Correo:"></p>
<input type="submit" name="contrasenia" value="Cambiar contrasenia">
</form>
