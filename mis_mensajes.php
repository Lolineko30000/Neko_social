<?php
include('Clases/DB.php');
include('Clases/log_check.php');

if(log_check::logeado()){
      $id_persona = log_check::logeado();

}else die("nelson");

if (isset($_GET['mid'])) {
      $mensaje = DB::query('SELECT * FROM mensajes WHERE id = :id AND id_destino = :id_destino OR id_destinatario = :id_destinatario',array(':id'=>$_GET['mid'], ':id_destino'=>$id_persona, ':id_destinatario'=>$id_persona))[0];

      echo "<h1>Ver mensaje</h1>";
      echo htmlspecialchars($mensaje['cuerpo']);
      echo "<hr />";
      if ($mensaje['id_destinatario'] == $id_persona) {
            $id = $mensaje['id_destino'];
      }else {
            $id = $mensaje['id_destinatario'];
      }
      DB::query('UPDATE mensajes SET visto = 1 WHERE id = :id', array(':id'=>$_GET['mid']));
?>

<form action="mensajes_e.php?reciver=<?php echo $id; ?>" method="post">
<textarea name="cuerpo_mensaje" rows="8" cols="80"></textarea>
<input type="submit" name="enviar" value="Enviar">

</form>

<?php
}else{

?>
<h1>Mis mensajes</h1>
<?php
$mensajes = DB::query('SELECT mensajes.*, personas.nombre FROM mensajes, personas WHERE mensajes.id_destino = :id_destino OR mensajes.id_destinatario = :id_destinatario AND personas.id_persona = mensajes.id_destinatario', array(':id_destino'=>$id_persona, ':id_destinatario'=>$id_persona ));
foreach ($mensajes as $mensaje) {
      if (strlen($mensaje['cuerpo']) > 15) {
            $m = substr($mensaje['cuerpo'],0, 15)." ...";
      }else {
            $m = $mensaje['cuerpo'];
      }

      if ($mensaje['visto'] == 0) {
            echo "<a href='mis_mensajes.php?mid=".$mensaje['id']."'><strong>".$m."</strong></a> de ".$mensaje['nombre'].'<hr />';
      }else{
            echo "<a href='mis_mensajes.php?mid=".$mensaje['id']."'>".$m."</a> de ".$mensaje['nombre'].'<hr />';
      }
}
}
?>
