
  document.addEventListener("DOMContentLoaded", function(event) {
    
    const url_path= document.getElementById("url_path")
    const divLoading = document.querySelector("#divLoading")

		json_listar_perfilespermitidos();
    
    $("#lista_usuarios_asignados_perfil").select2({
        dropdownParent: $('#modal_eliminarperfil')
    });

		const myModalEl = document.getElementById('modal_eliminarperfil')

		myModalEl.addEventListener('hidden.bs.modal', event => {
			//console.log("Se cerrara")

			//Se vacia el input donde estan los usuarios asignados al perfil, para garantizar que esta vacio y llenarlo solo con los usuarios de este perfil
			var lista_usuarios_asignados_perfil=document.getElementById("lista_usuarios_asignados_perfil");
			let lista_perfiles_permitidos_reasignar = document.getElementById("lista_perfiles_permitidos_reasignar")
			
			$('#lista_usuarios_asignados_perfil').val('').trigger('change');
			lista_usuarios_asignados_perfil.disabled = true
			lista_perfiles_permitidos_reasignar.value=0;

		})
		
		myModalEl.addEventListener('show.bs.modal', event => {
				
			// Button that triggered the modal
			const button = event.relatedTarget
			const recipient = JSON.parse(button.getAttribute('data-bs-dataperfil'))
			var lista_usuarios_asignados_perfil=document.getElementById("lista_usuarios_asignados_perfil");
			let lista_perfiles_permitidos_reasignar = document.getElementById("lista_perfiles_permitidos_reasignar")

			const IDsUser = []; //Inicializacion de arreglo donde estaran los IDS de los usuarios asignados a este perfil.
			
			//Card de aviso que hay usuarios asignados al perfil
			let card_avisode_usuarios_asignados=document.getElementById("card_avisode_usuarios_asignados")
			let div_notas_listaperfiles=document.getElementById("div_notas_listaperfiles")

			//Se vacia el input donde estan los usuarios asignados al perfil, para garantizar que esta vacio y llenarlo solo con los usuarios de este perfil
			$('#lista_usuarios_asignados_perfil').val('').trigger('change');
			lista_usuarios_asignados_perfil.disabled = true

			document.getElementById("nombre_perfil_aeliminar").innerHTML=recipient.NombrePerfil;
			document.getElementById("botones_confirmacion_eliminacion_perfil").innerHTML=`
					<!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> -->
					<button type="button" class="btn btn-warning" id="btn_confirmacion_eliminacion" onclick="confirma_eliminacion('`+recipient.IDPerfil+`','`+((recipient.UsuariosAsignados)?recipient.UsuariosAsignados.split(","):0)+`')" disabled>Si, entiendo las consecuencias y quiero eliminar el perfil</button>`

			if(lista_perfiles_permitidos_reasignar != null){

        lista_perfiles_permitidos_reasignar.addEventListener("change",function(){

						var btn_confirmacion_eliminacion=document.getElementById("btn_confirmacion_eliminacion")
						btn_confirmacion_eliminacion.disabled=false;

					let idoption_select=lista_perfiles_permitidos_reasignar.value;

					if(idoption_select > 0){
							document.getElementById("div_notas_listaperfiles").innerHTML=`<div class='alert alert-warning d-flex align-items-center' role='alert'>
											<div>
													<i class="bi bi-exclamation-triangle-fill"> </i><strong>Atención </strong> - Este perfil se borrara y a los usuarios aqui asignados se les quitara este perfil.
											</div>
									</div>`
					}else{
							document.getElementById("div_notas_listaperfiles").innerHTML=""
					}
        })
    	}


			if(recipient.UsuariosAsignados.length > 0){
					card_avisode_usuarios_asignados.style.display="flex"
					$('#lista_usuarios_asignados_perfil').val(recipient.UsuariosAsignados.split(",")).trigger('change');
			}else{
				card_avisode_usuarios_asignados.style.display="none"
			}
console.log(lista_perfiles_permitidos_reasignar.value)
console.log(recipient.UsuariosAsignados)
			if(lista_perfiles_permitidos_reasignar.value == 0 && recipient.UsuariosAsignados == 0){
					var btn_confirmacion_eliminacion=document.getElementById("btn_confirmacion_eliminacion")
					btn_confirmacion_eliminacion.disabled=false;
			}

		})

			
	});

