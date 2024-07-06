const validacion_newuser={ 
  "validate_email": false, //Se controla si el correo esta disponible para utilizar
  "validate_estructura_email":false, // Se controla si la estructura del correo es valida
  "Email":false,
  "Name": false,
  "Lastname":false,
  "Status":false,
  "Perfiles":false
};

const validate_newpass={
  "User_pass":false,
  "User_pass2":false
}

document.addEventListener("DOMContentLoaded", function(event) {

    const url_path= document.getElementById("url_path")
    let TKT
    let form_newuser = document.querySelector("#form_newuser");
    let checkstatususer=document.getElementById("newuser_status")
    let pass2=document.getElementById("newuser_comfirpass")
    let pass1=document.getElementById("newuser_pass")
    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
    let newuser_email=document.getElementById("newuser_email")
    let btn_validarcorreo=document.getElementById("btn_validarcorreo")
    let newuser_pass=document.getElementById("newuser_pass")
    let newuser_comfirpass=document.getElementById("newuser_comfirpass")
    let newuser_tenant=document.getElementById("newuser_tenant")
    let newuser_profile=document.getElementById("newuser_profile")
    let newuser_status=document.getElementById("newuser_status")
    let btn_guardar_nuevousuario=document.getElementById("btn_guardar_nuevousuario")
    let icono_validacion_changepass_user=document.getElementById("icono_validacion_changepass_user")
    let mensaje_validacion_changepass_user=document.getElementById("mensaje_validacion_changepass_user")
    let spinner_new_email = document.getElementById("spinner_new_email")
    let icono_validacion_disponibilidademail = document.getElementById("icono_validacion_disponibilidademail")
    let text_validacion_disponibilidademail = document.getElementById("text_validacion_disponibilidademail")
    let icon_spinner_validacion_disponibilidademail=document.getElementById("icon_spinner_validacion_disponibilidademail")
    let validacion_disponibilidademail=document.getElementById("validacion_disponibilidademail")
    let modal_new_user=document.getElementById("newuser")
    let modal_change_pass=document.getElementById("modal_changepassuser")
    let url_validaemail_usuario=url_path.value+'usuarios/findemail'
    var btn_save_changepassuser= document.getElementById("save_changepassuser")
		var input_aftervalidateemail=document.getElementsByClassName("input_aftervalidateemail");
		var input_tecnico=document.getElementById("input_tecnico");
		var input_new_user=document.getElementById("input_new_user");

    $(".select_2").select2({
       dropdownParent: $('#newuser'),
       placeholder: 'Seleccione un perfil para asignarlo a este usuario'
    });
    
    if(newuser_comfirpass){
        newuser_comfirpass.classList.remove("is-invalid","is-valid")
    }

    list_user()

		if(newuser_email){

				newuser_email.addEventListener("input",() => {

						newuser_pass.value="";
						newuser_comfirpass.value="";
						newuser_tenant.value="00";
						$("#newuser_profile").val('');
						$("#newuser_profile").trigger('change');
						
						document.getElementById("newuser_pass").classList.remove("is-valid","is-invalid")
						document.getElementById("newuser_comfirpass").classList.remove("is-valid","is-invalid")
						document.getElementById("btn_validarcorreo").classList.remove("visually-hidden")
						document.getElementById("btn_nuevocorreo").classList.add("visually-hidden")
						document.getElementById("mensaje_validacion_clave").style.color="black"
						document.getElementById("icono_validacion_clave").innerHTML=""

						btn_save_changepassuser.disabled=true
						newuser_pass.disabled=true
						newuser_comfirpass.disabled=true
						newuser_tenant.disabled=true
						newuser_profile.disabled=true
						newuser_status.disabled=true
						btn_guardar_nuevousuario.disabled=true
						btn_validarcorreo.disabled=false

				});
		}

/*
    modal_new_user.addEventListener('shown.bs.modal', () => {
        validate_newpass.User_pass = false
        validate_newpass.User_pass2= false
        set_value_validacion_newuser('validate_email',false)
        set_value_validacion_newuser('validate_estructura_email',false)
        set_value_validacion_newuser('Email',false)
        set_value_validacion_newuser('Lastname',false)
        set_value_validacion_newuser('Status',false)
        set_value_validacion_newuser('Perfiles',false)
    })

    modal_change_pass.addEventListener('shown.bs.modal', () => {
        
        var confirm_passwordInput = document.getElementById("confirm_changepass_user");
        var icon_confirm_changepass_user = document.getElementById("icon_confirm_changepass_user");
        confirm_passwordInput.type = "password";
        icon_confirm_changepass_user.innerHTML=""
        icon_confirm_changepass_user.innerHTML="<i class='bi bi-eye-slash-fill'></i>"
        validate_newpass.User_pass = false
        validate_newpass.User_pass2= false

    })

    btn_validarcorreo.addEventListener("click",function(){
         
            newuser_pass.disabled=true
            newuser_comfirpass.disabled=true
            newuser_tenant.disabled=true
            newuser_profile.disabled=true
            newuser_status.disabled=true
            btn_guardar_nuevousuario.disabled=true
        if(newuser_email.value.length > 4 || newuser_email.value.length !== 0 || newuser_email.value !== ""){
            icon_new_email.classList.add("visually-hidden")
            spinner_new_email.classList.remove("visually-hidden")
            icono_validacion_disponibilidademail.classList.add("visually-hidden")
            icon_spinner_validacion_disponibilidademail.classList.remove("visually-hidden")

            if(valida_estructura_email(newuser_email.value)){
                validacion_estructuraemail.style.color="green"
                icono_validacion_estructuraemail.innerHTML="<i class='bi bi-check' style='color:green'></i>"
                set_value_validacion_newuser("validate_estructura_email",true)
                validar_disponibilidademail(newuser_email.value,url_validaemail_usuario,function(existe) {
                    if (existe !== null) {
                        if (existe) {
                            validacion_disponibilidademail.style.color="red"
                            document.getElementById("text_validacion_disponibilidademail").innerText=" "
                            document.getElementById("text_validacion_disponibilidademail").innerText="Correo NO disponible."
                            icon_spinner_validacion_disponibilidademail.classList.add("visually-hidden")
                            icono_validacion_disponibilidademail.classList.remove("visually-hidden")
                            icono_validacion_disponibilidademail.innerHTML="<i class='bi bi-x'></i>"
                            set_value_validacion_newuser("validate_email",false)
                        } else {
                            validacion_disponibilidademail.style.color="green"
                            document.getElementById("text_validacion_disponibilidademail").innerText=" "
                            document.getElementById("text_validacion_disponibilidademail").innerText="Correo disponible."
                            icon_spinner_validacion_disponibilidademail.classList.add("visually-hidden")
                            icono_validacion_disponibilidademail.classList.remove("visually-hidden")
                            icono_validacion_disponibilidademail.innerHTML="<i class='bi bi-check' style='color:green'></i>"
                            set_value_validacion_newuser("validate_email",true)
                            newuser_pass.disabled=false
                            newuser_comfirpass.disabled=false
                            newuser_tenant.disabled=false
                            newuser_profile.disabled=false
                            newuser_status.disabled=false
                            btn_guardar_nuevousuario.disabled=false
                        }
                    } else {
                        // Acciones a realizar en caso de error
                        console.error('Error en la solicitud AJAX');
                    }

                    icon_new_email.classList.remove("visually-hidden")
                    spinner_new_email.classList.add("visually-hidden")
                    
                });
            }else{
                validacion_estructuraemail.style.color="red"
                icono_validacion_estructuraemail.innerHTML="<i class='bi bi-x'></i>"
                set_value_validacion_newuser("validate_estructura_email",false)
                btn_guardar_nuevousuario.disabled=true
                icon_new_email.classList.remove("visually-hidden")
                spinner_new_email.classList.add("visually-hidden")
                icono_validacion_disponibilidademail.classList.remove("visually-hidden")
                icon_spinner_validacion_disponibilidademail.classList.add("visually-hidden")
            }
        }else{
            set_value_validacion_newuser("validate_email",false)
            btn_guardar_nuevousuario.disabled=true
        }
    })

    btn_nuevocorreo.addEventListener("click",function(){
        
        newuser_email.disabled=false
        newuser_email.value=""
        newuser_email.classList.remove("is-valid")
        newuser_email.classList.remove("is-invalid")

        newuser_pass.value=""
        newuser_pass.disabled=true
        newuser_pass.classList.remove("is-valid")
        newuser_pass.classList.remove("is-invalid")
        
        newuser_comfirpass.value=""
        newuser_comfirpass.disabled=true
        newuser_comfirpass.classList.remove("is-valid")
        newuser_comfirpass.classList.remove("is-invalid")

        newuser_tenant.value="00"
        newuser_tenant.disabled=true

        $("#newuser_profile").val(null)
        $("#newuser_profile").trigger('change');

        newuser_profile.disabled=true
        
        newuser_status.value=""
        newuser_status.disabled=true
        
        btn_guardar_nuevousuario.disabled=true
        btn_validarcorreo.disabled=true
        btn_validarcorreo.classList.remove("visually-hidden")
        btn_nuevocorreo.classList.add("visually-hidden")

        document.getElementById("mensaje_validacion_clave").style.color="black"
        document.getElementById("icono_validacion_clave").innerHTML=""
    })

    checkstatususer.addEventListener('input', function() {
        change_newtenant_status(this.checked,"text_newuser_status")
    });

    pass2.addEventListener("input", function(){
        if(pass1.value.length > 1){
            let compara_claves=validarclaves(newuser_pass.value,newuser_comfirpass.value)
            if(compara_claves){
                validacion_newuser.User_pass=compara_claves.complejidad
                validacion_newuser.User_pass2=compara_claves.igualdad
            }
            
            if(validacion_newuser.User_pass){
                document.getElementById("mensaje_validacion_clave").style.color="green"
                document.getElementById("icono_validacion_clave").innerHTML="<i class='bi bi-check' style='color:green'></i>"
                btn_guardar_nuevousuario.disabled=false
            }else{
                document.getElementById("mensaje_validacion_clave").style.color="red"
                document.getElementById("icono_validacion_clave").innerHTML="<i class='bi bi-x'></i>"
                btn_guardar_nuevousuario.disabled=true
            }
            if(validacion_newuser.User_pass2){
                document.getElementById("newuser_comfirpass").classList.remove("is-invalid")
                document.getElementById("newuser_comfirpass").classList.add("is-valid")
                btn_guardar_nuevousuario.disabled=false
            }else{
                document.getElementById("newuser_comfirpass").classList.remove("is-valid")
                document.getElementById("newuser_comfirpass").classList.add("is-invalid")
                btn_guardar_nuevousuario.disabled=true
            }
        }
    })

    pass1.addEventListener("input", function(){
        if(pass1.value.length > 1){
            let compara_claves=validarclaves(newuser_pass.value,newuser_comfirpass.value)
            if(compara_claves){
                validacion_newuser.User_pass=compara_claves.complejidad
                validacion_newuser.User_pass2=compara_claves.igualdad
            }
            if(validacion_newuser.User_pass){
                document.getElementById("mensaje_validacion_clave").style.color="green"
                document.getElementById("icono_validacion_clave").innerHTML="<i class='bi bi-check' style='color:green'></i>"
                btn_guardar_nuevousuario.disabled=false
            }else{
                document.getElementById("mensaje_validacion_clave").style.color="red"
                document.getElementById("icono_validacion_clave").innerHTML="<i class='bi bi-x'></i>"
                btn_guardar_nuevousuario.disabled=true
            }
            if(validacion_newuser.User_pass2){
                document.getElementById("newuser_comfirpass").classList.remove("is-invalid")
                document.getElementById("newuser_comfirpass").classList.add("is-valid")
                btn_guardar_nuevousuario.disabled=false
            }else{
                document.getElementById("newuser_comfirpass").classList.remove("is-valid")
                document.getElementById("newuser_comfirpass").classList.add("is-invalid")
                btn_guardar_nuevousuario.disabled=true
            }
        }
    })

    change_pass1.addEventListener("input", function(e){
       var btn_save_changepassuser= document.getElementById("save_changepassuser")
       console.log(change_pass1.value.length)
        if(change_pass1.value.length > 1){
            let btn_save_changepassuser=document.getElementById("button_change_pass")
            let icono_validacion_changepass_user=document.getElementById("icono_validacion_changepass_user")
            let compara_claves=validarclaves(change_pass1.value,change_pass2.value)
            validacion_newuser.User_pass=compara_claves.complejidad
            validacion_newuser.User_pass2=compara_claves.igualdad

            if(validacion_newuser.User_pass){
                document.getElementById("mensaje_validacion_changepass_user").style.color="green"
                icono_validacion_changepass_user.innerHTML="<i class='bi bi-check' style='color:green'></i>"
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("mensaje_validacion_changepass_user").style.color="red"
                icono_validacion_changepass_user.innerHTML="<i class='bi bi-x' style='color:red'></i>"
                btn_save_changepassuser.disabled=true
            }
            if(validacion_newuser.User_pass2){
                document.getElementById("confirm_changepass_user").classList.remove("is-invalid")
                document.getElementById("confirm_changepass_user").classList.add("is-valid")
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("confirm_changepass_user").classList.remove("is-valid")
                document.getElementById("confirm_changepass_user").classList.add("is-invalid")
                btn_save_changepassuser.disabled=true
            }
        }else{
            document.getElementById("confirm_changepass_user").classList.remove("is-valid")
            document.getElementById("confirm_changepass_user").classList.add("is-invalid")
            btn_save_changepassuser.disabled=true
        }
    })

    change_pass2.addEventListener("input", function(){
        var btn_save_changepassuser= document.getElementById("save_changepassuser")
        if(change_pass2.value.length > 1){
            let compara_claves=validarclaves(change_pass1.value,change_pass2.value)
            if(compara_claves){
                validacion_newuser.User_pass=compara_claves.complejidad
                validacion_newuser.User_pass2=compara_claves.igualdad
            }
            
            if(validacion_newuser.User_pass){
                document.getElementById("mensaje_validacion_changepass_user").style.color="green"
                document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-check' style='color:green'></i>"
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("mensaje_validacion_changepass_user").style.color="red"
                document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-x'></i>"
                btn_save_changepassuser.disabled=true
            }

            if(validacion_newuser.User_pass2){
                document.getElementById("confirm_changepass_user").classList.remove("is-invalid")
                document.getElementById("confirm_changepass_user").classList.add("is-valid")
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("confirm_changepass_user").classList.remove("is-valid")
                document.getElementById("confirm_changepass_user").classList.add("is-invalid")
                btn_save_changepassuser.disabled=true
            }
        }else{
            document.getElementById("confirm_changepass_user").classList.remove("is-valid")
            document.getElementById("confirm_changepass_user").classList.add("is-invalid")
            btn_save_changepassuser.disabled=true
        }
    })

    form_newuser.onsubmit = function(e) {
        e.preventDefault();

        let newuser_nombre=document.getElementById("newuser_nombre").value.trim();
        let newuser_apellido=document.getElementById("newuser_apellido").value.trim();
        let newuser_email=document.getElementById("newuser_email").value.trim();
        let newuser_pass=document.getElementById("newuser_pass").value.trim();
        let newuser_token=document.getElementById("newuser_token").value.trim();
        let newuser_status=document.getElementById("newuser_status").checked
        let campos_llenos=false;

        if(newuser_token.length > 0){
            if(newuser_nombre.length <= 2 || newuser_apellido.length <= 2) {
                campos_llenos=false;
            }else{
                campos_llenos=true;
                validacion_newuser.User_pass = true;
                validacion_newuser.User_pass2 = true;
                validacion_newuser.User_email =(valida_estructura_email(newuser_email));
            }
        }else{
            if(
                newuser_nombre.length <= 2 || 
                newuser_apellido.length <= 2 || 
                newuser_email.length <= 4 || 
                newuser_pass.length <= 6
                ){
              campos_llenos=false;
            }else{
                campos_llenos=true;
            }
        }
        
        if(!campos_llenos) {
            show_msn_alert_intromodal("danger","Error","Los campos no pueden estar <b>vacios</b>, por favor llene los campos obligatorios e intente de nuevo","newuser","alert_new_user")
            setTimeout(function(){
                    let close_alert=document.getElementById("close_alert_intomodal")
                    close_alert.click();
                }, 4500);
            return false;
        }else{
            
            if(validacion_newuser.User_pass && validacion_newuser.User_pass2 && validacion_newuser.User_email){
                let boton_close_alert=document.getElementById("close_alert");
                if(boton_close_alert){
                    boton_close_alert.click();
                }
                divLoading.style.display = "flex";
                const url_path= document.getElementById("url_path").value
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = url_path+'usuarios/add_newuser';
                let formData = new FormData(form_newuser);
                formData.append("newuser_email",newuser_email);
                formData.append("newuser_status",newuser_status);
                formData.append("newuser_token",newuser_token);

                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){

                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);
                        console.log(objData)
                        if(objData.status){
                            list_user();
                        }
                        show_msn_alert(objData.type,objData.title,objData.msg)
                        close_canvas("close_new_user")
                        limpiar_formnuevousuario()
                        
                    }
                    divLoading.style.display = "none";
                    return false;  
                }
                
            }else{
                show_msn_alert_intromodal("danger","Error","Por favor comuniquese con soporte","newuser","alert_new_user")
                setTimeout(function(){
                    let close_alert=document.getElementById("close_alert_intomodal")
                    close_alert.click();
                }, 4500);
                return false;
            }
        }

        setTimeout(function(){
            let close_alert=document.getElementById("close_alert")
            close_alert.click();
        }, 4500);
    }
*/
});

