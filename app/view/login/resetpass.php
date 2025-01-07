<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Anibal Benitez">
    <meta name="generator" content="PROMTOS 1.0">
    <title>APP PROMTOS</title>

    <link href="<?php echo URL_PATH. PATH_ASSET; ?>bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="<?php echo URL_PATH. PATH_ASSET; ?>css/sign-in.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="col-12">
          <?php if(isset($_SESSION['sessData'])) {  ?>
            <div class="alert alert-<?php echo $_SESSION['sessData']['status']['type']; ?> alert-dismissible fade show" role="alert">
              <strong style="margin-left: 15px;"><?php echo $_SESSION['sessData']['status']['title']; ?>:</strong> <?php echo $_SESSION['sessData']['status']['msg']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

          <?php 
            } 
            unset($_SESSION['sessData']);
            session_destroy();
          ?>

        </div>
        </div>
      </div>
      <div class="row container" style="display: flex;justify-content: center; align-items: center;">
        <div>
          <div style="margin-top:0px;margin-bottom: 40px;">
              <h1>APP - PROMTOS</h1>
              <p class="h5"><small>Definición nueva contraseña</small></p>
          </div>
          <div class="form-signin w-100 m-auto">
            <form action="<?php echo URL_PATH; ?>login/recoverypass" method="post">

                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="resetpassword" required placeholder="Nueva Clave" style="margin-bottom:0px;">
                  <span class="input-group-text" id="basic-addon1">***</span>
                </div>

                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="resetconfirmpassword" required placeholder="Confirme la nueva clave" style="margin-bottom:0px;">
                  <span class="input-group-text" id="basic-addon1">***</span>
                </div>
             
                <input type="hidden" name="fp_code" value="<?php echo $token_code; ?>">
                <input type="submit" class="btn btn-primary btn-block" name="resetSubmit" value="Enviar">
              <p class="mt-5 mb-3 text-muted">&copy; 2022–<?php echo date("Y"); ?></p>
            </form>
            
          </div>
        </div>
      </div>
    </div>

     <script src="<?php echo URL_PATH. PATH_ASSET; ?>bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<!doctype html>

