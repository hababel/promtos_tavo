const config_categorias_cliente={
        "VIP":
            {
                "backgound_categoria": "#F9C304",
                "color_font":"white",
                "style_font": "italic",
                "font_size": "1.06rem"
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

const NombresDias = ["Domingo","Lunes", "Martes", "Miercoles","Jueves","Viernes","Sabado"];
const NombresMeses = ["Enero","Febrero", "Marzo", "Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const InicialesNombresMeses = ["Ene","Feb", "Mar", "Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
const InicialesNombresDias=["Dom","Lun","Mar","Mier","Jue","Vier","Sab"]

var lista_equiposxdirecciones=null;
var hoy=new Date();
var fecha_hoy=hoy.getFullYear()+"-"+padZero(hoy.getMonth()+1)+"-"+padZero(hoy.getDate());
var calendar=null

document.addEventListener("DOMContentLoaded", function () {
  //Activacion Tooltips
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  let newservice_prioridad=document.getElementById("newservice_prioridad");
  let newservices_prioridad_selected=document.getElementById("newservices_prioridad_selected");
  let select_cliente = document.getElementById("select_cliente_servicionuevo");
  let select_direccionescliente = document.getElementById("select_direccioncliente_servicionuevo");
  let equipos_direccionescliente = document.getElementById("select_equipocliente_servicionuevo");
  let guardar_nuevoservicio = document.getElementById("guardar_nuevoservicio");
	var seleccion_programando_tecnico=document.getElementById("seleccion_programando_tecnico")
	var selecciontecnico=document.getElementById('selecciontecnico')
	var form_seleccion_cliente=document.getElementById("form_seleccion_cliente");
	var form_propiedades_servicio=document.getElementById("form_propiedades_servicio");
	var newservices_estado=document.getElementById("newservices_estado");

	var fechaInicialSeleccionada=null
	var fechafinalSeleccionada=null


	if(selecciontecnico){
		var galleryModal = new bootstrap.Modal(document.getElementById('selecciontecnico'), { keyboard: false });
	}

  $("#select_cliente_servicionuevo").select2();

	$("#tbl_servicios").DataTable()

	if(newservices_estado){
		newservices_estado.options[0].selected=true;
	}
	
		// Carga de calendario
			var calendarEl = document.getElementById('fullcalendar');

			if(calendarEl){
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
							slotMaxTime: '20:00:00', // Hora final del calendario
							height: 400, //Altura del calendario
							
							// Lista de eventos (servicios)
							events: [],
							// events: [
							//       { id: 'servicio1', title: 'Servicio 1', start: '2023-11-28T10:00:00', end: '2023-11-28T12:00:00', tecnico: 'Técnico 1', backgroundColor: '#FF5733'  },
							//       { id: 'servicio2', title: 'Servicio 2', start: '2023-11-28T11:00:00', end: '2023-11-28T14:00:00', tecnico: 'Técnico 2', backgroundcolor: '#FF5733'  },
							// ],

							validRange: {
								start: fecha_hoy,
							},
							//Contenido de un evento
							eventContent: function(arg) {
								var tecnico = arg.event.extendedProps.tecnico;
								var horaInicio = arg.event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
								var horaFin = arg.event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
								var content = '<div class="tecnico">' + ((tecnico != undefined)?tecnico:"Sin Tecnico") + ' - '+arg.event.title +'</div>';
								content += '<div class="hora">' + horaInicio + ' - ' + horaFin + '</div>';
								return { html: content };
							},
							
							// acciones cuando da click en una fecha vacia sin evento
							dateClick: function(info) {
								calendar.unselect();
							},

							// acciones cuando da click en algun evento existente
							eventClick: function(info) {
									if(info.event.id != 'temporal event'){
											seleccion_programando_tecnico.classList.add('visually-hidden');
									}
									
									// console.log(info.event.extendedProps.tecnico)
									// console.log(info.event.start)
									// console.log(info.event.end)
									// console.log(info.event.title)
									// console.log(info.event.id)
									// console.log(info.event.startStr)
									// console.log(info.event.endStr)
									// console.log(info.event)
									var Fecha=new Date(info.event.start)
									var HoraInicio=new Date(info.event.start)
									var HoraFinal= new Date(info.event.end)
									var IDTecnicoAsignado= info.event.extendedProps.IDTecnicoAsignado
									abrirModal(IDTecnicoAsignado,Fecha,HoraInicio,HoraFinal,info.event)
							},

							//Acciones de una fecha seleccionada
							select: function(info) {

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
							},

							// Permitir siempre la selección, incluso si hay eventos existentes en ese rango
							selectAllow: function(selectInfo) {
								return true;
							},

							editable: true,
							selectable: true,
							selectMirror: true,
							selectOverlap: true,
							eventResizableFromStart: true,
						});

						calendar.render();
						deshabilitarFullCalendar(calendar) 

						// Obtener eventos mediante AJAX
						var xhr = new XMLHttpRequest();
						let ajaxUrl = url_path.value+'servicios/listareventosparacalendario';
						xhr.open('GET', ajaxUrl , true);
						xhr.onload = function() {
							if (xhr.status >= 200 && xhr.status < 400) {
								var data = JSON.parse(xhr.responseText);

								data.forEach(function(eventData) {
									//Se cargar los eventos encontrados en el calendario
									calendar.addEvent(eventData);
								});

							} else {
								console.log('Error al obtener eventos:', xhr.status, xhr.statusText);
							}
						};

						xhr.onerror = function() {
							console.log('Error de red al intentar obtener eventos');
						};

						xhr.send();
			}

		// Fin Carga Calendario

if(newservice_prioridad){
newservice_prioridad.addEventListener("change", function(){

    var indiceSeleccionado = newservice_prioridad.selectedIndex;
    let datacolorprioridad=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-colorprioridad");
    let dataHorasInicialRespuesta=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-horasinicialrespuesta");
    let dataHorasFinalRespuesta=newservice_prioridad.options[indiceSeleccionado].getAttribute("data-horasfinalrespuesta");
    newservices_prioridad_selected.innerHTML=newservice_prioridad.options[indiceSeleccionado].text;
    newservices_prioridad_selected.style.backgroundColor=datacolorprioridad

  })
}

if(guardar_nuevoservicio){


  guardar_nuevoservicio.addEventListener("click",function(){

		
		var evento_seleccionado=null
		var FechaServicio=null
		var HoraPlaneacionInicio=null
		var HoraPlaneadaTerminacion=null
		var IDTipoServicio=null
		var IDEquipoCliente=null
		var DescripcionCausa=null
		var IDPrioridad=null
		var IDCategoria=null
		var Estadoservicio=null
		var IDUsuarioAsignaciontecnico=null
		var FechaHoraAsignaciontecnico=null
		var IDTecnicoAsignado=null
		var IDUserUltimaModificacion=null
		var FechaHoraUltimaModificacion=null
		var Notas=null
		var IDCliente=null
		var Direccioncliente=null
		var IDUsuarioAsignaciontecnico=null
		var FechaHoraAsignaciontecnico=null
		var IDTecnicoAsignado=null
		var IDUserUltimaModificacion=null
		var FechaHoraUltimaModificacion=null
		const divLoading = document.querySelector("#divLoading")

		divLoading.style.display = "grid";
		calendar.getEvents().forEach(function (event) {
				if (event.id === 'temporal event') {
					evento_seleccionado=event;
				}
		});

		if(evento_seleccionado){
			var FechaServicio_seleccionado=new Date(evento_seleccionado.start)
			var HoraPlaneacionInicio_seleccionada=new Date(evento_seleccionado.start)
			var HoraPlaneacionFinal_seleccionada=new Date(evento_seleccionado.end)
			IDTecnicoAsignado= evento_seleccionado.extendedProps.IDTecnicoAsignado
			Notas= evento_seleccionado.extendedProps.NotasEvento

			FechaServicio=FechaServicio_seleccionado.getFullYear()+"-"+padZero(FechaServicio_seleccionado.getMonth()+1)+"-"+padZero(FechaServicio_seleccionado.getDate());
			HoraPlaneacionInicio=padZero(HoraPlaneacionInicio_seleccionada.getHours())+":"+padZero(HoraPlaneacionInicio_seleccionada.getMinutes())+":"+padZero(HoraPlaneacionInicio_seleccionada.getSeconds())
			HoraPlaneadaTerminacion=padZero(HoraPlaneacionFinal_seleccionada.getHours())+":"+padZero(HoraPlaneacionFinal_seleccionada.getMinutes())+":"+padZero(HoraPlaneacionFinal_seleccionada.getSeconds())

		}
		
		IDCliente=document.getElementById("select_cliente_servicionuevo")
		Direccioncliente= document.getElementById("select_direccioncliente_servicionuevo")
		IDEquipoCliente=document.getElementById("select_equipocliente_servicionuevo")
		IDTipoServicio=document.getElementById("newservice_tiposervicio")
		IDPrioridad=document.getElementById("newservice_prioridad")
		Estadoservicio=document.getElementById("newservices_estado")
		DescripcionCausa=document.getElementById("newservices_descripcion")

	 	//Valido datos vacios obligatorios.
		if(IDCliente.value == 0 || IDCliente.value == null 
				|| Direccioncliente.value == 0 || Direccioncliente.value == null 
				|| IDEquipoCliente.value == 0 || IDEquipoCliente.value == null
				|| IDTipoServicio.value ==0 || IDTipoServicio.value == null 
				|| IDPrioridad.value == 0 || IDPrioridad.value == null
				|| DescripcionCausa.value.length == 0 
			){	
				console.log('Error')

		}else{
			// envio ajax a guardar datos de nuevo servicio
				let ajaxUrl = url_path.value+'servicios/insertarservicionuevo';
				var xhr = new XMLHttpRequest();
				let formData = new FormData();
				formData.append("IDCliente",IDCliente.value)
				formData.append("Direccioncliente",Direccioncliente.value)
				formData.append("Estado",Estadoservicio.value)
				formData.append("FechaServicio",FechaServicio)
				formData.append("HoraPlaneacionInicio",HoraPlaneacionInicio)
				formData.append("HoraPlaneadaTerminacion",HoraPlaneadaTerminacion)
				formData.append("IDTipoServicio",IDTipoServicio.value)
				formData.append("IDEquipoCliente",IDEquipoCliente.value)
				formData.append("DescripcionCausa",DescripcionCausa.value)
				formData.append("IDPrioridad",IDPrioridad.value)
				formData.append("Notas",Notas)
				formData.append("Evento_seleccionado",JSON.stringify(evento_seleccionado))
				formData.append("IDTecnicoAsignado",IDTecnicoAsignado)
				xhr.open('POST', ajaxUrl , true);

				xhr.onload = function() {
						if (xhr.status >= 200 && xhr.status < 400) {
							var response = JSON.parse(xhr.responseText);
							if(response.status){
								setTimeout(function() {
										divLoading.style.display = "none";
										location.href =url_path.value+"/servicios";
									}, 2000);
							}else{
							
							}
						}
				};
				xhr.onerror = function() {
							console.log('Error de red al intentar obtener eventos');
				};

				xhr.send(formData);
		}

  });

}


});

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

		habilitar_seccionfieldset(form_seleccion_cliente)
		//Validar si los input de la informacion y equipos de cliente esta llena habilitar los campos del nuevo servicio
		if((select_direccionescliente.value.length > 0) && (select_equipocliente.value.length > 0)){
				habilitar_seccionfieldset(form_propiedades_servicio)
		}

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
            accesofcihacliente.innerHTML='<a name="" id="" href="'+url_path+'clientes/ficha_cliente/?TICK='+IDCliente+'" role="button" style="text-decoration: none;"><i class="bi bi-person-vcard-fill" style="font-size:1.5em;"></i></a>'

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
              MarcaClienteCategoria.classList.add("start-0")
              MarcaClienteCategoria.classList.remove("start-100")
              descripcioncategoriacliente="<i class='bi bi-gem' style='color:green;margin-right: 4px;font-weight: bold;margin-left: 15px;'></i> "+objData2.data[0][0].ClasificacionCliente;
            }else{
              MarcaClienteCategoria.classList.remove("start-0")
              MarcaClienteCategoria.classList.add("start-100")
              descripcioncategoriacliente=objData2.data[0][0].ClasificacionCliente
            }
            ClienteCategoria.innerHTML=descripcioncategoriacliente

            //Nombre cliente
            NombreCliente.innerHTML=objData2.data[0][0].NombreCompletoCliente
            
            //Recomendado clientes
            RecomendadoCliente.innerHTML=((objData2.data[0][0].FuenteCreacion === "recomendado") ? "<span class='badge text-bg-warning'> por " + objData2.data[0][0].NombreRecomendado + "</span>" : "-");
            
            //Se asigna fecha creacion cliente
            FechaCreacionCliente.innerHTML=obtener_desde_entrefechas_ahoy(objData2.data[0][0].FechaCreacionCliente);
            //se crea ToolTip para informacion adicional de creacion del ciente
            FechaCreacionTooltip.setAttribute("data-bs-title", "Creado el "+objData2.data[0][0].FechaCreacionCliente+"<br>"+"Por "+objData2.data[0][0].NombreCompletoUsuario);
            var tooltip = new bootstrap.Tooltip(FechaCreacionTooltip);

            //Se asigna valor de telefono para envio de whatsapp
            TelefonoWhatsappCliente.href="https://web.whatsapp.com/send/?phone=57"+objData2.data[0][0].Telefono2Cliente
            
            //Segun estado se pone ckeck e icono
            if(objData2.data[0][0].EstadoCliente){
              CheckEstadoCliente.checked = true
              EstadoClienteActivo.classList.remove("d-none")
              EstadoClienteInactivo.classList.add("d-none")
            }else{
              CheckEstadoCliente.checked = true
              EstadoClienteActivo.classList.add("d-none")
              EstadoClienteInactivo.classList.remove("d-none")
            }

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

  function abrirModal(IDTecnico,Fecha,HoraInicio,HoraFinal,detalle_evento) {

		var titulo_modal_programando_tecnico =document.getElementById("titulo_modal_programando_tecnico");
		var prioridad_evento_existente=document.getElementById("prioridad_evento_existente");
		var infotomado_evento_existente=document.getElementById("infotomado_evento_existente")
		var estado_evento_existente=document.getElementById("estado_evento_existente")
		var notas_evento_existente=document.getElementById("notas_evento_existente");
		var info_adicional_evento=document.getElementById("info_adicional_evento");
		var horainicial_programando_tecnico=document.getElementById("horainicial_programando_tecnico")
		var horafinal_programando_tecnico=document.getElementById("horafinal_programando_tecnico")
		var AMPM_horainicial_programando_tecnico=document.getElementById("AMPM_horainicial_programando_tecnico")
		var AMPM_horafinal_programando_tecnico=document.getElementById("AMPM_horafinal_programando_tecnico")

    var galleryModal = new bootstrap.Modal(document.getElementById('selecciontecnico'), { keyboard: false });
    galleryModal.show();

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
			evento.setExtendedProp('NotasEvento', document.getElementById("notas_evento_existente").value)
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

		titulo_modal_programando_tecnico.innerHTML=""
		info_adicional_evento.classList.add('visually-hidden');
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
			info_adicional_evento.classList.remove('visually-hidden');
			notas_evento_existente.value=detalle_evento.extendedProps.Notas
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
			titulo_modal_programando_tecnico.innerHTML="Asignacion de Técnico";
			info_adicional_evento.classList.add('visually-hidden');
		}
  }

