<?php
include('Clases/DB.php');
include('Clases/log_check.php');

if (!log_check::logeado()) {
      header ("Location: index.html");
}

if(isset($_POST['salir'])){
      if(isset($_POST['todos'])){
            DB::query( 'DELETE FROM token WHERE id_persona = :id_persona' , array(':id_persona' => log_check::logeado()));
      }else{
            if(isset($_COOKIE['SNID'])){
                DB::query( 'DELETE FROM token WHERE token = :token' , array(':token' => sha1($_COOKIE['SNID'])));
            }
            setcookie('SNID','1',time()-1);
            setcookie('SNID_','1',time()-1);
      }
}

?>

<h1>Salir de la cuenta</h1>
<p>Si quieres salir?</p>
<form action="logout.php" method="post">
<input type="checkbox" name="todos" value="todos">Salir de todos los dispositivos?</br>
<input type="submit" name="salir" value="Salir">
</form>
