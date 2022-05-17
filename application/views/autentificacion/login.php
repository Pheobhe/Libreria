<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema Libreria | Ingreso</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
   <link rel="stylesheet" href="<?php echo base_url('theme/');?>bootstrap/css/bootstrap.min.css">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/ionicons.min.css">
  <!-- Theme style -->
  
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('theme/');?>plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="<?php echo base_url('theme/');?>bootstrap/css/style.css">
   <link rel="shortcut icon" href="<?php echo base_url('theme/');?>dist/img/favicon_NU.png" type="<?php echo base_url('theme/');?>dist/img/favicon_NU.png"/>
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">


  <div class="row">
    <div class="col-md-12">
      <div class="headersalud">
      <img src="<?php echo base_url('theme/');?>dist/img/salud_justicia_logo2021.png"> 
   <!--    <img src="<?php echo base_url('theme/');?>dist/img/salud_justicia_logo.png"> -->
      </div>
    </div>
  </div>

<header class="main-header backmenu">
    <!-- Logo -->
    

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      

      
    </nav>
  </header>
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="#"><b>Sistema</b>LIBRERIA</a> -->
    <a href="#">LIBRERIA</a>
  </div>
  <!-- /.login-logo -->

  <?php
  // mensajes
  $mensaje=$this->session->flashdata('mensaje');
  if (isset($mensaje)){
        echo "<div class='alert alert-success show'>".$this->session->flashdata('mensaje')."</div>";  
  }else{
    echo "<div class='alert alert-success hidden'>".$this->session->flashdata('mensaje')."</div>";  
  }

  
  ?>
  <div class="login-box-body">
    <p class="login-box-msg">Ingresa tus datos para iniciar sesión</p>

 <?php 
 
   // comprobar que no este bloqueada la sesion y mostrar el formulario de login
    if (isset($_SESSION['bloquear']) && $_SESSION['bloquear']==0){
          echo validation_errors(); 
          echo form_open('VerificarLogin');
          ?>

     <div class="form-group has-feedback">
        <input type="email" class="form-control" id='usuario' name='usuario' placeholder="Correo Electrónico">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

    <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>



     <button type="submit" class="btn btn-primary btn-block btn-flat">INGRESAR</button>

      <div class="row">
        <!-- 
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> RECUERDAME
            </label>
          </div>
        </div>
        /.col -->
        <div class="col-xs-4">
          
        </div>
        <!-- /.col -->
      </div>
      
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


  <!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
   /.social-auth-links -->

   <!-- <a href="#">¿OLVIDASTE TU PASSWORD?</a><br>
    <a href="register.html" class="text-center">REGISTRAR UN NUEVO USUARIO</a>-->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<footer class="footerlogin">
  <div class="container">
    <div class="row" >
      <div class="col-md-4 col-xs-12">
        <div class="logofooter">
          <img src="<?php echo base_url('theme/');?>dist/img/logo_gba_footer.svg">
        </div>
      </div>
    </div>
  </div>
</footer>





<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url('theme/');?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('theme/');?>bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('theme/');?>plugins/iCheck/icheck.min.js"></script>

<script src="<?php echo base_url('theme/');?>js/detect-private-browsing.js"></script>

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<script>
$( document ).ready(function() {

  detectPrivateMode(
        function(is_private) {
            //document.getElementById('result').innerHTML = typeof is_private === 'undefined' ? 'cannot detect' : is_private ? 'private' : 'not private';
            if(is_private){
                window.location.href='index.php/Login/errorIncognito';
            }
        }
    );



});

document.addEventListener("click", function() {
    //console.log("reiniciar tiempo");
    <?php 
    //reiniciar el tiempo de sesion
    $_SESSION['ultimo_acceso'] = time();
    ?>
})


</script>
</body>
</html>
