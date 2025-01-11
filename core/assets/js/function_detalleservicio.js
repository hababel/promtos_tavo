let nuevoestadoservicio
let IDServicioDetalle
let descripcionactividadservicio

const urlParams = new URLSearchParams(window.location.search);
IDServicioDetalle = urlParams.get('IDServicio');

$(document).ready(function() {
  $('#descripcionnuevaactividadservicio').summernote({
		height: 210,
		focus: true,
		lang: 'es-ES',
		callbacks: {
			onImageUpload: function(files) {
				var reader = new FileReader();
				reader.onload = function(e) {
					var img = $('<img>').attr('src', e.target.result);
					
					// Limita el tamaño a 400px de ancho
					img.css({
						'max-width': '700px',
						'height': 'auto'
					});
					$('#descripcionnuevaactividadservicio').summernote('insertNode', img[0]);
				};
				reader.readAsDataURL(files[0]);
			}
		}
	});

});
document.addEventListener("DOMContentLoaded", function () {

  //Activacion Tooltips
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

	document.getElementById('confirmaguardadoactividad').addEventListener('click', function() {
			guardarnuevaactividad(nuevoestadoservicio);
			var modal = new bootstrap.Modal(document.getElementById('confirmModalsindescripcion'))
			modal.hide(); // Cerrar el modal
	});


})


function guardarnuevaactividad(estadonuevaactividad=null){
	
	const formData=new FormData();
	formData.append("estadonuevaactividad",estadonuevaactividad);
	formData.append("IDServicio",IDServicioDetalle);
	formData.append("DescripcionActividad",descripcionactividadservicio);
	formData.append("EstadoActualServicio",document.getElementById("EstadoActualServicio").value);

	const url_path= document.getElementById("url_path").value
	let ajaxUrl = url_path+'servicios/addnewactivity';

	fetch(ajaxUrl, {
			method: 'POST',
			body: formData
	})
	.then(response => response.text())  // Puedes cambiar a response.json() si esperas un JSON
	.then(data => {
		location.reload();
	})
}

function validadetalleactividad(nuevoestadoservicioparametro){

	descripcionactividadservicio=document.getElementById("descripcionnuevaactividadservicio").value;
	nuevoestadoservicio=nuevoestadoservicioparametro;

	if ((descripcionactividadservicio.length == 0)) {
		if((nuevoestadoservicioparametro == document.getElementById("EstadoActualServicio").value)){
		}else{
		var modalconfirmacionsindescripcion = new bootstrap.Modal(document.getElementById('confirmModalsindescripcion'))
				modalconfirmacionsindescripcion.show();
		}
		
	}else{
				descripcionactividadservicio=$('#descripcionnuevaactividadservicio').summernote('code')
				guardarnuevaactividad(nuevoestadoservicioparametro)
	}
	
}

function listaactividades(IDServicio){

	const url_path= document.getElementById("url_path").value
	let ajaxUrl = url_path+'servicios/listaractividadesajax/?IDServicio='+IDServicio;

	fetch(ajaxUrl, {
			method: 'GET'
	})
		.then(response => response.json())  // Puedes cambiar a response.json() si esperas un JSON
		.then(data => {
			let listadeactividades=document.getElementById("listadeactividades");
			listadeactividades.innerHTML="";
			console.log(data.data);  // Muestra la respuesta del servidor en la consola
			
		})

}

// Ejecutar guardarnuevaactividad con el parámetro guardado tras la confirmación