function valida_input_cliente(){

	let select_direccionescliente = document.getElementById("select_direccioncliente_servicionuevo");
	let select_equipocliente = document.getElementById("select_equipocliente_servicionuevo");
	var form_seleccion_cliente=document.getElementById("form_seleccion_cliente")
	var form_propiedades_servicio=document.getElementById("form_propiedades_servicio")

	//Validar si los input de la informacion y equipos de cliente esta llena habilitar los campos del nuevo servicio
	if((select_direccionescliente.value > 0) && (select_equipocliente.value > 0)){
			habilitar_seccionfieldset(form_propiedades_servicio)
	}else{
			deshabilitar_seccionfieldset(form_propiedades_servicio)
	}

}

function obtenertecnicosdisponibles(horainicial,horafinal,fecha){

	var fecha_seleccionada_programando_tecnico =document.getElementById("fecha_seleccionada_programando_tecnico");
	var horainicial_programando_tecnico=document.getElementById("horainicial_programando_tecnico");
	var horafinal_programando_tecnico=document.getElementById("horafinal_programando_tecnico");
	var AMPM_horainicial_programando_tecnico=document.getElementById("AMPM_horainicial_programando_tecnico")
	var AMPM_horafinal_programando_tecnico=document.getElementById("AMPM_horafinal_programando_tecnico")

	// Formatear la fecha en "yyyy-mm-dd" para enviar a la consulta de DataBase
	var fecha_formateada = fecha.getFullYear() + '-' + padZero(fecha.getMonth()+1) + '-' + padZero(fecha.getDate());
	// Obtener la porción de la hora y se le da formato hh:mm:ss
  var horaInicialSeleccionada_formateada = padZero(horainicial.getHours())+':'+ padZero(horainicial.getMinutes())+':'+padZero(horainicial.getSeconds());
	//Se da formato a hora final
	var horaFinalSeleccionada_formateada=padZero(horafinal.getHours())+':'+ padZero(horafinal.getMinutes())+':'+padZero(horafinal.getSeconds());

	fecha_seleccionada_programando_tecnico.innerHTML=InicialesNombresDias[fecha.getDay()]+" "+fecha.getDate()+" de "+InicialesNombresMeses[fecha.getMonth()]+" de "+fecha.getFullYear()
	
	horainicial_programando_tecnico.value= padZero((horainicial.getHours() % 12) || 12) + ':'+ padZero(horafinal.getMinutes());
	(horainicial.getHours() < 12) ? AMPM_horainicial_programando_tecnico[0].selected = true : AMPM_horainicial_programando_tecnico[1].selected = true 

	horafinal_programando_tecnico.value= padZero((horafinal.getHours() % 12) || 12) + ':'+ padZero(horafinal.getMinutes());
	(horafinal.getHours() < 12) ? AMPM_horafinal_programando_tecnico[0].selected = true :AMPM_horafinal_programando_tecnico[1].selected = true

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
			//  console.log(listtecnicosdisponibles)
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
function formato_fecha(fecha){
	var date = fecha.getFullYear()+'-'+(fecha.getMonth()+1)+'-'+fecha.getDate();
	return date;
}
function formato_time(time){
	var time = time.getHours()+':'+time.getMinutes()+':'+time.getSeconds();
	return time;
}
function padZero(num) {
  return (num < 10 ? '0' : '') + num;
}

function deshabilitar_seccionfieldset(nombrecomponente_fieldset){
	nombrecomponente_fieldset.disabled=true;
	deshabilitarFullCalendar(calendar)
}

function habilitar_seccionfieldset(nombrecomponente_fieldset){
	nombrecomponente_fieldset.disabled=false;
	habilitarFullCalendar(calendar)

}

function deshabilitarFullCalendar(calendar) {
		// Deshabilitar FullCalendar
		calendar.setOption('selectable', false);
}

function habilitarFullCalendar(calendar) {
		// Habilitar FullCalendar
		calendar.setOption('selectable', true);
}

function continuar_Overlay(){
	ocultarOverlay();
	location.href ="http://localhost/generandocodigo/App-Promtos-SF/servicios";
}