function list_tenant_select(){
      const url_path= document.getElementById("url_path").value
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = url_path+'tenant/list_tenant_select'; 
      let formData = new FormData();
      
      formData.append('estado_tenant',1);
      request.open("POST",ajaxUrl,true);
      request.send(formData);
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
              let objData = JSON.parse(request.responseText);

              if(objData.status){ 
                 
                select = document.getElementById("newuser_tenant");

                if(objData.data.length>0){
                    
                    for (let i = 0; i < (objData.data).length; i++) {
                        option = document.createElement("option");
                        option.value = objData.data[i].IDTenant;
                        option.text = objData.data[i].NombreTenant;
                        select.appendChild(option);
                        select.value="00"
                    }
                }
                
              }
          }
          return false;
        }
}

function list_user(){

  const url_path= document.getElementById("url_path").value
  let ajaxUrl = url_path+'usuarios/list_user';
	let tecnico = document.getElementById('tecnico').value;
	var data_columnas
	var columnDefs;

		if(!tecnico){
				data_columnas=[
				{ "data": "NombreCompletoUsuario",
						"width": "30%",
				},
				{	"data": "NombreTenant",
						"width": "20%",
						"render": function(data){
												return (data)?data:'<span class="text-muted fst-italic" style="font-size:smaller">- Sin Tenant -</span>';
										}
				},
				{	"data": "Perfiles",
						"width":"12%",
				},
				{	"data": "EstadoUsuario",
						"width":"8%",
						"className":"text-center",
						"render": function(data){
												return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span class="text-muted fst-italic" style="color:red;">Inactivo</span>';
										}
				},
				{	"data": "IDUser",
						"width":"20%",
				},
				{	"data": "boton_editar",
						"className":"text-center",
						"width":"20%",
				}];

				columnDefs=[{
						target: 4, // Columna IDUSER
						visible: false,
						searchable: true,
				},]
		}else{
					data_columnas=[
					{ "data": "NombreCompletoUsuario",
							"width": "25%",
					},
					{"data":"NombreCortoTecnico",
						"width": "12%",
					},
					{	"data": "NombreTenant",
							"width": "10%",
							"render": function(data){
													return (data)?data:'<span class="text-muted fst-italic" style="font-size:smaller">- Sin Tenant -</span>';
											}
					},
					{	"data": "Perfiles" },
					{	"data": "EstadoUsuario",
							"width":"8%",
							"className":"text-center",
							"render": function(data){
													return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span class="text-muted fst-italic">Inactivo</span>';
											}
					},
					{"data":"DisponibilidadTecnica",
						"width":"8%",
						"className":"text-center",
						"render": function(data){
								return(data)?'<i class="bi bi-wrench-adjustable-circle-fill" style="font-size: 1.3rem;color:green"></i>':'<span class="text-muted fst-italic">No disponible</span>';
						}
					},
					{"data":"ColorTecnico",
						"width":"4%",
						"className":"text-center",
						"render": function(data){
											return (data)?'<div style="background-color:'+data+'">&nbsp;</div>':' - sin color -';
									}
					},
					{"data":"CalificacionTecnica",
						"render":function(data){
												return (data)?`
												<div class="container text-center">
													<div class="row">`+((data >= 4.8)?`
														<div class="col-2">
															<i class="bi bi-trophy-fill" style="color:#6610f2"></i>
														</div>`:'')+`
														<div class="col-12">
															<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="`+data+`" aria-valuemin="0" aria-valuemax="5">
																<div class="progress-bar progress-bar-striped progress-bar-animated `+((data < 3)?`bg-danger`:((data >= 3 && data < 4.5)?`bg-warning`:((data >= 4.5 && data < 4.9 )?`bg-info`:`bg-success`)))+` " style="width: `+((data*100)/5)+`%">`+data+
																`</div>
															</div>
														</div>
													</div>
												</div>`:'<span class="text-muted fst-italic" style="color:red;">Sin calificación</span>';
											},
							"width":"13%",
						},
					{	"data": "IDUser" },
					{	"data": "boton_editar",
							"className":"text-center",
							"width":"20%",
					}
				];

				columnDefs=[{
					target: 8, // Columna IDUSER
					visible: false,
					searchable: false,
				},{
					target: [3], // Columna perfil
					visible: false,
					searchable: false,
				}]
		}

  $("#Table_list_User").DataTable({
      ajax:{
				"url": ajaxUrl ,
				"data": {
						"tecnico": tecnico
				},
				"dataType": "json",
				"type": "POST"
			},

      "destroy": true,
      "processing": false,
      "scrollResize": true,
      "autoWidth": true,
      "responsive": true,
      "columns":data_columnas,
      'dom': 'lBfrtip',
			"bFilter": true, // show search input,

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
                  "columns": [ 0, 1, 2,4]
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
      columnDefs: columnDefs,

  });

  var table = $("#Table_list_User").DataTable();
  new $.fn.dataTable.Buttons( table, {
      buttons: [
          'copy', 'excel', 'pdf'
      ]
  }); 
   

}
function limpiar_formnuevousuario(){

    let newuser_pass=document.getElementById("newuser_pass")
    let newuser_comfirpass=document.getElementById("newuser_comfirpass")
    let newuser_tenant=document.getElementById("newuser_tenant")
    let newuser_profile=document.getElementById("newuser_profile")
    let newuser_status=document.getElementById("newuser_status")
    let btn_guardar_nuevousuario=document.getElementById("btn_guardar_nuevousuario")
    var btn_save_changepassuser= document.getElementById("save_changepassuser")

    form_newuser=document.getElementById("form_newuser")
    if(form_newuser){
        form_newuser.reset()
    }
    if(newuser_tenant){
        newuser_tenant.value='00';
        newuser_tenant.disabled=true
    }
    document.getElementById("titulo_modal_user").innerHTML="Nuevo Usuario"
    
    $("#newuser_profile").val('');
    $("#newuser_profile").trigger('change');
    document.getElementById("newuser_email").disabled=false
    document.getElementById("newuser_email").classList.remove("is-valid","is-invalid")
    document.getElementById("newuser_pass").classList.remove("is-valid","is-invalid")
    document.getElementById("newuser_comfirpass").classList.remove("is-valid","is-invalid")
    document.getElementById("btn_validarcorreo").classList.remove("visually-hidden")
    document.getElementById("btn_nuevocorreo").classList.add("visually-hidden")
    document.getElementById("mensaje_validacion_clave").style.color="black"
    document.getElementById("icono_validacion_clave").innerHTML=""
    
    if(btn_save_changepassuser){
        btn_save_changepassuser.disabled=true
    }
    
    newuser_pass.disabled=true
    newuser_comfirpass.disabled=true
    if(newuser_profile){
        newuser_profile.disabled=true
    }
    
    newuser_status.disabled=true
    btn_guardar_nuevousuario.disabled=true
    btn_validarcorreo.disabled=false

}
function prepare_new_user(){
    
    let div_claves_nuevousuario=document.getElementById("div_claves_nuevousuario")
    div_claves_nuevousuario.classList.remove("visually-hidden")
    limpiar_formnuevousuario()
}

