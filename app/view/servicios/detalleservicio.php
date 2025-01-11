<?php

	$backgound_categoria = config_categorias_cliente[$detalle_servicio[0][0]->ClasificacionCliente]["backgound_categoria"];
	$color_font = config_categorias_cliente[$detalle_servicio[0][0]->ClasificacionCliente]["color_font"];
	$style_font = config_categorias_cliente[$detalle_servicio[0][0]->ClasificacionCliente]["style_font"];
	$font_size = config_categorias_cliente[$detalle_servicio[0][0]->ClasificacionCliente]["font_size"];

?>

<style>
	.user-block {
		margin-bottom: 15px;
		width: 100%;
	}

	.username {
		font-size: 16px;
		font-weight: 600;
		margin-top: -1px;
	}

	.description {
		color: gray;
		font-size: 13px;
		margin-top: -3px;
	}


	.username {
		font-size: 14px;
	}

	.categoria-cliente {
		border-top: 4.5px solid <?php echo $backgound_categoria; ?>
	}
</style>

<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong><i class="bi bi-wrench-adjustable"></i> Detalle de servicio </strong></h3>
	<div class="btn-toolbar mb-2 mb-md-0">
		<!-- <a class="btn btn-sm btn-primary me-2" href="<?php echo URL_PATH ?>servicios/nuevoservicio" role="button"><i class="bi bi-plus align-text-bottom"></i> Nuevo Servicio</a> -->
	</div>
</div>
<!-- ./ Titulo -->

