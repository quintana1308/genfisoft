workman = {
    index: function() {
        const tableWorkman = $('#tableWorkman').DataTable({
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
                url: "/workman/data", // Laravel route
                type: "GET",
                data: function (d) {
                    d.fecha_inicio = $('#filterStart').val();
                    d.fecha_fin = $('#filterEnd').val();
                },
                dataSrc: "data"
            },
            columns: [
                { data: "description", name: "description" },
                { data: "date", name: "date" },
                { data: "cost", name: "cost" },
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
            tableWorkman.ajax.reload();
        });

        // Reset del filtro
        $('#resetDate').on('click', function() {
            $('#filterStart').val('');
            $('#filterEnd').val('');
            tableWorkman.ajax.reload();
        });

        document.getElementById('containerRegister').addEventListener('click', function() {
            
            const container = document.getElementById('statusContainer');
            container.innerHTML = '';

            document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';
            document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-person-digging text-success"></i> Registrar Hechura';
            document.querySelector('#id').value = '';

            const containerRegister = document.getElementById('containerRegister');
            containerRegister.innerHTML = '';
            
            formWorkman.reset();
        });

    },

    form: function() {
        if (document.querySelector("#formWorkman")) {
            const formWorkman = document.querySelector("#formWorkman");

            formWorkman.onsubmit = function (e) {
                e.preventDefault();

                const id = document.querySelector("#id").value;
                const description = document.querySelector("#description").value;
                const date = document.querySelector("#date").value;
                const cost = document.querySelector("#cost").value;

                const campos = [
                    { campo: description, nombre: "'Descripción'" },
                    { campo: date, nombre: "'Fecha'" },
                    { campo: cost, nombre: "'Costo'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                if(id == ''){
                    var url = '/workman/create'
                    var metodo = 'POST';
                }else{
                    var url = '/workman/update'
                    var metodo = 'POST';
                }

                const formData = new FormData(formWorkman);

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
                            Swal.fire("Hechuras", data.msg, "success").then(() => {
                                $('#tableWorkman').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax
                                // Generar select + label con menos líneas
                                if(id != ''){
                                    const container = document.getElementById('statusContainer');
                                    container.innerHTML = '';
                                    document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';

                                    const containerRegister = document.getElementById('containerRegister');
                                    containerRegister.innerHTML = '';
                                }
                                formWorkman.reset();
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

function editWorkman($id){
            
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/workman/getWorkman/'+$id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value = objData.data.id;
                document.querySelector('#description').value = objData.data.description;
                document.querySelector('#date').value = objData.data.date;
                document.querySelector('#cost').value = objData.data.cost;
                document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-person-digging text-success"></i> Actualizar Hechura';
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
                        Registrar Hechura</a>
                `;

                
            }
        }
    }

}