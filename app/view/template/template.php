<?php include_once("app/view/template/header.php"); ?>
<?php include_once("app/view/template/script.php"); ?>


<div>
	<input type="hidden" name="url_path" id="url_path" value="<?php echo URL_PATH; ?>">

</div>

<div id="divLoading">
	<div>
		<img src="<?php echo URL_PATH; ?>app/assets/img/loading.svg" alt="Loading">
	</div>
</div>

<header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color:#659AB0;">
	<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="<?php echo URL_PATH ?>dashboard"><strong>APP PROMTOS</strong></a>
	<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<span class="form-control form-control-dark w-100 rounded-0 border-0">Perfil - formulario de soporte</span>
</header>

<div class="container-fluid">
	<div class="row">

		<!-- sidebar -->
		<?php include_once("app/view/template/sidebar.php"); ?>
		<!-- ./ sidebar -->

		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
			
			<!-- Overlay -->
				<div class="overlay" id="overlay" style="display:none">
					<div class="card m-4">
						<div class="card-body">
							<h4 class="card-title">
								<span id="title_action_overlay">Este es el proceso que esta haciendo - Guardando nuevo servicio </span><span class="spinner-grow" style="width: 1rem; height: 1rem;" role="status" aria-hidden="true"></span> <span class="spinner-grow" style="width: 1rem; height: 1rem;" role="status" aria-hidden="true"></span> <span class="spinner-grow" style="width: 1rem; height: 1rem;" role="status" aria-hidden="true"></span>
								<span id="title_result_overlay">Este podria ser el resultado - Se guardo satisfactoriamente - # de servicio: 451228</span>
							</h4>
						</div>
						<div class="card-body">
							<div id="text_overlay">Este es un texto para mostrar que el lo que esta haciendo y posiblemente mostrar un consecutgivo resultante de alguna operacion</div>
						</div>
						<div class="card-footer">
							<div id="action_overlay">Y aqui un posible boton para dejar que el usuario lea el error o el resultado <button type="button" class="btn btn-secondary" onclick="continuar_Overlay()">Continuar</button></div>
						</div>
					</div>
				</div>

			<!-- Overlay -->

			<!-- Contenido -->
			<?php

				$path_file_view = RUTA_VISTAS . $content_view;

				(file_exists($path_file_view) ? include_once($path_file_view) : " ");

			?>
			<!-- ./ Contenido -->
		</main>
		<!-- footer -->
		<?php include_once("app/view/template/footer.php"); ?>
		<!-- ./ footer -->

	</div>
</div>

</body>

</html>