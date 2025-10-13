estate = {
    index: function() {
        const tableEstate = $('#tableEstate').DataTable({
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
                url: "/estate/data", // Laravel route
                type: "GET",
                data: function (d) {
                    d.fecha_inicio = $('#filterStart').val();
                    d.fecha_fin = $('#filterEnd').val();
                },
                dataSrc: "data"
            },
            columns: [
                { data: "description", name: "description" },
                { data: "date_purchase", name: "date_purchase" },
                { data: "price", name: "price" },
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

        // Cuando cambian las fechas
        $('#filterStart, #filterEnd').on('change', function() {
            tableEstate.ajax.reload();
        });

        // Reset del filtro
        $('#resetDate').on('click', function() {
            $('#filterStart').val('');
            $('#filterEnd').val('');
            tableEstate.ajax.reload();
        });


        document.getElementById('containerRegister').addEventListener('click', function() {
            
            const container = document.getElementById('statusContainer');
            container.innerHTML = '';

            document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';
            document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-tractor text-success"></i> Registrar Bien';
            document.querySelector('#id').value = '';

            const containerRegister = document.getElementById('containerRegister');
            containerRegister.innerHTML = '';
            
            formEstate.reset();
        });

    },

    form: function() {
        if (document.querySelector("#formEstate")) {
            const formEstate = document.querySelector("#formEstate");

            formEstate.onsubmit = function (e) {
                e.preventDefault();

                const id = document.querySelector("#id").value;
                const description = document.querySelector("#description").value;
                const date_purchase = document.querySelector("#datePurchase").value;
                const price = document.querySelector("#price").value;

                const campos = [
                    { campo: description, nombre: "'Descripción'" },
                    { campo: date_purchase, nombre: "'Fecha de Compra'" },
                    { campo: price, nombre: "'Precio'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                if(id == ''){
                    var url = '/estate/create'
                    var metodo = 'POST';
                }else{
                    var url = '/estate/update'
                    var metodo = 'POST';
                }

                const formData = new FormData(formEstate);

                fetch(url, {
                    method: metodo,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status) {
                            Swal.fire("Bienes", data.msg, "success").then(() => {
                                $('#tableEstate').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax
                                // Generar select + label con menos líneas
                                if(id != ''){
                                    const container = document.getElementById('statusContainer');
                                    container.innerHTML = '';
                                    document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';

                                    const containerRegister = document.getElementById('containerRegister');
                                    containerRegister.innerHTML = '';
                                }
                                formEstate.reset();
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

function editEstate($id){
            
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/estate/getEstate/'+$id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value = objData.data.id;
                document.querySelector('#description').value = objData.data.description;
                document.querySelector('#datePurchase').value = objData.data.date_purchase;
                document.querySelector('#price').value = objData.data.price;
                document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-tractor text-success"></i> Actualizar Bien';
                document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Actualizar';

                // Generar select + label con menos líneas
                const container = document.getElementById('statusContainer');
                container.innerHTML = `
                    <div class="form-group">
                        <label class="col-form-label" for="status"><i class="fa-solid fa-spinner"></i> Estado</label>
                        <select name="status" id="status" class="form-control" required>
                            ${objData.statuses.map(s => `
                                <option value="${s.id}" ${objData.data.status_id == s.id ? 'selected' : ''}>
                                    ${s.name}
                                </option>`).join('')}
                        </select>
                    </div>
                `;

                const containerRegister = document.getElementById('containerRegister');
                containerRegister.innerHTML = `
                    <a href="#" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i>
                        Registrar bien</a>
                `;

                
            }
        }
    }

}