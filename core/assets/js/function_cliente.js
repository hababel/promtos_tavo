  const validacion_newcliente={ 
    "documento_cliente":false,
    "validate_email": false, //Se controla si el correo esta disponible para utilizar
    "validate_estructura_email":false, // Se controla si la estructura del correo es valida
    "Email":false,
    "Name": false,
    "Lastname":false,
    "Status":false,
    "telefono1":false,
    "telefono2":false,
    "notas":false,
    "clasificacion":false,
    "recomendado":false,
    "nombrerecomendado":false,
  };

 let direccionesArray = []; // Array para almacenar las direcciones

  const ciudadesPorDepartamento = {
        Antioquia: ['Medellín',
          'Sabaneta',
          'Bello',
          'Envigado',
          'Itagui',
          'La Estrella',
          'Abejorral',
          'Abriaquí',
          'Alejandría',
          'Amagá',
          'Amalfi',
          'Andes',
          'Angelópolis',
          'Angostura',
          'Anorí',
          'Anza',
          'Apartadó',
          'Arboletes',
          'Argelia',
          'Armenia',
          'Barbosa',
          'Betania',
          'Betulia',
          'Ciudad Bolívar',
          'Briceño',
          'Buriticá',
          'Cáceres',
          'Caicedo',
          'Caldas',
          'Campamento',
          'Cañasgordas',
          'Caracolí',
          'Caramanta',
          'Carepa',
          'Carolina',
          'Caucasia',
          'Chigorodó',
          'Cisneros',
          'Cocorná',
          'Concepción',
          'Concordia',
          'Copacabana',
          'Dabeiba',
          'Don Matías',
          'Ebéjico',
          'El Bagre',
          'Entrerrios',
          'Fredonia',
          'Giraldo',
          'Girardota',
          'Gómez Plata',
          'Guadalupe',
          'Guarne',
          'Guatapé',
          'Heliconia',
          'Hispania',
          'Ituango',
          'Belmira',
          'Jericó',
          'La Ceja',
          'La Pintada',
          'La Unión',
          'Liborina',
          'Maceo',
          'Marinilla',
          'Montebello',
          'Murindó',
          'Mutatá',
          'Nariño',
          'Necoclí',
          'Nechí',
          'Olaya',
          'Peñol',
          'Peque',
          'Pueblorrico',
          'Puerto Berrío',
          'Puerto Nare',
          'Puerto Triunfo',
          'Remedios',
          'Retiro',
          'Rionegro',
          'Sabanalarga',
          'Salgar',
          'San Francisco',
          'San Jerónimo',
          'San Luis',
          'San Pedro',
          'San Rafael',
          'San Roque',
          'San Vicente',
          'Santa Bárbara',
          'Santo Domingo',
          'El Santuario',
          'Segovia',
          'Sopetrán',
          'Támesis',
          'Tarazá',
          'Tarso',
          'Titiribí',
          'Toledo',
          'Turbo',
          'Uramita',
          'Urrao',
          'Valdivia',
          'Valparaíso',
          'Vegachí',
          'Venecia',
          'Yalí',
          'Yarumal',
          'Yolombó',
          'Yondó',
          'Zaragoza',
          'San Pedro de Uraba',
          'Santafé de Antioquia',
          'Santa Rosa de Osos',
          'San Andrés de Cuerquía',
          'Vigía del Fuerte',
          'San José de La Montaña',
          'San Juan de Urabá',
          'El Carmen de Viboral',
          'San Carlos',
          'Frontino',
          'Granada',
          'Jardín',
          'Sonsón'
        ],
        Amazonas: ["Leticia",
          "El Encanto",
          "La Chorrera",
          "La Pedrera",
          "La Victoria",
          "Puerto Arica",
          "Puerto Nariño",
          "Puerto Santander",
          "Tarapacá",
          "Puerto Alegría",
          "Miriti Paraná"
        ],
        Arauca: ['Arauquita',
          'Cravo Norte',
          'Fortul',
          'Puerto Rondón',
          'Saravena',
          'Tame',
          'Arauca'
        ],
        SanAndres_Providencia_SantaCatalina: ['Providencia',
          'San Andrés'
        ],
        Atlantico: ['Barranquilla',
          'Baranoa',
          'Candelaria',
          'Galapa',
          'Luruaco',
          'Malambo',
          'Manatí',
          'Piojó',
          'Polonuevo',
          'Sabanagrande',
          'Sabanalarga',
          'Santa Lucía',
          'Santo Tomás',
          'Soledad',
          'Suan',
          'Tubará',
          'Usiacurí',
          'Juan de Acosta',
          'Palmar de Varela',
          'Campo de La Cruz',
          'Repelón',
          'Puerto Colombia',
          'Ponedera'
        ],
        Bogota: ['Bogotá D.C.'],
        Bolivar: ['Achí',
          'Arenal',
          'Arjona',
          'Arroyohondo',
          'Calamar',
          'Cantagallo',
          'Cicuco',
          'Córdoba',
          'Clemencia',
          'El Guamo',
          'Magangué',
          'Mahates',
          'Margarita',
          'Montecristo',
          'Mompós',
          'Morales',
          'Norosí',
          'Pinillos',
          'Regidor',
          'Río Viejo',
          'San Estanislao',
          'San Fernando',
          'San Juan Nepomuceno',
          'Santa Catalina',
          'Santa Rosa',
          'Simití',
          'Soplaviento',
          'Talaigua Nuevo',
          'Tiquisio',
          'Turbaco',
          'Turbaná',
          'Villanueva',
          'Barranco de Loba',
          'Santa Rosa del Sur',
          'Hatillo de Loba',
          'El Carmen de Bolívar',
          'San Martín de Loba',
          'Altos del Rosario',
          'San Jacinto del Cauca',
          'San Pablo de Borbur',
          'San Jacinto',
          'El Peñón',
          'Cartagena',
          'María la Baja',
          'San Cristóbal',
          'Zambrano'
        ],
        Boyaca: ['Tununguá',
          'Motavita',
          'Ciénega',
          'Tunja',
          'Almeida',
          'Aquitania',
          'Arcabuco',
          'Berbeo',
          'Betéitiva',
          'Boavita',
          'Boyacá',
          'Briceño',
          'Buena Vista',
          'Busbanzá',
          'Caldas',
          'Campohermoso',
          'Cerinza',
          'Chinavita',
          'Chiquinquirá',
          'Chiscas',
          'Chita',
          'Chitaraque',
          'Chivatá',
          'Cómbita',
          'Coper',
          'Corrales',
          'Covarachía',
          'Cubará',
          'Cucaita',
          'Cuítiva',
          'Chíquiza',
          'Chivor',
          'Duitama',
          'El Cocuy',
          'El Espino',
          'Firavitoba',
          'Floresta',
          'Gachantivá',
          'Gameza',
          'Garagoa',
          'Guacamayas',
          'Guateque',
          'Guayatá',
          'Güicán',
          'Iza',
          'Jenesano',
          'Jericó',
          'Labranzagrande',
          'La Capilla',
          'La Victoria',
          'Macanal',
          'Maripí',
          'Miraflores',
          'Mongua',
          'Monguí',
          'Moniquirá',
          'Muzo',
          'Nobsa',
          'Nuevo Colón',
          'Oicatá',
          'Otanche',
          'Pachavita',
          'Páez',
          'Paipa',
          'Pajarito',
          'Panqueba',
          'Pauna',
          'Paya',
          'Pesca',
          'Pisba',
          'Puerto Boyacá',
          'Quípama',
          'Ramiriquí',
          'Ráquira',
          'Rondón',
          'Saboyá',
          'Sáchica',
          'Samacá',
          'San Eduardo',
          'San Mateo',
          'Santana',
          'Santa María',
          'Santa Sofía',
          'Sativanorte',
          'Sativasur',
          'Siachoque',
          'Soatá',
          'Socotá',
          'Socha',
          'Sogamoso',
          'Somondoco',
          'Sora',
          'Sotaquirá',
          'Soracá',
          'Susacón',
          'Sutamarchán',
          'Sutatenza',
          'Tasco',
          'Tenza',
          'Tibaná',
          'Tinjacá',
          'Tipacoque',
          'Toca',
          'Tópaga',
          'Tota',
          'Turmequé',
          'Tutazá',
          'Umbita',
          'Ventaquemada',
          'Viracachá',
          'Zetaquira',
          'Togüí',
          'Villa de Leyva',
          'Paz de Río',
          'Santa Rosa de Viterbo',
          'San Pablo de Borbur',
          'San Luis de Gaceno',
          'San José de Pare',
          'San Miguel de Sema',
          'Tuta',
          'Tibasosa',
          'La Uvita',
          'Belén'
        ],
        Caldas: ['Manizales',
          'Aguadas',
          'Anserma',
          'Aranzazu',
          'Belalcázar',
          'Chinchiná',
          'Filadelfia',
          'La Dorada',
          'La Merced',
          'Manzanares',
          'Marmato',
          'Marulanda',
          'Neira',
          'Norcasia',
          'Pácora',
          'Palestina',
          'Pensilvania',
          'Riosucio',
          'Risaralda',
          'Salamina',
          'Samaná',
          'San José',
          'Supía',
          'Victoria',
          'Villamaría',
          'Viterbo',
          'Marquetalia'
        ],
        Caqueta: ['Florencia',
          'Albania',
          'Curillo',
          'El Doncello',
          'El Paujil',
          'Morelia',
          'Puerto Rico',
          'Solano',
          'Solita',
          'Valparaíso',
          'San José del Fragua',
          'Belén de Los Andaquies',
          'Cartagena del Chairá',
          'Milán',
          'La Montañita',
          'San Vicente del Caguán'
        ],
        Casanare: ['Yopal',
          'Aguazul',
          'Chámeza',
          'Hato Corozal',
          'La Salina',
          'Monterrey',
          'Pore',
          'Recetor',
          'Sabanalarga',
          'Sácama',
          'Tauramena',
          'Trinidad',
          'Villanueva',
          'San Luis de Gaceno',
          'Paz de Ariporo',
          'Nunchía',
          'Maní',
          'Támara',
          'Orocué'
        ],
        Cauca: ['Popayán',
          'Almaguer',
          'Argelia',
          'Balboa',
          'Bolívar',
          'Buenos Aires',
          'Cajibío',
          'Caldono',
          'Caloto',
          'Corinto',
          'El Tambo',
          'Florencia',
          'Guachené',
          'Guapi',
          'Inzá',
          'Jambaló',
          'La Sierra',
          'La Vega',
          'López',
          'Mercaderes',
          'Miranda',
          'Morales',
          'Padilla',
          'Patía',
          'Piamonte',
          'Piendamó',
          'Puerto Tejada',
          'Puracé',
          'Rosas',
          'Santa Rosa',
          'Silvia',
          'Sotara',
          'Suárez',
          'Sucre',
          'Timbío',
          'Timbiquí',
          'Toribio',
          'Totoró',
          'Villa Rica',
          'Santander de Quilichao',
          'San Sebastián',
          'Páez'
        ],
        Cesar: ['Valledupar',
          'Aguachica',
          'Agustín Codazzi',
          'Astrea',
          'Becerril',
          'Bosconia',
          'Chimichagua',
          'Chiriguaná',
          'Curumaní',
          'El Copey',
          'El Paso',
          'Gamarra',
          'González',
          'La Gloria',
          'Manaure',
          'Pailitas',
          'Pelaya',
          'Pueblo Bello',
          'La Paz',
          'San Alberto',
          'San Diego',
          'San Martín',
          'Tamalameque',
          'Río de Oro',
          'La Jagua de Ibirico'
        ],
        Choco: ['Istmina',
          'Quibdó',
          'Acandí',
          'Alto Baudo',
          'Atrato',
          'Bagadó',
          'Bahía Solano',
          'Bajo Baudó',
          'Bojaya',
          'Cértegui',
          'Condoto',
          'Juradó',
          'Lloró',
          'Medio Atrato',
          'Medio Baudó',
          'Medio San Juan',
          'Nóvita',
          'Nuquí',
          'Río Iro',
          'Río Quito',
          'Riosucio',
          'Sipí',
          'Unguía',
          'El Litoral del San Juan',
          'El Cantón del San Pablo',
          'El Carmen de Atrato',
          'San José del Palmar',
          'Belén de Bajira',
          'Carmen del Darien',
          'Tadó',
          'Unión Panamericana'
        ],
        Cordoba: ['San Bernardo del Viento',
          'Montería',
          'Ayapel',
          'Buenavista',
          'Canalete',
          'Cereté',
          'Chimá',
          'Chinú',
          'Cotorra',
          'Lorica',
          'Los Córdobas',
          'Momil',
          'Moñitos',
          'Planeta Rica',
          'Pueblo Nuevo',
          'Puerto Escondido',
          'Purísima',
          'Sahagún',
          'San Andrés Sotavento',
          'San Antero',
          'San Pelayo',
          'Tierralta',
          'Tuchín',
          'Valencia',
          'San José de Uré',
          'Ciénaga de Oro',
          'San Carlos',
          'Montelíbano',
          'La Apartada',
          'Puerto Libertador'
        ],
        Cundinamarca: ['Anapoima',
          'Arbeláez',
          'Beltrán',
          'Bituima',
          'Bojacá',
          'Cabrera',
          'Cachipay',
          'Cajicá',
          'Caparrapí',
          'Caqueza',
          'Chaguaní',
          'Chipaque',
          'Choachí',
          'Chocontá',
          'Cogua',
          'Cota',
          'Cucunubá',
          'El Colegio',
          'El Rosal',
          'Fomeque',
          'Fosca',
          'Funza',
          'Fúquene',
          'Gachala',
          'Gachancipá',
          'Gachetá',
          'Girardot',
          'Granada',
          'Guachetá',
          'Guaduas',
          'Guasca',
          'Guataquí',
          'Guatavita',
          'Guayabetal',
          'Gutiérrez',
          'Jerusalén',
          'Junín',
          'La Calera',
          'La Mesa',
          'La Palma',
          'La Peña',
          'La Vega',
          'Lenguazaque',
          'Macheta',
          'Madrid',
          'Manta',
          'Medina',
          'Mosquera',
          'Nariño',
          'Nemocón',
          'Nilo',
          'Nimaima',
          'Nocaima',
          'Venecia',
          'Pacho',
          'Paime',
          'Pandi',
          'Paratebueno',
          'Pasca',
          'Puerto Salgar',
          'Pulí',
          'Quebradanegra',
          'Quetame',
          'Quipile',
          'Apulo',
          'Ricaurte',
          'San Bernardo',
          'San Cayetano',
          'San Francisco',
          'Sesquilé',
          'Sibaté',
          'Silvania',
          'Simijaca',
          'Soacha',
          'Subachoque',
          'Suesca',
          'Supatá',
          'Susa',
          'Sutatausa',
          'Tabio',
          'Tausa',
          'Tena',
          'Tenjo',
          'Tibacuy',
          'Tibirita',
          'Tocaima',
          'Tocancipá',
          'Topaipí',
          'Ubalá',
          'Ubaque',
          'Une',
          'Útica',
          'Vianí',
          'Villagómez',
          'Villapinzón',
          'Villeta',
          'Viotá',
          'Zipacón',
          'San Juan de Río Seco',
          'Villa de San Diego de Ubate',
          'Guayabal de Siquima',
          'San Antonio del Tequendama',
          'Agua de Dios',
          'Carmen de Carupa',
          'Vergara',
          'Albán',
          'Anolaima',
          'Chía',
          'El Peñón',
          'Sopó',
          'Gama',
          'Sasaima',
          'Yacopí',
          'Fusagasugá',
          'Zipaquirá',
          'Facatativá'
        ]
      };




