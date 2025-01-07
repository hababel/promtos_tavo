
let selectedValues = {};


document.addEventListener("DOMContentLoaded", function(event) { 

	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
	const url_path= document.getElementById("url_path")
	const form_newpermisos= document.getElementById("form_newpermisos")
  const divLoading = document.querySelector("#divLoading")
 	// Obtener todos los input check en la matriz
  const checkboxes = document.querySelectorAll('.check-permisos');
	var IDPerfil_edit=document.getElementById("IDPerfil_edit");

	//json_listar_perfilespermitidos()
  if(IDPerfil_edit.value === 0){
		limpiar_permisos_recursos()
	}


 	$(".select_2").select2({
      placeholder: 'Seleccione un usuario para asignarlo a este perfil'
  });

	// Agregar un event listener para cada input check y se modifica matriz vacia creada anteriormente
	checkboxes.forEach(function(checkbox) {
				
			checkbox.addEventListener('change',event => {
			// Actualizar el objeto con los valores seleccionados

					selectedValues[checkbox.id]=(checkbox.checked)?1:0
					
					/*var PadreRecurso = document.getElementById(checkbox.getAttribute('data-PadreRecurso'));
					var PadreAccion = document.getElementById(checkbox.getAttribute('data-PadreAccion'));
					var all_elementPadreRecurso=document.getElementsByClassName(checkbox.getAttribute('data-classPadreRecurso'))
					var all_elementPadreAccion=document.getElementsByClassName(checkbox.getAttribute('data-classPadreAccion'))
					var cant_elementRecurso_checked=0;
					var cant_elementAccion_checked=0;

					for(var i=0; i<all_elementPadreRecurso.length; i++) {
							if(all_elementPadreRecurso[i].checked){
									cant_elementRecurso_checked++
							}
					}

					for (let index = 0; index < all_elementPadreAccion.length; index++) {
							if(all_elementPadreAccion[i].checked){
									cant_elementAccion_checked++
							}
					}

					if(PadreRecurso.checked && !checkbox.checked ){
							PadreRecurso.checked=false
					}else if(checkbox.checked && (cant_elementRecurso_checked === all_elementPadreRecurso.length)){
							PadreRecurso.checked=true
					}

					if(PadreAccion.checked && !checkbox.checked ){
							PadreAccion.checked=false
					}else if(checkbox.checked && (cant_elementAccion_checked === all_elementPadreAccion.length)){
							PadreAccion.checked=true
					}
					*/
			});
	});

	form_newpermisos.addEventListener('submit', function(event) {

		event.preventDefault();
		var array_checkrecursosperfiles=new Array();
		let permisosseleccionados={};
		var IDPerfil_edit=document.getElementById("IDPerfil_edit").value
		var nuevoperfil_nombre=document.getElementById("nuevoperfil_nombre").value
		var Jerarquia_Perfil_edit=document.getElementById("Jerarquia_Perfil_edit").value
		var nuevoperfil_asignarusuarios=$('#nuevoperfil_asignarusuarios').val()

		if(Jerarquia_Perfil_edit == 1){

			form_newpermisos.submit()

		}else{

				var todoslosrecursos=document.getElementsByName("Allcheckrecursos")

				let indice=0 
				todoslosrecursos.forEach(element => {

						let id_recurso=(element.id.substring(3,4))
						let permisos=document.getElementsByClassName("Resource"+id_recurso)
						let permisosxrecurso={};
						permisosxrecurso["id_recurso"]=id_recurso
						for (let index = 0; index < permisos.length; index++) {
								permisosxrecurso[permisos[index].id.substring(3)]=(permisos[index].checked)?1:0
						}
						permisosseleccionados[indice]=permisosxrecurso;
						indice+=1
				});

				if(nuevoperfil_nombre.length === 0 || !hasValue(permisosseleccionados, 1)){
					var text_alertp = 'Los campos no pueden estar <b>vacios</b>, por favor llene los campos obligatorios e intente de nuevo'
					show_msn_alert("danger","Error",text_alertp)
					window.scroll(0, 0);

					setTimeout(function(){
							let close_alert=document.getElementById("close_alert")
							close_alert.click();
					}, 6500);

				}else{
						// Agregar datos al formulario
						var nuevoInput = document.createElement('input');
						nuevoInput.type = 'hidden';
						nuevoInput.name = 'checkperfiles';

						nuevoInput.value = (JSON.stringify(permisosseleccionados));
						form_newpermisos.appendChild(nuevoInput);
						form_newpermisos.submit()
				}
		}

	})

})

