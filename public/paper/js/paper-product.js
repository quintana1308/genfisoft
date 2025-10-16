product = {
    index: function() {
        const tableProduct = $('#tableProduct').DataTable({
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
                url: "/product/data", // Laravel route
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "name", name: "name" },
                { data: "type", name: "type" },
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
            document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-syringe text-success"></i> Registrar Producto';
            document.querySelector('#id').value = '';

            const containerRegister = document.getElementById('containerRegister');
            containerRegister.innerHTML = '';
            
            formProduct.reset();
        });

    },

    form: function() {
        if (document.querySelector("#formProduct")) {
            const formProduct = document.querySelector("#formProduct");

            formProduct.onsubmit = function (e) {
                e.preventDefault();

                const name = document.querySelector("#name").value;
                const type = document.querySelector("#type").value;
                const id = document.querySelector("#id").value;

                if(id == ''){
                    var url = '/product/create'
                    var metodo = 'POST';
                }else{
                    var url = '/product/update'
                    var metodo = 'POST';
                }

                if (name.trim() === "") {
                    Swal.fire("Atención", "El campo nombre es requerido", "error");
                    return false;
                }
                if (type.trim() === "") {
                    Swal.fire("Atención", "El campo tipo es requerido", "error");
                    return false;
                }

                const elementsValid = document.getElementsByClassName("valid");
                for (let i = 0; i < elementsValid.length; i++) {
                    if (elementsValid[i].classList.contains("is-invalid")) {
                        Swal.fire("Atención", 'Por favor verifique el campo "Nombre".', "error");
                        return false;
                    }
                }

                const formData = new FormData(formProduct);

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
                            Swal.fire("Producto", data.msg, "success").then(() => {
                                $('#tableProduct').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax

                                if(id != ''){
                                    const container = document.getElementById('statusContainer');
                                    container.innerHTML = '';
                                    document.querySelector('#buttomSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Registrar';

                                    const containerRegister = document.getElementById('containerRegister');
                                    containerRegister.innerHTML = '';
                                }

                                formProduct.reset();
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

function editProduct($id){
            
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/product/getProduct/'+$id;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector('#id').value = objData.data.id;
                document.querySelector('#name').value = objData.data.name;
                
                // Establecer el valor del tipo
                const typeSelect = document.querySelector('#type');
                if (typeSelect && objData.data.type) {
                    typeSelect.value = objData.data.type;
                }
                
                document.querySelector('#titleHeaderForm').innerHTML = '<i class="fa-solid fa-syringe text-success"></i> Actualizar Producto';
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
                        Registrar Producto</a>
                `;

            }
        }
    }

}