function editar_usuario(IDUser,perfiles_user) {
    let newuser_nombre=document.getElementById("newuser_nombre")
    let newuser_apellido=document.getElementById("newuser_apellido")
    let newuser_email=document.getElementById("newuser_email")
    let titulo_modal_user=document.getElementById("titulo_modal_user")
    // let div_claves_nuevousuario=document.getElementById("div_claves_nuevousuario")
    let newuser_token=document.getElementById("newuser_token");
    // div_claves_nuevousuario.classList.add("visually-hidden")
    // document.getElementById("newuser_profile").disabled=false

    newuser_nombre.value=""
    newuser_apellido.value=""
    newuser_email.value=""
    titulo_modal_user.innerHTML=""
    

    const url_path= document.getElementById("url_path").value
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = url_path+'usuarios/list_user'; 
    let formData = new FormData();
    
    formData.append('id_user',IDUser);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){ 
                if(objData.data.length>0){
                    objData.data.forEach(element => {
                        titulo_modal_user.innerHTML="Editar Usuario: <b>"+element.NombreCompletoUsuario+"</b>"
                        newuser_nombre.value=element.NombreUsuario
                        newuser_apellido.value=element.ApellidosUsuario
                        newuser_email.value=element.EmailUsuario
                        newuser_token.value=element.TokenUser
                    });

                    if(perfiles_user){
                        let arr = perfiles_user.split(',');
                        $("#newuser_profile").val(arr);
                        $("#newuser_profile").trigger('change');
                    }
                }
            }
        }
        return false;
    }

    // limpiar_formnuevousuario()
    // div_claves_nuevousuario=document.getElementById("div_claves_nuevousuario")
    // div_claves_nuevousuario.style.display="none"
    // newuser_tenant=document.getElementById("newuser_tenant")
    // newuser_tenant.disabled=false
    // btn_guardar_nuevousuario=document.getElementById("btn_guardar_nuevousuario")
    // btn_guardar_nuevousuario.disabled=false
    // document.getElementById("titulo_modal_user").innerHTML="Editando Usuario: <b>"+Data_User.NombreCompletoUsuario+"</b>"
    // document.getElementById("newuser_nombre").value=Data_User.NombreUsuario
    // document.getElementById("newuser_apellido").value=Data_User.ApellidosUsuario
    // newuser_tenant.value=(Data_User.IDTenant)?Data_User.IDTenant:'00';
    // document.getElementById("newuser_token").value=Data_User.TokenUser
    // document.getElementById("newuser_email").value=Data_User.EmailUsuario
    // newuser_profile=document.getElementById("newuser_profile")
    // newuser_profile.disabled=false;
    // document.getElementById("newuser_status").disabled=false;
    // document.getElementById("newuser_pass").removeAttribute("required")
    // document.getElementById("newuser_comfirpass").removeAttribute("required")

    // if(Data_User.EstadoUsuario){
    //     document.getElementById("newuser_status").checked=true
    // }else{
    //     document.getElementById("newuser_status").checked = false
    // }
    // change_newtenant_status(Data_User.EstadoUsuario,"text_newuser_status")

    
}