<div class="container-fluid">


	<div class="card my-2">
		<div class="card-body py-2">
			<div class="list-group list-group-horizontal-lg w-100">

				<a href="<?php echo URL_PATH; ?>servicios" class="list-group-item-action d-flex justify-content-center align-items-center text-center list-group-item-action border-0" style="text-decoration: none;">
					<i class="bi bi-wrench-adjustable align-text-bottom mx-2"></i> Lista de servicios
				</a>
				<a href="<?php echo URL_PATH; ?>clientes" class="list-group-item-action d-flex justify-content-center align-items-center text-center list-group-item-action border-0" style="text-decoration: none;">
					<i class="bi bi-person-lines-fill align-text-bottom mx-2"></i> Lista de Clientes
				</a>
				<a href="<?php echo URL_PATH; ?>productos" class="list-group-item-action d-flex justify-content-center align-items-center text-center list-group-item-action border-0" style="text-decoration: none;">
					Lista productos
				</a>
				<a href="<?php echo URL_PATH; ?>productos" class="list-group-item-action d-flex justify-content-center align-items-center text-center list-group-item-action border-0" style="text-decoration: none;">
					Anular servicio
				</a>
			</div>
		</div>
	</div>

	<div class="card my-3">
		<div class="card-body py-0">

			<div class="row">
				<ul class="list-group list-group-horizontal-lg w-100">
					<!-- Consecutivo numero de Orden de Servicio -->
					<li class="list-group-item d-flex justify-content-center align-items-center text-center border-0 col-12 col-lg">
						<h1>OS-<?php echo $detalle_servicio[0][0]->IDDoc; ?></h1>
					</li>
					<!-- Estado del Servicio -->
					<li class="list-group-item d-flex justify-content-center align-items-center text-center border-0 border-start col-12 col-lg">
						<span><?php echo definicion_estado_servicio($detalle_servicio[0][0]->Estado) ?></span>
					</li>
					<!-- Fechas de vencimiento -->
					<li class="list-group-item d-flex justify-content-center align-items-center text-center border-0 border-start col-12 col-lg">
						<div class="d-flex justify-content-center align-items-center">
							<!-- Icono de vencimiento -->
							<div class="me-3">
								<span>
									<?php
									$vencimiento = definicion_vencimiento($detalle_servicio[0][0]->FechaServicio, $detalle_servicio[0][0]->HoraPlaneadaTerminacion, $detalle_servicio[0][0]->HoraPlaneacionInicio, $detalle_servicio[0][0]->HorasFinalRespuesta);
									echo (($vencimiento[0] === "+") ? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top'>
                                        <i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'>Vencido</strong></span>" : "-");
									?>
								</span>
							</div>
							<!-- Texto apoyo al vencimiento -->
							<div style="font-size: 0.7rem;background-color: ghostwhite;">
								<?php echo "<div class='p-2'>" . $vencimiento[1] . "</div>"; ?>
							</div>
						</div>
					</li>
					<!-- Propridad -->
					<li class="list-group-item d-flex justify-content-center align-items-center text-center border-0 border-start col-12 col-lg">
						<span><?php echo "<span class='badge px-3' style='background-color:" . $detalle_servicio[0][0]->ColorPrioridad . "'>" . $detalle_servicio[0][0]->DescripcionPrioridad . "</span>"; ?></span>
					</li>
					<!-- Informacion tecnico -->
					<li class="list-group-item d-flex justify-content-center align-items-center text-center border-0 border-start col-12 col-lg">
						<div class="d-flex justify-content-center align-items-center">
							<!-- Primer div con el badge -->
							<div class="me-3">
								<span>
									<?php
									if ($detalle_servicio[0][0]->IDTecnicoAsignado) {
										echo $detalle_servicio[0][0]->TecnicoAsignado;
									} else { ?>
										<div class="row">
											<a name="" id="" class="btn btn-primary" href="#" role="button">
												<i class="bi bi-node-plus-fill"></i> Asignar tecnico
											</a>
										</div>
										<div class="row">Sin tecnico asignado</div>

									<?php	}
									?>
								</span>
							</div>

						</div>
					</li>
				</ul>
			</div>

		</div>
	</div>

	<div class="my-3">
		<div class="row">
			<!-- Card de la izquierda (70%) -->
			<div class="col-md-8"> <!-- col-md-8 corresponde aproximadamente al 70% de una fila de 12 columnas -->

				<div class="card categoria-cliente">
					<div class="card-header"> Detalle orden de servicio </div>
					<div class="card-body">
						<strong><?php echo $detalle_servicio[0][0]->UsuarioCreacion; ?></strong> - Creado <?php echo timeAgo($detalle_servicio[0][0]->FechaServicioCreacion); ?><i class="bi bi-info-circle ms-2" data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top'
							data-bs-title='<?php echo $detalle_servicio[0][0]->FechaServicioCreacion; ?>'></i>
						<div class="card mt-3">
							<div class="card-body">
								<strong>Descripcion Causa</strong><br>
								<p class="fs-2 lh-lg"> <?php echo $detalle_servicio[1][0]["DescripcionCausa"]; ?>,</p>
							</div>
						</div>
					</div>
					<div class="card-footer ">
						<a class="btn btn-primary me-2 float-sm-end" data-bs-toggle="collapse" href="#divnuevaactividad" role="button" aria-expanded="false" aria-controls="divnuevaactividad"><i class="bi bi-plus align-text-bottom"></i> Agregar actividad</a>
					</div>
				</div>


				<div class="card collapse categoria-cliente mt-2" id="divnuevaactividad">
					<div class="card-body">
						<div id="alert_form"></div>
						<h5 class="card-title">Descripción actividad</h5>
						<p class="card-text">
						<form action="" method="post" id="formnuevaactividad">

							<div class="mb-3">
								<textarea class="form-control" id="descripcionnuevaactividadservicio" rows="3" required></textarea>
							</div>
							<div class="mb-3">
								<div class="btn-group dropup float-sm-end">
									<button type="button" class="btn btn-outline-secondary" onclick="validadetalleactividad(<?php echo $detalle_servicio[0][0]->Estado; ?>)"><i class='bi bi-play-fill' style='color:green;font-size: 1.05rem;'></i> Guardar actividad</button>
									<button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
										<span class="visually-hidden">Toggle Dropdown</span>
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li><a class="dropdown-item" href="#" onclick="validadetalleactividad(2)"><i class='bi bi-pause-circle-fill' style='color:#FFA33A;font-size: 1.05rem'></i> Guardar y esperar repuesto</a></li>
										<li><a class="dropdown-item" href="#" onclick="validadetalleactividad(3)"><i class='bi bi-pause-circle-fill' style='color:#FFA33A;font-size: 1.05rem'></i> Guardar y poner en espera</a></li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li><a class="dropdown-item" href="#" onclick="validadetalleactividad(4)"><i class='bi bi-check2-circle' style='color:green'></i> Guardar y cerrar/terminar</a></li>
									</ul>

								</div>
							</div>
						</form>
						</p>
					</div>
				</div>

				<hr>
				<div id="listadeactividades">
					<?php
					if ($detalle_servicio[2]) {
						foreach ($detalle_servicio[2] as $key => $value) {
					?>
							<div class="card mt-2">
								<div class="card-body">
									<div class="post">
										<div class="user-block d-flex justify-content-between">
											<span class="username">
												<a href="#"><?php echo $value['NombreUsuario']; ?></a> - <span class="description">Creado <?php echo timeAgo($value['FechaActividad']); ?><i class="bi bi-info-circle ms-2" data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='<?php echo $value['FechaActividad']; ?>'></i></span>
												<a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
											</span>
											<span class="float-right"><?php echo ($value['EstadoServicio'] != $value['EstadoAnt']) ? 'Cambio a: ' . definicion_estado_servicio($value['EstadoServicio']) : ''; ?></span>
										</div>
										<p class="border-top">
											<?php echo (strlen($value['DescripcionActividad'])  > 0) ? $value['DescripcionActividad'] : "<span class='text-body-secondary fst-italic'>- Sin descripción -</span>";  ?>
										</p>
									</div>
								</div>
							</div>
					<?php
						}
					}
					?>
				</div>
			</div>
			<!-- Card de la derecha (30%) -->
			<div class="col-md-4"> <!-- col-md-4 corresponde aproximadamente al 30% de una fila de 12 columnas -->

				<!-- Card ficha de cliente -->
				<div class="card card-ficha-cliente categoria-cliente mb-3">
					<?php if (strlen($detalle_servicio[0][0]->ClasificacionCliente) > 0) { ?>
						<div id="clasificacioncliente" class="card-header d-flex justify-content-between align-items-center">
							<span><strong>Detalle Cliente</strong></span>
							<span style="color:#000; font-size: 0.85rem;">
								Categoría:
								<span class="fw-bold px-3 ms-2" style="color:<?php echo $color_font; ?>; padding:0.3rem 0.5rem; border-radius: 10px;font-style: <?php echo $style_font; ?>;font-size: <?php echo $font_size; ?>;background-color:<?php echo $backgound_categoria; ?>;<?php echo (($detalle_servicio[0][0]->ClasificacionCliente == "VIP") ? 'box-shadow: 0 4px 8px 0 rgba(0, 0, 0,0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.4);' : ''); ?>">
									<?php if ($detalle_servicio[0][0]->ClasificacionCliente == "VIP") {
										echo '<i class="bi bi-gem" style="color:green;margin-right: 4px;font-weight: bold;margin-left: 4px;"></i>';
									} ?>
									<?php echo $detalle_servicio[0][0]->ClasificacionCliente; ?>
								</span>
							</span>
						</div>
					<?php } ?>
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<div class="mt-2">
								<h5>
									<a href="<?php echo URL_PATH ?>clientes/ficha_cliente/?TICK=<?php echo rawurlencode(openssl_encrypt($detalle_servicio[0][0]->IDCliente, METHODENCRIPT, KEY)); ?>">
										<?php echo $detalle_servicio[0][0]->NombreCompletoCliente; ?>
									</a>
								</h5>
								<?php if (($detalle_servicio[0][0]->FuenteCreacion === "recomendado")) { ?>
									<p class="text-secondary mb-1">Recomendado:
										<?php echo (($detalle_servicio[0][0]->FuenteCreacion === "recomendado") ? "<span class='badge text-bg-warning'>" . $detalle_servicio[0][0]->NombreRecomendado . "</span>" : "-"); ?>
									</p>
								<?php } ?>
								<p class="text-secondary mb-1">Creado <?php echo (timeAgo($detalle_servicio[0][0]->FechaCreacionCliente)); ?> <i class="bi bi-info-circle-fill" data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='<?php echo "Creado el " . $detalle_servicio[0][0]->FechaCreacionCliente ?>'></i></p>
							</div>

						</div>
						<hr class="my-0">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Estado</h6>
								<div class="form-check form-switch" style="text-align:left;">
									<label for="Switchestadocliente"> <?php echo ($detalle_servicio[0][0]->EstadoCliente) ? '<i class="bi bi-check-circle-fill" style="color:green;font-size: 1.06rem;"></i>' : '<i class="bi bi-x-circle-fill" style="color:red;font-size: 1.06rem;"></i>'; ?>
									</label>
									<input class="form-check-input" type="checkbox" role="switch" id="Switchestadocliente" <?php echo ($detalle_servicio[0][0]->EstadoCliente) ? "checked" : null;  ?> disabled>
								</div>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0"> <i class="bi bi-whatsapp me-1"></i> Whatsapp </h6>
								<span class="text-secondary">
									<a href="https://web.whatsapp.com/send/?phone=57<?php echo $detalle_servicio[0][0]->Telefono2Cliente; ?>" target="_blank" style="text-decoration: none;color:green"> <?php echo $detalle_servicio[0][0]->Telefono2Cliente; ?> <i class="bi bi-box-arrow-up-right"></i></a>
								</span>
							</li>
						</ul>
					</div>
				</div>
				<!-- Fin ficha cliente -->

				<!-- Descripcion de la direccion del cliente -->
				<div class="card categoria-cliente mb-3">
					<div class="card-header"> Detalle Direccion</div>
					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Nombre Direccion</h6>
								<span><?php echo $detalle_servicio[1][0]["NombreDireccion"]; ?></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Departamento/Ciudad</h6>
								<?php echo $detalle_servicio[1][0]["DepartamentoDireccion"]; ?>/<?php echo $detalle_servicio[1][0]["CiudadDireccion"]; ?>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6>Direccion Servicio:</h6>
								<?php echo $detalle_servicio[1][0]["DescripcionDireccion"]; ?>
							</li>
						</ul>
					</div>
				</div>


				<!-- Descripcion del equipo -->
				<div class="card categoria-cliente mb-3">
					<div class="card-header"> Detalle Equipo</div>
					<div class="card-body">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Modelo Equipo</h6>
								<span><?php echo $detalle_servicio[1][0]["ModeloEquipo"]; ?></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Tipo Equipo</h6>
								<?php echo $detalle_servicio[1][0]["DescripcionEquipoTipo"]; ?>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Marca Equipo</h6>
								<?php echo $detalle_servicio[1][0]["EquipoMarca"]; ?>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Serial</h6>
								<?php echo $detalle_servicio[1][0]["Serial"]; ?>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6>Descripcion Equipo</h6>
								<?php echo $detalle_servicio[1][0]["DescripcionEquipo"]; ?>
							</li>
						</ul>
					</div>
				</div>

				<!-- Propiedades Orden de servicio -->

				<div class="card categoria-cliente mb-3">
					<div class="card-header">
						Propiedades OS
					</div>
					<div class="card-body">
						<form action="<?php echo URL_PATH; ?>servicios/guardarpropiedades" method="post">

							<div class="mb-3">
								<label for="" class="form-label">Prioridad</label>
								<select class="form-select form-select-sm" name="prioridadservicios" id="prioridadservicios">
									<?php foreach ($listaprioridades as $key => $value) { ?>
										<option value="<?php echo $value->IDPrioridad; ?>" <?php echo (($detalle_servicio[0][0]->IDPrioridad == $value->IDPrioridad) ? "selected" : null);  ?>><?php echo $value->DescripcionPrioridad; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="mb-3">
								<input type="hidden" name="EstadoActual" id="EstadoActualServicio" value="<?php echo $detalle_servicio[0][0]->Estado; ?>">
								<label for="" class="form-label">Estado</label>
								<select class="form-select form-select-sm" name="estadoservicios" id="estadoservicios">
									<option value="0" <?php echo (($detalle_servicio[0][0]->Estado == 0) ? "selected" : null); ?> disabled>Sin tecnico asignado</option>
									<option value="1" <?php echo (($detalle_servicio[0][0]->Estado == 1) ? "selected" : null); ?> disabled>Con tecnico asignado</option>
									<option value="2" <?php echo (($detalle_servicio[0][0]->Estado == 2) ? "selected" : null); ?>>Esperando repuesto</option>
									<option value="3" <?php echo (($detalle_servicio[0][0]->Estado == 3) ? "selected" : null); ?>>En espera/Pausa</option>
									<option value="4" <?php echo (($detalle_servicio[0][0]->Estado == 4) ? "selected" : null); ?>>Cerrado/Terminado</option>
									<option value="5" <?php echo (($detalle_servicio[0][0]->Estado == 5) ? "selected" : null); ?>>Anulado</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="" class="form-label">Tipo servicio</label>
								<select class="form-select form-select-sm" name="tiposervicio" id="tiposervicio">
									<option value="1" <?php echo (($detalle_servicio[0][0]->Estado == 1) ? "selected" : null); ?>>Preventivo/limpieza</option>
									<option value="2" <?php echo (($detalle_servicio[0][0]->Estado == 2) ? "selected" : null); ?>>Correctivo</option>
									<option value="3" <?php echo (($detalle_servicio[0][0]->Estado == 3) ? "selected" : null); ?>>Predictivo</option>
									<option value="4" <?php echo (($detalle_servicio[0][0]->Estado == 4) ? "selected" : null); ?>>Otro</option>
								</select>
							</div>

							<button type="submit" class="btn btn-primary">
								Guardar propiedades
							</button>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal de confirmación de guardado de actividad sin descripcion -->
<div class="modal fade" id="confirmModalsindescripcion" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmModalLabel">Nueva actividad sin descripción.</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				¿ Está seguro de que desea guardar el nuevo servicio sin una breve descripción ?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				<!-- <button type="button" class="btn btn-success" id="confirmButtonguardasinconfirmacion"></button> -->
				<a class="btn btn-success" id="confirmaguardadoactividad" href="#"> Si, deseo guardarlo sin descripción</a>
			</div>
		</div>
	</div>
</div>