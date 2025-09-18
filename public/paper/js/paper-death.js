death = {
    index: function() {
        const tableDeath = $('#tableDeath').DataTable({
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
                url: "/death/data", // Laravel route
                type: "GET",
                data: function (d) {
                    d.fecha_inicio = $('#filterStart').val();
                    d.fecha_fin = $('#filterEnd').val();
                },
                dataSrc: "data"
            },
            columns: [
                { data: "cattle", name: "cattle" },
                { data: "reason", name: "reason" },
                { data: "date", name: "date" },
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
            tableDeath.ajax.reload();
        });

        // Reset del filtro
        $('#resetDate').on('click', function() {
            $('#filterStart').val('');
            $('#filterEnd').val('');
            tableDeath.ajax.reload();
        });

    },

    form: function() {
        if (document.querySelector("#formDeath")) {
            const formDeath = document.querySelector("#formDeath");

            formDeath.onsubmit = function (e) {
                e.preventDefault();


                const cattleId = document.querySelector("#cattleId").value;
                const reason = document.querySelector("#reason").value;
                const date = document.querySelector("#date").value;
                
                const campos = [
                    { campo: cattleId, nombre: "'Animal'" },
                    { campo: reason, nombre: "'Motivo'" },
                    { campo: date, nombre: "'Fecha'" }
                ];

                for (const { campo, nombre } of campos) {
                    if (campo.trim() === "") {
                        Swal.fire("Atención", `El campo ${nombre} es requerido`, "error");
                        return false;
                    }
                }

                var url = '/death/create'
                var metodo = 'POST';

                const formData = new FormData(formDeath);

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
                            Swal.fire("Muerte", data.msg, "success").then(() => {
                                $('#tableDeath').DataTable().ajax.reload();
                                formDeath.reset();
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

function deleteDeath($id){
    
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción eliminará el registro de forma permanente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/death/deleteDeath/'+$id;
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){

                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);

                    if (objData.status) {
                        Swal.fire("Muerte", objData.msg, "success").then(() => {
                            $('#tableDeath').DataTable().ajax.reload(); // ✅ recarga el DataTable por ajax
                            // Generar select + label con menos líneas
                            formDeath.reset();
                        });
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }
        }
    });
}