function prepare_changepassuser(nombre_usuario,IDUser){
    console.log(nombre_usuario)
    //let nameuser_changepass=document.getElementById("nameuser_changepass")
    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
    let button_change_pass=document.getElementById("button_change_pass")

   
        button_change_pass.innerHTML=`
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="save_changepassuser" onclick="save_changepassuser('`+IDUser+`')">Guardar</button>`
   

    nameuser_changepass.innerHTML=nombre_usuario
    change_pass1.value=""
    change_pass2.value=""
    document.getElementById("mensaje_validacion_changepass_user").style.color="black"
    document.getElementById("icono_validacion_changepass_user").innerHTML=" "
    document.getElementById("confirm_changepass_user").classList.remove("is-invalid","is-valid")

}

function set_value_validacion_newuser(propiedad,valor){
    validacion_newuser[propiedad]=valor
}

function save_changepassuser(IDUserchange){

    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
        if((change_pass1.value !== change_pass2.value) || 
            change_pass1.value.length == 0 || 
            change_pass2.value.length == 0 ){
            let type_alertp="danger"
            let title_alertp="Error"
            let text_alertp="Los datos no pueden estar vacios, por favor validelos"
            let id_modal="modal_changepassuser"
            let id_alertintomodal="alert_model_changepassuser"
            show_msn_alert_intromodal(type_alertp,title_alertp,text_alertp,id_modal,id_alertintomodal)
            change_pass1.value=""
            change_pass2.value=""
        }else{
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
            let ajaxUrl = url_path.value+'usuarios/changepass_user'
            let formData = new FormData(form_newuser)
            formData.append("newpass",change_pass1.value)
            formData.append("IDUser",IDUserchange)
            request.open("POST",ajaxUrl,true)
            request.send(formData)
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    console.log(request.responseText);
                    let objData = JSON.parse(request.responseText);
                    
                    if(objData.status){
                        
                        let close_alert=document.getElementById("btnclose_modalchangepass")
                        close_alert.click();

                        show_msn_alert(objData.type,objData.title,objData.msg)

                        setTimeout(function(){
                            let close_alert=document.getElementById("close_alert")
                            close_alert.click();
                        }, 6500);

                    }else{
                        
                        let id_modal="modal_changepassuser"
                        let id_alertintomodal="alert_model_changepassuser"
                        show_msn_alert_intromodal(objData.type,objData.title,objData.msg,id_modal,id_alertintomodal)
                        setTimeout(function(){
                            let close_alert=document.getElementById("close_alert_intomodal")
                            close_alert.click();
                        }, 6500);
                    }
                    return false
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }

function confirm_view_pass(){
    
    var confirm_passwordInput = document.getElementById("confirm_changepass_user");
    var icon_confirm_changepass_user = document.getElementById("icon_confirm_changepass_user");


    if (confirm_passwordInput.type === "password") {
        confirm_passwordInput.type = "text";
        icon_confirm_changepass_user.innerHTML=""
        icon_confirm_changepass_user.innerHTML="<i class='bi bi-eye-fill'></i>"

    } else {
        confirm_passwordInput.type = "password";
        icon_confirm_changepass_user.innerHTML=""
        icon_confirm_changepass_user.innerHTML="<i class='bi bi-eye-slash-fill'></i>"
    }
}

function view_pass(){
    
    var passwordInput = document.getElementById("changepass_user");
    var icon_changepass_user = document.getElementById("icon_changepass_user");


    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon_changepass_user.innerHTML=""
        icon_changepass_user.innerHTML="<i class='bi bi-eye-fill'></i>"

    } else {
        passwordInput.type = "password";
        icon_changepass_user.innerHTML=""
        icon_changepass_user.innerHTML="<i class='bi bi-eye-slash-fill'></i>"
    }
}