document.addEventListener("DOMContentLoaded", function(event) {


	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

//Activacion Tooltips
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


  var email_cliente=document.getElementById("email_cliente")
  var nombre_cliente=document.getElementById("nombre_cliente");
  var apellidos_cliente=document.getElementById("apellidos_cliente")
  var telefono1_cliente=document.getElementById("telefono1_cliente")
  var telefono2_cliente=document.getElementById("telefono2_cliente")
  var notas_cliente=document.getElementById("notas_cliente")
  var btn_guardarclientenuevo=document.getElementById("btn_guardarclientenuevo")
  var modal_nuevocliente=document.getElementById("newcliente")
  var list_A=document.getElementById("list-A" )
  var list_tab=document.getElementsByClassName("list-group-item")
  var nombre_recomendado=document.getElementById("nombre_recomendado")
  var fuente=document.getElementById("fuente")
  var direcciones_cliente=document.getElementsByClassName("direcciones_cliente")
  var eliminar_todas_direcciones_cliente=document.getElementById("eliminar_todas_direcciones_cliente")
  var documento_cliente=document.getElementById("documento_cliente")
  var continue_cliente=document.getElementById("continue_cliente")
  var datos_basicos_cliente=document.getElementById("datos_basicos_cliente")
  var direcciones_cliente=document.getElementById("direcciones_cliente")
	var form_clientenuevo=document.getElementById("form_clientenuevo")
	let my_alert=document.getElementById("my-alert")
	let clasificacionC= document.getElementById("clasificacionC")
var showHistoryBtn=document.getElementById('showHistoryBtn')
	
	if(my_alert){
			setTimeout(function(){
					const alert = bootstrap.Alert.getOrCreateInstance('#my-alert')
					alert.close()
					//close_alert.click();
			}, 5000);
	}

	$("#Table_list_Clientes").DataTable()

  if(btn_guardarclientenuevo){
    btn_guardarclientenuevo.disabled=true
  }

  if(eliminar_todas_direcciones_cliente){
    eliminar_todas_direcciones_cliente.disabled=true
  }
  
  if(direcciones_cliente){
    for (let index = 0; index < direcciones_cliente.length; index++) {
        direcciones_cliente[index].disabled=true;
      }
  }

  documento_cliente.addEventListener("input", function(){
    var inputs = datos_basicos_cliente.querySelectorAll("input");
    if(documento_cliente.value.length > 0){
      buscar_documento_cliente(documento_cliente.value, function(resultado) {
          if (resultado > 0) { // El documento existe
              documento_cliente.classList.remove("is-valid");
              documento_cliente.classList.add("is-invalid");
              continue_cliente.classList.add("visually-hidden");
              set_value_validacion_newcliente("documento_cliente",false)
              datos_basicos_cliente.disabled=true
              direcciones_cliente.disabled=true
              btn_guardarclientenuevo.disabled=true
          } else {
              documento_cliente.classList.remove("is-invalid");
              documento_cliente.classList.add("is-valid");
              continue_cliente.classList.remove("visually-hidden");
              set_value_validacion_newcliente("documento_cliente",true)
              datos_basicos_cliente.disabled=false;
              direcciones_cliente.disabled=false;
              email_cliente.classList.remove("is-valid")
              email_cliente.classList.remove("is-invalid")
              btn_guardarclientenuevo.disabled=false
							clasificacionC.checked=true;
							clasificacionC.click();
          }
      });
    }else if(documento_cliente.value.length == 0){
        
        documento_cliente.classList.remove("is-invalid");
        documento_cliente.classList.remove("is-valid");
        continue_cliente.classList.remove("visually-hidden");
        set_value_validacion_newcliente("documento_cliente",false)
        datos_basicos_cliente.disabled=false;
        direcciones_cliente.disabled=false;
        email_cliente.classList.remove("is-valid")
        email_cliente.classList.remove("is-invalid")
        btn_guardarclientenuevo.disabled=false
    }
  })

  if(email_cliente){
      email_cliente.addEventListener("input", function(){
        if(email_cliente.value.length > 0){
          if(valida_estructura_email(email_cliente.value)){
            email_cliente.classList.remove("is-invalid")
            email_cliente.classList.add("is-valid")
            set_value_validacion_newcliente("validate_estructura_email",true)
          }else{
            email_cliente.classList.remove("is-valid")
            email_cliente.classList.add("is-invalid")
            set_value_validacion_newcliente("validate_estructura_email",false)
          }
        }else{
          email_cliente.classList.remove("is-valid")
          email_cliente.classList.remove("is-invalid")
          set_value_validacion_newcliente("validate_estructura_email",false)
        }
      })
  }
 
	if(btn_guardarclientenuevo){
		btn_guardarclientenuevo.addEventListener("click",function(event){
			
			event.preventDefault();

			if(documento_cliente.value.length ==0 || email_cliente.value.length==0 || nombre_cliente.value.length==0 || apellidos_cliente.value.length==0 || telefono1_cliente.value.length==0){
							var text_alertp = 'Los campos no pueden estar <b>vacios</b>, por favor llene los campos obligatorios e intente de nuevo'
							show_msn_alert_intromodal("danger","Error",text_alertp,"newcliente","alert_intomodal")
							setTimeout(function(){
									let close_alert=document.getElementById("close_alert_intomodal")
									close_alert.click();
							}, 6500);
			}else{
				if(!validacion_newcliente.documento_cliente || !validacion_newcliente.validate_estructura_email){
							
							var text_alertp = 'Debe validar correctamente el documento antes de enviar el formulario.'
							show_msn_alert_intromodal("danger","Error",text_alertp,"newcliente","alert_intomodal")
							setTimeout(function(){
									let close_alert=document.getElementById("close_alert_intomodal")
									close_alert.click();
							}, 6500);
				}else{
					
					form_clientenuevo.submit();
				}
			}
		});
	}

if(showHistoryBtn){
	document.getElementById('showHistoryBtn').addEventListener('click', function() {
			var historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
			historyModal.show();
		});
}

	const departamentoSelect = document.getElementById('departamento');
	if(departamentoSelect){
		llenarDepartamentos();
		llenarCiudades() 
		departamentoSelect.addEventListener('change',function(){ llenarCiudades() })
	}

});


