

    document.addEventListener("DOMContentLoaded", function(event) {

        var divLoading = document.querySelector("#divLoading");
        var btn_newTenant=document.getElementById("btn_newtenant")
        var checkstatustenan=document.getElementById("newtenant_status")
        let form_newtenant = document.querySelector("#form_newtenant");

        //se activa function de limpiar input al abrir el canvas NewTenant
        const myOffcanvas = document.getElementById('newtenant')

        myOffcanvas.addEventListener('show.bs.offcanvas', event => {
            empty_input_newtenant()
        })

        btn_newTenant.addEventListener("click",function(){
            prepareform_new_tenant();
        });

        checkstatustenan.addEventListener('change', function() {
            change_newtenant_status(this.checked,"text_newtenant_status")
        });

        form_newtenant.onsubmit = function(e) {
            e.preventDefault();
            let newtenant_nombre = document.querySelector('#newtenant_nombre').value
            let newtenant_ciudad = document.getElementById('newtenant_ciudad').value
            let newtenant_tipodoc=document.getElementById("newtenant_tipodoc").value
            let newtenant_doc=document.getElementById("newtenant_doc").value

            //Valida que info no esta vacia
            if( newtenant_nombre == '' || newtenant_ciudad == '' || newtenant_doc=='' || newtenant_tipodoc == 0){
            
                let type_alert="danger"
                let title_alert="Error"
                let text_alert="Todos los campos son obligatorios, valide nuevamente el fomulario.";
                
                show_msn_alert(type_alert,title_alert,text_alert)
                return false;
            }

            divLoading.style.display = "flex";

            //Construye objeto request para ebviar por ajax. para guardar nuevo Tenant
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = 'tenant/newtenant'; 
            let formData = new FormData(form_newtenant);

            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    reset_alert()

                    if(objData.status){ // Se creo correctamente la organizacion
                        var time_alert=(objData.type==="danger")?4500:2500;
                        // Construccion de mensaje de alerta
                        list_tenant();
                        setTimeout(function(){
                            close_canvas("close_offcanvas")
                            empty_input_newtenant()
                        }, time_alert);
                    }
                    show_msn_alert(objData.type,objData.title,objData.msg)
                }
                divLoading.style.display = "none";
                return false;
            }
        }

        list_tenant()

    });

    /************ Functions Tenan */

    function list_tenant(){
        
        const url_path= document.getElementById("url_path").value
        let ajaxUrl = url_path+'tenant/list_tenant'; 

        $("#Table_list_Tenant").DataTable({
            ajax: function (d, cb) {
                fetch(ajaxUrl)
                    .then(response => response.json())
                    .then(data => cb(data));
            },
            "destroy": true,
            "processing": true,
            "scrollResize": true,
            "autoWidth": true,
            "responsive": true,
            "columns": [
                {"data": "IDTenant",
                    "width": "10%",
                    "className": "text-center"
                },
                {"data": "NombreTenant",
                    "width": "30%",
                },
                {"data": "AliasTenant",
                    "width":"20%",
                },
                {"data": "EstadoActualTenant",
                    "width":"10%",
                    "className":"text-center",
                    "render": function(data){
                                return (data)?'<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>':'<span style="color:red;">Inactivo</span>';
                            }
                },
                {"data": "IDTenant",
                    "className":"text-center",
                    "width":"20%",
                    "render":function(data) {
                        return `
                        <div class="d-grid gap-2 d-md-block">
                            <button type="button" class="btn btn-outline-dark btn-sm" onclick="editar_tenant(`+data+`);"> <i class="bi bi-pencil"></i> Editar</button>
                        </div>
                        `;
                    }
                },
            ],
            "order": [
                [0, 'asc']
            ],
            "language": {
                "url": "/generandocodigo/App-Promtos-SF/app/assets/DataTables/es-CO.json"
            }
        });

        var table = $("#Table_list_Tenant").DataTable();
        new $.fn.dataTable.Buttons( table, {
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    }
    
    function editar_tenant(IdTenant_find){
         
        divLoading.style.display = "flex";
        let request2 = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = url_path.value+'tenant/list_tenant'; 
        
        let formData = new FormData();
        formData.append('IDTenant',IdTenant_find);
        request2.open("POST",ajaxUrl,true);
        request2.send(formData);

        request2.onreadystatechange = function(){

            if(request2.readyState == 4 && request2.status == 200){

                var btn_new_tenant=document.getElementById("btn_newtenant");
                btn_new_tenant.click();

                document.getElementById("titulo_offcanvas_tenant").innerHTML="Editar Organización: "+IdTenant_find;
                let objData = JSON.parse(request2.responseText);
                
                if(objData.status){

                    document.getElementById("newtenant_token").value=1
                    document.getElementById("newtenant_nombre").value=objData.data[0].NombreTenant
                    document.getElementById("newtenant_alias").value=objData.data[0].AliasTenant
                    document.getElementById("newtenant_ciudad").value=objData.data[0].CiudadTenant
                    
                    if(objData.data[0].EstadoActualTenant){
                        document.getElementById("newtenant_status").checked=true
                    }else{
                        document.getElementById("newtenant_status").checked = false
                    }
                    
                    change_newtenant_status(objData.data[0].EstadoActualTenant,"text_newtenant_status")

                    document.getElementById("newtenant_tipodoc").setAttribute("style","cursor: not-allowed;")
                    document.getElementById("newtenant_tipodoc").value=objData.data[0].TipodocTenant
                    document.getElementById("newtenant_doc").value=objData.data[0].NumdocTenant
                    document.getElementById("newtenant_doc").setAttribute("style","cursor: not-allowed;")
                    document.getElementById("newtenant_doc").setAttribute("readonly",true)

                }else{
                    show_msn_alert(objData.type,objData.title,objData.msg)
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }

    function prepareform_new_tenant(){
        document.getElementById("titulo_offcanvas_tenant").innerHTML="Crear Nueva Organización";
        empty_input_newtenant()
    }
    //Limpiar input NewTenant
    function empty_input_newtenant(){
        document.getElementById('newtenant_nombre').value = "";
        document.getElementById('newtenant_alias').value = "";
        document.getElementById('newtenant_ciudad').value = "";
        

        // input tipo de documento
        var sel_tipodocumento_tenant = document.getElementById("newtenant_tipodoc"); 
        for (var i = 0; i < sel_tipodocumento_tenant.length; i++) {
            sel_tipodocumento_tenant[i].removeAttribute("disabled")
        }
        document.getElementById("newtenant_tipodoc").removeAttribute("style","cursor: not-allowed;")
        document.getElementById('newtenant_tipodoc').value = 0;


        //vacia input token
        document.getElementById('newtenant_token').value = 0;

        //checked estado tenant le pone activo
        document.getElementById("newtenant_status").checked = true;
        change_newtenant_status(1,"text_newtenant_status")

        //vacia input documento
        document.getElementById('newtenant_doc').value = "";
        document.getElementById("newtenant_doc").removeAttribute("style","cursor: not-allowed;")
        document.getElementById("newtenant_doc").removeAttribute("readonly")

    }









