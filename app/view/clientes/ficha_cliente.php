<style>

.timeline {
    list-style-type: none;
    padding: 0;
    position: relative;
}

.timeline::before {
    content: '';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 50%;
    width: 2px;
    height: 100%;
    z-index: 400;
}

.timeline > li {
    margin: 20px 0;
    padding-left: 40px;
    position: relative;
}

.timeline > li::before {
    content: '';
    background: white;
    border: 3px solid #22c0e8;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    z-index: 400;
    top: 0;
    margin-left: -10px;
}

.timeline .timeline-content {
    padding: 20px;
    background: #f9f9f9;
    position: relative;
    border-radius: 5px;
    width: 45%;
}

.timeline .timeline-content::before {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
    border-style: solid;
    top: 20px;
    z-index: 400;
}

.timeline > li:nth-child(even) .timeline-content {
    left: 55%;
}

.timeline > li:nth-child(odd) .timeline-content {
    left: 0;
}

.timeline > li:nth-child(odd) .timeline-content::before {
    left: 100%;
    border-color: transparent transparent transparent #f9f9f9;
    border-width: 10px 0 10px 10px;
    margin-left: -1px;
}

.timeline > li:nth-child(even) .timeline-content::before {
    right: 100%;
    border-color: transparent #f9f9f9 transparent transparent;
    border-width: 10px 10px 10px 0;
    margin-right: -1px;
}
</style>


<?php 

$backgound_categoria = config_categorias_cliente[$data_ficha_cliente[0][0]->ClasificacionCliente]["backgound_categoria"];
$color_font = config_categorias_cliente[$data_ficha_cliente[0][0]->ClasificacionCliente]["color_font"];
$style_font = config_categorias_cliente[$data_ficha_cliente[0][0]->ClasificacionCliente]["style_font"];
$font_size = config_categorias_cliente[$data_ficha_cliente[0][0]->ClasificacionCliente]["font_size"];

?>

<style>
	.card-ficha-cliente {
		position: relative;
		display: flex;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 0 solid transparent;
		border-radius: .25rem;
		margin-bottom: 1.5rem;
		box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
	}

	.me-2 {
		margin-right: .5rem !important;
	}

	.categoria-cliente {
		border-top: 4.5px solid <?php echo $backgound_categoria; ?>
	}
</style>