function changeestadocliente(object){

	console.log(object.checked);

	// Guardar el estado original para revertir si es necesario
	var originalState = !object.checked;

	if (!object.checked) {

		let inputconfirmacioncambioestado=document.getElementById('inputconfirmacioncambioestado');

		let urlParams = new URLSearchParams(window.location.search);
		let TICK = urlParams.get('TICK');

		var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
		confirmationModal.show();

		// Remover cualquier listener previo para evitar ejecución múltiple
		const confirmButton = document.getElementById('confirmChange');
		confirmButton.removeEventListener('click', confirmChangeHandler);

		// Añadir el nuevo listener
		confirmButton.addEventListener('click', confirmChangeHandler);

		// Configurar el botón de confirmación
		function confirmChangeHandler() {

			//if(inputconfirmacioncambioestado.value==="DESACTIVAR"){
			inputconfirmacioncambioestado.value="";
			let inputjustificacioncambioestado=document.getElementById("inputjustificacioncambioestado")
			
			let ajaxUrl = url_path.value+'clientes/cambioestadoajax';
			// ************
			var xhr = new XMLHttpRequest();
			let formData = new FormData();
			formData.append("TICK",TICK)
			formData.append("inputjustificacioncambioestado",inputjustificacioncambioestado.value)
			formData.append("nuevoEstado",((object.checked)?1:0))
			
			xhr.open('POST', ajaxUrl , true);

			xhr.onload = function() {

					if (xhr.status >= 200 && xhr.status < 400) {

						var response = JSON.parse(xhr.responseText);
						
						if(response.status){

						const data_losestados = JSON.parse(response.data)

						let timeline = document.querySelector('.timeline');
            timeline.innerHTML = '';

            data_losestados.forEach(function(log) {
							let listItem = document.createElement('li');
							listItem.innerHTML = `
									<div class="timeline-content">
											`+log.usuariocreacion+`
											<br><span>`+((log.estadonuevo > 0) ? '<i class="bi bi-check-circle-fill" style="color:green;font-size: 1.06rem;"></i> - Activado' : '<i class="bi bi-x-circle-fill" style="color:red;font-size: 1.06rem;"></i> - Desactivado')+`</span>
											<br><span>`+log.fechaasignacion+`</span>
											<p>`+((log.inputjustificacioncambioestado.length > 0)?log.inputjustificacioncambioestado:"- Sin justificación -")+`</p>
									</div>`;
							timeline.appendChild(listItem);
						})

						confirmationModal.hide();
						var showHistoryBtn=document.getElementById("showHistoryBtn")
						var alert_ficha_cliente=document.getElementById("alert_ficha_cliente")
						const alert = document.createElement('div');
						alert.className = 'alert alert-success alert-dismissible fade show';
						alert.role = 'alert';
						alert.innerHTML = `
							<strong>Cambio correcto</strong> Se cambio correctamente el estado del cliente.
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						`;

						showHistoryBtn.classList.remove("invisible");
						showHistoryBtn.classList.add("visible");
						// Insertar la alerta en el DOM
						alert_ficha_cliente.appendChild(alert);

						setTimeout(function() {
								const alert = bootstrap.Alert.getOrCreateInstance('#alert_ficha_cliente')
								alert.close()
							}, 2000);
						
						}else{
							const alert = document.createElement('div');
							alert.className = 'alert alert-danger alert-dismissible fade show';
							alert.role = 'alert';
							alert.innerHTML = `
							<strong>Error</strong> Hubo un error en la actualizacion del estado del cliente.<br> Por favor, comuniquese con soporte.
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							`
						}
					}
			};

			xhr.onerror = function() {
				const alert = document.createElement('div');
				alert.className = 'alert alert-danger alert-dismissible fade show';
				alert.role = 'alert';
				alert.innerHTML = `
				<strong>Error</strong> Hubo un error al comunicarse con la base de datos.<br> Por favor, comuniquese con soporte.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`
			};

			xhr.send(formData);

				// Cerrar el modal
				confirmationModal.hide();
			confirmButton.removeEventListener('click', confirmChangeHandler);
			// }else{
			// 	let type_alertp="danger"
			// 	let title_alertp="Error"
			// 	let text_alertp="El texto de confirmación no es el correcto."
			// 	let id_modal="confirmationModal"
			// 	let id_alertintomodal="alert_model_changeestadocliente"
			// 	show_msn_alert_intromodal(type_alertp,title_alertp,text_alertp,id_modal,id_alertintomodal)
				
			// 	setTimeout(function(){
			// 			const alert = bootstrap.Alert.getOrCreateInstance('#alertmodal')
			// 			alert.close()
			// 	}, 6500);
			// }
		};

		// Si el usuario cierra el modal sin confirmar, revertir el cambio
		document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function () {
			//document.getElementById('Switchestadocliente').checked = originalState;
		});
	}

}

