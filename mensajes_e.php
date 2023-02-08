<?php
session_start();
$aux_token = True;
$token = bin2hex(openssl_random_pseudo_bytes(100, $aux_token));
if (!isset($_SESSION['token'])) {$_SESSION['token'] = $token;}

include('Clases/DB.php');
include('Clases/log_check.php');

if(log_check::logeado()){
      $id_persona = log_check::logeado();

}else header ("Location: index.html");

if (isset($_POST['enviar'])) {

      if (!isset($_POST['no_csrf'])) {die("CSRF");}
      if ($_POST['no_csrf'] != $_SESSION['token']) {die("CSRF");}

      if (DB::query('SELECT id_persona FROM personas WHERE id_persona = :id_persona', array(':id_persona' =>  $_GET['reciver']))) {
            $pk_mensajes =  1+DB::query('SELECT MAX(id) AS pkt FROM mensajes', array())[0]['pkt'];
            DB::query('INSERT INTO mensajes VALUES (:id, :cuerpo, :visto, :id_destino, :id_destinatario)' ,array(':id'=>$pk_mensajes, ':cuerpo'=>$_POST['cuerpo_mensaje'] , ':visto'=>0, ':id_destino'=>htmlspecialchars($_GET['reciver']), ':id_destinatario'=>$id_persona ));
      }else {
            header ("Location: index.html");
      }

      session_destroy();
}

?>
<!--
<h1>Enviar mensaje</h1>
<form action="mensajes_e.php?reciver=<?php echo htmlspecialchars($_GET['reciver']); ?>" method="post">

#<textarea name="cuerpo_mensaje" rows="8" cols="80"></textarea>
<input type="hidden" name="no_csrf" value="<?php echo $_SESSION['token']; ?>">
<input type="submit" name="enviar" value="Enviar">

</form>
-->
