<?php

$hoy = new DateTime();

$today = $hoy->format('Y-m-d');
?>
<style>
	.tecnico-item {
		cursor: pointer;
		margin: 5px 0;
		padding: 6px;
		border-radius: 5px;
		/* color: white; */
		text-align: center;
		font-size: 12px;
	}

	.mostrar-todos {
		margin-top: 20px;
		padding: 6px;
		background-color: #333;
		color: white;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
	}

	.quitar-todos {
		margin-top: 20px;
		padding: 6px;
		background-color: #d2d2d2;
		color: black;
		border-radius: 5px;
		text-align: center;
		cursor: pointer;
	}

	.selected {
		opacity: 1;
	}


	.unselected {
		opacity: 0.4;
	}

	.unselected .check-icon {
		display: none;
	}
</style>

<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong><i class="bi bi-person-heart align-text-bottom"></i> Agenda de servicios </strong></h3>

</div>
<!-- ./ Titulo -->

<div id="alert_form">
	<?php if (isset($_SESSION['msg'])) { ?>

		<div class="alert alert-<?php echo $_SESSION['msg']['type']; ?> alert-dismissible fade show" id="my-alert" role="alert">
			<strong><?php echo $_SESSION['msg']['title']; ?></strong>
			<p><?php echo $_SESSION['msg']['msg']; ?></p>
			<button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#my-alert" aria-label="Close"></button>
		</div>
	<?php

		unset($_SESSION['msg']);
	} ?>
</div>


<div class="container-fluid row">

	<div class="col-2" id="legend">

		<h4 style="text-align: center;">Técnicos</h4>
		<div id="tecnicos-list" class="tecnicos-list"></div>
		<div id="mostrar-todos" class="mostrar-todos" onclick="mostrarTodosLosTecnicos()">Ver todos los tecnicos</div>
		<div id="quitar-todos" class="quitar-todos" onclick="ocultarTodosLosTecnicos()">Ocultar todos</div>

	</div>

	<div class="col-10" id="calendar"> </div>

</div>

