const config_categorias_cliente={
        "VIP":
            {
                "backgound_categoria": "#F9C304",
                "color_font":"white",
                "style_font": "italic",
                "font_size": "font-size: 0.7rem"
            } 
        ,"A":
            {
                "backgound_categoria" : "#08D908",
                "color_font" : "white",
                "style_font" : "normal",
                "font_size" : "font-size: 0.7rem"
            }
        ,"B":
            {
                "backgound_categoria" : "#0FA4E1",
                "color_font" : "white",
                "style_font" : "normal",
                "font_size" : "font-size: 0.7rem"
            }
        ,"C":
            {
                "backgound_categoria" : "#FC994B",
                "color_font" : "white",
                "style_font" : "normal",
                "font_size" : "font-size: 0.7rem"
            }
        ,"D":
            {
                "backgound_categoria" : "#B0B0B0",
                "color_font" : "black",
                "style_font" : "normal",
                "font_size" : "font-size: 0.7rem"
            }
        }		

		var tecnicosListEl = document.getElementById('tecnicos-list');
		var tecnicosData = [];  // Aquí se almacenará la lista de técnicos
		var calendar;  // Variable global para el calendario

		const NombresDias = ["Domingo","Lunes", "Martes", "Miercoles","Jueves","Viernes","Sabado"];
		const NombresMeses = ["Enero","Febrero", "Marzo", "Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		const InicialesNombresMeses = ["Ene","Feb", "Mar", "Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
		const InicialesNombresDias=["Dom","Lun","Mar","Mier","Jue","Vier","Sab"]

		// Función para obtener la lista de técnicos mediante AJAX
		function obtenerTecnicos() {
				fetch(document.getElementById('url_path').value+'servicios/listartecnicosdisponibles')
						.then(response => response.json())
						.then(tecnicos => {
								tecnicosData = tecnicos;  // Guardar la lista en una variable global
								mostrarTecnicos(tecnicos);  // Mostrar la lista de técnicos en la interfaz
								//generarEventosAleatorios(tecnicos);  // Generar eventos aleatorios para cada técnico
						})
						.catch(error => console.error('Error al obtener técnicos:', error));
		}

		// Función para mostrar la lista de técnicos
		function mostrarTecnicos(tecnicos) {

				var tecnicosListEl = document.getElementById('tecnicos-list');
				tecnicosListEl.innerHTML = '';  // Limpiar el contenedor de técnicos

				tecnicos.forEach(function(tecnico) {
						var tecnicoItem = document.createElement('div');
						tecnicoItem.className = 'tecnico-item selected';
						tecnicoItem.style.backgroundColor = tecnico.ColorTecnico;
						tecnicoItem.textContent = tecnico.NombreCompletoTecnico;

						var checkIcon = document.createElement('span');
						checkIcon.className = 'check-icon ms-2';
						checkIcon.innerHTML = '&#10003;'; // Ícono de check ✔
						tecnicoItem.appendChild(checkIcon);

						// Al hacer clic en un técnico, alterna la visibilidad de sus servicios en el calendario
						tecnicoItem.addEventListener('click', function() {
								alternarVisibilidadTecnico(tecnico.IDTecnico, tecnicoItem);
						});

						tecnicosListEl.appendChild(tecnicoItem);
				});
		}

		// Función para alternar la visibilidad de los eventos de un técnico
		function alternarVisibilidadTecnico(tecnicoId, tecnicoItem) {
				var isSelected = tecnicoItem.classList.toggle('selected');
				var eventosTecnico = calendar.getEvents().filter(evento => evento.extendedProps.IDTecnicoAsignado === tecnicoId);

						// Cambiar la apariencia del elemento (marcado o desmarcado)
						if (isSelected) {
								tecnicoItem.classList.remove('unselected');
								tecnicoItem.classList.add('selected');
						} else {
								tecnicoItem.classList.remove('selected');
								tecnicoItem.classList.add('unselected');
						}

				eventosTecnico.forEach(function(evento) {
						if (isSelected) {
								evento.setProp('display', '');  // Mostrar eventos
						} else {
								evento.setProp('display', 'none');  // Ocultar eventos
						}
				});
		}

		// Función para mostrar todos los técnicos y sus eventos
		function mostrarTodosLosTecnicos() {
				var tecnicosItems = document.querySelectorAll('.tecnico-item');
				tecnicosItems.forEach(function(tecnicoItem) {
						tecnicoItem.classList.replace('unselected','selected');  // Seleccionar todos los técnicos
				});

				// Mostrar todos los eventos
				var todosEventos = calendar.getEvents();
				todosEventos.forEach(function(evento) {
						evento.setProp('display', '');  // Mostrar todos los eventos
				});
		}

		function ocultarTodosLosTecnicos(){

			var tecnicosItems = document.querySelectorAll('.tecnico-item');
			tecnicosItems.forEach(function(tecnicoItem) {
					tecnicoItem.classList.replace('selected','unselected');  // Seleccionar todos los técnicos
			});

			// Mostrar todos los eventos
			var todosEventos = calendar.getEvents();
			todosEventos.forEach(function(evento) {
					evento.setProp('display', 'none');  // Mostrar todos los eventos
			});
		}

		// Generar eventos aleatorios para los técnicos
		function mostrareventosservicios(eventos) {

				calendar.addEventSource(eventos);
		}

	function eliminarTodosLosEventos() {
		calendar.getEvents().forEach(event => event.remove());
	}

		function listareventosparacalendario(){
				fetch(document.getElementById('url_path').value+'servicios/listareventosparacalendario')
					.then(response => response.json())
					.then(eventos => {
							mostrareventosservicios(eventos);  // Mostrar la lista de técnicos en la interfaz
					})
					.catch(error => console.error('Error al obtener técnicos:', error));
		}

		function abrirModal(IDTecnico,Fecha,HoraInicio,HoraFinal,detalle_evento) {

				var titulo_modal_programando_tecnico =document.getElementById("titulo_modal_programando_tecnico");
				var prioridad_evento_existente=document.getElementById("prioridad_evento_existente");
				var infotomado_evento_existente=document.getElementById("infotomado_evento_existente")
				var estado_evento_existente=document.getElementById("estado_evento_existente")
				let CategoriaCliente=document.getElementsByClassName("categoria-cliente")
	
				var horainicial_programando_tecnico=document.getElementById("horainicial_programando_tecnico")
				var horafinal_programando_tecnico=document.getElementById("horafinal_programando_tecnico")
				var AMPM_horainicial_programando_tecnico=document.getElementById("AMPM_horainicial_programando_tecnico")
				var AMPM_horafinal_programando_tecnico=document.getElementById("AMPM_horafinal_programando_tecnico")

				var galleryModal = new bootstrap.Modal(document.getElementById('selecciontecnico'), { keyboard: false });
				galleryModal.show();

				for (let index = 0; index < CategoriaCliente.length; index++) {
					CategoriaCliente[index].style.borderTop = "3px solid #e4e4e4";
				}

				document.getElementById('seleccion_programando_tecnico').addEventListener('click', function () {
				
					var tecnicodisponible_programando_tecnico = document.getElementById("tecnicodisponible_programando_tecnico");
					var newservices_estado = document.getElementById("newservices_estado");
					var tecnico_seleccionado=tecnicodisponible_programando_tecnico.options[tecnicodisponible_programando_tecnico.selectedIndex];
					
					if (!tecnico_seleccionado || tecnico_seleccionado === "undefined") {
							tecnico_seleccionado=tecnicodisponible_programando_tecnico.options[0]
					}
			
					var evento=calendar.getEventById(detalle_evento.id)
					evento.setProp('borderColor', 'black');
					evento.setProp('textColor', 'white');
					evento.setExtendedProp('tecnico', tecnico_seleccionado.text)
					evento.setProp('backgroundColor', tecnico_seleccionado.dataset.colortecnico)
					evento.setExtendedProp('IDTecnicoAsignado', tecnico_seleccionado.value)

					calendar.render();

					newservices_estado.options[1].selected=true;
					//Oculta la modal
					galleryModal.hide();

				});

				document.getElementById('closemodal').addEventListener('click', function () {
					galleryModal.hide();
				});

				document.getElementById('closemodal_btn').addEventListener('click', function () {
					galleryModal.hide();
				});
		
				obtenertecnicosdisponibles(HoraInicio,HoraFinal,Fecha)
				
				if(IDTecnico){
					var selecttecnicos=document.getElementById("tecnicodisponible_programando_tecnico");
					var fecha_horafinalservicio=new Date(detalle_evento.end)
					var diff_fechavencimientoFinal =fecha_horafinalservicio-hoy;
					const meses_vencimiento = Math.floor(diff_fechavencimientoFinal / (1000 * 60 * 60 * 24 * 30));
					const dias_vencimiento = Math.floor((diff_fechavencimientoFinal - (meses_vencimiento * (1000 * 60 * 60 * 24 * 30))) / (1000 * 60 * 60 * 24));
					const horas_vencimiento = Math.floor((diff_fechavencimientoFinal - (meses_vencimiento * (1000 * 60 * 60 * 24 * 30)) - (dias_vencimiento * (1000 * 60 * 60 * 24))) / (1000 * 60 * 60));
					var text_tooltip = "<strong>Vencido</strong> x "+dias_vencimiento + "d:" + horas_vencimiento + "h.<br>Debio cerrarse el: "+ padZero(fecha_horafinalservicio.getDay())+"/"+InicialesNombresMeses[fecha_horafinalservicio.getMonth()]+"/"+fecha_horafinalservicio.getFullYear() +" a las "+ padZero(fecha_horafinalservicio.getHours())+':'+ padZero(fecha_horafinalservicio.getMinutes())+':'+padZero(fecha_horafinalservicio.getSeconds());;
					titulo_modal_programando_tecnico.innerHTML="Detalle de evento: <strong><i>"+detalle_evento.title+"</i></strong>";
				

					prioridad_evento_existente.innerHTML=`
								<span class='badge px-3' style='background-color:` + detalle_evento.extendedProps.ColorPrioridad + `'>`
									+ detalle_evento.extendedProps.DescripcionPrioridad + `
								</span><div>`+((diff_fechavencimientoFinal < 0) ? "<span class='badge text-bg-warning' id='tooltip' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='"+text_tooltip+"'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'>Vencido</strong></span></div>" : "-")
					infotomado_evento_existente.innerHTML=detalle_evento.extendedProps.EstadoTomado
					estado_evento_existente.innerHTML=detalle_evento.extendedProps.EstadoServicio

						if((diff_fechavencimientoFinal < 0)){
									var tooltip_elem=document.getElementById("tooltip")
									var tooltip = new bootstrap.Tooltip(tooltip_elem);
						}

				}else{
					//Es un evento nuevo que se esta programando en el momento.
					titulo_modal_programando_tecnico.innerHTML="Crear servicio nuevo"
					
				}
		}

		function obtenertecnicosdisponibles(horainicial,horafinal,fecha){


			var horainicial_programando_tecnico=document.getElementById("horainicial_programando_tecnico");
			var horafinal_programando_tecnico=document.getElementById("horafinal_programando_tecnico");

			// Formatear la fecha en "yyyy-mm-dd" para enviar a la consulta de DataBase
			var fecha_formateada = fecha.getFullYear() + '-' + padZero(fecha.getMonth()+1) + '-' + padZero(fecha.getDate());
			// Obtener la porción de la hora y se le da formato hh:mm:ss
			var horaInicialSeleccionada_formateada = padZero(horainicial.getHours())+':'+ padZero(horainicial.getMinutes())+':'+padZero(horainicial.getSeconds());
			//Se da formato a hora final
			var horaFinalSeleccionada_formateada=padZero(horafinal.getHours())+':'+ padZero(horafinal.getMinutes())+':'+padZero(horafinal.getSeconds());


			var selecttecnicos=document.getElementById("tecnicodisponible_programando_tecnico");
			selecttecnicos.innerHTML="";
			let ajaxUrl = url_path.value+'servicios/listartecnicosdisponibles';
			var xhr = new XMLHttpRequest();
			let formData = new FormData();
			formData.append("horainicial",horaInicialSeleccionada_formateada)
			formData.append("horafinal",horaFinalSeleccionada_formateada)
			formData.append("fecha",fecha_formateada)

			xhr.open('POST', ajaxUrl , true);
			xhr.onload = function() {
				if (xhr.status >= 200 && xhr.status < 400) {
					var listtecnicosdisponibles = JSON.parse(xhr.responseText);

					for (let index = 0; index < listtecnicosdisponibles.length; index++) {
						let newoption = document.createElement("option");
						newoption.value = listtecnicosdisponibles[index].IDTecnico
						newoption.text=listtecnicosdisponibles[index].NombreCortoTecnico
						newoption.dataset.colortecnico =listtecnicosdisponibles[index].ColorTecnico
						selecttecnicos.appendChild(newoption);
					}
				}
			};
			xhr.onerror = function() {
				console.log('Error de red al intentar obtener eventos');
			};
			xhr.send(formData);
		}

		function padZero(num) {
			return (num < 10 ? '0' : '') + num;
		}

		function muestra_direcciones_cliente(){

			let IDCliente=document.getElementById("select_cliente_servicionuevo").value
			let select_direccionescliente = document.getElementById("select_direccioncliente_servicionuevo");
			let select_equipocliente = document.getElementById("select_equipocliente_servicionuevo");
			var form_seleccion_cliente=document.getElementById("form_seleccion_cliente")
			var form_propiedades_servicio=document.getElementById("form_propiedades_servicio")

			const url_path= document.getElementById("url_path").value
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let requestCliente = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = url_path+'clientes/lista_direccionxcliente'; 
			let ajaxUrlCliente=url_path+'clientes/ficha_cliente_ajax';
			let formData = new FormData();
			let accesofcihacliente=document.getElementById("accesofichacliente")

			//vacias select de direcciones del cliente
			select_direccionescliente.innerHTML = '';
			// Vaciar select de equipo cliente
			select_equipocliente.innerHTML = '';
			
			// Retorna informacion ficha cliente
			let formDataCliente = new FormData();
			formDataCliente.append('IDCliente',IDCliente);
			requestCliente.open("POST",ajaxUrlCliente,true);
			requestCliente.send(formDataCliente);

			requestCliente.onreadystatechange = function(){
					if(requestCliente.readyState == 4 && requestCliente.status == 200){
						let objData2 = JSON.parse(requestCliente.responseText);

						if(objData2.status){ 
							if(objData2.data.length > 0){
								lista_equiposxdirecciones=objData2.data[7];
								// accesofcihacliente.innerHTML='<a name="" id="" href="'+url_path+'clientes/ficha_cliente/?TICK='+IDCliente+'" role="button" style="text-decoration: none;"><i class="bi bi-person-vcard-fill" style="font-size:1.5em;"></i></a>'

								//Se llena select direcciones.
									option = document.createElement("option");
									option.text="Seleccione una dirección del cliente"
									option.value=0
									option.disabled=true
									select_direccionescliente.appendChild(option);

									for (let i = 0; i < (objData2.data[6]).length; i++) {

										option = document.createElement("option");
										option.value = objData2.data[6][i].IDClienteDirecciones;
										option.text = objData2.data[6][i].NombreDireccion;
										select_direccionescliente.appendChild(option);
									}

									// Seleccionar automáticamente el primer ítem
									select_direccionescliente.options[0].selected = true;

								//./

								// Defino las variables para los elementos
								let ClienteCategoria=document.getElementById("DescripcionClienteCategoria");
								let MarcaClienteCategoria=document.getElementById("MarcaClienteCategoria");
								let NombreCliente=document.getElementById("NombreCliente");
								let RecomendadoCliente=document.getElementById("RecomendadoCliente");
								let FechaCreacionCliente=document.getElementById("FechaCreacionCliente");
								let FechaCreacionTooltip=document.getElementById("FechaCreacionTooltip")
								let CheckEstadoCliente=document.getElementById("CheckEstadoCliente")
								let EstadoClienteActivo=document.getElementById("EstadoClienteActivo")
								let EstadoClienteInactivo=document.getElementById("EstadoClienteInactivo")
								let TelefonoWhatsappCliente=document.getElementById("TelefonoWhatsappCliente")
								let CorreoFichaCliente=document.getElementById("CorreoFichaCliente")
								let CategoriaCliente=document.getElementsByClassName("categoria-cliente")

								//Se llena el estilo seguna la ClasificacionCliente
								config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].backgound_categoria
								config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].color_font
								config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].style_font
								config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].font_size

								// Se asigna los valores a los elementos segun la categoria
								MarcaClienteCategoria.style.backgroundColor=config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].backgound_categoria;
								MarcaClienteCategoria.style.color=config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].color_font;
								MarcaClienteCategoria.style.fontStyle=config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].style_font;
								MarcaClienteCategoria.style.fontSize=config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].font_size;

								//Se construye texto y color de la etiqueta de la clasificacion del cliente
								let descripcioncategoriacliente=null;
								if(objData2.data[0][0].ClasificacionCliente=="VIP"){
									descripcioncategoriacliente="<i class='bi bi-gem' style='color:green;margin-right: 0px;font-weight: bold;margin-left: 2px;'></i> "+objData2.data[0][0].ClasificacionCliente;
								}else{
									descripcioncategoriacliente=objData2.data[0][0].ClasificacionCliente
								}
								ClienteCategoria.innerHTML=descripcioncategoriacliente

								//Segun clasificacion del cliente se pone color en todas las top card de class CategoriaCliente
								for (let index = 0; index < CategoriaCliente.length; index++) {
									CategoriaCliente[index].style.borderTop = "3px solid " + config_categorias_cliente[objData2.data[0][0].ClasificacionCliente].backgound_categoria;
								}
								
							}else{
								lista_equiposxdirecciones=[];
							}
						}
					}
			}

		}

		function muestra_equipos_direccion(element){

			let select_equipocliente = document.getElementById("select_equipocliente_servicionuevo");
			const lista_equiposxdirecciones_direccionselect = lista_equiposxdirecciones.filter((elemento) => elemento.IDClienteDireccion == element);

			if(lista_equiposxdirecciones_direccionselect.length > 0 ){
				select_equipocliente.innerHTML = '';
				option = document.createElement("option");
				option.value=0
				option.text="Seleccione un equipo asociado a la dirección cliente"
				option.disabled=true
				select_equipocliente.appendChild(option);
				for (let i = 0; i < (lista_equiposxdirecciones_direccionselect).length; i++) {
						option = document.createElement("option");
						option.value = lista_equiposxdirecciones_direccionselect[i].IDEquipoCliente;
						option.text = lista_equiposxdirecciones_direccionselect[i].DescripcionEquipo;
						select_equipocliente.appendChild(option);
				}
			}else{
				select_equipocliente.innerHTML = '';
				option = document.createElement("option");
				option.value = 0;
				option.text = "No existen equipos registrados en esta dirección";
				option.disabled=true
				select_equipocliente.appendChild(option);
				option.disabled=true
			}

			// Seleccionar automáticamente el primer ítem
			select_equipocliente.options[0].selected = true;
		}

		function valida_input_cliente(){

			let select_direccionescliente = document.getElementById("select_direccioncliente_servicionuevo");
			let select_equipocliente = document.getElementById("select_equipocliente_servicionuevo");
			var form_seleccion_cliente=document.getElementById("form_seleccion_cliente")
			var form_propiedades_servicio=document.getElementById("form_propiedades_servicio")

			//Validar si los input de la informacion y equipos de cliente esta llena habilitar los campos del nuevo servicio
			if((select_direccionescliente.value > 0) && (select_equipocliente.value > 0)){
					form_propiedades_servicio.disabled=false
			}else{
					form_propiedades_servicio.disabled=true
			}

		}