function seleccionarPrincipal(index) {
		direccionesArray.forEach((direccion, i) => {
			direccion.dirprincipal = (i === index) ? 1 : 0;
		});

		var direccionesselect = document.getElementById("direccionesselect");
		direccionesselect.value = JSON.stringify(direccionesArray);
	}

	function llenarDepartamentos() {
		const departamentoSelect = document.getElementById('departamento');
		for (const departamento in ciudadesPorDepartamento) {
			const option = document.createElement('option');
			option.value = departamento;
			option.textContent = departamento.replace(/_/g, " ");
			departamentoSelect.appendChild(option);
		}
	}

	function llenarCiudades() {

		const departamentoSelect = document.getElementById('departamento');
		const ciudadSelect = document.getElementById('ciudad');

		// Limpiar ciudades previas
		ciudadSelect.innerHTML = '<option disabled selected>Seleccione la ciudad</option>';

		const ciudades = ciudadesPorDepartamento[departamentoSelect.value];
		if (ciudades) {
			ciudades.forEach(ciudad => {
				const option = document.createElement('option');
				option.value = ciudad;
				option.textContent = ciudad;
				ciudadSelect.appendChild(option);
			});
		}
	}

function set_value_validacion_newcliente(propiedad,valor){
    validacion_newcliente[propiedad]=valor
}

