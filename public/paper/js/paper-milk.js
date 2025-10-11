var milk = {
    index: function() {
        $('#tableMilk').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: true,
            info: true,
            lengthChange: true,
            scrollX: true,
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron registros",
                emptyTable: "No hay producción registrada",
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
                url: "/milk/data",
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "production_date", name: "production_date" },
                { data: "cattle_code", name: "cattle_code" },
                { data: "liters", name: "liters" },
                { data: "price_per_liter", name: "price_per_liter" },
                { data: "total_price", name: "total_price" },
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
            order: [[0, "desc"]]
        });
    },

    form: function() {
        const formMilk = document.querySelector('#formMilk');
        if (formMilk) {
            formMilk.onsubmit = function(e) {
                e.preventDefault();

                const formData = new FormData(formMilk);

                fetch('/milk/create', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire("Producción", data.msg, "success").then(() => {
                            $('#tableMilk').DataTable().ajax.reload();
                            formMilk.reset();
                            // Restablecer fecha a hoy
                            const today = new Date().toISOString().split('T')[0];
                            document.querySelector('#production_date').value = today;
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
    }
}

function viewProduction($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/milk/getProduction/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector('#cattleCodeView').innerHTML = objData.data.cattle ? objData.data.cattle.code : 'N/A';
                document.querySelector('#productionDateView').innerHTML = objData.data.production_date;
                document.querySelector('#litersView').innerHTML = parseFloat(objData.data.liters).toFixed(2) + ' L';
                document.querySelector('#pricePerLiterView').innerHTML = '$' + parseFloat(objData.data.price_per_liter).toFixed(2);
                document.querySelector('#totalPriceView').innerHTML = '$' + parseFloat(objData.data.total_price).toFixed(2);
                document.querySelector('#observationsView').innerHTML = objData.data.observations || 'Sin observaciones';
            }
            $('#modalMilkView').modal('show');
        }
    }
}

function deleteProduction($id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(base_url + '/milk/delete/' + $id, {
                method: 'DELETE',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire("Eliminado", data.msg, "success").then(() => {
                        $('#tableMilk').DataTable().ajax.reload();
                    });
                } else {
                    Swal.fire("Error", data.msg, "error");
                }
            })
            .catch(error => {
                Swal.fire("Error", "Hubo un problema en la solicitud", "error");
                console.error("Error:", error);
            });
        }
    });
}
