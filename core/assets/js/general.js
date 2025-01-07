
    
    function change_newtenant_status(checkstatustenant,id_elemento_estado){
        
        var text_newtenant_status=document.getElementById(id_elemento_estado)

        if(!checkstatustenant){
            text_newtenant_status.innerHTML='Inactivo'; 
            text_newtenant_status.classList.add('text-danger');
        }else{
            text_newtenant_status.innerHTML='Activo'; 
            text_newtenant_status.classList.remove('text-danger');
        }
    }

    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

		function validarcomplejidadpass(pass){

						var patternABC =/^(?=.*[a-z])(?=.*[A-Z])/;
						var pattern123 = /^(?=.*\d)/;
						var complejidad_pass={
							"lengthpass":(pass.length >= 6)?true:false,
							"letraspass":(!patternABC.test(pass))?false:true,
							"numerospass":(!pattern123.test(pass))?false:true
						};

						return complejidad_pass;
		}

    function validarclaves(pass1,pass2) {
        var respuestavalidacionclaves={"igualdad":false,"complejidad":false}
        // Verificar si las contraseñas coinciden
        respuestavalidacionclaves.igualdad=((pass1 === pass2)?true:false);

        // Verificar la complejidad de la nueva contraseña
        var pattern = /^(?=.*[A-Z])(?=.*\d)(?!.*\s).{6,}$/;
        respuestavalidacionclaves.complejidad=(!pattern.test(pass1))?false:true;

        return respuestavalidacionclaves;
    }

    function show_msn_alert(type_alertp,title_alertp,text_alertp) {
        let alert=document.getElementById("alert_form")
        alert.innerHTML = 
           `<div class="alert alert-`+type_alertp+` alert-dismissible" role="alert" id="show_alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="close_alert"></button>
              <p id="text_alert"><strong id="title_alert" class="me-1">`+title_alertp+`</strong> `+text_alertp+`</p>
            </div>`
    }

    function show_msn_alert_intromodal(type_alertp,title_alertp,text_alertp,id_modal,id_alertintomodal){
        var alertPlaceholder = document.getElementById(id_alertintomodal)
        var input_focus=document.getElementById(id_modal);
        // var wrapper = document.createElement('div')
        alertPlaceholder.innerHTML = 
            `<div class="alert alert-`+type_alertp+` alert-dismissible" role="alert" id="alertmodal">
                <p id="text_alert"><strong class="me-1" id="title_alert">`+title_alertp+`</strong> `+text_alertp+`</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="close_alert_intomodal"></button>
            </div>`
        // alertPlaceholder.append(wrapper)
        input_focus.scrollTop=0
    }

    function reset_alert_intomodal(id_alertintomodal){
        var alertPlaceholder = document.getElementById(id_alertintomodal)
        alertPlaceholder.dispose()
    }

    function close_canvas(idcanvas){

        let button_close_offcanvas=document.getElementById(idcanvas)
        button_close_offcanvas.click()

    }

    function valida_estructura_email(email){
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        return (!emailRegex.test(email))?false:true;
    }

    function validar_disponibilidademail(email,url_path,callback){
        const xhr = new XMLHttpRequest();
        const data = 'email=' + encodeURIComponent(email);
        xhr.open('POST', url_path, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const existeEmail = parseInt((xhr.responseText))
                    callback(existeEmail);
                } else {
                    callback(null);
                }
            }
        };
        xhr.send(data);
    }
    function mostrar_pass(nombre_elemento){
        const passwordInput = document.getElementById(nombre_elemento);
        passwordInput.type = "text";
    }
    function ocultar_pass(nombre_elemento){
        const passwordInput = document.getElementById(nombre_elemento);
        passwordInput.type = "password";
    }
    function obtener_desde_entrefechas_ahoy(fechacomparar){
        // Crear la fecha específica (por ejemplo, "2023-11-15")
        var fechaEspecifica = new Date(fechacomparar);

        // Obtener la fecha actual
        var fechaActual = new Date();

        //Diferencia de en años, meses, dias y horas desde la creacion ahoy
        var diffannos=fechaActual.getFullYear()-fechaEspecifica.getFullYear();
        var diffmeses=fechaActual.getMonth()-fechaEspecifica.getMonth();
        var diffdias=fechaActual.getDate()-fechaEspecifica.getDate();
        var diffhoras=fechaActual.getHours()-fechaEspecifica.getHours();
        
        // Crear el intervalo "desde:"
        var intervaloDesde = "";
        

        if (diffannos > 0) {
            intervaloDesde = diffannos + ' año'+((diffannos > 1)?'s':'');
        }
        
        if (diffmeses > 0) {
            intervaloDesde += ((diffannos > 0)?' y ': '' )+diffmeses+' mes'+((diffmeses > 1)?'es':'');
        } 
        
        if (diffdias > 0) {
            intervaloDesde +=((diffmeses > 0)?' y ':'')+ diffdias+' día'+((diffdias > 1)?'s':'');
        } 

        if(diffhoras > 0 && diffdias <= 0 && diffmeses<= 0 && diffannos <= 0){
            intervaloDesde +=((diffdias > 0)?' y ':'')+ diffhoras+' hora'+((diffhoras > 1)?'s':'');
        }

         return intervaloDesde;

    }
		function generarCodigoHexadecimal() {
			// Genera un número aleatorio entre 0 y 16777215 (FFFFFF en hexadecimal)
			var numeroAleatorio = Math.floor(Math.random() * 16777216);

			// Convierte el número a formato hexadecimal y quita los primeros caracteres
			var codigoHexadecimal = numeroAleatorio.toString(16).substring(0, 6);

			// Asegura que el código tenga exactamente 6 caracteres
			while (codigoHexadecimal.length < 6) {
				codigoHexadecimal = '0' + codigoHexadecimal;
			}

			return codigoHexadecimal;
		}

	function mostrarOverlay() {
		var overlay = document.getElementById('overlay');
		overlay.style.display = 'flex';
	}

	function ocultarOverlay() {
		var overlay = document.getElementById('overlay');
		overlay.style.display = 'none';
	}