// Función para validar el formulario
	function validarFormulario() {
			// Obtener los valores de los campos del formulario
			var fecha = document.getElementById("fecha_seleccionada_programando_tecnico").value;
			var hora1 = document.getElementById("horainicial_programando_tecnico").value;
			var hora2 = document.getElementById("horafinal_programando_tecnico").value;
			var cliente = document.getElementById("select_cliente_servicionuevo").value;
			var direccion = document.getElementById("select_direccioncliente_servicionuevo").value;
			var equipo = document.getElementById("select_equipocliente_servicionuevo").value;
			
			var descripcion = document.getElementById("newservices_descripcion").value;
			var estado=document.getElementById("newservices_estado").value;

			var prioridadSelect = document.getElementById("newservice_prioridad");
			var prioridad=prioridadSelect.options[prioridadSelect.selectedIndex].value;

			var servicioSelect=document.getElementById("newservice_tiposervicio");
			var tipoServicio=servicioSelect.options[servicioSelect.selectedIndex].value;

			var tecnicoSelect = document.getElementById("tecnicodisponible_programando_tecnico");
			var tecnico = tecnicoSelect.options[tecnicoSelect.selectedIndex].value;


			// Validar que los campos no estén vacíos
			if (fecha == "" || hora1 == "" || hora2 == "" || cliente == "" || direccion == "" || equipo == "" || tipoServicio == "" || prioridad == "" || descripcion == "") {
					// Mostrar un mensaje de error si algún campo está vacío
					alert("Por favor, complete todos los campos del formulario.");
					// return false;
			}

			// Validar que la hora inicial sea menor que la hora final
			var hora1Obj = new Date("2000-01-01 " + hora1);
			var hora2Obj = new Date("2000-01-01 " + hora2);
			if (hora1Obj >= hora2Obj) {
					// Mostrar un mensaje de error si la hora inicial es mayor o igual que la hora final
					alert("La hora inicial debe ser menor que la hora final.");
					return false;
			}
			console.log(tecnico);
			// Si todos los campos son válidos, enviar la información a través de AJAX
			enviarInformacionAjax(fecha, hora1, hora2, cliente, direccion, equipo, tipoServicio, prioridad, descripcion,estado,tecnico);
	}

