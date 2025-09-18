input = {
    index: function() {
        const tableInput = $('#tableInput').DataTable({
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
                url: "/input/data", // Laravel route
                type: "GET",
                data: function (d) {
                    d.fecha_inicio = $('#filterStart').val();
                    d.fecha_fin = $('#filterEnd').val();
                },
                dataSrc: "data"
            },
            columns: [
                { data: "description", name: "description" },
                { data: "owner", name: "owner" },
                { data: "price", name: "price" },
                { data: "quantity", name: "quantity" },
                { data: "date", name: "date" },
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
            tableInput.ajax.reload();
        });

        // Reset del filtro
        $('#resetDate').on('click', function() {
            $('#filterStart').val('');
            $('#filterEnd').val('');
            tableInput.ajax.reload();
        });

        document.getElementById('containerRegister').addEventListener('click', function() {
            
            const container = document.getElementById('statusContainer');
            container.innerHTML = '';

            document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';
            document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-wheat-awn text-success"></i> Registrar Insumo';
            document.querySelector('#id').value = '';

            const containerRegister = document.getElementById('containerRegister');
            containerRegister.innerHTML = '';
            
            formInput.reset();
        });

    },

    form: function() {
        if (document.querySelector("#formInput")) {
            const formInput = document.querySelector("#formInput");

            formInput.onsubmit = function (e) {
                e.preventDefault();

                const id = document.querySelector("#id").value;
                const description = document.querySelector("#description").value;
                const owner = document.querySelector("#owner").value;
                const price = document.querySelector("#price").value;
                const quantity = document.querySelector("#quantity").value;
                const date = document.querySelector("#date").value;

                const campos = [
                    { campo: description, nombre: "'Descripción'" },
                    { campo: owner, nombre: "'Propietario'" },
                    { campo: price, nombre: "'Precio'" },
                    { campo: quantity, nombre: "'Cantidad'" },
                    { campo: date, nombre: "'Fecha'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                if(id == ''){
                    var url = '/input/create'
                    var metodo = 'POST';
                }else{
                    var url = '/input/update'
                    var metodo = 'POST';
                }

                const formData = new FormData(formInput);

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
                            Swal.fire("Insumos", data.msg, "success").then(() => {
                                $('#tableInput').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax
                                // Generar select + label con menos líneas
                                if(id != ''){
                                    const container = document.getElementById('statusContainer');
                                    container.innerHTML = '';
                                    document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';

                                    const containerRegister = document.getElementById('containerRegister');
                                    containerRegister.innerHTML = '';
                                }
                                formInput.reset();
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

function editInput($id){
            
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/input/getInput/'+$id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value = objData.data.id;
                document.querySelector('#description').value = objData.data.description;
                fillSelect('#owner', objData.owners, objData.data.owner);
                document.querySelector('#price').value = objData.data.price;
                document.querySelector('#quantity').value = objData.data.quantity;
                document.querySelector('#date').value = objData.data.date;
                document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-wheat-awn text-success"></i> Actualizar Insumo';
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
                        Registrar Insumo</a>
                `;

                
            }
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