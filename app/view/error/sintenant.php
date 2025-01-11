
      <div class="alert alert-danger mt-4" role="alert">
        <h4 class="alert-heading">Usuario sin acceso!</h4>
				<?php if ($_SESSION['sessData']) {?>
        <p><?php echo $_SESSION['sessData']['status']['msg']; ?>
          <hr>
          o envia directamente una solicitud <a name="" id="" class="btn btn-secondary btn-sm ms-4" href="solicitaraccesoadmintenant" role="button">Solicitar acceso</a>
        </p>
			<?php } ?>
      </div>

    
      