function reset_form_nuevocliente(){

  var inputs = datos_basicos_cliente.querySelectorAll("input");
  var inputs_direccion = direcciones_cliente.querySelectorAll("input");
  for (var i = 0; i < inputs.length; i++) {
    inputs[i].value = "";
  }
  for (var i = 0; i < inputs_direccion.length; i++) {
    inputs_direccion[i].value = "";
  }

  documento_cliente.classList.remove("is-invalid");
  documento_cliente.classList.remove("is-valid");
  continue_cliente.classList.add("visually-hidden");
  email_cliente.classList.remove("is-valid")
  email_cliente.classList.remove("is-invalid")
  datos_basicos_cliente.disabled=true;
  direcciones_cliente.disabled=true;
  btn_guardarclientenuevo.disabled=true
  
  eliminarTodasDirecciones()

  var list_tab=document.getElementsByClassName("list-group-item")
  var list_tab_pane=document.getElementsByClassName("tab-pane")
  
  /* Quitar seleccion de list group y desactivarlo */
  for (let index = 0; index < list_tab.length; index++) {
    list_tab[index].classList.remove("active")
  }

  //esconder el list_tab_pane
  for (let index = 0; index < list_tab_pane.length; index++) {
    list_tab_pane[index].classList.remove("active","show")
  }

  //Reset de arreglo para validacion de form cliente nuevo
  for (let index = 0; index < validacion_newcliente.length; index++) {
    validacion_newcliente[index]=false;
  }
}
function select_clasificacion(element){

  var radio_check
	var colortab;
	var tab_content=document.getElementById("nav-tabContent")
	var descripctioncategory=document.getElementById("descripctioncategory")

  switch (element) {
    case 'list-VIP-list':
      radio_check=document.getElementById("clasificacionVIP")
			colortab="#F9C304";
      break;
    case 'list-A-list' :
      radio_check=document.getElementById("clasificacionA")
			colortab="#A5D6A7";
      break;
    case 'list-B-list' :
      radio_check=document.getElementById("clasificacionB")
			colortab="#AED6F1";
      break;
    case 'list-C-list' :
      radio_check=document.getElementById("clasificacionC")
			colortab="#E6EE9C";
      break;
    case 'list-D-list' :
      radio_check=document.getElementById("clasificacionD")
			colortab="#E6E6E5";
      break;
    
  }
  
  radio_check.checked=true;
	descripctioncategory.setAttribute("style", "border-top: 0.4em solid "+colortab+";border-bottom: 0.4em solid "+colortab);

  // Se obtiene la referencia al elemento tab
  var tab2 = document.getElementById(element);

  // Activa el tab
  var tab2Tab = new bootstrap.Tab(tab2);
  tab2Tab.show();

}

