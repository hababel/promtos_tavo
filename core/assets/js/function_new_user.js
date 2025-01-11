const validacion_newuser={ 
  "validate_email": false, //Se controla si el correo esta disponible para utilizar
  "validate_estructura_email":false, // Se controla si la estructura del correo es valida
	"validate_pass":false, // Se controla si la contraseña cumplio las politicas de complejidad
};

document.addEventListener("DOMContentLoaded", function(event) {

    const url_path= document.getElementById("url_path")
    let TKT
    let form_newuser = document.getElementById("form_newuser");
    let checkstatususer=document.getElementById("newuser_status")

    let pass1=document.getElementById("newuser_pass")
    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
    let newuser_email=document.getElementById("newuser_email")
    let copy_newuser_email=document.getElementById("copy_newuser_email")
		let icon_new_email=document.getElementById("icon_new_email")
    let btn_validarcorreo=document.getElementById("btn_validarcorreo")
    let newuser_pass=document.getElementById("newuser_pass")
		let newuser_nombre=document.getElementById("newuser_nombre")
		let newuser_apellido=document.getElementById("newuser_apellido")
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
		var btn_showpass=document.getElementById("btn_showpass");
		var Perfiles_user = $("#newuser_profile");
		var title_seccion =document.getElementById("title_seccion");


		const urlParams = new URLSearchParams(window.location.search);
		const TKU = urlParams.get('TKU');

		$(".select_2").select2({
			placeholder: 'Seleccione un perfil para asignarlo a este usuario'
		});

		// Se esta editando un usuario
		if (TKU) {
			title_seccion.innerHTML="Editar usuario";
			if(newuser_email.value.length > 0){
				newuser_email.classList.remove("is-invalid","is-valid");
			}else{
        newuser_email.classList.add("is-invalid")
				btn_validarcorreo.disabled=true;
			}
				
		}

    newuser_email.addEventListener("input",() => {
				if(input_tecnico.value == 1){
		
					Perfiles_user.find("option").each(function() {
						// Obtiene el id y el nombre de cada option
						var id = $(this).val();
						var nombre = $(this).text();
						if($(this).text() === "Técnico"){
							Perfiles_user.val($(this).val()).trigger('change');
						}
					});

				}else{
					// Perfiles_user.val(null).trigger('change');
				}
        if(newuser_email.value.length > 0){
					newuser_email.classList.remove("is-invalid")
					newuser_email.classList.add("is-valid")
				}else{
					newuser_email.classList.add("is-invalid")
					newuser_email.classList.remove("is-valid")
				}
				if(newuser_email.value.length > 0){
					btn_validarcorreo.classList.replace("btn-outline-secondary","btn-dark");
					btn_validarcorreo.disabled=false;
				}

				for (let index = 0; index < input_aftervalidateemail.length; index++) {
					// input_aftervalidateemail[index].value=null;
					input_aftervalidateemail[index].disabled=true;
				}
	
    });

		btn_validarcorreo.addEventListener("click",function(){
			
					if(newuser_nombre.value.length > 4 
							|| newuser_nombre.value.length !== 0 
							|| newuser_nombre.value !== "" 
							|| newuser_apellido.value.length > 4 
							|| newuser_apellido.value.length !== 0 
							|| newuser_apellido.value !== "")
					{

							newuser_nombre.classList.replace("is-invalid","is-valid")
							newuser_apellido.classList.replace("is-invalid","is-valid")

						if(newuser_email.value.length > 4 
							|| newuser_email.value.length !== 0 
							|| newuser_email.value !== "" ){
								
								spinner_new_email.classList.remove("visually-hidden")

								if(valida_estructura_email(newuser_email.value)){
										set_value_validacion_newuser("validate_estructura_email",true)
										validar_disponibilidademail(newuser_email.value,url_validaemail_usuario,function(existe) {
												if (existe !== null) {
														
														if (existe) {
																newuser_email.classList.add("is-invalid")
																document.getElementById("disponibilidad_email").innerHTML="Correo electrónico ya se encuentra registrado."
																set_value_validacion_newuser("validate_email",false)
														} else {
																newuser_email.classList.add("is-valid")
																set_value_validacion_newuser("validate_email",true)
																for (let index = 0; index < input_aftervalidateemail.length; index++) {
																	input_aftervalidateemail[index].disabled=false;
																}
																
														}
												} else {
														// Acciones a realizar en caso de error
														console.error('Error en la solicitud AJAX');
												}
												spinner_new_email.classList.add("visually-hidden")
												
										});
								}else{
									
									set_value_validacion_newuser("validate_estructura_email",false)
									spinner_new_email.classList.add("visually-hidden")
									document.getElementById("disponibilidad_email").innerHTML="Estructura de correo electrónico no permitida.  Debe ser: usuario@dominio.ext."
									newuser_email.classList.add("is-invalid")
									for (let index = 0; index < input_aftervalidateemail.length; index++) {
										input_aftervalidateemail[index].disabled=true;
									}

								}
						}else{
							newuser_email.classList.add("is-invalid")
							set_value_validacion_newuser("validate_email",false)
							for (let index = 0; index < input_aftervalidateemail.length; index++) {
								input_aftervalidateemail[index].disabled=true;
							}
						}

					}else{
							newuser_nombre.classList.add("is-invalid")
							newuser_apellido.classList.add("is-invalid")
							for (let index = 0; index < input_aftervalidateemail.length; index++) {
								input_aftervalidateemail[index].value=="";							
								input_aftervalidateemail[index].disabled=true;
							}
					}

		})

		if(btn_showpass){
				btn_showpass.addEventListener("click",function(){
					if(newuser_pass.type === "password"){
						newuser_pass.type="text"
						document.getElementById("icono_showpass").innerHTML='<i class="bi bi-eye-fill"></i>';
					}else if(newuser_pass.type === "text"){
						newuser_pass.type="password"
						document.getElementById("icono_showpass").innerHTML='<i class="bi bi-eye-slash-fill"></i>';
					}

				})

				newuser_pass.addEventListener("input",() => {

					var ulElement = document.getElementById("feedbback_pass").querySelector("ul");
					
					var li_feedback_letraspass=document.getElementById("li_feedback_letraspass")
					var li_feedback_numerospass=document.getElementById("li_feedback_numerospass")
					var result_complejidad_pass=validarcomplejidadpass(newuser_pass.value);

					if(result_complejidad_pass.lengthpass && result_complejidad_pass.letraspass && result_complejidad_pass.numerospass){
						newuser_pass.classList.add("is-valid")
						newuser_pass.classList.remove("is-invalid")
							while (ulElement.firstChild) {
								ulElement.removeChild(ulElement.firstChild);
							}
						set_value_validacion_newuser("validate_pass",true)
					}else{

							if(!result_complejidad_pass.lengthpass){ //Valida que tenga minimo 6 caracteres
								newuser_pass.classList.add("is-invalid")
								var li_feedback_lengthpass=document.getElementById("li_feedback_lengthpass")
								if (!li_feedback_lengthpass) {
									var liElement = document.createElement("li");
									liElement.textContent ="La contraseña debe ser minimo de 6 caracteres"
									liElement.id ="li_feedback_lengthpass"; 
									ulElement.appendChild(liElement);
								}
								set_value_validacion_newuser("validate_pass",false)
							}else{
								var li_feedback_lengthpass=document.getElementById("li_feedback_lengthpass")
								if (li_feedback_lengthpass) {
										ulElement.removeChild(li_feedback_lengthpass);
								}
							}
							if (!result_complejidad_pass.letraspass){ // Valida que tenga al menos 1 letra
								newuser_pass.classList.add("is-invalid")
								var li_feedback_letraspass=document.getElementById("li_feedback_letraspass")
								if(!li_feedback_letraspass){
									var liElement = document.createElement("li");
									liElement.textContent ="La contraseña debe tener al menos 1 letras mayuscula y minuscula"
									liElement.id="li_feedback_letraspass"
									ulElement.appendChild(liElement);
								}
								set_value_validacion_newuser("validate_pass",false)
							}else{
								var li_feedback_letraspass=document.getElementById("li_feedback_letraspass")
								if(li_feedback_letraspass){
									ulElement.removeChild(li_feedback_letraspass);
								}
							}
							if (!result_complejidad_pass.numerospass){ // Valida que el menos tenga 1 numero
								newuser_pass.classList.add("is-invalid")
								var li_feedback_numerospass=document.getElementById("li_feedback_numerospass")
								if(!li_feedback_numerospass){
									var liElement = document.createElement("li");
									liElement.textContent ="La contraseña debe tener al menos 1 número"
									liElement.id="li_feedback_numerospass"
									ulElement.appendChild(liElement);
								}
								set_value_validacion_newuser("validate_pass",false)
							}else{
								var li_feedback_numerospass=document.getElementById("li_feedback_numerospass")
								if(li_feedback_numerospass){
									ulElement.removeChild(li_feedback_numerospass);
								}
							}
					}

				})
		}

		$('#newuser_status').change(function() {
				if ($(this).prop('checked')) {
					$('#estadoLabel').text('Activo').removeClass('text-danger').addClass('text-success');
				} else {
					$('#estadoLabel').text('Inactivo').removeClass('text-success').addClass('text-danger');
				}
		});

		form_newuser.addEventListener('submit', function (event) {
	 		event.preventDefault();


			if(validacion_newuser.validate_email && validacion_newuser.validate_estructura_email &&	validacion_newuser.validate_pass)
			{
					document.getElementById('validacion_newuser').value=JSON.stringify(validacion_newuser);
					form_newuser.submit();

			}else{
					set_value_validacion_newuser("validate_estructura_email",((valida_estructura_email(newuser_email.value))?true:false))
					if(TKU.length > 3 ){
						set_value_validacion_newuser("validate_pass",true)
					}

					if(copy_newuser_email.value === copy_newuser_email.value){
						set_value_validacion_newuser("validate_email",true)
					}
					document.getElementById('validacion_newuser').value=JSON.stringify(validacion_newuser);
					if(validacion_newuser.validate_email && validacion_newuser.validate_estructura_email &&	validacion_newuser.validate_pass)
					{
						form_newuser.submit();
					}
			}
		})
	
});


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
    let div_claves_nuevousuario=document.getElementById("div_claves_nuevousuario")
    let newuser_token=document.getElementById("newuser_token");
    div_claves_nuevousuario.classList.add("visually-hidden")
    document.getElementById("newuser_profile").disabled=false

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