// Función para enviar la información a través de AJAX
	function enviarInformacionAjax(fecha, hora1, hora2, cliente, direccion, equipo, tipoServicio, prioridad, descripcion,estado,tecnico) {
			
			const url_path= document.getElementById("url_path").value
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = url_path+'agenda/crearNuevoServicio'; 

			// Crear un nuevo objeto XMLHttpRequest
			var xhr = new XMLHttpRequest();

			// Configurar la solicitud AJAX
			xhr.open("POST", ajaxUrl, true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			// Crear la cadena de parámetros para enviar a través de AJAX
			var params = "fecha=" + fecha + "&hora1=" + hora1 + "&hora2=" + hora2 + "&cliente=" + cliente + "&direccion=" + direccion + "&equipo=" + equipo + "&tipoServicio=" + tipoServicio + "&prioridad=" + prioridad + "&descripcion=" + descripcion+"&estado="+estado+"&tecnico="+encodeURIComponent(tecnico);

			// Enviar la solicitud AJAX
			xhr.send(params);

			// Manejar la respuesta AJAX
			xhr.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {

							// Mostrar un mensaje de éxito al usuario
							alert("El servicio se ha creado correctamente.");

							// Restablecer el formulario
							document.getElementById("agenda_servicio").reset();

							// Cerrar la modal
							$("#selecciontecnico").modal("hide");
							
							eliminarTodosLosEventos()
							listareventosparacalendario()

					}
			}
	}


	document.addEventListener('DOMContentLoaded', function() {


		let newservices_prioridad_selected=document.getElementById("newservices_prioridad_selected");
		let newservice_prioridad=document.getElementById("newservice_prioridad");
		
		listareventosparacalendario()

		$('#select_cliente_servicionuevo').select2({
			dropdownParent: $('#selecciontecnico')
		});

		// Selecciona los elementos select con los que vas a trabajar
		const selectTecnico = document.getElementById("tecnicodisponible_programando_tecnico");
		const selectEstado = document.getElementById("newservices_estado");

		// Escucha los cambios en el select de técnico
		selectTecnico.addEventListener("change", () => {
				// Si se selecciona un técnico diferente a 0, cambia el estado a 1
				if (selectTecnico.value !== "00") {
						selectEstado.value = "1";
				} 
		});

		// Escucha los cambios en el select de estado
		selectEstado.addEventListener("change", () => {
				// Si se selecciona el estado 0, cambia la selección del técnico a 0
				if (selectEstado.value === "0") {
						selectTecnico.value = "00";
				}
		});
					
		newservice_prioridad.addEventListener('change', function() {
			var indiceSeleccionado = newservice_prioridad.selectedIndex;
			let datacolorprioridad=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-colorprioridad");
			let dataHorasInicialRespuesta=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-horasinicialrespuesta");
			let dataHorasFinalRespuesta=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-horasfinalrespuesta");
			newservices_prioridad_selected.innerHTML=newservice_prioridad.options[indiceSeleccionado].text;
			newservices_prioridad_selected.style.backgroundColor=datacolorprioridadckgroundColor=datacolorprioridad

		})

		var calendarEl = document.getElementById('calendar');
		calendar = new FullCalendar.Calendar(calendarEl, {

			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'dayGridMonth,timeGridWeek,timeGridDay'
			},
			initialView: 'timeGridWeek',
			buttonText: {
						today: 'Hoy',
						month: 'Mes',
						week: 'Semana',
						day: 'Día'
					},
			locale: 'es',
			slotLabelFormat:{
				hour: 'numeric',
				minute: '2-digit',
				omitZeroMinute: true,
				hour12:true,
				meridiem: 'short',
			},
			businessHours: [ 
				{
					daysOfWeek: [ 1, 2, 3, 4, 5 ], //lunes, martes, miercoles, jueves, vierne
					startTime: '06:00', 
					endTime: '20:00' 
				},
				{
					daysOfWeek: [ 6 ],  //Sabado
					startTime: '8:00', 
					endTime: '14:00' 
				}
			],
			slotMinTime: '06:00:00', // Hora inicial del calendario
			slotMaxTime: '23:00:00', // Hora final del calendario
			height: 800, //Altura del calendario

			initialDate: new Date(), // Fecha inicial como "hoy"
			firstDay: new Date().getDay(), // Primer día de la semana como "hoy" 
			events: [],  // Se llenarán más adelante con eventos 
			datesSet: function(dateInfo) {
					var fechaInicio = dateInfo.start;
					var fechaFin = dateInfo.end;
			},
			
			selectAllow: function(selectInfo) {
				return true;
			},

			//Acciones de una fecha seleccionada
			select: function(info) {
				var descripcionfecha
				var check = info.start;
				var today = new Date(); // Obtiene la fecha y hora actual

				if (check < today) {
						// Si la fecha seleccionada es anterior a hoy, muestra un mensaje de error
						alert('No se pueden agregar eventos en el pasado.'); 
						calendar.unselect(); // Deselecciona la fecha
				} else {
						
					//Borra los eventos seleccionados anteriormente
					calendar.getEvents().forEach(function (event) {
							if (event.id === 'temporal event') {
									event.remove();
							}
					});

					seleccion_programando_tecnico.classList.remove('visually-hidden');
					fechaInicialSeleccionada=new Date(info.start)
					fechafinalSeleccionada=new Date(info.start)
					//Sumar 2 horas a la fecha para obtener rango de 2 horas en cada seleccion
					fechafinalSeleccionada.setHours(fechafinalSeleccionada.getHours() + 2);

					var tempEvent = {id:'temporal event',
						title:"Nuevo",
						start: info.start,
						end: fechafinalSeleccionada,
						borderColor: 'darkred',
						textColor: 'black',
						color: '#F3F3F2',
						IDTecnicoAsignado:null,
						NotasEvento:null};

					// Agregar el nuevo evento temporal al calendario
					calendar.addEvent(tempEvent);

					abrirModal(null,fechaInicialSeleccionada ,fechaInicialSeleccionada,fechafinalSeleccionada,tempEvent)

					// Formatear la fecha en formato "yyyy-MM-dd" para el input date
					const fechaFormateada = fechaInicialSeleccionada.toISOString().split('T')[0];

					const opciones = {
								weekday: 'long',
								year: 'numeric',
								month: 'long',
								day: 'numeric',
								hour12:true,
								meridiem: 'short',
							};

					// Establecer los valores de los inputs en la modal
					document.getElementById('fecha_seleccionada_programando_tecnico').value = fechaFormateada;
					document.getElementById('fecha_seleccionada_programando_tecnicoseleccionada').innerHTML = moment(fechaInicialSeleccionada).format("dddd, D [de] MMMM [de] YYYY");
					document.getElementById('horainicial_programando_tecnico').value = fechaInicialSeleccionada.toLocaleTimeString('es-CO', {
						hour: '2-digit',
						minute: '2-digit',
						hour12: false,
						meridiem: 'short',
					});
					document.getElementById('horainicial_programando_tecnicoseleccionada').innerHTML = moment(fechaInicialSeleccionada).format("h:mm a");
					document.getElementById('horafinal_programando_tecnico').value = fechafinalSeleccionada.toLocaleTimeString('es-CO', {
						hour: '2-digit',
						minute: '2-digit',
						hour12: false,
						meridiem: 'short',
					});
					document.getElementById('horafinal_programando_tecnicoseleccionada').innerHTML = moment(fechafinalSeleccionada).format("h:mm a")

							const inputsFechaHora = document.querySelectorAll('.fechahoraseleccionada');

							// Iterar sobre cada input y agregar un event listener
							inputsFechaHora.forEach(input => {
								input.addEventListener('change', () => {
									// Obtener el valor del input que cambió
									nuevafechaseleccionada=fechaInicialSeleccionada;
									const valorInput = input.value;
									const idelemento=input.id;
									
									document.getElementById(idelemento+'seleccionada').innerHTML="";

									if(input.type === 'time'){
										if(input.id === 'horainicial_programando_tecnico'){
											nuevafechaInicialSeleccionada=moment(valorInput, "HH:mm");
											nuevafechafinalSeleccionada=nuevafechaInicialSeleccionada
											nuevafechafinalSeleccionada.add(2,'hours')
											document.getElementById(idelemento+'seleccionada').innerHTML=moment(valorInput, "HH:mm").format("h:mm a")
											document.getElementById('horafinal_programando_tecnico').value=nuevafechafinalSeleccionada.format("HH:mm");
											document.getElementById('horafinal_programando_tecnicoseleccionada').innerHTML=nuevafechafinalSeleccionada.format("HH:mm");

										}else if(input.id === "horafinal_programando_tecnico"){
											nuevafechafinalSeleccionada=moment(valorInput, "HH:mm");
											nuevafechaInicialSeleccionada=nuevafechafinalSeleccionada.subtract(2,'hours')
										}
									}else if(input.type === 'date'){
										nuevafechaseleccionada=valorInput;
										document.getElementById(idelemento+'seleccionada').innerHTML=moment(valorInput).format("dddd, D [de] MMMM [de] YYYY")
									}

								});
										
										//obtenertecnicosdisponibles(nuevafechaInicialSeleccionada,nuevafechafinalSeleccionada,nuevafechaseleccionada)
							});
				}
			},
			editable: true,
			selectable: true,
			selectMirror: true,
			selectOverlap: true,
			eventResizableFromStart: false,
			nowIndicator:true
		});

			calendar.render();  // Renderizar el calendario

			obtenerTecnicos();  // Cargar la lista de técnicos y generar eventos

			var modalCrearEvento = document.getElementById('selecciontecnico');

			modalCrearEvento.addEventListener('hidden.bs.modal', function () {
					calendar.getEvents().forEach(function (event) {
							if (event.id === 'temporal event') {
									event.remove();
							}
					});
			});

	});