function listar_perfiles_permitidos(){
    var table=$("#Table_list_Profiles").DataTable();
    divLoading.style.display = "flex";
    json_listar_perfilespermitidos(function(lista_perfiles) {
                    if (lista_perfiles !== null) {
                        var lista_perfiles_permitidos=lista_perfiles.data
                        console.log(lista_perfiles.data.length);
                        
                        $("#Table_list_Profiles").DataTable({
                                "data":lista_perfiles.data,
                                "destroy": true,
                                "processing": true,
                                "scrollResize": true,
                                "autoWidth": true,
                                "responsive": true,
                                "columns": [
                                    { "data": "NombrePerfil"
                                    },
                                    {	"data": "EstadoPerfil",
                                        "width":"8%",
                                        "className":"text-center",
                                        "render": function(data){
                                                    return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span class="text-muted fst-italic" style="color:red;">Inactivo</span>';
                                                }
                                    },
                                    {	"data": "boton_editar",
                                        "className":"text-center",
                                        "width":"30%",
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

                             new $.fn.dataTable.Buttons( table, {
                                buttons: ['copy', 'excel', 'pdf' ]
                            });

                    } else {
                        
                        // Acciones a realizar en caso de error
                        console.error('Error en la solicitud AJAX');
                    }
                });

/*
    $("#Table_list_Profiles").DataTable({
        ajax: function (d, cb) {
            fetch(ajaxUrl)
                .then(response => response.json())
                .then(data => cb(data));
                console.log(data)
        },
        "destroy": true,
        "processing": false,
        "scrollResize": true,
        "autoWidth": true,
        "responsive": true,
        "columns": [
            { "data": "NombrePerfil"
            },
            {	"data": "CantTenant",
                "width": "20%",
            },
            {	"data": "EstadoPerfil",
                "width":"8%",
                "className":"text-center",
                "render": function(data){
                            return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span class="text-muted fst-italic" style="color:red;">Inactivo</span>';
                        }
            },
            {	"data": "boton_editar",
                "className":"text-center",
                "width":"30%",
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

    new $.fn.dataTable.Buttons( table, {
        buttons: ['copy', 'excel', 'pdf' ]
    });*/

    divLoading.style.display = "none";
    return false;
}

function editar_perfil(element){

    let ajaxUrl = url_path.value+'perfiles/getdataprofile'; 
    const xhr = new XMLHttpRequest();
    const checkboxes = document.querySelectorAll('.check-permisos');
    let formData = new FormData();
    let idperfilencrypt=element.id

    document.getElementById("titulonewPerfil").innerHTML=""
    document.getElementById("titulonewPerfil").innerHTML="Editar Perfil"
    document.getElementById("tokenperfil_edit").value=element.id
    
    limpiar_permisos_recursos()
   
    formData.append("TokenPerfil",idperfilencrypt)
    xhr.open("POST", ajaxUrl, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
               
                var data=JSON.parse(xhr.responseText);
                
                //Actualiza el input-switch segun el valor traido de DB.
                for (var i = 0; i < data.length; i++) {

                    document.getElementById("R"+data[i].IDRecurso+"_R").checked=(data[i].r) ? true : false
                    selectedValues["R"+data[i].IDRecurso+"_R"]=(data[i].r) ? 1 : 0;//Se asigna el mismo valor a la matriz (read)
                    
                    if(data[i].r){
                        document.getElementById("R"+data[i].IDRecurso+"_R").onchange()
                    }

                    document.getElementById("R"+data[i].IDRecurso+"_C").checked=(data[i].c) ? true : false
                    selectedValues["R"+data[i].IDRecurso+"_C"]=(data[i].c) ? 1 : 0;
                    document.getElementById("R"+data[i].IDRecurso+"_U").checked=(data[i].u) ? true : false
                    selectedValues["R"+data[i].IDRecurso+"_U"]=(data[i].u) ? 1 : 0;
                    document.getElementById("R"+data[i].IDRecurso+"_D").checked=(data[i].d) ? true : false
                    selectedValues["R"+data[i].IDRecurso+"_D"]=(data[i].d) ? 1 : 0;
                }

                //Agrega a cada input-switch un evento input
                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change',event => {
                        // Actualizar el objeto con los valores seleccionados
                        selectedValues[checkbox.id]=(checkbox.checked)?1:0
                    })
                })

            } else {
                console.error('Error en la solicitud AJAX');
                callback(null);
            }
        }
    };
    xhr.send(formData);

}

