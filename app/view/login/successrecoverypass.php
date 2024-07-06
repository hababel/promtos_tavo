<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $titlepage; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URLPATH; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo URLPATH; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo URLPATH; ?>plugins/adminlte3.2.0/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo URLPATH; ?>plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition login-page bg">

  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Envio exitoso de correo ???</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <div class="input-group mb-3">
          
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?php echo URLPATH; ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo URLPATH; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo URLPATH; ?>plugins/adminlte3.2.0/dist/js/adminlte.min.js"></script>
  <script src="<?php echo URLPATH; ?>plugins/toastr/toastr.min.js"></script>

  <?php require_once(RUTA_VISTAS . "/error/nottoasts.php"); ?>

</body>

</html>