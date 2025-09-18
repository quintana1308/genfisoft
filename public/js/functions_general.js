document.addEventListener('DOMContentLoaded', function () { 

    const formContacts = document.querySelector("#formContacts");
    const modalElement = document.getElementById('kt_modal_stacked_11'); 
    const selectElementEditPrefijo = document.querySelector('#prefijoEdit');
    const selectElement = document.querySelector('#prefijo');

    //PREFIJO DEL MODAL EDITAR CONTACTO
        $(selectElementEditPrefijo).select2({
            placeholder: '+P',
            minimumInputLength: 0,
            dropdownParent: $(selectElementEditPrefijo).parent(),
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


        //PREFIJO DEL MODAL CREAR CONTACTO
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
    
    if(modalElement){
        modalElement.addEventListener('shown.bs.modal', function () {
                // Obtener todas las tags disponibles primero
                let reqTags = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                reqTags.open("GET", base_url + '/tags/get-select-tags', true);
                reqTags.send();
                reqTags.onreadystatechange = function () {
                    if (reqTags.readyState == 4 && reqTags.status == 200) {
                        let select = document.querySelector('.listTagsIndividual');
                        select.innerHTML = reqTags.responseText;
                    }
                };
        });
    }


    if(formContacts){
            const formContacts = document.querySelector("#formContacts");
            const fileInput = document.querySelector('#file');
            const loadingPicture = document.getElementById('loadingPicture');
            const picture = document.getElementById('picture');
            const excelIcon = document.getElementById('excelIcon');
            const infoText = document.getElementById('info');
            const divLoading = document.querySelector("#divLoadingCont");
            const modalElement = document.querySelector("#kt_modal_stacked_11");

            // Evento para mostrar información del archivo seleccionado
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                clearFileState();

                if (file) {
                    loadingPicture.style.display = 'block';

                    const reader = new FileReader();
                    reader.onload = function () {
                        loadingPicture.style.display = 'none';

                        if (file.name.endsWith('.xlsx')) {
                            excelIcon.style.display = 'block';
                            infoText.textContent = 'Archivo Excel seleccionado: ' + file.name;
                        } else {
                            Swal.fire("Atención", "Archivo no soportado: " + file.name, "error");
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            formContacts.onsubmit = function (e) {
                e.preventDefault();

                const file = fileInput.files[0];

                if (!file) {
                    Swal.fire("Atención", "Debe seleccionar un archivo para poder cargar los contactos.", "error");
                    return;
                }

                if (!file.name.endsWith('.xlsx')) {
                    Swal.fire("Atención", "El archivo debe ser un archivo Excel (.xlsx).", "error");
                    return;
                }

                divLoading.style.display = "flex";

                const formData = new FormData(formContacts);

                fetch("/contacts/upload", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(objData => {
                    divLoading.style.display = "none";  

                        if (objData.status) {
                            let errors = objData.errors?.join('\n') || '';
                            Swal.fire("Contactos", objData.msg + (errors ? '\n' + errors : ''), "success")
                                .then(() => {
                                    $('#kt_modal_stacked_22').modal("hide");
                                    $('#kt_modal_stacked_11').modal("hide");
                                    formContacts.reset();
                                    clearFileState();
                                });
                        } else {
                            const message = objData.msg || 'Ocurrió un error';
                            const errorHtml = Array.isArray(objData.errors)
                                ? objData.errors.join('<br><br>')
                                : '';

                            Swal.fire({
                                title: "Error",
                                html: message + (errorHtml ? '<br><br>' + errorHtml : ''),
                                icon: "error",
                                confirmButtonText: "Aceptar"
                            });
                        }
                })
                .catch(error => {
                    divLoading.style.display = "none";
                    console.error("Error:", error);
                    Swal.fire("Error", "Hubo un problema en el servidor", "error");
                });
            };

            modalElement.addEventListener('hidden.bs.modal', function () {
                formContacts.reset();
                clearFileState();
                location.reload(); // Opcional: ¿realmente necesitas recargar toda la página?
            });

            // Función auxiliar para limpiar íconos/textos de archivo
            function clearFileState() {
                loadingPicture.style.display = 'none';
                picture.style.display = 'none';
                excelIcon.style.display = 'none';
                infoText.textContent = '';
            }
    }

    if (document.querySelector("#formContactsIndividual")) {
            const formContactsIndividual = document.querySelector("#formContactsIndividual");

            formContactsIndividual.onsubmit = function (e) {
                e.preventDefault();

                const name = document.querySelector('#name').value;
                const phone = document.querySelector('#phoneTel').value;
                const prefijo = document.querySelector('#prefijo').value;
                console.log(phone);
                if (name === '' || phone === '') {
                    Swal.fire("Atención", "Por favor completa todos los campos requeridos para continuar.", "error");
                    return false;
                }

                if (prefijo === '') {
                    Swal.fire("Atención", "Por favor seleccione el Prefijo (P) para continuar.", "error");
                    return false;
                }

                divLoading.style.display = "flex";

                const formData = new FormData(formContactsIndividual);

                fetch(`/contacts/storeContact`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    divLoading.style.display = "none";

                    if (data.status) {
                        let errors = '';
                        if (data.errors) {
                            for (let key in data.errors) {
                                errors += `${key}: ${data.errors[key]}\n`;
                            }
                        }

                        Swal.fire("Contactos", data.msg + '\n' + errors, "success").then(() => {
                            $('#kt_modal_stacked_11').modal("hide");
                            formContactsIndividual.reset();
                            $('#etiquetaComboBoxEnvio').val(null).trigger('change');
                            $('#listTagsIndividual').val(null).trigger('change');
                        });
                    } else {
                        Swal.fire("Error", data.msg + ' ' + (data.errors ?? ''), "error");
                    }
                })
                .catch(error => {
                    divLoading.style.display = "none";
                    console.error('Error:', error);
                    Swal.fire("Error", "Ocurrió un error al enviar el formulario.", "error");
                });
            };
    }

    if (document.querySelector("#formTags")) {
        const formTags = document.querySelector("#formTags");

        formTags.onsubmit = function (e) {
            e.preventDefault();

            const tag = document.querySelector("#tag").value;

            if (tag.trim() === "") {
                Swal.fire("Atención", "El campo etiqueta es requerido", "error");
                return false;
            }

            const elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains("is-invalid")) {
                    Swal.fire("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }

            divLoading.style.display = "flex";

            const formData = new FormData(formTags);

            fetch("/tags/create", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    divLoading.style.display = "none";

                    if (data.status) {
                        Swal.fire("Etiqueta", data.msg, "success").then(() => {
                            $('#modalTags').modal("hide");
                            $('#tableTags').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax
                            formTags.reset();
                        });
                    } else {
                        Swal.fire("Error", data.msg, "error");
                    }
                })
                .catch(error => {
                    divLoading.style.display = "none";
                    Swal.fire("Error", "Hubo un problema en la solicitud", "error");
                    console.error("Error:", error);
                });

            return false;
        };
    }
});

function controlTag(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla == 8) return true; 
	else if (tecla == 0 || tecla == 9) return true;
	patron =/[0-9]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}

document.querySelectorAll("input[type=search]").forEach((node) =>
    node.addEventListener("keypress", (e) => {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    })
);

let formMessagesSideMenu = document.querySelector("#formMessagesSideMenu");

formMessagesSideMenu.onsubmit = function (e) {
    e.preventDefault();

    let phone = document.getElementById("phone1").value;
    let message = document.getElementById("message1").value;

    if (message == "" || phone == "") {
        Swal.fire(
            "Atención",
            "Por favor complete todos los campos requeridos para continuar.",
            "warning"
        );
        return false;
    }

    divLoading.style.display = "flex";
    
    const formData = new FormData();
    formData.append('phone', phone);
    formData.append('message', message);
    // Agregar token CSRF si usas FormData manualmente
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch("/messages/sendSideMenu", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(objData => {
        if (objData.status) {
            Swal.fire({
                title: "Éxito!",
                text: `Mensaje enviado correctamente.`,
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            let errorMessage = `Mensaje no enviado: ${objData.error_count}\n`;
            let errorDetails = objData.error_messages?.[0] || '';
            Swal.fire("Error", errorMessage + errorDetails, "error");
        }
    })
    .catch(error => {
        Swal.fire("Error", "Hubo un problema con la solicitud.", "error");
    })
    .finally(() => {
        divLoading.style.display = "none";
    });
};

if (document.querySelector("#formMsjExcel")) {
    const formMsjExcel = document.querySelector("#formMsjExcel");
    const loadingPictureExcel = document.querySelector('#loadingPictureExcel');
    const pictureExcel = document.querySelector('#pictureExcel');
    const excelIconExcel = document.querySelector('#excelIconExcel');
    const infoTextExcel = document.querySelector('#infoExcel');
    const fileInput = document.querySelector('#fileExcel');
    const divLoadingExcel = document.querySelector('#loadingPictureExcel');

    fileInput.addEventListener('change', function (event) {
        const fileExcel = event.target.files[0];

        if (fileExcel) {
            loadingPictureExcel.style.display = 'block';
            pictureExcel.style.display = 'none';
            excelIconExcel.style.display = 'none';
            infoTextExcel.textContent = '';

            const reader = new FileReader();

            reader.onload = function () {
                loadingPictureExcel.style.display = 'none';

                if (fileExcel.name.endsWith('.xlsx')) {
                    excelIconExcel.style.display = 'block';
                    infoTextExcel.textContent = 'Archivo Excel seleccionado: ' + fileExcel.name;
                } else {
                    Swal.fire("Atención", "Archivo no soportado: " + fileExcel.name, "error");
                    infoTextExcel.textContent = '';
                }
            };

            reader.readAsDataURL(fileExcel);
        } else {
            loadingPictureExcel.style.display = 'none';
            pictureExcel.style.display = 'none';
            excelIconExcel.style.display = 'none';
            infoTextExcel.textContent = '';
        }
    });

    formMsjExcel.onsubmit = function (e) {
        e.preventDefault();

        const fileExcel = fileInput.files[0];

        if (!fileExcel) {
            Swal.fire("Atención", "Debe seleccionar un archivo para poder cargar los contactos.", "error");
            return false;
        }

        if (!fileExcel.name.endsWith('.xlsx')) {
            Swal.fire("Atención", "El archivo debe ser un archivo Excel (.xlsx).", "error");
            return false;
        }

        divLoadingExcel.style.display = "block";
        const request = new XMLHttpRequest();
        const ajaxUrl = base_url + '/messages/setExcelEnvios';
        const formData = new FormData(formMsjExcel);

        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                divLoadingExcel.style.display = "none";
                const objData = JSON.parse(request.responseText);

                if (objData.status) {
                    Swal.fire("Mensajes", 'Los mensajes se estarán enviando en un segundo plano. Recibirá la notificación al ser enviados completamente.<br>', "success").then(() => {
                        $('#modalExcel').modal('hide');
                        formMsjExcel.reset();
                    });
                } else {
                    Swal.fire("Error en el Envío", `Los mensajes no se pudieron enviar de la manera correcta.`, "error");
                  /*  if (!objData.error_count) {
                        let errorMessage = '';
                        objData.errors.forEach(error => {
                            errorMessage += `${error}<br><br>`;
                        });
                        Swal.fire("Error en el Excel", errorMessage, "error");
                    } else {
                        const errorMessages = objData.error_messages?.[0] ?? '';
                        Swal.fire("Error en el Envío", `Mensajes no enviados: ${objData.error_count}<br>${errorMessages}`, "error");
                    }*/
                }
            }
        };
    };
}


function sendMessageDash(messageId) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/messages/' + messageId;
    const modalElementSendMensaje = document.getElementById('kt_modal_stacked_1');
    
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector("#idmessage").value = objData.data.id;
            }
        }
        $('#kt_modal_stacked_1').modal('show');
    };

    modalElementSendMensaje.addEventListener('shown.bs.modal', function () {
            // Obtener todas las tags disponibles primero
            let reqTags = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            reqTags.open("GET", base_url + '/tags/get-select-tags', true);
            reqTags.send();
            reqTags.onreadystatechange = function () {
                if (reqTags.readyState == 4 && reqTags.status == 200) {
                    let select = document.querySelector('.listTags');
                    select.innerHTML = reqTags.responseText;
                }
            };
    });

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

    const formComboBoxEnvio = document.querySelector("#formComboBoxEnvio");
    
    formComboBoxEnvio.onsubmit = function(e) {
        e.preventDefault();

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

        divLoadingExcel.style.display = "flex";
        const ajaxUrl = base_url + '/messages/sendComboBox';
        const formData = new FormData();

        if (allComboBoxEnvioCheckbox) {
            formData.append('idmessage', idmessage);
            formData.append('all', all);
            formData.append('allComboBoxEnvioCheckbox', allComboBoxEnvioCheckbox);
            formData.append('tagline', tagline);
        } else {
            formData.append('idmessage', idmessage);
            formData.append('listTags', listTags);
            formData.append('etiquetaComboBoxEnvioCheckbox', etiquetaComboBoxEnvioCheckbox);
            formData.append('listGrupo', listGrupo);
            formData.append('grupoComboBoxEnvioCheckbox', grupoComboBoxEnvioCheckbox);
            formData.append('phone', phone);
            formData.append('tagline', tagline);
        }

        divLoadingExcel.style.display = "block";

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(objData => {
            divLoadingExcel.style.display = "none";

            if (objData.status) {

                if(objData.msg == 'jobs'){
                    successMessage = `Los mensajes se estaran enviando en un segundo plano. Recibira la notificación al ser enviados completamente. \n\n`;
                }else{
                    successMessage = `Mensaje enviado de manera exitosa. \n\n`;
                }
                Swal.fire({
                    title: "Éxito!",
                    text: successMessage,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.listTags').val(null).trigger('change');
                        $('#grupoComboBox').val(null).trigger('change');
                        formComboBoxEnvio.reset();
                        sectionAllContacts.style.display = "block";
                        sectionTodos.style.display = "block";
                        etiketa.style.display = "none";
                        grup.style.display = "none";
                        $('#kt_modal_stacked_1').modal('hide');
                    }
                });
            } else {
                if(objData.error_count > 0){
                    let successMessage = '';
                    if (objData.success_count > 0 && objData.error_count > 0) {
                        successMessage = `Mensajes enviados correctamente: ${objData.success_count}`;
                    }

                    let errorMessage = `Mensajes no enviados: ${objData.error_count}`;
                    let errorMessages = objData.error_messages?.length ? 'Msj de error: ' + objData.error_messages.join('\n') + '\n' : '';
                    let methodErrors = objData.error_methods?.length ? `Error en el método: ${objData.error_methods.join(', ')}\n` : '';

                    const alertType = (objData.success_count > 0 && objData.error_methods?.length) ? "warning" : "error";

                    Swal.fire({
                        title: alertType === "warning" ? "Advertencia" : "Error",
                        html: `${successMessage}<br>${errorMessage}<br>${errorMessages}<br>${methodErrors}`,
                        icon: alertType
                    });
                }else{
                    Swal.fire({
                        title: "Error",
                        html: objData.error_messages,
                        icon: "error"
                    });
                }
            }
        })
        .catch(error => {
            divLoading.style.display = "none";
            console.error('Error:', error);
            Swal.fire("Error", "Hubo un problema al procesar su solicitud.", "error");
        });

    }
    let modalElement = document.querySelector("#kt_modal_stacked_1");
    modalElement.addEventListener('hidden.bs.modal', function () {
        formComboBoxEnvio.reset();
    });
}