function mostrarNombreRecomendado() {
      const fuenteSelect = document.getElementById('fuente');
      const nombreRecomendadoDiv = document.getElementById('nombreRecomendadoDiv');
      const nombreRecomendadoInput = document.getElementById('nombre_recomendado');

      if (fuenteSelect.value === 'recomendado') {
        nombreRecomendadoDiv.classList.remove("visually-hidden")
        nombreRecomendadoInput.setAttribute('required', 'required');
      } else {
        nombreRecomendadoDiv.classList.add("visually-hidden")
        nombreRecomendadoInput.removeAttribute('required');
      }
}

function actualizarCiudades(ciudadesPorDepartamento) {

    const departamentoSelect = document.getElementById('departamento');
    const ciudadSelect = document.getElementById('ciudad');

    // Obtener el valor seleccionado en el departamento
    const departamentoSeleccionado = departamentoSelect.value;
    // Limpiar las opciones actuales del menú de ciudades
    ciudadSelect.innerHTML = '';

    // Agregar las nuevas opciones de ciudades según el departamento seleccionado
    const ciudades = ciudadesPorDepartamento[departamentoSeleccionado];
    for (const ciudad of ciudades) {
      const option = document.createElement('option');
      option.value = ciudad;
      option.textContent = ciudad;
      ciudadSelect.appendChild(option);
    }

}

