const validacion_edituser={ 
  "Name": false,
  "Lastname":false
};

const validate_changepass={
  "User_pass":false,
  "User_pass2":false
}


document.addEventListener("DOMContentLoaded", function(event) { 
  event.preventDefault(); 

    let modal_change_pass=document.getElementById("modal_changepassuser")
    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
    let save_changepassuser=document.getElementById("save_changepassuser")
    var newuser_token=document.location.search.split('TKU=')[1];
    let btn_save_changepassuser= document.getElementById("save_changepassuser")
    let firstName=document.getElementById("firstName")
    let lastName=document.getElementById("lastName")

    set_value_validacion_edituser("Name",firstName.value)
    set_value_validacion_edituser("Lastname",lastName.value)

    $(".select_2").select2({
       dropdownParent: $('#newuser'),
       placeholder: 'Seleccione un perfil para asignarlo a este usuario'
    });
    
    change_pass1.addEventListener("input", function(e){
        
          if(change_pass1.value.length > 1){
              let compara_claves=validarclaves(change_pass1.value,change_pass2.value)
              if(compara_claves){
                  validate_changepass.User_pass=compara_claves.complejidad
                  validate_changepass.User_pass2=compara_claves.igualdad
              }

              if(validate_changepass.User_pass){
                  document.getElementById("mensaje_validacion_changepass_user").style.color="green"
                  document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-check' style='color:green'></i>"
                  btn_save_changepassuser.disabled=false
              }else{
                  document.getElementById("mensaje_validacion_changepass_user").style.color="red"
                  document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-x'></i>"
                  btn_save_changepassuser.disabled=true
              }
              if(validate_changepass.User_pass2){
                  document.getElementById("confirm_changepass_user").classList.remove("is-invalid")
                  document.getElementById("confirm_changepass_user").classList.add("is-valid")
                  btn_save_changepassuser.disabled=false
              }else{
                  document.getElementById("confirm_changepass_user").classList.remove("is-valid")
                  document.getElementById("confirm_changepass_user").classList.add("is-invalid")
                  btn_save_changepassuser.disabled=true
              }
          }
          
    })

    change_pass2.addEventListener("input", function(){
        if(change_pass2.value.length > 1){
            let compara_claves=validarclaves(change_pass1.value,change_pass2.value)
            if(compara_claves){
                validate_changepass.User_pass=compara_claves.complejidad
                validate_changepass.User_pass2=compara_claves.igualdad
            }
            
            if(validate_changepass.User_pass){
                document.getElementById("mensaje_validacion_changepass_user").style.color="green"
                document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-check' style='color:green'></i>"
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("mensaje_validacion_changepass_user").style.color="red"
                document.getElementById("icono_validacion_changepass_user").innerHTML="<i class='bi bi-file-excel'></i>"
                btn_save_changepassuser.disabled=true
            }

            if(validate_changepass.User_pass2){
                document.getElementById("confirm_changepass_user").classList.remove("is-invalid")
                document.getElementById("confirm_changepass_user").classList.add("is-valid")
                btn_save_changepassuser.disabled=false
            }else{
                document.getElementById("confirm_changepass_user").classList.remove("is-valid")
                document.getElementById("confirm_changepass_user").classList.add("is-invalid")
                btn_save_changepassuser.disabled=true
            }
        }
    })

    save_changepassuser.addEventListener("click",function(){

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
            let tokenuser_changepass=document.getElementById("tokenuser_changepass")
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP')
            let ajaxUrl = url_path.value+'usuarios/changepass_user'
            let formData = new FormData(form_newuser)
            formData.append("newpass",change_pass1.value)
            formData.append("tokenuser",tokenuser_changepass.value)
            request.open("POST",ajaxUrl,true)
            request.send(formData)
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
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
    })

    modal_change_pass.addEventListener('shown.bs.modal', () => {
        
        validate_changepass.User_pass = false
        validate_changepass.User_pass2= false
        prepare_changepassuser(firstName.value,newuser_token)
    })

    changeuserprofile.addEventListener("click", function(e) {
        e.preventDefault();

        let boton_close_alert=document.getElementById("close_alert");
                
        if(boton_close_alert){
            boton_close_alert.click();
        }

        let newuser_nombre=document.getElementById("firstName").value.trim();
        let newuser_apellido=document.getElementById("lastName").value.trim();
        let campos_llenos=false;

        if(newuser_token.length > 0){
            if(newuser_nombre.length <= 2 || newuser_apellido.length <= 2 ) {
                campos_llenos=false;
            }else{
                campos_llenos=true;
            }
        }else{
            campos_llenos=false;
            validacion_edituser.Name=false
            validacion_edituser.Lastname=false
        }
        
        if(!campos_llenos) {
            show_msn_alert("danger","Error","Los campos no pueden estar <b>vacios</b>, por favor llene los campos obligatorios e intente de nuevo") 
            setTimeout(function(){
                    let close_alert=document.getElementById("close_alert")
                    close_alert.click();
                }, 4500);
            return false;
        }else{

            if((validacion_edituser.Name !== newuser_nombre) || (validacion_edituser.Lastname !== newuser_apellido)){

                divLoading.style.display = "flex";
                const url_path= document.getElementById("url_path").value
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = url_path+'usuarios/edit_profile_user';
                let formData = new FormData(form_newuser);
                formData.append("newuser_token",newuser_token);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){

                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);
                        
                        console.log(objData)
                        show_msn_alert(objData.type,objData.title,objData.msg)
                        
                        setTimeout(function(){
                            let close_alert=document.getElementById("close_alert")
                            close_alert.click();
                            if(objData.status){
                                location.reload(true);
                            }
                        }, 2500)

                    }
                    divLoading.style.display = "none";
                    return false;
                }

            }else{
                // show_msn_alert("danger","Error","Por favor comuniquese con soporte")
                // setTimeout(function(){
                //     let close_alert=document.getElementById("close_alert")
                //     close_alert.click();
                // }, 4500);
                return false;
            }
        }

        // setTimeout(function(){
        //     let close_alert=document.getElementById("close_alert")
        //     close_alert.click();
        // }, 4500);
        //console.log(validacion_edituser)
    })


});
function prepare_changepassuser(nombre_usuario,TokenUser){
    let nameuser_changepass=document.getElementById("nameuser_changepass")
    let change_pass1=document.getElementById("changepass_user")
    let change_pass2=document.getElementById("confirm_changepass_user")
    let tokenuser_changepass=document.getElementById("tokenuser_changepass")
    
    tokenuser_changepass.value=TokenUser
    nameuser_changepass.innerHTML=nombre_usuario
    change_pass1.value=""
    change_pass2.value=""
    document.getElementById("mensaje_validacion_changepass_user").style.color="black"
    document.getElementById("icono_validacion_changepass_user").innerHTML=" "
    document.getElementById("confirm_changepass_user").classList.remove("is-invalid","is-valid")

}
function set_value_validacion_edituser(propiedad,valor){
    validacion_edituser[propiedad]=valor
}
