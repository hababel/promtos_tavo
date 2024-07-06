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
              for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
              }
              documento_cliente.classList.remove("is-invalid");
              documento_cliente.classList.add("is-valid");
              continue_cliente.classList.remove("visually-hidden");
              set_value_validacion_newcliente("documento_cliente",true)
              datos_basicos_cliente.disabled=false;
              direcciones_cliente.disabled=false;
              email_cliente.classList.remove("is-valid")
              email_cliente.classList.remove("is-invalid")
              btn_guardarclientenuevo.disabled=false
          }
      });
    }else if(documento_cliente.value.length == 0){
        
        for (var i = 0; i < inputs.length; i++) {
          inputs[i].value = "";
        }
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
 
  btn_guardarclientenuevo.addEventListener("click",function(){
    if(documento_cliente.value.length ==0 || email_cliente.value.length==0 || 
      nombre_cliente.value.length==0 || apellidos_cliente.value.length==0 ||
      telefono1_cliente.value.length==0){
            modal_nuevocliente.scrollTop = 0 // Ubica usuario al inicio de la modal
            var text_alertp = 'Los campos no pueden estar <b>vacios</b>, por favor llene los campos obligatorios e intente de nuevo'
            show_msn_alert_intromodal("danger","Error",text_alertp,"newcliente","alert_intomodal")
            setTimeout(function(){
                let close_alert=document.getElementById("close_alert_intomodal")
                close_alert.click();
            }, 6500);
    }else{
      if(!validacion_newcliente.documento_cliente || !validacion_newcliente.validate_estructura_email){
            modal_nuevocliente.scrollTop = 0 // Ubica usuario al inicio de la modal
            var text_alertp = 'Debe validar correctamente el documento antes de enviar el formulario.'
            show_msn_alert_intromodal("danger","Error",text_alertp,"newcliente","alert_intomodal")
            setTimeout(function(){
                let close_alert=document.getElementById("close_alert_intomodal")
                close_alert.click();
            }, 6500);
      }else{
        //divLoading.style.display = "grid";
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = url_path.value+'clientes/nuevoCliente';
        let formData = new FormData();
        
        formData.append('documento_cliente',documento_cliente.value);
        formData.append('nombre_cliente',nombre_cliente.value);
        formData.append('apellidos_cliente',apellidos_cliente.value);
        formData.append('email_cliente',email_cliente.value);
        formData.append('telefono1_cliente',telefono1_cliente.value);
        formData.append('telefono2_cliente',telefono2_cliente.value);
        formData.append('notas_cliente',notas_cliente.value);
        formData.append('nombre_recomendado',nombre_recomendado.value);
        formData.append('fuente',fuente.value);
        formData.append('direcciones',(direccionesArray.length > 0)?JSON.stringify(direccionesArray):null);
        formData.append('clasificacion_cliente',document.querySelector('input[name="clasificacion"]:checked').value);

        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
            console.log(request.responseText)
            let objData = JSON.parse(request.responseText);
            if(objData.ExisteEmail){
                show_msn_alert_intromodal("danger","No fue posible guardar el cliente.","El correo ya existe en la base de datos.  Por favor intenta con otros datos.","newcliente","alert_intomodal")
                setTimeout(function(){
                      let close_alert=document.getElementById("close_alert_intomodal")
                      close_alert.click();
                  }, 4500);
            }else if(objData.InsertaCliente){
                show_msn_alert("success","Exito!","Cliente creado correctamente!")
                close_canvas("close_modal_newcliente")
                setTimeout(function(){
                      let close_alert=document.getElementById("close_alert")
                      close_alert.click();
                  }, 4500);
            }
            // show_msn_alert(objData.type,objData.title,objData.msg)
          }
          //divLoading.style.display = "none";
          return false;  
        }
      }
    
    }

  });

  modal_nuevocliente.addEventListener('show.bs.modal', function () {
    reset_form_nuevocliente()
    var selectdepartamento = document.getElementById("departamento");
  
    select_clasificacion("list-A-list")

    for (var key in ciudadesPorDepartamento) {
      var option = document.createElement("option");
      option.value = key;
      option.text = key;
      selectdepartamento.appendChild(option);
    }

    const departamentoSelect = document.getElementById('departamento');
    if (departamentoSelect.value != 0) {
      actualizarCiudades(ciudadesPorDepartamento)
    }

    departamentoSelect.addEventListener("change", function() {
      actualizarCiudades(ciudadesPorDepartamento)
    })
    
  })

  json_lista_clientes_permitidos();

});

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

  switch (element) {
    case 'list-VIP-list':
      radio_check=document.getElementById("clasificacionVIP")
      break;
    case 'list-A-list' :
      radio_check=document.getElementById("clasificacionA")
      break;
    case 'list-B-list' :
      radio_check=document.getElementById("clasificacionB")
      break;
    case 'list-C-list' :
      radio_check=document.getElementById("clasificacionC")
      break;
    case 'list-D-list' :
      radio_check=document.getElementById("clasificacionD")
      break;
  }
  
  radio_check.checked=true;
  
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
          departamento:departamento
        });

        const newRow = document.createElement('tr');
        newRow.id = `direccionRow${direccionesArray.length - 1}`;
        newRow.innerHTML = `
                    <td>${nombreDireccion}</td>
                    <td>${direccion}</td>
                    <td>${departamento}</td>
                    <td>${ciudad}</td>
                    <td>${barrio}</td>
                    <td><a name="" href="#" style="color:red"  onclick="eliminarDireccion(${direccionesArray.length - 1})"><i class="bi bi-trash-fill" ></i></a> </td>
                `;
        direccionesTabla.appendChild(newRow);
        nombreDireccionInput.value = '';
        direccionInput.value = '';
        barrioInput.value = '';
        // Limpia los errores
        document.getElementById('direccionError').textContent = '';
        document.getElementById('barrioError').textContent = '';
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
        direccionesArray.splice(index, 1); // Elimina la dirección del array
        const rowToDelete = document.getElementById(`direccionRow${index}`);
        rowToDelete.remove(); // Elimina la fila de la tabla
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
          console.log(response)
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
                        {   "data":"NombreCompletoCliente",
                            "width":"20%",
                        },
                        {	"data":"ClasificacionCliente",
                            "width":"10%",
                        },
                        {	  "data":"FuenteCreacion",
                            "width":"8%",
                        },
                        { "data":"Telefono2Cliente",
                          "width":"8%",
                        }
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
                        "url": "/generandocodigo/App-Promtos-SF/app/assets/DataTables/es-CO.json"
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