function agregarDireccion() {
      const nombreDireccionInput = document.getElementById('nombre_direccion');
      const direccionInput = document.getElementById('direccion');
      const departamentoInput = document.getElementById('departamento');
      const ciudadInput = document.getElementById('ciudad');
      const barrioInput = document.getElementById('barrio');
      const direccionesTabla = document.getElementById('direccionesTabla');
      const nombreDireccion = nombreDireccionInput.value.trim();
      const direccion = direccionInput.value.trim();
      const ciudad = ciudadInput.value.trim();
      const departamento = departamentoInput.value.trim();
      const barrio = barrioInput.value.trim();

      if (direccion && ciudad && barrio) {
        
				direccionesArray.push({
          nombre: nombreDireccion,
          direccion: direccion,
          ciudad: ciudad,
          barrio: barrio,
          departamento:departamento,
 					dirprincipal: direccionesArray.length === 0 ? 1 : 0 
        });

				var direccionesselect=document.getElementById("direccionesselect")
        direccionesselect.value=JSON.stringify(direccionesArray)

        const newRow = document.createElement('tr');
        newRow.id = `direccionRow${direccionesArray.length - 1}`;
        newRow.innerHTML = `
							<td>${nombreDireccion}</td>
							<td>${direccion}</td>
							<td>${departamento}</td>
							<td>${ciudad}</td>
							<td>${barrio}</td>
							<td><input type="radio" id="direccionprincipal${direccionesArray.length - 1}" data-param="${direccionesArray.length - 1}" name="direccionprincipal" onclick="seleccionarPrincipal(${direccionesArray.length - 1})" ></td>
							<td><a name="" href="#" style="color:red"  onclick="eliminarDireccion(${direccionesArray.length - 1})"><i class="bi bi-trash-fill" ></i></a> </td>
						`;
        direccionesTabla.appendChild(newRow);
        nombreDireccionInput.value = '';
        direccionInput.value = '';
        barrioInput.value = '';
        // Limpia los errores
        document.getElementById('direccionError').textContent = '';
        document.getElementById('barrioError').textContent = '';

				if(direccionesArray.length === 1){
					var direccionprincipal=document.getElementsByName("direccionprincipal")
					direccionprincipal[0].checked=true
				}
      } else {
        // Muestra errores si los campos son inválidos o vacíos
        if (!direccion) {
          document.getElementById('direccionError').textContent = 'La dirección es obligatoria';
        }
        if (!barrio) {
          document.getElementById('barrioError').textContent = 'El barrio es obligatorio';
        }
      }

}

function eliminarDireccion(index) {
		const direccionid=document.getElementById("direccionprincipal"+index)
		const paramdireccion=direccionid.getAttribute('data-param')
		const isPrincipal = direccionesArray[paramdireccion].dirprincipal;
		var direccionprincipal=document.getElementsByName("direccionprincipal")
		direccionesArray.splice(paramdireccion, 1); // Elimina la dirección del array
		const rowToDelete = document.getElementById(`direccionRow${index}`);
		rowToDelete.remove(); // Elimina la fila de la tabla

		if(isPrincipal && direccionesArray.length > 0){
      direccionprincipal[0].checked=true // Se selecciona la primer dirección como principal en caso de que la eliminada era la principal	
		}

		// Reasignacion de data-param en la relacion input-indice de arreglo
		for (let index = 0; index < direccionprincipal.length; index++) {
			direccionprincipal[index].setAttribute('data-param', index);
		}

}

