
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
 		border-top: 3px solid <?php echo $backgound_categoria; ?>
 	}


 </style>
 <?php $hoy = new DateTime(); ?>
 <!-- Titulo Seccion segun clase en php -->
 <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
 	<h3><strong><i class="bi bi-wrench-adjustable"></i><i class="bi bi-plus" style="color:green"></i> Nuevo Servicio </strong></h3>
 	<!-- <div class="btn-toolbar mb-2 mb-md-0">
     <a class="btn btn-sm btn-primary me-2" href="<?php echo URL_PATH ?>servicios/nuevoservicio" role="button"><i class="bi bi-plus align-text-bottom"></i> Nuevo Servicio</a>
   </div> -->
 </div>
 <!-- ./ Titulo -->

 <div id="alert_form"></div>
 <?php //var_dump($lista_servicios_abiertos); 
	?>

 <div class="container">
 	<section class="content">
 		<div class="main-body mt-3">
 			<div class="row">
 				<div class="col-12 col-lg-7">
 					<div class="mb-2">
 						<a class="icon-link" href="<?php echo URL_PATH; ?>servicios" style="text-decoration: none;">
 							<i class="bi bi-caret-left-fill"></i> Atras
 						</a>
 					</div>
 					<form class="container g-3 needs-validation" novalidate>

 						<fieldset id="form_seleccion_cliente" disabled>
 							<div class="card card-ficha-cliente categoria-cliente">
 								<div class="card-body">
 									<div class="row mb-1">
 										<label for="select_cliente_servicionuevo" class="col-sm-4 col-form-label"><i class="bi bi-building-fill"></i> Cliente <span class="text-danger fs-6">*</span></label>
 										<div class="col-md-8">
 											<select name="select_cliente_servicionuevo" class="form-control form-select" id="select_cliente_servicionuevo" style="width: 100%;" onchange="muestra_direcciones_cliente(),valida_input_cliente()">
 												<option value="0" disabled selected>Seleccione un cliente</option>
 												<?php foreach ($lista_clientes as $keycl => $valuecl) { ?>
 													<option value="<?php echo urlencode(openssl_encrypt($valuecl->IDCliente, METHODENCRIPT, KEY)); ?>"><?php echo $valuecl->NombreCompletoCliente; ?></option>
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
 							<div class="card card-ficha-cliente categoria-cliente">
 								<div class="card-body">
 									<div class="row mb-1">
 										<label for="newservice_tiposervicio" class="col-sm-4 col-form-label">Tipo Servicio <span class="text-danger fs-6">*</span></label>
 										<div class="col-md-8">
 											<select class="form-select form-select" name="newservice_tiposervicio" id="newservice_tiposervicio">
 												<option selected disabled>Seleccione uno</option>
 												<option value="1">Preventivo/limpieza</option>
 												<option value="2">Correctivo</option>
 												<option value="3">Predictivo</option>
 												<option value="4">Otro</option>
 											</select>
 										</div>
 									</div>

 									<div class="row mb-1">
 										<label for="newservice_prioridad" class="col-sm-3 col-form-label">Prioridad <span class="text-danger fs-6">*</span></label>
 										<div class="col-sm-3 mx-0 my-0 text-lg-center">
 											<h5><span class="badge w-100" id="newservices_prioridad_selected"></span></h5>
 										</div>
 										<div class="col-md-6">
 											<select class="form-select form-select" name="newservice_prioridad" id="newservice_prioridad">
 												<option selected disabled>Seleccione prioridad</option>
 												<?php foreach ($lista_prioridades as $key => $value) { ?>
 													<option value="<?php echo $value->IDPrioridad; ?>" data-colorprioridad="<?php echo $value->ColorPrioridad; ?>" data-horasinicialrespuesta="<?php echo $value->HorasInicialRespuesta; ?>" data-horasfinalrespuesta="<?php echo $value->HorasFinalRespuesta; ?>"><?php echo $value->DescripcionPrioridad; ?></option>
 												<?php } ?>
 											</select>
 										</div>
 									</div>

 									<div class="row mb-1">
 										<label for="newservices_estado" class="col-sm-4 form-label">Estado <span class="text-danger fs-6">*</span></label>
 										<div class="col-md-8 mx-0 my-0 text-lg-center">
 											<select class="form-select form-select" name="newservices_estado" id="newservices_estado" disabled>
 												<option value="0" selected>En elaboración</option>
 												<option value="1">Asignado a técnico</option>
 												<option value="2">Esperando repuesto</option>
 												<option value="3">En espera/Pausa</option>
 												<option value="4">Cerrado/Terminado</option>
 												<option value="5">Anulado</option>
 											</select>
 										</div>
 									</div>

 									<div class="row">
 										<label for="newservices_descripcion" class="form-label">Descripción <span class="text-danger fs-6">*</span> (Describa que le sucede al equipo)</label>
 										<textarea class="form-control" name="newservices_descripcion" id="newservices_descripcion" cols="80" rows="3"></textarea>
 									</div>

 								</div>
 							</div>
 						</fieldset>

 					</form>

 				</div>
 				<div class="col-12 col-lg-5 z-3">
 					<div class="card card-ficha-cliente">
 						<div class="card-body" style="padding-top: 2px;">
 							<div class="d-flex flex-column align-items-center text-center">
 								<div class="mt-2">
 									<!-- Cliente categoria VIP,A,B,C,D -->
 									<h4 id="ClasificacionCliente">
 										<span id="MarcaClienteCategoria" class="position-absolute  start-0 translate-middle badge rounded-pill" style="top: 0.7em;box-shadow: 0 4px 8px 0 rgba(0, 0, 0,0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.4);">
 											<span id="DescripcionClienteCategoria"></span>
 										</span>
 									</h4>
 									<h4 id="NombreCliente"></h4>
 									<p class="text-secondary mb-1">Recomendado: <span id="RecomendadoCliente"></span></p>
 									<p class="text-secondary mb-1">Creado desde: <span id="FechaCreacionCliente"></span> <i class='bi bi-info-circle-fill' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='Creado el --' id="FechaCreacionTooltip"></i></p>
 									<p>Ir a ficha cliente <span class="col-md-3" id="accesofichacliente"></span></p>
 								</div>
 							</div>
 							<hr class="my-1">
 							<ul class="list-group list-group-flush">
 								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
 									<h6 class="mb-0">Estado</h6>
 									<div class="form-check form-switch" style="text-align:left;">
 										<label for="CheckEstadoCliente">
 											<i id="EstadoClienteActivo" class="bi bi-check-circle-fill d-none" style="color:green;font-size: 1.06rem;"></i>
 											<i id="EstadoClienteInactivo" class="bi bi-x-circle-fill d-none" style="color:red;font-size: 1.06rem;"></i></label>
 										<input id="CheckEstadoCliente" class="form-check-input" type="checkbox" role="switch" readonly>
 									</div>
 								</li>
 								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
 									<h6 class="mb-0">
 										<i class="bi bi-whatsapp me-1"></i> Whatapp
 									</h6>
 									<span class="text-secondary">
 										<a id="TelefonoWhatsappCliente" target="_blank" style="text-decoration: none;color:green"> <i class="bi bi-box-arrow-up-right"></i></a>
 									</span>
 								</li>
 								
 							</ul>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>

 		<div class="row">
 			<div class="col-12">
 				<div class="card card-ficha-cliente categoria-cliente">
 					<div class="card-body">
 						<div id="fullcalendar"></div>
 					</div>
 					<div class="card-footer">
 						<div class="row">
 							<div class="col-4 my-2">
 								<button class="btn btn-primary" type="button" id="guardar_nuevoservicio"><i class="bi bi-cloud-plus-fill"></i> Guardar Servicio</button>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</section>
 </div>


 <!-- Modal -->
 <div class="modal fade" id="selecciontecnico" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
 	<div class="modal-dialog" role="document">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h5 class="modal-title" id="titulo_modal_programando_tecnico"></h5>
 				<button type="button" id="closemodal" class="close" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">&times;</span>
 				</button>
 			</div>
 			<div class="modal-body">
 				<div class="container">
 					<div class="row">
 						<div class="mb-4 px-1 col-12">
 							Fecha seleccionada: <strong class="ms-2"><span id="fecha_seleccionada_programando_tecnico" class="fs-4 fst-italic"> </span></strong>
 						</div>
 					</div>
 					<div class="row">
 						<div class="px-0 col-12 col-md-4">
 							Tecnico disponible
 						</div>
 						<div class="mb-2 px-1 col-12 col-md-8">
 							<select class="form-select" name="tecnicodisponible_programando_tecnico" id="tecnicodisponible_programando_tecnico"> </select>
 						</div>
 					</div>
 					<div class="row">
 						<div class="mb-2 px-1 col-md-6 col-12">
 							<label for="" class="form-label">Hora Inicial: </label>
 							<div class="row">
 								<div class="col-5 pe-1">
 									<input type="text" class="form-control" name="horainicial_programando_tecnico" id="horainicial_programando_tecnico" aria-describedby="helpId" placeholder="">
 								</div>
 								<div class="col-5 ps-1">
 									<select class="form-select" id="AMPM_horainicial_programando_tecnico">
 										<option value="AM">AM</option>
 										<option value="PM">PM</option>
 									</select>
 								</div>
 							</div>
 						</div>

 						<div class="mb-2 px-1 col-md-6 col-12">
 							<label for="" class="form-label">Hora Final: </label>
 							<div class="row">
 								<div class="col-5 pe-1">
 									<input type="text" class="form-control" name="horafinal_programando_tecnico" id="horafinal_programando_tecnico" aria-describedby="helpId" placeholder="">
 								</div>
 								<div class="col-5 pe-1">
 									<select class="form-select" id="AMPM_horafinal_programando_tecnico">
 										<option value="AM">AM</option>
 										<option value="PM">PM</option>
 									</select>
 								</div>
 							</div>
 						</div>
 					</div>

 				</div>

 				<div class="visually-hidden" id="info_adicional_evento">
 					<div class="card mt-2">
 						<div class="card-body">
 							<div class="row">
 								<div class="col">
 									<div>Prioridad:</div>
 									<span id="prioridad_evento_existente"></span>
 								</div>
 								<div class="col">
 									Tomado: <span id="infotomado_evento_existente"></span>
 								</div>
 								<div class="col">
 									Estado: <span id="estado_evento_existente"></span>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>

 				<div class="mt-4">
 					<label for="notas_evento_existente" class="form-label">Notas programación del servicio</label>
 					<textarea class="form-control" name="" id="notas_evento_existente" rows="3"></textarea>
 				</div>
 			</div>
 			<div class="modal-footer">
 				<button type="button" class="btn btn-secondary" id="closemodal_btn" data-dismiss="modal">Cerrar</button>
 				<button type="button" class="btn btn-primary" id="seleccion_programando_tecnico">Seleccionar Técnico</button>
 			</div>
 		</div>
 	</div>
 </div>