function hasValue(obj, value) {
  for (const key in obj) {
    if (obj[key] === value) {
      return true;
    } else if (typeof obj[key] === "object") {
      const foundInNested = hasValue(obj[key], value);
      if (foundInNested) {
        return true;
      }
    }
  }
  return false;
}


function habilitarxmostrar(element){

    var elementoseleccionado_mostrar=document.getElementById(element)
    var grupo_elementos_enabled=document.getElementsByClassName(element.getAttribute('data-classPadreRecurso'))

    if(element.checked){
         for (let index = 1; index < grupo_elementos_enabled.length; index++) {
            grupo_elementos_enabled[index].disabled = false;
            const event = new Event('change'); // Crear un nuevo evento 'change'
            grupo_elementos_enabled[index].dispatchEvent(event);
         }
    }else{
         for (let index = 1; index < grupo_elementos_enabled.length; index++) {
            grupo_elementos_enabled[index].checked = false;
            grupo_elementos_enabled[index].disabled = true;
            const event = new Event('change'); // Crear un nuevo evento 'change'
            grupo_elementos_enabled[index].dispatchEvent(event);
         }
    }

}

function limpiar_permisos_recursos(){

    const event = new Event('change'); // Crear un nuevo evento 'change'
    const all_elementos_check = document.getElementsByClassName("checkperfiles");
    
    //Pone en false el check de todos los elementos que son input checked
    for (let index = 0; index < all_elementos_check.length; index++) {
        all_elementos_check[index].checked = false;
        all_elementos_check[index].dispatchEvent(event)
    }

    const MostrarChecked=document.getElementsByClassName("MostrarChecked")
    for (let index = 0; index < MostrarChecked.length; index++) {
        MostrarChecked[index].dispatchEvent(event);
    }
}

//Cambio en todos los check de todos los recursos segun la accion (Crear,mostrar,editar o eliminar)
function AllActionChecked(actionselected){
    
    switch (actionselected.id) {
        case "AllCreateChecked":
            padreDIVinputs=document.getElementsByClassName("CreateChecked")
            break;
        case "AllMostrarChecked":
            padreDIVinputs=document.getElementsByClassName("MostrarChecked")
            break;
        case "AllEditarChecked":
            padreDIVinputs=document.getElementsByClassName("EditarChecked")
            break;
        case "AllEliminarChecked":
            padreDIVinputs=document.getElementsByClassName("EliminarChecked")
            break;
        default:
            break;
    }

    for(var i=0; i<padreDIVinputs.length; i++) {
        if(!(padreDIVinputs[i].disabled)){
          padreDIVinputs[i].checked = actionselected.checked;
            const event = new Event('change'); // Crear un nuevo evento 'change'
            padreDIVinputs[i].dispatchEvent(event);
        }
    }
}

//Cambio en todos los check de las acciones del recurso seleccionado.
function AllResourceChecked(resourceselected){

    value_padrecheckinput=document.getElementById("All"+resourceselected+"Checked")
    class_idresource="Resource"+resourceselected;
    padrecheckinputs=document.getElementsByClassName(class_idresource)
  
    for(var i=0; i<padrecheckinputs.length; i++) {
        padrecheckinputs[i].checked = value_padrecheckinput.checked;
        var eventoOnchange = new Event('change');
        padrecheckinputs[i].dispatchEvent(eventoOnchange);
        
        if(value_padrecheckinput.checked){
            if(i > 0){
                padrecheckinputs[i].disabled = false;
            }
        }else{

            if(i > 0){
                padrecheckinputs[i].disabled = true;
            }
        }
    }
}

function prepare_newperfil(){

	// document.getElementById("titulonewPerfil").innerHTML=""
 	// document.getElementById("titulonewPerfil").innerHTML="Nuevo Perfil"
 	// document.getElementById("form_newpermisos").reset()
  //   $('#nuevoperfil_asignarusuarios').val('').trigger('change')
  //   document.getElementById("idperfil_edit").value=0
  //   document.getElementById("tokenperfil_edit").value=0

  //   limpiar_permisos_recursos()
  //   const checkboxes = document.querySelectorAll('.check-permisos');
    
  //   //Genera/Inicializa matriz nueva
  //   selectedValues = {};
    
  //   //LLena matriz de ceros
  //   checkboxes.forEach(function(checkbox) {
  //       const groupName = (checkbox.id).substring(0,2);
  //       if (!selectedValues[groupName]) {
  //           selectedValues[groupName] = {};
  //       }
  //       selectedValues[groupName][(checkbox.id).substring(3,4)]=0
  //   });

}