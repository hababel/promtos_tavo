<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong><i class="bi bi-person-badge align-text-bottom"></i><span id="title_seccion">Nuevo Cliente</span></strong></h3>
	<div class="btn-toolbar mb-2 mb-md-0">
		<a name="" id="" class="btn btn-sm btn-success me-2" href="<?php echo URL_PATH . "clientes" ?>" role="button"><i class="bi bi-arrow-left"></i> volver</a>
	</div>
</div>
<!-- ./ Titulo -->
<div id="alert_form"></div>

<div class="container">
	<form id="form_clientenuevo" action="<?php echo URL_PATH ?>clientes/nuevoCliente" method="post">

		<div class="row">
			<!-- documento de identidad -->
			<div class="col-12 col-md-6">
				<label class="form-label">Documento de identidad<span style="color:red;">*</span></label>
				<div class="input-group">
					<span class="input-group-text"><i class="bi bi-person-badge"></i></span>
					<input type="text" aria-label="Documento identidad cliente" class="form-control" name="documento_cliente" id="documento_cliente" autocomplete="off" required>
					<span class="input-group-text visually-hidden">
						<div class="spinner-border spinner-border-sm" id="spinner_new_doccliente" role="status"></div>
					</span>
					<span class="input-group-text visually-hidden" id="continue_cliente">
						<a href="#"><i class="bi bi-caret-right-fill"></i></a>
					</span>
					<div class="invalid-feedback">
						El documento ya existente, por favor intente con otro documento.
					</div>
					<div class="valid-feedback">
						Valido !
					</div>
				</div>
			</div>
		</div>

		<fieldset id="datos_basicos_cliente" disabled>
			<div>
				<div class="row mt-3">
					<div class="col-12 col-md-4">
						<label for="nombre_cliente" class="form-label">Nombres <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" autocomplete="off" required value="">
					</div>

					<div class="col-12 col-md-4">
						<label for="apellidos_cliente" class="form-label">Apellidos <span style="color:red;">*</span></label>
						<input type="text" class="form-control" id="apellidos_cliente" name="apellidos_cliente" autocomplete="off" required value="">
					</div>

					<div class="col-12 col-md-4">
						<label for="email_cliente" class="form-label">Correo electrónico <span style="color:red;">*</span></label>
						<div class="input-group">
							<span class="input-group-text" id="basic-addon1">@</span>
							<input type="email" class="form-control" id="email_cliente" name="email_cliente" autocomplete="off" required value="" autofocus aria-describedby="basic-addon5">
							<div class="invalid-feedback">
								La estructura debe ser: usuario@dominio.ext.
							</div>
						</div>
					</div>

				</div>
				<div class="row mt-3">
					<div class="col-md-4 form-group">
						<label for="telefono1_cliente" class="form-label">Telefono 1<span style="color:red;">*</span></label>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
							<input type="tel" class="form-control" id="telefono1_cliente" name="telefono1_cliente" autocomplete="off" required value="">
						</div>
					</div>

					<!-- Teléfono de WhatsApp -->
					<div class="col-md-4 form-group">
						<label for="telefono2_cliente" class="form-label">Teléfono de WhatsApp:</label>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon1"><i class="bi bi-whatsapp"></i></span>
							<input type="tel" class="form-control" id="telefono2_cliente" name="telefono2_cliente" autocomplete="off" value="">
						</div>
					</div>

					<!-- Selección de fuente -->
					<div class="col-md-4 form-group">
						<label for="fuente" class="form-label">Recomendado por:</label>
						<select class="form-control" id="fuente" name="fuente" onchange="mostrarNombreRecomendado()">
							<option value="directo_tecnico">Directo desde el técnico</option>
							<option value="directo_admon">Directo desde administración</option>
							<option value="otra_fuente">Otra fuente</option>
							<option value="recomendado">Recomendado</option>
						</select>
					</div>

					<!-- Campo para el nombre del recomendado (oculto por defecto) -->
					<div class="col-4 form-group visually-hidden" id="nombreRecomendadoDiv">
						<label for="nombre_recomendado" class="form-label">Nombre del Recomendado:</label>
						<input type="text" class="form-control" id="nombre_recomendado" name="nombre_recomendado">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="notas_cliente" class="form-label">Notas</label>
						<textarea class="form-control" name="notas_cliente" id="notas_cliente" rows="6" autocomplete="off" style="resize: none;"></textarea>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="">Clasificacion cliente</label>
						<div class="row">
							<div class="col-3">
								<div class="list-group" id="list-tab" role="tablist" style="font-size: 0.85em;">
									<li class="list-group-item list-group-item-action" id="list-VIP-list" data-bs-toggle="list" href="#list-VIP" role="tab" aria-controls="list-VIP-list" style="font-weight: bold;color:black;background-color: <?php echo config_categorias_cliente["VIP"]["backgound_categoria"]; ?>;font-size: 1.2em;font-style: italic;" onclick="select_clasificacion(this.id)">
										<input class="form-check-input me-1" type="radio" name="clasificacion" value="VIP" id="clasificacionVIP">
										<label class="form-check-label" for="clasificacionVIP"><i class="bi bi-gem" style="color:green;margin-right: 4px;font-weight: bold;font-size: 1.2em;"></i>VIP</label>
									</li>
									<li class="list-group-item list-group-item-action" id="list-A-list" data-bs-toggle="list" href="#list-A" role="tab" aria-controls="list-A-list" style="font-weight: bold;color:black; background-color:<?php echo config_categorias_cliente["A"]["backgound_categoria"]; ?>" onclick="select_clasificacion(this.id)">
										<input class="form-check-input me-1" type="radio" name="clasificacion" value="A" id="clasificacionA">
										<label class="form-check-label" for="clasificacionA">A</label>
									</li>
									<li class="list-group-item list-group-item-action" id="list-B-list" data-bs-toggle="list" href="#list-B" role="tab" aria-controls="list-B-list" style="font-weight: bold;color:black;background-color: <?php echo config_categorias_cliente["B"]["backgound_categoria"]; ?>" onclick="select_clasificacion(this.id)">
										<input class="form-check-input me-1" type="radio" name="clasificacion" value="B" id="clasificacionB">
										<label class="form-check-label" for="clasificacionB">B</label>
									</li>
									<li class="list-group-item list-group-item-action" id="list-C-list" data-bs-toggle="list" href="#list-C" role="tab" aria-controls="list-C-list" style="font-weight: bold;color:black;background-color: <?php echo config_categorias_cliente["C"]["backgound_categoria"]; ?>" onclick="select_clasificacion(this.id)">
										<input class="form-check-input me-1" type="radio" name="clasificacion" value="C" id="clasificacionC">
										<label class="form-check-label" for="clasificacionC">C</label>
									</li>
									<li class="list-group-item list-group-item-action" id="list-D-list" data-bs-toggle="list" href="#list-D" role="tab" aria-controls="list-D-list" style="font-weight: bold;color:black;background-color: <?php echo config_categorias_cliente["D"]["backgound_categoria"]; ?>" onclick="select_clasificacion(this.id)">
										<input class="form-check-input me-1" type="radio" name="clasificacion" value="D" id="clasificacionD">
										<label class="form-check-label" for="clasificacionD">D-Vetado</label>
									</li>
								</div>
							</div>
							<div class="col-9" id="descripctioncategory">
								<div class="tab-content" id="nav-tabContent" style="text-align: justify;">
									<div class="tab-pane fade my-2" id="list-nuevo" role="tabpanel" aria-labelledby="list-nuevo-list">
										<b>Clientes Nuevos</b> - ¡Bienvenido! Este es un nuevo cliente con el que tenemos la oportunidad de construir una relación valiosa. Anima a los colaboradores a ofrecer un excelente servicio y atención, ayudando a este cliente a subir de nivel y convertirse en un aliado clave para nuestro negocio.
									</div>
									<div class="tab-pane fade my-2" id="list-VIP" role="tabpanel" aria-labelledby="list-VIP-list">
										<b><i class="bi bi-gem" style="margin-right: 4px;font-weight: bold;font-size: 1.4em;"></i> <span style="font-size: 1.5em;">VIP</span> </b>- Clientes que que reciben un trato diferencial por la importancia comercial que tienen para nuestra empresa. Son consumidores que seguro no quieres perder; por eso, es clave hacerlos sentir especiales brindándoles una atención superior
									</div>
									<div class="tab-pane fade my-2" id="list-A" role="tabpanel" aria-labelledby="list-A-list">
										<b>Clientes A</b> - Son muy buenos clientes. Pagan a tiempo y regularmente utilizan varios de sus servicios, lo valoran, lo refieren y le ayudan a crecer el negocio rentablemente. Estos son los clientes en los que se debe enfocar, de los que quisiera tener más. Bríndeles una atención especial y demuéstreles su aprecio cultivando relaciones de largo plazo. Son los clientes con los que da gusto trabajar.
									</div>
									<div class="tab-pane fade my-2" id="list-B" role="tabpanel" aria-labelledby="list-B-list">
										<b>Clientes B</b> - Son aquellos a los que les falta una o dos características de las de los A. Puede que a veces no paguen a tiempo o que sus solicitudes de servicios no sean tan constantes. Estos son clientes con potencial. La meta es convertir los clientes B en A. Los B son buenos clientes en los que podría trabajar y desarrollar para mejorar su desempeño. Un cliente B tiene potencial para ofrecerles servicios complementarios.
									</div>
									<div class="tab-pane fade my-2" id="list-C" role="tabpanel" aria-labelledby="list-C-list">
										<b>Clientes C</b> - Solicitan menos servicios y tienen menor potencial. Sin embargo, cuando se comparan con el esfuerzo e inversión que requiere atraer clientes totalmente nuevos, los C podrían aportar un poco más al negocio. Son clientes menos leales o que aprecian menos sus beneficios. El precio tiende a ser más importante para este grupo. La idea con ellos es tratar de llevarlos a B.
									</div>
									<div class="tab-pane fade my-2" id="list-D" role="tabpanel" aria-labelledby="list-D-list">
										<b style="color:red">Clientes D (Vetado) X</b> - Son clientes que no pagan a tiempo, quieren beneficios excesivos, demandan gran cantidad de tiempo, no invierten en sí mismos y siempre consideran que están comprando caro. Por difícil que sea, hay clientes que tienes que despedir.
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<hr>

		<!-- Acordeon de direcciones clientes -->
		<div class="accordion" id="accordionExample">

			<div class="accordion-item">
				<h2 class="accordion-header">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						Direcciones clientes (Opcional)
					</button>
				</h2>
				<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<fieldset id="direcciones_cliente" disabled>
							<div class="row ">
								<div class="row mt-3">

									<div class="col-12 col-md-3 form-group">
										<label for="nombre_direccion" class="form-label">Nombre dirección:</label>
										<input type="text" class="form-control form-control-sm direcciones_cliente" id="nombre_direccion">
									</div>

									<div class="col-12 col-md-3 form-group">
										<label for="departamento" class="form-label">Departamento:</label>
										<select class="form-control form-control-sm" id="departamento" name="departamento">
											<option disabled>Seleccione un departamento</option>
										</select>
									</div>

									<!-- Ciudad -->
									<div class="col-12 col-md-3 form-group">
										<label class="form-label" for="ciudad">Ciudad:</label>
										<select class="form-control form-control-sm" id="ciudad" name="ciudad">
											<option disabled>Seleccione la ciudad</option>
										</select>
									</div>
									<div class="col-12 col-md-3 form-group">
										<label class="form-label" for="barrio">Barrio:</label>
										<input type="text" class="form-control form-control-sm direcciones_cliente" id="barrio">
										<small class="text-danger" id="barrioError"></small>
									</div>

								</div>

								<div class="row mt-3">

									<div class="col-12 col-md-8 form-group">
										<label for="direccion" class="form-label">Dirección:</label>
										<input type="text" class="form-control form-control-sm direcciones_cliente" id="direccion">
										<small class="text-danger" id="direccionError"></small>
									</div>
									<div class="col-12 col-md-2 form-group mt-3">
										<button type="button" class="btn btn-primary direcciones_cliente form-control" onclick="agregarDireccion()">Agregar <span class="ms-2"><i class="bi bi-arrow-bar-down"></i></span></button>
									</div>
								</div>


							</div>
							<!-- Card tabla para mostrar direcciones -->
							<div class="mt-5">
								<div class="card">
									<div class="card-header d-flex justify-content-between align-items-center">
										<div>
											<h5 class="mb-0">Direcciones Agregadas</h5>
											<input type="hidden" name="direccionesselect" id="direccionesselect">
										</div>
										<div>
											<!-- Botón para eliminar todas las direcciones -->
											<button type="button" class="btn btn-danger btn-sm" id="eliminar_todas_direcciones_cliente" onclick="eliminarTodasDirecciones()"><i class="bi bi-trash-fill me-2"></i> Eliminar Todas las Direcciones</button>
										</div>
									</div>
									<div class="card-body">
										<table class="table table-sm">
											<thead>
												<tr>
													<th>Nombre</th>
													<th>Dirección</th>
													<th>Departamento</th>
													<th>Ciudad</th>
													<th>Barrio</th>
													<th>Principal</th>
													<th>Opciones</th>
												</tr>
											</thead>
											<tbody id="direccionesTabla" class="table-group-divider">
											</tbody>
										</table>
									</div>
								</div>

							</div>

						</fieldset>

					</div>
				</div>
			</div>
		</div>
<hr>
		<div class="my-3">
			<button type="reset" class="btn btn-secondary">Limpiar</button>
			<button type="submit" class="btn btn-primary" id="btn_guardarclientenuevo">Guardar</button>
		</div>
	</form>
</div>