function eliminarTodasDirecciones() {
  direccionesArray = []; // Elimina todas las direcciones del array
  document.getElementById('direccionesTabla').innerHTML = ''; // Elimina todas las filas de la tabla
}

function buscar_documento_cliente(documento_cliente, callback){
  spinner_new_doccliente.classList.remove("visually-hidden")
  var xhr = new XMLHttpRequest();

  // Configurar la solicitud AJAX
  let ajaxUrl = url_path.value+'clientes/find_documento_cliente';
  xhr.open("POST", ajaxUrl, true); // Cambia la ruta al script PHP
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  const data="documento_cliente=" + documento_cliente;
  // Definir la función de respuesta
  xhr.onreadystatechange = function() {
    spinner_new_doccliente.classList.add("visually-hidden")
      if (xhr.readyState === 4 && xhr.status === 200) {
          var response = xhr.responseText;
          callback(response);
      }
  };

  // Enviar la solicitud con los datos
  xhr.send(data);
  
}

function json_lista_clientes_permitidos(){

  let ajaxUrl = url_path.value+'clientes/lista_clientes_permitidos'; 
    const xhr = new XMLHttpRequest();
    xhr.open('GET', ajaxUrl, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                
              var data=JSON.parse(xhr.responseText);

                var miTabla=$("#Table_list_Clientes").DataTable({
                    
                    ajax: function (d, cb) {
                        fetch(ajaxUrl)
                          .then(response => response.json())
                          .then(data => cb(data));
                    },
                    "destroy": true,
                    "processing": false,
                    "scrollResize": true,
                    "autoWidth": true,
                    "responsive": true,
                    "columns": [
                        { "data":"NombreCompletoCliente",
                          "width":"20%",
                        },
												{	"data": "EstadoCliente",
																		"width":"8%",
																		"className":"text-center",
																		"render": function(data){
																								return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span class="text-muted fst-italic" style="color:red;">Inactivo</span>';
																						}
																},
                        {	"data":"ClasificacionCliente",
                            "width":"10%",
                        },
                        {	"data":"FuenteCreacion",
                            "width":"10%",
                        },
                        { "data":"Telefono2Cliente",
                          "width":"15%",
                        },
												{
                            "data":"ServiciosAbiertos",
                            "width":"20%",
"render": function (data) { return (data)? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='"+data+"'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'>Vencido</strong></span>" : null ; }
                        },
{
                            "data":null,
                            "width":"20%",
"render": function (data) { return '<a href=#/>' + 'Edit' + '</a>'; }
                        },
                    ],
                    'dom': 'lBfrtip',
                    'buttons': [
                        {
                            "extend": "copyHtml5",
                            "text": "<i class='bi bi-clipboard2-fill'></i> Copiar",
                            "titleAttr":"Copiar",
                            "className": "btn btn-outline-dark btn-sm ms-5",
                            "exportOptions": { 
                                "columns": [ 0, 1, 2]
                            }
                        },{
                            "extend": "excelHtml5",
                            "text": "<i class='bi bi-table'></i> Excel",
                            "titleAttr":"Esportar a Excel",
                            "className": "btn btn-outline-dark btn-sm ms-2",
                            "exportOptions": { 
                                "columns": [ 0, 1, 2]
                            }
                        },{
                            "extend": "pdfHtml5",
                            "text": "<i class='bi bi-file-earmark-pdf'></i> PDF",
                            "titleAttr":"Esportar a PDF",
                            "className": "btn btn-outline-dark btn-sm ms-2",
                            "exportOptions": { 
                                "columns": [ 0, 1, 2]
                            }
                        },{
                            "extend": "csvHtml5",
                            "text": "<i class='bi bi-filetype-csv'></i> CSV",
                            "titleAttr":"Esportar a CSV",
                            "className": "btn btn-outline-dark btn-sm ms-2",
                            "exportOptions": { 
                                "columns": [ 0, 1, 2]
                            }
                        }
                    ],
                    "order": [
                        [0, 'asc']
                    ],
                    "language": {
                        "url": "/generandocodigo/App-Promtos-SF/core/assets/DataTables/es-CO.json"
                    },
                    columnDefs: [
                            {
                                //target: 4,
                                //visible: false,
                                //searchable: true,
                            },
                            
                        ],
                });


            } else {
                console.error('Error en la solicitud AJAX');
                callback(null);
            }
        }
    };
    xhr.send();
}

function abrirWhatsApp(telefonocliente){
  if (telefonocliente) {
      // Crea el enlace para abrir WhatsApp Web con un mensaje predefinido
      const mensaje = encodeURIComponent('Hola, ¿en qué puedo ayudarte?');
      const enlaceWhatsApp = `https://web.whatsapp.com/send/?phone=57${telefonocliente}`;
      // Abre WhatsApp Web en una nueva ventana o pestaña
      window.open(enlaceWhatsApp, '_blank');
  } else {
      alert('Por favor, ingrese un número de WhatsApp válido.');
  }
  
}

