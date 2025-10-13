herd = {
    index: function() {
        const tableHerd = $('#tableHerd').DataTable({
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
                url: "/herd/data", // Laravel route
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "code", name: "code" },
                { data: "name", name: "name" },
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

        document.getElementById('containerRegister').addEventListener('click', function() {
            
            const container = document.getElementById('statusContainer');
            container.innerHTML = '';
            
            document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';
            document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-house-chimney-crack text-success"></i> Registrar Rebaño';
            document.querySelector('#id').value = '';

            const containerRegister = document.getElementById('containerRegister');
            containerRegister.innerHTML = '';
            
            formHerd.reset();
        });

    },

    form: function() {
        if (document.querySelector("#formHerd")) {
            const formHerd = document.querySelector("#formHerd");

            formHerd.onsubmit = function (e) {
                e.preventDefault();

                const code = document.querySelector("#code").value;
                const name = document.querySelector("#name").value;
                const id = document.querySelector("#id").value;

                if(id == ''){
                    var url = '/herd/create'
                    var metodo = 'POST';
                }else{
                    var url = '/herd/update'
                    var metodo = 'POST';
                }

                if (name.trim() === "") {
                    Swal.fire("Atención", "El campo nombre es requerido", "error");
                    return false;
                }
                if (code.trim() === "") {
                    Swal.fire("Atención", "El campo código es requerido", "error");
                    return false;
                }

                const elementsValid = document.getElementsByClassName("valid");
                for (let i = 0; i < elementsValid.length; i++) {
                    if (elementsValid[i].classList.contains("is-invalid")) {
                        Swal.fire("Atención", 'Por favor verifique el campo "Nombre y/o Código".', "error");
                        return false;
                    }
                }

                const formData = new FormData(formHerd);

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
                            Swal.fire("Rebaño", data.msg, "success").then(() => {
                                $('#tableHerd').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax

                                if(id != ''){
                                    const container = document.getElementById('statusContainer');
                                    container.innerHTML = '';
                                    document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';

                                    const containerRegister = document.getElementById('containerRegister');
                                    containerRegister.innerHTML = '';
                                }

                                formHerd.reset();
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

function editHerd($id){
            
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/herd/getHerd/'+$id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value = objData.data.id;
                document.querySelector('#code').value = objData.data.code;
                document.querySelector('#name').value = objData.data.name;
                document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-house-chimney-crack text-success"></i> Actualizar Rebaño';
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
                        Registrar Rebaño</a>
                `;
            }
        }
    }

}