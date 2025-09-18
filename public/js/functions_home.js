let tableContacts;
let divLoading = document.querySelector("#divLoading");
let divLoadingCont = document.querySelector("#divLoadingCont");
let divLoadingMsj = document.querySelector("#divLoadingMsj");
let divLoadingExcel = document.querySelector("#divLoadingExcel");
document.addEventListener('DOMContentLoaded', function(){

    // vista mensaje, enviar msj masivo
    // if (document.querySelector("#formSendMessageMasivo")) {
    //     let formSendMessageMasivo = document.querySelector("#formSendMessageMasivo");
    
    //     formSendMessageMasivo.onsubmit = function(e) {
    //         e.preventDefault();
            
    //         Swal.fire({
    //             title: '¿Estás seguro?',
    //             text: "¡Se enviará el mensaje a todos los contactos!",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#3085d6',
    //             cancelButtonColor: '#d33',
    //             confirmButtonText: 'Sí, enviar',
    //             cancelButtonText: 'Cancelar'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 // Si el usuario confirma, procede con la validación del formulario y el envío
    
    //                 let idmessage = document.querySelector('#idmessage').value;
    //                 let all = document.querySelector('#all').value;
    //                 let tagline = document.getElementById('tagline');
    
    //                 if (tagline.checked) {
    //                     tagline = document.getElementById('tagline').value;
    //                 } else {
    //                     tagline = null;
    //                 }
    
    //                 let elementsValid = document.getElementsByClassName("valid");
    //                 for (let i = 0; i < elementsValid.length; i++) {
    //                     if (elementsValid[i].classList.contains('is-invalid')) {
    //                         Swal.fire("Atención", "Por favor verifique los campos en rojo.", "error");
    //                         return false;
    //                     }
    //                 }
    
    //                 divLoadingMsj.style.display = "flex";
    //                 let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //                 let ajaxUrl = base_url + '/Messages/sendToAllContacts';
    //                 let formData = new FormData();
    //                 formData.append('idmessage', idmessage);
    //                 formData.append('all', all);
    //                 formData.append('tagline', tagline);
    
    //                 request.open("POST", ajaxUrl, true);
    //                 request.send(formData);
    
    //                 request.onreadystatechange = function () {
    //                     if (request.readyState == 4) {
    //                         divLoadingMsj.style.display = "none";
    //                         if (request.status == 200) {
    //                             let objData = JSON.parse(request.responseText);
    //                             if (objData.status) {
    //                                 let successMessage = `Mensajes enviados correctamente: ${objData.success_count}\n`;
    //                                 formSendMessageMasivo.reset();
    
    //                                 Swal.fire({
    //                                     title: "Éxito!",
    //                                     text: successMessage,
    //                                     icon: "success",
    //                                     showCancelButton: false,
    //                                     confirmButtonText: "OK"
    //                                 }).then((result) => {
    //                                     if (result.isConfirmed) {
    //                                         location.reload();
    //                                     }
    //                                 });
    
    //                             } else {
    //                                 let errorMessage = `Mensajes no enviados: ${objData.error_count}\n`;
    //                                 let errorMessages = '';
    
    //                                 if (objData.error_messages && objData.error_messages.length > 0) {
    //                                     const firstErrorMessage = objData.error_messages[0];
    //                                     errorMessages = `${firstErrorMessage}\n`;
    //                                 }
    
    //                                 Swal.fire("Error", errorMessage + ', ' + errorMessages, "error");
    //                             }
    //                         } else {
    //                             Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
    //                         }
    //                     }
    //                 };
    //             }
    //         });
    //     }
    // }
    // fin de enviar msj masivo

    // vista mensaje, enviar msj por etiqueta
    // if(document.querySelector("#formSendMessageEtiqueta")){
    //     let formSendMessageEtiqueta = document.querySelector("#formSendMessageEtiqueta");

    //     formSendMessageEtiqueta.onsubmit = function(e) {
    //         e.preventDefault();

    //         let idmessage = document.querySelector('#idmessage').value;
    //         let listTags = $('.listTags').val();
    //         let tagline = document.getElementById('tagline');

    //         if(tagline.checked){
    //             tagline =  document.getElementById('tagline').value;
    //         }
    //         else{
    //             tagline = null;
    //         }

    //         let elementsValid = document.getElementsByClassName("valid");
    //         for (let i = 0; i < elementsValid.length; i++) {
    //             if(elementsValid[i].classList.contains('is-invalid')) {
    //                 Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
    //                 return false;
    //             }
    //         }
    //         divLoadingMsj.style.display = "flex";
    //         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //         let ajaxUrl = base_url+'/Messages/sendToTaggedContacts';
    //         let formData = new FormData();
    //         formData.append('idmessage', idmessage);
    //         formData.append('listTags[]', listTags);
    //         formData.append('tagline', tagline);

    //         request.open("POST",ajaxUrl,true);
    //         request.send(formData);

    //         request.onreadystatechange = function () {
    //             if (request.readyState == 4) {
    //                 divLoadingMsj.style.display = "none";
    //                 if (request.status == 200) {
    //                     let objData = JSON.parse(request.responseText);
    //                     if (objData.status) {

    //                         let successMessage = `Mensajes enviados correctamente: ${objData.success_count}\n`;
    //                         $('#kt_modal_stacked_4').modal('hide');
    //                         formSendMessageEtiqueta.reset();
                            
    //                         Swal.fire({
    //                             title: "Exito!",
    //                             text: successMessage,
    //                             icon: "success",
    //                             showCancelButton: false,
    //                             confirmButtonText: "OK"
    //                         }).then((result) => {
    //                             if (result.isConfirmed) {
    //                                 location.reload();
    //                             }
    //                         });

    //                     } else {

    //                         let errorMessage = `Mensajes no enviados: ${objData.error_count}\n`;

    //                         let errorMessages = '';
    //                         if (objData.error_messages && objData.error_messages.length > 0) {
    //                             const firstErrorMessage = objData.error_messages[0];
    //                             errorMessages = `${firstErrorMessage}\n`;
    //                         }
    //                         Swal.fire("Error", errorMessage+', '+ errorMessages, "error");
    //                     }
    //                 } else {
    //                     Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
    //                 }
    //             }
    //         };
    //     }
    // }
    // fin de enviar msj por etiqueta

    // vista mensaje, enviar msj rapido
    // if(document.querySelector("#formSendMessageRapido")){
    //     let formSendMessageRapido = document.querySelector("#formSendMessageRapido");

    //     document.querySelectorAll('input[type=search]').forEach( node => node.addEventListener('keypress', e => {
    //         if(e.keyCode == 13) {
    //             e.preventDefault();
    //         }
    //     }))

    //     formSendMessageRapido.onsubmit = function(e) {
    //         e.preventDefault();

    //         let idmessage = document.querySelector('#idmessage').value;
    //         let phone = document.querySelector('#phone').value;
    //         let tagline = document.getElementById('tagline');

    //         if(tagline.checked){
    //             tagline =  document.getElementById('tagline').value;
    //         }
    //         else{
    //             tagline = null;
    //         }

    //         let elementsValid = document.getElementsByClassName("valid");
    //         for (let i = 0; i < elementsValid.length; i++) {
    //             if(elementsValid[i].classList.contains('is-invalid')) {
    //                 Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
    //                 return false;
    //             }
    //         }
    //         divLoadingMsj.style.display = "flex";
    //         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //         let ajaxUrl = base_url+'/Messages/sendToSingleContact';
    //         let formData = new FormData();
    //         formData.append('idmessage', idmessage);
    //         formData.append('phone', phone);
    //         formData.append('tagline', tagline);

    //         request.open("POST",ajaxUrl,true);
    //         request.send(formData);

    //         request.onreadystatechange = function () {
    //             if (request.readyState == 4) {
    //                 divLoadingMsj.style.display = "none";
    //                 if (request.status == 200) {
    //                     let objData = JSON.parse(request.responseText);
    //                     if (objData.status) {

    //                         let successMessage = `Mensajes enviados correctamente: ${objData.success_count}\n`;
    //                         $('#kt_modal_stacked_4').modal('hide');
    //                         formSendMessageRapido.reset();
                            
    //                         Swal.fire({
    //                             title: "Exito!",
    //                             text: successMessage,
    //                             icon: "success",
    //                             showCancelButton: false,
    //                             confirmButtonText: "OK"
    //                         }).then((result) => {
    //                             if (result.isConfirmed) {
    //                                 // location.reload();
    //                             }
    //                         });

    //                     } else {

    //                         let errorMessage = `Mensajes no enviados: ${objData.error_count}\n`;

    //                         let errorMessages = '';
    //                         if (objData.error_messages && objData.error_messages.length > 0) {
    //                             objData.error_messages.forEach(error => {
    //                                 errorMessages += `${error}\n`;  
    //                             });
    //                         }
    //                         Swal.fire("Error", errorMessage + errorMessages, "error");
    //                     }
    //                 } else {
    //                     Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
    //                 }
    //             }
    //         };
    //     }
    //     let modalElement = document.querySelector("#kt_modal_stacked_1");
    //         modalElement.addEventListener('hidden.bs.modal', function () {
    //         formSendMessageRapido.reset();
    //         location.reload();
    //     });
    // }
    // fin de enviar msj rapido

    // cargar mediante excel
    if (document.querySelector("#formContacts")) {
        let formContacts = document.querySelector("#formContacts");
        let loadingPicture = document.querySelector('.loadingPicture');
        let picture = document.querySelector('.picture');
        let excelIcon = document.querySelector('.excelIcon');
        let infoText = document.querySelector('.info');

        // Evento para mostrar el archivo seleccionado
            document.querySelector('.file').addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    loadingPicture.style.display = 'block';
                    picture.style.display = 'none';
                    excelIcon.style.display = 'none';
                    infoText.textContent = '';

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        loadingPicture.style.display = 'none';

                        if (file.name.endsWith('.xlsx')) {
                            excelIcon.style.display = 'block';
                            infoText.textContent = 'Archivo Excel seleccionado: ' + file.name;
                        } else {
                            Swal.fire("Atención", "Archivo no soportado: " + file.name, "error");
                            infoText.textContent = '';
                        }
                    };

                    reader.readAsDataURL(file);
                } else {
                    loadingPicture.style.display = 'none';
                    picture.style.display = 'none';
                    excelIcon.style.display = 'none';
                    infoText.textContent = '';
                }
            });

            formContacts.onsubmit = function(e) {
                e.preventDefault();
                
                let fileInput = document.querySelector('.file');
                let file = fileInput.files[0];
            
                if (!file) {
                    Swal.fire("Atención", "Debe seleccionar un archivo para poder cargar los contactos.", "error");
                    return false;
                }
            
                if (!file.name.endsWith('.xlsx')) {
                    Swal.fire("Atención", "El archivo debe ser un archivo Excel (.xlsx).", "error");
                    return false;
                }
            
                divLoadingCont.style.display = "flex";
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Contacts/setContacts'; 
                let formData = new FormData(formContacts);
            
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        divLoadingCont.style.display = "none";
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            let errors = '';
                            for (let key in objData.errors) {
                                if (objData.errors.hasOwnProperty(key)) {
                                    errors += key + ': ' + objData.errors[key] + '\n';
                                }
                            }
                            Swal.fire("Contactos", objData.msg + ' \n ' + errors, "success").then(() => {
                                $('#kt_modal_stacked_22').modal("hide");
                                formContacts.reset();
                                $('.info').text('');
                                $('.excelIcon').hide();
                            });
                            
                        } else {
                            Swal.fire("Error", objData.msg + ' ' + objData.errors, "error");
                        }
                    }
                    return false;
                }
            }
        let modalElement = document.querySelector("#kt_modal_stacked_11");
        modalElement.addEventListener('hidden.bs.modal', function () {
            formContacts.reset();
            location.reload();
        });
    }
    // fin de cargar mediante excel

    // cargar manualmente vista contacto
    if(document.querySelector("#formContactsIndividual")){
        let formContactsIndividual = document.querySelector("#formContactsIndividual");
        formContactsIndividual.onsubmit = function(e) {
            e.preventDefault();

            let name = document.querySelector('#name').value;
            let phone = document.querySelector('.phone').value;
            let prefijo = document.querySelector('#prefijo').value;
            let listTagsIndividual = document.querySelector('#listTagsIndividual').value;
            console.log(listTagsIndividual);

            
            if( name == '' || phone == '')
            {
                Swal.fire("Atención", "Por favor completa todos los campos requeridos para continuareeeeeee." , "error");
                return false;
            }
            if( prefijo == '')
                {
                    Swal.fire("Atención", "Por favor seleccione el Prefijo (P) para continuar." , "error");
                    return false;
                }

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Contacts/setContactsIndividual'; 
            let formData = new FormData(formContactsIndividual);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){

                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        let errors = '';
                        for (let key in objData.errors) {
                            if (objData.errors.hasOwnProperty(key)) {
                                errors += key + ': ' + objData.errors[key] + '\n';
                            }
                        }

                        Swal.fire("Contactos", objData.msg + ' \n ' + errors, "success").then(() => {
                            // location.reload();
                            formContactsIndividual.reset();
                            $('#prefijo').val(null).trigger('change');
                            $('#listTagsIndividual').val(null).trigger('change');
                            // tableContacts.api().ajax.reload();
                        });
                    }else{

                        Swal.fire("Error", objData.msg +' '+objData.errors, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }

        let modalElement = document.querySelector("#kt_modal_stacked_11");
        modalElement.addEventListener('hidden.bs.modal', function () {
            formContactsIndividual.reset();
            location.reload();
        });
    }
    // fin de cargar manualmente

    // crear etiqueta vista tag
    if(document.querySelector("#formTags")){
        let formTags = document.querySelector("#formTags");
        formTags.onsubmit = function(e) {
            e.preventDefault();
            let tag = document.querySelector('#tag').value;
            
            if( tag == '')
            {
                Swal.fire("Atención", "El campo etiqueta es requerido" , "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tags/setTags'; 
            let formData = new FormData(formTags);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        Swal.fire("Etiqueta", objData.msg ,"success").then(() => {
                            location.reload();
                            tableTags.api().ajax.reload();
                            formTags.reset();
                        });
                        $('#modalTags').modal("hide");
                        
                    }else{
                        Swal.fire("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    // fin de crear etiqueta vista tag

    // enviar mensaje a los grupos
    // if(document.querySelector("#formSendMessageGrupos")){
    //     let formSendMessageGrupos = document.querySelector("#formSendMessageGrupos");

    //     formSendMessageGrupos.onsubmit = function(e) {
    //         e.preventDefault();

    //         const idmessage = document.querySelector('#idmessage').value;
    //         const listGrupo = Array.from(document.querySelector('#grupo').selectedOptions).map(option => option.value);
    //         const tagline = document.getElementById('tagline');

    //         if(listGrupo == '' )
    //             {
    //                 Swal.fire("Atención", "Debe Seleccionar un grupo para poder enviar en msj." , "error");
    //                 return false;
    //             }

    //         const taglineValue = tagline.checked ? tagline.value : null;
            
    //         divLoadingMsj.style.display = "flex";
    //         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //         let ajaxUrl = base_url+'/Messages/sendToGroups';
    //         let formData = new FormData();
    //         formData.append('idmessage', idmessage);
    //         formData.append('listGrupo', listGrupo);
    //         formData.append('tagline', taglineValue);

    //         request.open("POST",ajaxUrl,true);
    //         request.send(formData);

    //         request.onreadystatechange = function () {
    //             if (request.readyState == 4) {
    //                 divLoadingMsj.style.display = "none";
    //                 if (request.status == 200) {
    //                     let objData = JSON.parse(request.responseText);
    //                     if (objData.status) {

    //                         let successMessage = `Mensajes enviados correctamente: ${objData.success_count}\n`;
    //                         $('#kt_modal_stacked_5').modal('hide');
    //                         formSendMessageGrupos.reset();

    //                         Swal.fire({
    //                             title: "Exito!",
    //                             text: successMessage,
    //                             icon: "success",
    //                             showCancelButton: false,
    //                             confirmButtonText: "OK"
    //                         }).then((result) => {
    //                             if (result.isConfirmed) {
    //                                 location.reload();
    //                             }
    //                         });

    //                     } else {

    //                         let errorMessage = `Mensajes no enviados: ${objData.error_count}\n`;

    //                         let errorMessages = '';
    //                         if (objData.error_messages && objData.error_messages.length > 0) {
    //                             const firstErrorMessage = objData.error_messages[0];
    //                             errorMessages = `${firstErrorMessage}\n`;
    //                         }
    //                         Swal.fire("Error", errorMessage+', '+ errorMessages, "error");
    //                     }
    //                 } else {
    //                     Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
    //                 }
    //             }
    //         };
    //     }
    // }
    // fin de enviar mensaje a los grupos

    // todos los metodos de envio
    if (document.querySelector("#formComboBoxEnvio")) {
        let formComboBoxEnvio = document.querySelector("#formComboBoxEnvio");
        let divLoading = document.querySelector('#divLoading');

        // Obtener todos los checkboxes
        let allComboBoxEnvioCheckbox = document.querySelector("#allComboBoxEnvio");
        let etiquetaComboBoxEnvioCheckbox = document.querySelector("#etiquetaComboBoxEnvio");
        let grupoComboBoxEnvioCheckbox = document.querySelector("#GrupoComboBoxEnvio");

        // Secciones a mostrar/ocultar
        let sectionAllContacts = document.querySelector("#sectionAllContacts");
        let sectionTodos = document.querySelector("#ocultar");
        let etiketa = document.querySelector("#etiketa");
        let grup = document.querySelector("#grup");


        // Función para mostrar/ocultar secciones
        function updateVisibility() {
            if (allComboBoxEnvioCheckbox.checked) {
                sectionTodos.style.display = "none";
                sectionAllContacts.style.display = "block";

            } else if (etiquetaComboBoxEnvioCheckbox.checked) {
                sectionAllContacts.style.display = "none";
                sectionTodos.style.display = "block";
                etiketa.style.display = "block";
                grup.style.display = "none";

                if (grupoComboBoxEnvioCheckbox.checked) {
                    grup.style.display = "block";
                }

            } else if (grupoComboBoxEnvioCheckbox.checked) {
                sectionAllContacts.style.display = "none";
                sectionTodos.style.display = "block";
                etiketa.style.display = "none";
                grup.style.display = "block";

                if (etiquetaComboBoxEnvioCheckbox.checked) {
                    etiketa.style.display = "block";
                }

            } else {
                sectionAllContacts.style.display = "block";
                sectionTodos.style.display = "block";
                etiketa.style.display = "none";
                grup.style.display = "none";
            }
        }

        // Añadir el manejador de eventos para los checkboxes
        allComboBoxEnvioCheckbox.addEventListener('change', updateVisibility);
        etiquetaComboBoxEnvioCheckbox.addEventListener('change', updateVisibility);
        grupoComboBoxEnvioCheckbox.addEventListener('change', updateVisibility);

        // Inicializar la visibilidad al cargar la página
        updateVisibility();

        formComboBoxEnvio.onsubmit = function(e) {
            e.preventDefault();

            if(!estado_vinculado)
            {
                Swal.fire("Atención", "Teléfono desvinculado, ¡Por favor vincule!" , "error");
                return false;
            }

            // variables para enviar a todos
            let idmessage = document.querySelector('#idmessage').value;
            let all = document.querySelector('#all').value;
            let allComboBoxEnvioCheckbox = document.getElementById('allComboBoxEnvio').checked;
            // variables para enviar por etiquetas
            let listTags = $('.listTags').val();
            let etiquetaComboBoxEnvioCheckbox = document.getElementById('etiquetaComboBoxEnvio').checked;
            // variables para enviar a grupos
            const listGrupo = Array.from(document.querySelector('#grupoComboBox').selectedOptions).map(option => option.value);
            let grupoComboBoxEnvioCheckbox = document.getElementById('GrupoComboBoxEnvio').checked;
            // variables para envio rapido
            let phone = document.querySelector('#phone').value;
            // variable para la id aleatoria al final del msj
            let tagline = document.getElementById('tagline').checked;

            if (!etiquetaComboBoxEnvioCheckbox && !grupoComboBoxEnvioCheckbox && !allComboBoxEnvioCheckbox) {
                if(phone == '' )
                    {
                        Swal.fire("Atención", "Debe Seleccionar un telefono para poder enviar un msj." , "error");
                        return false;
                    }
            }
            if (grupoComboBoxEnvioCheckbox) {
                if(listGrupo == '' )
                    {
                        Swal.fire("Atención", "Debe Seleccionar un grupo para poder enviar un msj." , "error");
                        return false;
                    }
            }
            if (etiquetaComboBoxEnvioCheckbox) {
                if(listTags == '' )
                    {
                        Swal.fire("Atención", "Debe Seleccionar una etiqueta para poder enviar un msj." , "error");
                        return false;
                    }
            }    

            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Messages/comboBox';
            let formData = new FormData();
            if (allComboBoxEnvioCheckbox) {
                formData.append('idmessage', idmessage);
                formData.append('all', all);
                formData.append('allComboBoxEnvioCheckbox', allComboBoxEnvioCheckbox);
                formData.append('tagline', tagline);
            }else{
                formData.append('idmessage', idmessage);
                formData.append('listTags', listTags);
                formData.append('etiquetaComboBoxEnvioCheckbox', etiquetaComboBoxEnvioCheckbox);
                formData.append('listGrupo', listGrupo);
                formData.append('grupoComboBoxEnvioCheckbox', grupoComboBoxEnvioCheckbox);
                formData.append('phone', phone);
                formData.append('tagline', tagline);
            }

            request.open("POST", ajaxUrl, true);
            request.send(formData);

            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    divLoading.style.display = "none";
                    if (request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            let successMessage = `Mensajes enviados correctamente: ${objData.success_count}\n\n`;
                            
                            Swal.fire({
                                title: "Éxito!",
                                text: successMessage,
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // location.reload();
                                    $('.listTags').val(null).trigger('change');
                                    $('#grupoComboBox').val(null).trigger('change');
                                    formComboBoxEnvio.reset();
                                    sectionAllContacts.style.display = "block";
                                    sectionTodos.style.display = "block";
                                    etiketa.style.display = "none";
                                    grup.style.display = "none";
                                }
                            });

                        } else {
                            let successMessage = '';
                            if (objData.success_count > 0 && objData.error_count > 0) {
                                successMessage = `Mensajes enviados correctamente: ${objData.success_count}`;
                            }
                            let errorMessage = `Mensajes no enviados: ${objData.error_count}`;
                            let errorMessages = '';

                            if (objData.error_messages && objData.error_messages.length > 0) {
                                errorMessages = 'Msj de error: '+objData.error_messages.join('\n') + '\n';
                            }
                            
                            let methodErrors = '';
                            if (objData.error_methods && objData.error_methods.length > 0) {
                                methodErrors = `Error en el metodo: ${objData.error_methods.join(', ')}\n`;
                            }

                            if (objData.success_count > 0 && objData.error_count > 0 && objData.error_methods && objData.error_methods.length > 0) {
                                Swal.fire({
                                    title: "Advertencia",
                                    html: `${successMessage}<br>${errorMessage}<br>${errorMessages}<br>${methodErrors}`,
                                    icon: "warning"
                                });
                            }else{
                                Swal.fire({
                                    title: "Error",
                                    html: `${successMessage}<br>${errorMessage}<br>${errorMessages}<br>${methodErrors}`,
                                    icon: "error"
                                });
                            }
                        }

                    } else {
                        Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
                    }
                }
            };
        }
        let modalElement = document.querySelector("#kt_modal_stacked_1");
        modalElement.addEventListener('hidden.bs.modal', function () {
            formComboBoxEnvio.reset();
            location.reload();
        });
    }
    // fin de todos los metodos de envio

    initializeSelect2Individual();

}, false);