<div class="modal fade" id="selecciontecnico" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titulo_modal_programando_tecnico"></h5>
				<button type="button" id="closemodal" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="container g-3 needs-validation" name="agenda_servicio" id="agenda_servicio" novalidate>
				<input type="hidden" name="id_servicio" id="id_servicio">
				<div class="modal-body">
					<div class="container">

						<!-- Fecha, hora inicial y hora final -->
						<div class="card card-ficha-cliente categoria-cliente">
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="fecha">Fecha:</label>
											<input type="date" class="form-control fechahoraseleccionada" id="fecha_seleccionada_programando_tecnico" name="fecha_seleccionada_programando_tecnico" min="<?php echo $today; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="hora1">Hora inicial:</label>
											<input type="time" class="form-control fechahoraseleccionada" id="horainicial_programando_tecnico" name="horainicial_programando_tecnico" min="05:00" max="19:00">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="hora2">Hora final:</label>
											<input type="time" class="form-control fechahoraseleccionada" id="horafinal_programando_tecnico" name="horafinal_programando_tecnico" min="05:00" max="19:00">

										</div>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-md-12">
										<label id="textoDescriptivo"><strong><span id='fecha_seleccionada_programando_tecnicoseleccionada'></span> de <span id='horainicial_programando_tecnicoseleccionada'></span>
												hasta las: <span id='horafinal_programando_tecnicoseleccionada'></span></strong></label>
									</div>
								</div>
							</div>
						</div>

						<div class="row mt-2">
							<fieldset id="form_seleccion_cliente">
								<div class="card card-ficha-cliente categoria-cliente">
									<div class="card-body">
										<div class="row mb-1">
											<label for="select_cliente_servicionuevo" class="col-sm-4 col-form-label"><i class="bi bi-building-fill"></i> Cliente <span class="text-danger fs-6">*</span>
												<span id="MarcaClienteCategoria" class="badge rounded-pill">
													<span id="DescripcionClienteCategoria"></span>
												</span>
											</label>
											<div class="col-md-8">
												<select name="select_cliente_servicionuevo" class="form-control form-select" id="select_cliente_servicionuevo" style="width: 100%;" onchange="muestra_direcciones_cliente(),valida_input_cliente()">
													<option value="0" disabled selected>Seleccione un cliente</option>
													<?php if (isset($lista_clientes)) { ?>
														<?php foreach ($lista_clientes as $keycl => $valuecl) { ?>
															<option value="<?php echo urlencode(openssl_encrypt($valuecl->IDCliente, METHODENCRIPT, KEY)); ?>"><?php echo $valuecl->NombreCompletoCliente; ?></option>
														<?php }
													} else { ?>
														<option value="0" selected>Sin clientes</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="row mb-1">
											<label for="select_direccioncliente_servicionuevo" class="col-sm-4 col-form-label"><i class="bi bi-houses-fill"></i> Dirección cliente <span class="text-danger fs-6">*</span></label>
											<div class="col-md-8">
												<select name="select_direccioncliente_servicionuevo" class="form-control form-select" id="select_direccioncliente_servicionuevo" onchange="muestra_equipos_direccion(this.value),valida_input_cliente()">
												</select>
											</div>
										</div>
										<div class="row mb-1">
											<label for="select_equipocliente_servicionuevo" class="col-sm-4 col-form-label"><i class="bi bi-upc-scan align-text-bottom"></i> Equipos cliente <span class="text-danger fs-6">*</span></label>
											<div class="col-md-8">
												<select name="select_equipocliente_servicionuevo" class="form-control form-select" id="select_equipocliente_servicionuevo" onchange="valida_input_cliente()">

												</select>
											</div>
										</div>
									</div>
								</div>
							</fieldset>

							<fieldset id="form_propiedades_servicio" disabled>
								<div class="card card-ficha-cliente categoria-cliente mt-2">
									<div class="card-body">
										<div class="row mb-1">

											<div class="col-md-6">
												<label for="newservice_tiposervicio" class="form-label">Tipo Servicio <span class="text-danger fs-6">*</span></label>
												<select class="form-select form-select" name="newservice_tiposervicio" id="newservice_tiposervicio">
													<option selected disabled>Seleccione uno</option>
													<option value="1">Preventivo/limpieza</option>
													<option value="2">Correctivo</option>
													<option value="3">Predictivo</option>
													<option value="4">Otro</option>
												</select>
											</div>

											<div class="col-md-6">
												<label for="newservices_estado" class="form-label">Estado <span class="text-danger fs-6">*</span></label>
												<select class="form-select" name="newservices_estado" id="newservices_estado">
													<option value="0" selected>En elaboración</option>
													<option value="1">Asignado a técnico</option>
													<option value="2" disabled>Esperando repuesta</option>
													<option value="3">En espera/Pausa</option>
													<option value="4" disabled>Cerrado/Terminado</option>
													<option value="5" disabled>Anulado</option>
												</select>
											</div>

										</div>

										<div class="row mb-1">

											<div class="col-6">
												<label for="tecnicodisponible_programando_tecnico" class="form-label">Tecnico disponible <span class="text-danger fs-6">*</span></label>
												<select class="form-select" name="tecnicodisponible_programando_tecnico" id="tecnicodisponible_programando_tecnico"> </select>

											</div>
											<div class="row col-6">

												<label for="newservice_prioridad" class="form-label">Prioridad <span class="text-danger fs-6">*</span></label>
												<div class="col-md-8">
													<select class="form-select" name="newservice_prioridad" id="newservice_prioridad">
														<option selected disabled>Seleccione prioridad</option>
														<?php if (isset($lista_prioridades)) { ?>
															<?php foreach ($lista_prioridades as $key => $value) { ?>
																<option value="<?php echo $value->IDPrioridad; ?>" data-colorprioridad="<?php echo $value->ColorPrioridad; ?>" data-horasinicialrespuesta="<?php echo $value->HorasInicialRespuesta; ?>" data-horasfinalrespuesta="<?php echo $value->HorasFinalRespuesta; ?>"><?php echo $value->DescripcionPrioridad; ?></option>
															<?php }
														} else { ?>
															<option value="0" disabled selected>Sin prioridades definidas</option>
														<?php } ?>
													</select>
												</div>
												<div class="col-md-4">
													<span class="badge w-100 p-2" id="newservices_prioridad_selected"></span>
												</div>
											</div>
										</div>
										<div class="row">
											<label for="newservices_descripcion" class="form-label">Descripción <span class="text-danger fs-6">*</span> (Describa que le sucede al equipo)</label>
											<textarea class="form-control" name="newservices_descripcion" id="newservices_descripcion" cols="80" rows="3"></textarea>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" id="closemodal_btn" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="seleccion_programando_tecnico" onclick="validarFormulario()">Guardar Servicio Técnico</button>
				</div>
			</form>
		</div>
	</div>
</div>