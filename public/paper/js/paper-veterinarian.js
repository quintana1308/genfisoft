veterinarian = {
    index: function() {
        const tableVeterinarian = $('#tableVeterinarian').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            lengthChange: false,
            scrollX: false,
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Buscar:",
                loadingRecords: "Cargando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: ">",
                    previous: "<"
                },
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"
            },
            ajax: {
                url: "/veterinarian/data", // Laravel route
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "cattle", name: "cattle" },
                { data: "product", name: "product" },
                { data: "symptoms", name: "symptoms" },
                { data: "date_start", name: "date_start" },
                { data: "date_end", name: "date_end" },
                { data: "status", name: "status" },
                { data: "options", name: "options", orderable: false, searchable: false }
            ],
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "<i class='fa fa-copy'></i> Copiar",
                    titleAttr: "Copiar",
                    className: "btn btn-secondary"
                },
                {
                    extend: "excelHtml5",
                    text: "<i class='fa fa-file-excel-o'></i> Excel",
                    titleAttr: "Exportar a Excel",
                    className: "btn btn-success"
                },
                {
                    extend: "pdfHtml5",
                    text: "<i class='fa fa-file-pdf-o'></i> PDF",
                    titleAttr: "Exportar a PDF",
                    className: "btn btn-danger"
                },
            ],
            responsive: true,
            destroy: true,
            pageLength: 10,
            order: [[0, "asc"]]
        });
    },

    create: function() {

        if (document.querySelector("#formVeterinarianNew")) {
            const formVeterinarianNew = document.querySelector("#formVeterinarianNew");

            formVeterinarianNew.onsubmit = function (e) {
                e.preventDefault();

                const cattle = document.querySelector("#cattleForm").value;
                const product = document.querySelector("#product").value;
                const dateStart = document.querySelector("#dateStart").value;
                const dateEnd = document.querySelector("#dateEnd").value;

                const campos = [
                    { campo: cattle, nombre: "'Animal'" },
                    { campo: product, nombre: "'Producto'" },
                    { campo: dateStart, nombre: "'Fecha de ingreso'" },
                    { campo: dateEnd, nombre: "'Fecha de salida'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                const formData = new FormData(formVeterinarianNew);

                fetch('/veterinarian/create', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status) {
                            Swal.fire("Animal", data.msg, "success").then(() => {
                                formVeterinarianNew.reset();
                                window.location.href = "/veterinarian";
                            });
                        } else {
                            Swal.fire("Error", data.msg, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Error", "Hubo un problema en la solicitud", "error");
                        console.error("Error:", error);
                    });

                return false;
            };
        }
    },

    edit: function() {
        if (document.querySelector("#formVeterinarianEdit")) {
            const formVeterinarianEdit = document.querySelector("#formVeterinarianEdit");

            formVeterinarianEdit.onsubmit = function (e) {
                e.preventDefault();

                const campos = [
                    { id: "#cattleEdit", nombre: "Animal" },
                    { id: "#productEdit", nombre: "Producto" },
                    { id: "#statusEdit", nombre: "Estado" },
                    { id: "#dateStartEdit", nombre: "Fecha de ingreso" },
                    { id: "#dateEndEdit", nombre: "Fecha de salida" }
                ];

                for (let campo of campos) {
                    const valor = document.querySelector(campo.id).value.trim();
                    if (valor === "") {
                        Swal.fire("Atención", `El campo ${campo.nombre} es requerido`, "error");
                        return false;
                    }
                }

                const formData = new FormData(formVeterinarianEdit);

                fetch('/veterinarian/update', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status) {
                            Swal.fire("Animal", data.msg, "success").then(() => {
                                $('#tableVeterinarian').DataTable().ajax.reload();
                                formVeterinarianEdit.reset();
                                $('#modalVeterinarianEdit').modal('hide');
                            });
                        } else {
                            Swal.fire("Error", data.msg, "error");
                        }
                    })
                    .catch(error => {
                        Swal.fire("Error", "Hubo un problema en la solicitud", "error");
                        console.error("Error:", error);
                    });

                return false;
            };
        }
    },
}

function viewVeterinarian($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/veterinarian/getVeterinarianView/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                document.querySelector('#cattleView').innerHTML = objData.veterinarian.cattle.code;
                document.querySelector('#productView').innerHTML = objData.veterinarian.product.name;
                document.querySelector('#symptomsView').innerHTML = objData.veterinarian.symptoms;
                document.querySelector('#dateStartView').innerHTML = objData.veterinarian.date_start;
                document.querySelector('#dateEndView').innerHTML = objData.veterinarian.date_end;
                document.querySelector('#statusView').innerHTML = objData.veterinarian.status.name;
                document.querySelector('#observationView').innerHTML = objData.veterinarian.observation;
            }
            $('#modalVeterinarianView').modal('show');
        }
    }
}

function editVeterinarian($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/veterinarian/getVeterinarian/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                document.querySelector('#idEdit').value = objData.data.id;
                fillSelectCattle('#cattleEdit', objData.cattles, objData.data.cattle);
                fillSelect('#productEdit', objData.products, objData.data.product);
                fillSelect('#statusEdit', objData.statuses, objData.data.id);
                document.querySelector('#symptomsEdit').value = objData.data.symptoms;
                document.querySelector('#dateStartEdit').value = objData.data.date_start;
                document.querySelector('#dateEndEdit').value = objData.data.date_end;
                document.querySelector('#observationEdit').value = objData.data.observation;

            }
            $('#modalVeterinarianEdit').modal('show');
        }
    }
}

function fillSelect(selectId, items, selectedValue) {
    const select = document.querySelector(selectId);
    select.innerHTML = '<option value="">-- Seleccione --</option>';
    items.forEach(item => {
        let option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.name;
        select.appendChild(option);
    });
    select.value = selectedValue;
}

function fillSelectCattle(selectId, items, selectedValue) {
    const select = document.querySelector(selectId);
    select.innerHTML = '<option value="">-- Seleccione --</option>';
    items.forEach(item => {
        let option = document.createElement('option');
        option.value = item.id;
        option.textContent = item.code;
        select.appendChild(option);
    });
    select.value = selectedValue;
}