<div class="container">
	<div class="main-body mt-3">
		<div class="row">
			<div class="col-lg-4">
				<div class="my-3">
					<a class="icon-link" href="<?php echo URL_PATH; ?>clientes" style="text-decoration: none;">
						<!-- <i class="bi bi-chevron-left"></i> <i class="bi bi-caret-left"></i>  -->
						<i class="bi bi-caret-left-fill"></i> Lista clientes
					</a>
				</div>
				<div class="card card-ficha-cliente categoria-cliente">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<!-- <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110"> -->
							<div class="mt-2">

								<!-- Cliente categoria VIP -->
								<?php if ($data_ficha_cliente[0][0]->ClasificacionCliente === "VIP") { ?>
									<h4>
										<span class="position-absolute start-0 translate-middle badge rounded-pill" style="color:<?php echo $color_font; ?>; font-style: <?php echo $style_font; ?>;font-size: <?php echo $font_size; ?>;top: 0.7em;background-color:<?php echo $backgound_categoria; ?> ;box-shadow: 0 4px 8px 0 rgba(0, 0, 0,0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.4);">
											<i class="bi bi-gem" style="color:green;margin-right: 4px;font-weight: bold;margin-left: 15px;"></i> <?php echo $data_ficha_cliente[0][0]->ClasificacionCliente; ?>
										</span>
									</h4>
								<?php } else { ?>
									<!-- Cliente otras categorias -->
									<h4>
										<span class="position-absolute start-100 translate-middle badge rounded-pill px-3" style="top: 0.7rem;color:<?php echo $color_font; ?>; font-style: <?php echo $style_font; ?>;font-size: <?php echo $font_size; ?>;top: 0.7em;background-color:<?php echo $backgound_categoria; ?> ">
											<?php echo $data_ficha_cliente[0][0]->ClasificacionCliente; ?>
										</span>
									</h4>
								<?php } ?>

									<div  id="alert_ficha_cliente" >
										
									</div>

								<h4><?php echo $data_ficha_cliente[0][0]->NombreCompletoCliente; ?></h4>
								<?php if (($data_ficha_cliente[0][0]->FuenteCreacion === "recomendado")) { ?>
									<p class="text-secondary mb-1">Recomendado:
										<?php echo (($data_ficha_cliente[0][0]->FuenteCreacion === "recomendado") ? "<span class='badge text-bg-warning'>" . $data_ficha_cliente[0][0]->NombreRecomendado . "</span>" : "-"); ?>
									</p>
								<?php } ?>
								<p class="text-secondary mb-1">Creado <?php echo (timeAgo($data_ficha_cliente[0][0]->FechaCreacionCliente)); ?> <i class="bi bi-info-circle-fill" data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='<?php echo "Creado el " . $data_ficha_cliente[0][0]->FechaCreacionCliente ?>'></i></p>
								<p class="text-secondary mb-1">Creado por: <span style="font-style: italic;"><?php echo $data_ficha_cliente[0][0]->NombreCompletoUsuario; ?></span></p>

							</div>

						</div>
						<hr class="my-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Estado
										<a class="ms-2 <?php echo (!empty($data_ficha_cliente[0][0]->LogEstados)) ? "visible" : "invisible"; ?>" id="showHistoryBtn">
											<i class="bi bi-info-circle"></i>
										</a>
									
								</h6>

								<div class="form-check form-switch" style="text-align:left;">
									<label for="Switchestadocliente"> <?php echo ($data_ficha_cliente[0][0]->EstadoCliente) ? '<i class="bi bi-check-circle-fill" style="color:green;font-size: 1.06rem;"></i>' : '<i class="bi bi-x-circle-fill" style="color:red;font-size: 1.06rem;"></i>'; ?>
									</label>
									<input class="form-check-input" type="checkbox" role="switch" id="Switchestadocliente" <?php echo ($data_ficha_cliente[0][0]->EstadoCliente) ? "checked" : null;  ?> onchange="changeestadocliente(this)">
								</div>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">
									<i class="bi bi-whatsapp me-1"></i> Whatsapp
								</h6>
								<span class="text-secondary">
									<a href="https://web.whatsapp.com/send/?phone=57<?php echo $data_ficha_cliente[0][0]->Telefono2Cliente; ?>" target="_blank" style="text-decoration: none;color:green"> <?php echo $data_ficha_cliente[0][0]->Telefono2Cliente; ?> <i class="bi bi-box-arrow-up-right"></i></a>
								</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap row">
								<div class="col">
									<h6 class="mb-0"><i class="bi bi-envelope-at-fill me-1"></i> Correo</h6>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="card card-ficha-cliente categoria-cliente">
					<div class="card-body">
						<div class="row">
							<div class="col-8">
								<div class="row mb-1">
									<div class="col-md-4">
										<label for="documento_cliente" class="form-label">Documento</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="documento_cliente" name="documento_cliente" value="<?php echo $data_ficha_cliente[0][0]->DocCliente ?>">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-md-4">
										<label for="fichacliente_nombres" class="form-label">Nombres</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="fichacliente_nombres" name="fichacliente_nombres" value="<?php echo $data_ficha_cliente[0][0]->NombreCliente ?>">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-md-4">
										<label for="fichacliente_apellidos" class="form-label">Apellidos</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="fichacliente_apellidos" name="fichacliente_apellidos" value="<?php echo $data_ficha_cliente[0][0]->ApellidoCliente ?>">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-md-4">
										<label for="fichacliente_telefono1" class="form-label">Telefono 1</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="fichacliente_telefono1" name="fichacliente_telefono1" value="<?php echo $data_ficha_cliente[0][0]->Telefono1Cliente ?>">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-md-4">
										<label for="fichacliente_correoelectronico" class="form-label">Correo electrónico</label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="fichacliente_correoelectronico" name="fichacliente_correoelectronico" value="<?php echo $data_ficha_cliente[0][0]->CorreoCliente; ?>">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-md-12">
										<label for="fichacliente_notas" class="form-label">Notas</label>
										<textarea class="form-control" name="fichacliente_notas" id="fichacliente_notas" rows="1"><?php echo $data_ficha_cliente[0][0]->NotasCliente ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-md-12">
								<!-- <input type="button" class="btn btn-primary px-4" value="Grabar cambios"> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Direcciones clientes -->
		<div class="row">
			<div class="col-12">
				<div class="card card-ficha-cliente categoria-cliente">
					<div class="card-body">
						<h5 class="d-flex align-items-center mb-3">Direcciones - <?php echo isset($data_ficha_cliente[5]) ? count(($data_ficha_cliente[5])) : "0"; ?></h5>
						<div class="table-responsive">
							<table class="table table-sm">
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Dirección</th>
										<th>Departamento</th>
										<th>Ciudad</th>
										<th>Barrio</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody id="direccionesTabla" class="table-group-divider">
									<?php
									if (isset($data_ficha_cliente[6])) {
										foreach ($data_ficha_cliente[6] as $key => $value) { ?>
											<tr>
												<td><?php echo $value->NombreDireccion; ?></td>
												<td><?php echo $value->DescripcionDireccion; ?></td>
												<td><?php echo $value->DepartamentoDireccion; ?></td>
												<td><?php echo $value->CiudadDireccion; ?></td>
												<td><?php echo ($value->BarrioCiudad === NULL) ? "-" : $value->BarrioCiudad; ?></td>
												<td><a href="http://<?php echo URL_PATH ?>editardireccion/?IDDireccion=<?php echo urlencode(openssl_encrypt($value->IDClienteDirecciones, METHODENCRIPT, KEY)); ?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td>
											</tr>
									<?php }
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ -->

		<!-- Equipos registrados -->
		<div class="row">
			<div class="col-12">
				<div class="card card-ficha-cliente categoria-cliente">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h5>Equipos registrados - <?php echo isset($data_ficha_cliente[6]) ? count(($data_ficha_cliente[6])) : "0"; ?></h5>
							</div>
							<div><button type="button" class="btn px-4" style="background-color: #659AB0;"><span class="fs-5 fw-bold" style="color:white">+</span></button></div>
						</div>
						<div>
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">Tipo</th>
											<th scope="col">Marca</th>
											<th scope="col">Descripción</th>
											<th scope="col">Modelo</th>
											<th scope="col">Serial</th>
											<th scope="col">Nombre Direccion</th>
											<th scope="col">Acciones</th>
										</tr>
									</thead>
									<tbody>

										<?php
										if (isset($data_ficha_cliente[7])) {
											foreach ($data_ficha_cliente[7] as $key2 => $value2) { ?>
												<tr>
													<td><?php echo $value2->DescripcionEquipoTipo; ?></td>
													<td><?php echo $value2->EquipoMarca; ?></td>
													<td><?php echo $value2->DescripcionEquipo; ?></td>
													<td><?php echo $value2->ModeloEquipo; ?></td>
													<td><?php echo $value2->Serial; ?></td>
													<td><?php echo $value2->NombreDireccion; ?></td>
													<td><a href="http://<?php echo URL_PATH ?>editardireccion/?IDDireccion=<?php echo urlencode(openssl_encrypt($value->IDClienteDirecciones, METHODENCRIPT, KEY)); ?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td>
												</tr>
										<?php }
										} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ./ -->

	<!-- Ordenes de Servicios -->
	<div class="row">
		<div class="col-12">
			<div class="card card-ficha-cliente categoria-cliente">
				<div class="card-body">
					<h5 class="d-flex align-items-center mb-3">Ordenes de Servicios </h5>
					<div>
						<ul class="nav nav-pills mb-3" id="TabServicios" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" id="abiertas-tab" data-bs-toggle="tab" data-bs-target="#servicio-tab-abiertas" type="button" role="tab" aria-controls="servicio-tab-abiertas" aria-selected="true">Abiertas/Pendientes</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="historico-tab" data-bs-toggle="tab" data-bs-target="#servicios-tab-historico" type="button" role="tab" aria-controls="servicios-tab-historico" aria-selected="false">Historico</button>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<!-- Lista de servicios activos estado (0,1,2,3) -->
							<div class="tab-pane fade show active" id="servicio-tab-abiertas" role="tabpanel" aria-labelledby="abiertas-tab" tabindex="0" style="background-color: #fff !important;">
								<div>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th scope="col">Documento</th>
													<th scope="col">Estado</th>
													<th scope="col">Prioridad</th>
													<th scope="col">Vencimiento</th>
													<th scope="col">Fecha incio servicio</th>
													<th scope="col">Nombre direccion</th>
													<th scope="col">Modelo equipo</th>
													<th scope="col">Acciones</th>
												</tr>
											</thead>
											<tbody>

												<?php
												$fecha_hoy = new DateTime();
												if (isset($data_ficha_cliente[3])) {
													foreach ($data_ficha_cliente[3] as $key3 => $value3) {

														$fechavencimientofinal_segun_prioridad = new DateTime($value3->FechaHoraPlaneadaTerminacion);
														$fecha_vencimiento_final = $fechavencimientofinal_segun_prioridad->modify('+' . $value3->HorasFinalRespuesta . ' hours');
														$diff_fechavencimientoFinal = $fecha_vencimiento_final->diff($fecha_hoy);
														$text_tooltip = "<strong>Vencido</strong> x " . $diff_fechavencimientoFinal->d . "d:" . $diff_fechavencimientoFinal->h . "h.<br>Debio cerrarse el: " . $fecha_vencimiento_final->format("Y-m-d h:m:s");
												?>
														<tr>
															<td><?php echo "OS-" . $value3->IDDoc; ?></td>
															<td>
																<?php echo definicion_estado_servicio($value3->Estado); ?>
															</td>
															<td>
																<?php echo "<span class='badge px-3' style='background-color:" . $value3->ColorPrioridad . "'>" . $value3->DescripcionPrioridad . "</span>"; ?>
															</td>
															<td>
																<?php echo (($diff_fechavencimientoFinal->format('%R') === "+") ? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='$text_tooltip'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'>Vencido</strong></span>" : "-"); ?>
															</td>
															<td><?php echo $value3->FechaHoraPlaneacionInicio; ?></td>
															<td><?php echo $value3->NombreDireccion; ?></td>
															<td><?php echo $value3->ModeloEquipo; ?></td>
															<td><a href="http://<?php echo URL_PATH ?>editardireccion/?IDServicio=<?php echo $value3->IDServicio; ?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td>
														</tr>
												<?php }
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Lista de servicios cerrados estado (4) -->
							<div class="tab-pane fade" id="servicios-tab-historico" role="tabpanel" aria-labelledby="historicoe-tab" tabindex="0" style="background-color: #fff !important;">
								<div>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
												<tr>
													<th scope="col">Documento</th>
													<th scope="col">Estado</th>
													<th scope="col">Prioridad</th>
													<th scope="col">Vencimiento</th>
													<th scope="col">Fecha cierre servicio</th>
													<th scope="col">Nombre direccion</th>
													<th scope="col">Modelo equipo</th>
													<th scope="col">Acciones</th>
												</tr>
												</tr>
											</thead>
											<tbody>

												<?php
												if (isset($data_ficha_cliente[2])) {
													foreach ($data_ficha_cliente[2] as $key4 => $value4) {
														$fechacierre_servicio = new DateTime($value4->FechaHoraCierre);
														$fecha_atencionplaneada = new DateTime($value4->FechaHoraPlaneadaTerminacion);
														$dias_entre_cierreyatencion = $fechacierre_servicio->diff($fecha_atencionplaneada);
														$text_tooltip_cerrados = ($dias_entre_cierreyatencion->format('%R') === "-") ? "Se atendio vencido x " . ($dias_entre_cierreyatencion->d) . " dias y " . ($dias_entre_cierreyatencion->h) . " horas" : "Atendido a tiempo";
												?>
														<tr>
															<td><?php echo "OS-" . $value4->IDDoc; ?></td>
															<td><?php echo definicion_estado_servicio($value4->Estado); ?></td>
															<td><?php echo "<span class='badge px-3' style='background-color:" . $value4->ColorPrioridad . "'>" . $value4->DescripcionPrioridad . "</span>"; ?></td>
															<td><?php echo (($dias_entre_cierreyatencion->format('%R') === "-") ? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='$text_tooltip_cerrados'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'></strong></span>" : "<i class='bi bi-bookmark-star-fill' style='color:green;'></i> A tiempo !"); ?></td>
															<td><?php echo $value4->FechaHoraCierre;
																	?></td>
															<td><?php echo $value4->NombreDireccion;
																	?></td>
															<td><?php echo $value4->ModeloEquipo; ?></td>
															<td><a href="http://<?php echo URL_PATH ?>editardireccion/?IDDireccion=<?php echo urlencode(openssl_encrypt($value4->IDServicio, METHODENCRIPT, KEY)); ?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td>
														</tr>
												<?php }
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ./ -->

</div>
</div>


<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirmationModalLabel">Confirmar <b>desactivacion de cliente</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="alert_model_changeestadocliente"></div>
				<p>¿Estás seguro de que deseas desactivar este cliente?.</p>
				<p>Si desactivas el cliente, ya no se podrán asignar servicios.</p>
				
				<p>
				
				<div class="mb-3">
					<label class="form-label" for="inputjustificacioncambioestado">Justificacion: ¿Por qué se desactivará este cliente? (Opcional)</label>
					<textarea class="form-control" name="inputjustificacioncambioestado" id="inputjustificacioncambioestado" cols="2"></textarea>
				</div>
				<hr>
				<p>Escriba la palabra "<strong>DESACTIVAR</strong>" para confirmar.<strong style="color:red;">*</strong>(Obligatorio)</p>
				<div class="mb-3">
					<input type="text" class="form-control" name="inputconfirmacioncambioestado" id="inputconfirmacioncambioestado" aria-describedby="helpId" placeholder="" />
				</div>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary" id="confirmChange">Sí</button>
			</div>
		</div>
	</div>
</div>



<!-- Modal de timeline cambio de estado cliente -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyModalLabel">Historial de Cambios de Estado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 0.875em;">
                <ul class="timeline">
									<?php if (!empty($data_ficha_cliente[0][0]->LogEstados)) { 
													$arrayLogEstados= json_decode($data_ficha_cliente[0][0]->LogEstados,true);
													foreach ($arrayLogEstados as $key => $value) {		?>
												<li>
													<div class="timeline-content">
														<?php echo $value['usuariocreacion']; ?>
														<br><?php echo ($value['estadonuevo'])? '<i class="bi bi-check-circle-fill" style="color:green;font-size: 1.06rem;"></i> - Activado' : '<i class="bi bi-x-circle-fill" style="color:red;font-size: 1.06rem;"></i> - Desactivado'; ?>
														<br><span><?php echo $value['fechaasignacion']; ?></span>
														<br><span class='fw-lighter'>
														<br><?php echo (strlen($value['inputjustificacioncambioestado'] > 0)) ? $value['inputjustificacioncambioestado'] : "- Sin justificación -"; ?> </span>
													</div>
												</li>
											<?php } 
										} ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