// funciones de la vista mensaje
window.addEventListener('load', function() {
    fntTagsContact();
    fntTagsContactIndividual();
}, false);

function fntTagsContact() {
    if (document.querySelector('.listTags')) {
        let ajaxUrl = base_url + '/Tags/getSelectTags';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('.listTags').innerHTML = request.responseText;
                $('.listTags').trigger('change');
            }
        }
    }
}

// para agregar las etiquetas en guardar contacto individual
function fntTagsContactIndividual(){
    if(document.querySelector('#listTagsIndividual')){
        let ajaxUrl = base_url+'/Tags/getSelectTags';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listTagsIndividual').innerHTML = request.responseText;
                $('#listTagsIndividual').trigger('change');
            }
        }
    }
}

function sendMessage(message){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Messages/getMessage/'+message;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {

                document.querySelector("#idmessage").value = objData.data.ID;
                // console.log(objData.data.ID);
                $('#listTags').selectpicker('render');
            }
        }
        $('#kt_modal_stacked_1').modal('show');
    }
}

// modal dentro de otro modal
var elements = Array.prototype.slice.call(document.querySelectorAll("[data-bs-stacked-modal]"));

    if (elements && elements.length > 0) {
        elements.forEach((element) => {
            if (element.getAttribute("data-kt-initialized") === "1") {
                return;
            }

            element.setAttribute("data-kt-initialized", "1");

            element.addEventListener("click", function(e) {
                e.preventDefault();

                const modalEl = document.querySelector(this.getAttribute("data-bs-stacked-modal"));

                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        });
    }
// fin de las funciones de la vista mensaje

// funcion para mostrar el texto en Añadir Identificador Único
function toggleDetails(event) {
    event.preventDefault(); // Evita que el enlace haga scroll o navegue
    
    const details = document.querySelector('.form-check-details');
    const isVisible = details.style.display === 'block';
    
    details.style.display = isVisible ? 'none' : 'block';
    event.target.textContent = isVisible ? 'Ver más' : 'Ver menos';
    }
//fin de la funcion para mostrar el texto en Añadir Identificador Único

function initializeSelect2Individual() {

    const selectElement = document.querySelector('#prefijo');

    $(selectElement).select2({
        placeholder: '+P',
        minimumInputLength: 0,
        dropdownParent: $(selectElement).parent(),
        dropdownCssClass: 'custom-dropdown',
        templateResult: function(option) {
            if (!option.id) {
                return option.text;
            }

            // Añadir imagen de la bandera
            let flag = $(option.element).data('flag');
            let text = $('<span>' + option.text + '</span>');

            if (flag) {
                let img = $('<img>', {
                    src: flag,
                    class: 'flag',
                    style: 'width: 20px; height: 15px; margin-right: 5px; vertical-align: middle;'
                });
                return $('<span>').append(img).append(text);
            }

            return text;
        },
        templateSelection: function(option) {
            if (!option.id) {
                return option.text;
            }

            let flag = $(option.element).data('flag');
            let text = $('<span>' + option.text + '</span>');
            let prefijo = $(option.element).data('prefijo');

            if (flag) {
                let img = $('<img>', {
                    src: flag,
                    class: 'flag',
                    style: 'width: 20px; height: 15px; margin-right: 5px; vertical-align: middle;'
                });
                return $('<span>').append(img).append(prefijo);
            }

            return text.append(prefijo);
        }
    });
}