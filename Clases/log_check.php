<?php

class log_check{

      public static function logeado(){
            if(isset($_COOKIE['SNID']))
                  if(DB::query('SELECT id_persona FROM token WHERE token = :token',array(':token' => sha1($_COOKIE['SNID'])))){

                        $id_usuario = DB::query('SELECT id_persona FROM token WHERE token = :token',array(':token' => sha1($_COOKIE['SNID'])))[0]['id_persona'];

                        if (!(isset($_COOKIE['SNID_']))){
                              $aux_token = True;
                              $token = bin2hex(openssl_random_pseudo_bytes(100, $aux_token));
                              DB::query('INSERT INTO token VALUES (:token , :id_persona)',array(':token'=>sha1($token),':id_persona'=>$id_usuario));
                              DB::query('DELETE FROM token WHERE token = :token', array(':token' => sha1($_COOKIE['SNID'])));

                              setcookie("SNID",$token, time() + 2592000, '/', NULL, NULL,TRUE);
                              setcookie("SNID_",'1', time() +  604800, '/', NULL, NULL,TRUE);
                        }

                        return $id_usuario;
                  }
            return false;
      }
}


?>