function eliminar_perfil(value_perfil,usuarios_asignados_perfil,array_perfiles_IDS){

    // const miSelect = document.getElementById('lista_perfiles_permitidos_reasignar')
    // miSelect.innerHTML=""

    const IDsUser = []; //Inicializacion de arreglo donde estaran los IDS de los usuarios asignados a este perfil.
    
    //Card de aviso que hay usuarios asignados al perfil
    let card_avisode_usuarios_asignados=document.getElementById("card_avisode_usuarios_asignados")
    let div_notas_listaperfiles=document.getElementById("div_notas_listaperfiles")
    div_notas_listaperfiles.innerHTML="";

    //Se vacia el input donde estan los usuarios asignados al perfil, para garantizar que esta vacio y llenarlo solo con los usuarios de este perfil
    // $('#lista_usuarios_asignados_perfil').val('').trigger('change');
    // document.getElementById("lista_usuarios_asignados_perfil").innerHTML=""
    document.getElementById("nombre_perfil_aeliminar").innerHTML=value_perfil.NombrePerfil;
    document.getElementById("botones_confirmacion_eliminacion_perfil").innerHTML=`
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> -->
        <button type="button" class="btn btn-warning" id="btn_confirmacion_eliminacion" onclick="confirma_eliminacion(`+value_perfil.IDPerfil+`,`+value_perfil.CantUsuarios+`)">Si, entiendo las consecuencias y quiero eliminar el perfil</button>`

    if(usuarios_asignados_perfil.length > 0){

        card_avisode_usuarios_asignados.style.display="flex"

        if(Object.keys(array_perfiles_IDS).length > 0){
            
            for (var key in array_perfiles_IDS)  {
                if(key != value_perfil.IDPerfil){
                    const option = document.createElement('option');
                    option.value = key;
                    option.text = array_perfiles_IDS[key];
                    miSelect.appendChild(option);
                }
            }
            const option = document.createElement('option');
            option.value = 0;
            option.text = "** Ninguno, elimina el perfil y quita usuarios asignados";
            miSelect.appendChild(option);
        }

        //Se construye input para ponerlo en select de los usuarios asignados a este perfil - Dato desde parametro de la funcion
        for (let i = 0; i < usuarios_asignados_perfil.length; i++) {
            IDsUser.push(usuarios_asignados_perfil[i].IDUser);
            var newOption = new Option(usuarios_asignados_perfil[i].NombreUsuario, usuarios_asignados_perfil[i].IDUser, false, false);
            $('#lista_usuarios_asignados_perfil').append(newOption).trigger('change')
        }
        $('#lista_usuarios_asignados_perfil').val(IDsUser).trigger('change')
    
    }else{
        card_avisode_usuarios_asignados.style.display="none"
    }
}

function confirma_eliminacion(value_perfil,usuarios_asignadosalperfil){

    let lista_perfiles_permitidos_reasignar=document.getElementById("lista_perfiles_permitidos_reasignar")

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
    let ajaxUrl = url_path.value+'perfiles/eliminar_perfil'
    let formData = new FormData();
    formData.append('IDPerfil',value_perfil) //Perfil que se borrara
    formData.append('usuarios_asignadosalperfil',usuarios_asignadosalperfil) 

    if(usuarios_asignadosalperfil.length > 0){ 
        formData.append('IDPerfil_reasignacion',lista_perfiles_permitidos_reasignar.value)
    }else{
        formData.append('IDPerfil_reasignacion',null)
    }

    request.open("POST",ajaxUrl,true)
    request.send(formData)

    request.onreadystatechange = function(){

				console.log(request.responseText)
        let objData=JSON.parse(request.responseText)
        if(request.readyState == 4 && request.status == 200){
           
            close_canvas("close_modal_eliminarperfil")
            console.log(objData.status)
            
            if(objData.status){
                type_alertp="success"
                title_alertp="Correcto"
                text_alertp="Perfil eliminado."
                listar_perfiles_permitidos()
            }else{
                type_alertp="danger"
                title_alertp="Error"
                text_alertp="Por favor comuniquese con soporte."
            }

            let alert=document.getElementById("alert_form")
            alert.innerHTML=""

            show_msn_alert(type_alertp,title_alertp,text_alertp)
            
            setTimeout(function(){
                let close_alert=document.getElementById("close_alert")
                close_alert.click();
            }, 6500);
            return false
        }
    }
}

function json_listar_perfilespermitidos(callback){

    let ajaxUrl = url_path.value+'perfiles/listar_perfiles_permitidos'; 
    const xhr = new XMLHttpRequest();
    xhr.open('GET', ajaxUrl, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {

                var data=JSON.parse(xhr.responseText);
                var miTabla=$("#Table_list_Profiles").DataTable({
                    "destroy": true,
                    "processing": false,
                    "scrollResize": true,
                    "autoWidth": true,
                    "responsive": true,
"data":data.data,
                    "columns": [
                        {   
														"data": "NombrePerfil",
                            "width":"20%",
                        },
                        {	
"data":"Estado",
                            "width":"8%",
                        },
                        {	
"data":"Botones",
                            "width":"30%",
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
                
                
                //miTabla.clear();
                // for (var i = 0; i < data.data.length; i++) {
                //     miTabla.row.add([
                //         data.data[i].NombrePerfil,
                //         '<span class="badge text-bg-'+((data.data[i].Estado)?'success':'danger')+'">'+((data.data[i].Estado)?'<i class="bi bi-check me-1"></i> Activo':'<i class="bi bi-x me-1"></i> Inactivo')+'</span>',
                //         '<button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#newPerfil" data-bs-nombreperfil="'+data.data[i].NombrePerfil+'" data-bs-usuarios_asignados="'+data.data[i].usuarios_asignados+'"  data-bs-IDPerfil="'+data.data[i].IDPerfil+'"  data-bs-descripcionperfil="'+data.data[i].DescripcionPerfil+'" id="'+data.data[i].TokenPerfil+'" onclick="editar_perfil(this)"><i class="bi bi-pencil-fill"></i> Editar</button>'
                //     ]).draw(false); 
                // }

            } else {
                console.error('Error en la solicitud AJAX');
                callback(null);
            }
        }
    };
    xhr.send();
}
