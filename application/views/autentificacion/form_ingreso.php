<!DOCTYPE html>
<html>
 <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
</script>
   <title>LOGIN</title>
 </head>
 <body>
   <h1>LOGIN</h1>
   <?php 
   // comprobar que no este bloqueada la sesion y mostrar el formulario de login
    if (isset($_SESSION['bloquear']) && $_SESSION['bloquear']==0){
          echo validation_errors(); 
          echo form_open('verificarLogin');
          ?>

     <label for="usuario">Usuario:</label>
     <input type="text" size="20" id="usuario" name="usuario"/>
     <br/>
     <label for="password">Password:</label>
     <input type="password" size="20" id="password" name="password"/>
     <br/>
     <input type="submit" value="Login"/>
   </form>
   <?php
    }else{
      //si la sesion esta bloqueada $_SESSION['bloquear']==1 mostrar que hay que esperar
      echo "esperar...";
      if (isset($_SESSION['espera']) && isset($_SESSION['tiempoEspera'])){
         if (time() - $_SESSION['espera'] > $_SESSION['tiempoEspera']){
          //si la sesion esta bloqueada pero ya paso el tiempo de espera
            //resetear variables y permitir login
              $_SESSION['bloquear']=0;
              $_SESSION['intentos'] = 0; 
         }
        //echo "<script> localStorage.colorSetting = '#a4509b'</script>";
        echo time() - $_SESSION['espera'];  
      }
    }
   ?>
     
 

   <?php if(isset($_SESSION['mensaje'])){
      echo "<br>mensaje:".$_SESSION['mensaje'];
      if (isset($_SESSION['intento']) && !$_SESSION['intento'] ){
        $_SESSION['ultimo_intento'] = time();
      }
   }

   if (isset($_SESSION['ultimo_intento'])){
    $tiempo_transcurrido = time() - $_SESSION['ultimo_intento'];
    if ($tiempo_transcurrido > 10){
      $_SESSION['ultimo_intento'] = time();
    }
  }
?>

 </body>
</html>