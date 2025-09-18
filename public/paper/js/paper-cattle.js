cattle = {
    index: function() {
        const tableCattle = $('#tableCattle').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            lengthChange: false,
            scrollX: true,
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
                url: "/cattle/data", // Laravel route
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "code", name: "code" },
                { data: "herd", name: "herd" },
                { data: "category", name: "category" },
                { data: "classification", name: "classification" },
                { data: "date_start", name: "date_start" },
                { data: "causeEntry", name: "causeEntry" },
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
            
        const sexo = document.getElementById('sexo');
        const statusReproductive = document.getElementById('statusReproductive');
        const statusProductive = document.getElementById('statusProductive');

        if (!sexo || !statusReproductive || !statusProductive) return;

        const containerReproductive = statusReproductive.closest('.col-md-4');
        const containerProductive = statusProductive.closest('.col-md-4');

        const toggleReproductiveFields = () => {
            const selectedSexo = sexo.value;

            if (selectedSexo === 'Hembra') {
                containerReproductive.style.display = '';
                containerProductive.style.display = '';
            } else if (selectedSexo === 'Macho') {
                statusReproductive.value = '';
                statusProductive.value = '';
                containerReproductive.style.display = 'none';
                containerProductive.style.display = 'none';
            } else {
                containerReproductive.style.display = '';
                containerProductive.style.display = '';
            }
        };

        // Ejecutar al abrir el modal
        toggleReproductiveFields();

        // Al cambiar el sexo
        sexo.addEventListener('change', toggleReproductiveFields);


        if (document.querySelector("#formCattleNew")) {
            const formCattleNew = document.querySelector("#formCattleNew");

            formCattleNew.onsubmit = function (e) {
                e.preventDefault();

                const code = document.querySelector("#code").value;
                const category = document.querySelector("#category").value;
                const status = document.querySelector("#status").value;
                const herd = document.querySelector("#herd").value;
                const date_start = document.querySelector("#dateStart").value;
                const causeEntry = document.querySelector("#causeEntry").value;
                const dateRevision = document.querySelector("#dateRevision").value;
                const color = document.querySelector("#color").value;
                const classification = document.querySelector("#classification").value;
                const sexo = document.querySelector("#sexo").value;
                const incomeWeight = document.querySelector("#incomeWeight").value;
                const pricePurchase = document.querySelector("#pricePurchase").value;
                const priceFarm = document.querySelector("#priceFarm").value;

                const campos = [
                    { campo: code, nombre: "'Código'" },
                    { campo: category, nombre: "'Categoría'" },
                    { campo: status, nombre: "'Estado'" },
                    { campo: herd, nombre: "'Rebaño'" },
                    { campo: date_start, nombre: "'Fecha de entrada'" },
                    { campo: causeEntry, nombre: "'Causa de entrada'" },
                    { campo: dateRevision, nombre: "'Proxima revisión'" },
                    { campo: color, nombre: "'Color'" },
                    { campo: classification, nombre: "'Clasificación'" },
                    { campo: sexo, nombre: "'Sexo'" },
                    { campo: incomeWeight, nombre: "'Peso de ingreso'" },
                    { campo: pricePurchase, nombre: "'Precio de compra'" },
                    { campo: priceFarm, nombre: "'Precio en finca'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                const formData = new FormData(formCattleNew);

                fetch('/cattle/create', {
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
                                formCattleNew.reset();
                                window.location.href = "/cattle";
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
        if (document.querySelector("#formCattleEdit")) {
            const formCattleEdit = document.querySelector("#formCattleEdit");

            formCattleEdit.onsubmit = function (e) {
                e.preventDefault();

                const campos = [
                    { id: "#codeEdit", nombre: "Código" },
                    { id: "#categoryEdit", nombre: "Categoría" },
                    { id: "#statusEdit", nombre: "Estado" },
                    { id: "#herdEdit", nombre: "Rebaño" },
                    { id: "#dateStartEdit", nombre: "Fecha de entrada" },
                    { id: "#causeEntryEdit", nombre: "Causa de entrada" },
                    { id: "#dateRevisionEdit", nombre: "Proxima revisión" },
                    { id: "#colorEdit", nombre: "Color" },
                    { id: "#classificationEdit", nombre: "Clasificación" },
                    { id: "#sexoEdit", nombre: "Sexo" },
                ];

                for (let campo of campos) {
                    const valor = document.querySelector(campo.id).value.trim();
                    if (valor === "") {
                        Swal.fire("Atención", `El campo ${campo.nombre} es requerido`, "error");
                        return false;
                    }
                }

                const formData = new FormData(formCattleEdit);

                fetch('/cattle/update', {
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
                                $('#tableCattle').DataTable().ajax.reload();
                                formCattleEdit.reset();
                                $('#modalCattleEdit').modal('hide');
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

        $(document).ready(function () {
            // Cuando se muestra el modal de edición
            $('#modalCattleEdit').on('shown.bs.modal', function () {
                validarSexoEdit();
            });

            // También ejecutar al cambiar el select
            $('#sexoEdit').on('change', function () {
                validarSexoEdit();
            });

            function validarSexoEdit() {
                const sexo = $('#sexoEdit').val();

                const $reproductiveContainer = $('#statusReproductiveEdit').closest('.col-md-4');
                const $productiveContainer = $('#statusProductiveEdit').closest('.col-md-4');

                if (sexo === 'Hembra') {
                    $reproductiveContainer.show();
                    $productiveContainer.show();
                } else if (sexo === 'Macho') {
                    $('#statusReproductiveEdit').val('');
                    $('#statusProductiveEdit').val('');
                    $reproductiveContainer.hide();
                    $productiveContainer.hide();
                } else {
                    // Si no está seleccionado, mostrar por defecto
                    $reproductiveContainer.show();
                    $productiveContainer.show();
                }
            }
        });

    },

    veterinarian: function(cattleId) {
        const tableCattleServices = $('#tableCattleServices').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            lengthChange: false,
            scrollX: true,
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
                url: "/cattle/dataVeterinarian", // Laravel route
                type: "GET",
                data: function(d) {
                    d.cattle_id = cattleId; // Enviamos el id del animal
                },
                dataSrc: "data"
            },
            columns: [
                { data: "product", name: "product" },
                { data: "symptoms", name: "symptoms" },
                { data: "dateStart", name: "dateStart" },
                { data: "dateEnd", name: "dateEnd" },
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
}

function viewCattle($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/cattle/getCattleView/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                document.querySelector('#codeView').innerHTML = objData.cattle.code;
                document.querySelector('#categoryView').innerHTML = objData.cattle.category?.name ?? 'Sin categoría';
                document.querySelector('#statusView').innerHTML = objData.cattle.status?.name;
                document.querySelector('#herdView').innerHTML = objData.cattle.herd?.name ?? 'Sin rebaño';
                document.querySelector('#dateStartView').innerHTML = objData.cattle?.date_start ?? 'Sin fecha de entrada';
                document.querySelector('#dateEndView').innerHTML = objData.cattle?.date_end ?? 'Sin fecha de salida';
                document.querySelector('#causeEntryView').innerHTML = objData.cattle?.cause_entry?.name ?? 'Sin causa de entrada';
                document.querySelector('#statusReproductiveView').innerHTML = objData.cattle.status_reproductive?.name ?? 'Sin estado reproductivo';
                document.querySelector('#statusProductiveView').innerHTML = objData.cattle.status_productive?.name ?? 'Sin estado productivo';
                document.querySelector('#dateRevisionView').innerHTML = objData.cattle?.dateRevision ?? 'Sin fecha de revisión';
                document.querySelector('#ownerView').innerHTML = objData.cattle.owner?.name ?? 'Sin Propietario';
                document.querySelector('#fatherView').innerHTML = objData.cattle.father?.father_id ?? 'Sin padre';
                document.querySelector('#motherView').innerHTML = objData.cattle.mother_id ?? 'Sin madre';
                document.querySelector('#dateBirthView').innerHTML = objData.cattle?.date_birth ?? 'Sin Fecha de Nacimiento';
                document.querySelector('#colorView').innerHTML = objData.cattle.color?.name ?? 'Sin color';
                document.querySelector('#classificationView').innerHTML = objData.cattle.classification?.name ?? 'Sin clasificación';
                document.querySelector('#sexoView').innerHTML = objData.cattle?.sexo ?? 'Sin color';
                document.querySelector('#incomeWeightView').innerHTML = objData.cattle?.income_weight ?? 'Sin peso inicial (Kg)';
                document.querySelector('#outputWeightView').innerHTML = objData.cattle?.output_weight ?? 'Sin peso final (Kg)';
                document.querySelector('#pricePurchaseView').innerHTML = objData.cattle?.price_purchase ?? 'Sin precio de compra ($/Kg)';
                document.querySelector('#priceFarmView').innerHTML = objData.cattle?.price_farm ?? 'Sin precio en finca ($/Kg)';
            }
            $('#modalCattleView').modal('show');
        }
    }
}

function editCattle($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/cattle/getCattle/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                
                document.querySelector('#idEdit').value = objData.data.id;
                document.querySelector('#codeEdit').value = objData.data.code;
                fillSelect('#categoryEdit', objData.categories, objData.data.category);
                fillSelect('#statusEdit', objData.statuses, objData.data.status_id);
                fillSelect('#herdEdit', objData.herds, objData.data.herd);
                document.querySelector('#dateStartEdit').value = objData.data.dateStart;
                document.querySelector('#dateEndEdit').value = objData.data.dateStart;
                fillSelect('#causeEntryEdit', objData.causeEntrys, objData.data.causeEntry);
                fillSelect('#statusReproductiveEdit', objData.statusReproductives, objData.data.statusReproductive);
                fillSelect('#statusProductiveEdit', objData.statusProductives, objData.data.statusProductive);
                document.querySelector('#dateRevisionEdit').value = objData.data.dateRevision;
                fillSelect('#ownerEdit', objData.owners, objData.data.owner);
                fillSelect('#fatherEdit', objData.fathers, objData.data.father);
                fillSelect('#motherEdit', objData.mothers, objData.data.mother);
                document.querySelector('#dateBirthEdit').value = objData.data.dateBirth;
                fillSelect('#colorEdit', objData.colors, objData.data.color);
                fillSelect('#classificationEdit', objData.classifications, objData.data.classification);
                document.querySelector('#sexoEdit').value = objData.data.sexo;
                document.querySelector('#incomeWeightEdit').value = objData.data.incomeWeight;
                document.querySelector('#outputWeightEdit').value = objData.data.outputWeight;
                document.querySelector('#pricePurchaseEdit').value = objData.data.pricePurchase;
                document.querySelector('#priceFarmEdit').value = objData.data.priceFarm;

            }
            $('#modalCattleEdit').modal('show');
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

function toggleReproductiveFields(containerReproductive, containerProductive, sexoSelect) {
    const sexo = sexoSelect.value;

    if (sexo === 'Hembra') {
        containerReproductive.style.display = '';
        containerProductive.style.display = '';
    } else if (sexo === 'Macho') {
        // Asegúrate de limpiar valores si existen (si están accesibles aquí)
        const statusReproductive = document.getElementById('statusReproductive');
        const statusProductive = document.getElementById('statusProductive');

        if (statusReproductive) statusReproductive.value = '';
        if (statusProductive) statusProductive.value = '';

        containerReproductive.style.display = 'none';
        containerProductive.style.display = 'none';
    } else {
        containerReproductive.style.display = '';
        containerProductive.style.display = '';
    }
}

function serviceCattle($id) {
    $('#modalVeterinarianCattle').modal('show');
}

function viewCattleServices($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/cattle/getCattleServicesView/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                document.querySelector('#productView').innerHTML = objData.veterinarian.product.name;
                document.querySelector('#symptomsView').innerHTML = objData.veterinarian.symptoms;
                document.querySelector('#dateStartView').innerHTML = objData.veterinarian.date_start;
                document.querySelector('#dateEndView').innerHTML = objData.veterinarian.date_end;
                document.querySelector('#statusView').innerHTML = objData.veterinarian.status.name;
                document.querySelector('#observationView').innerHTML = objData.veterinarian.observation;
            }
            $('#modalCattleServicesView').modal('show');
        }
    }
}