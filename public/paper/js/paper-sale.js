var sale = {
    index: function() {
        const tableSale = $('#tableSale').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: true,
            info: true,
            lengthChange: true,
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
                url: "/sale/data",
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "cattle_code", name: "cattle_code" },
                { data: "sale_price", name: "sale_price" },
                { data: "sale_date", name: "sale_date" },
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
            order: [[2, "desc"]]
        });
    },

    form: function() {
        const formSale = document.querySelector('#formSale');
        if (formSale) {
            formSale.onsubmit = function(e) {
                e.preventDefault();

                const formData = new FormData(formSale);

                fetch('/sale/create', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire("Venta", data.msg, "success").then(() => {
                            $('#tableSale').DataTable().ajax.reload();
                            formSale.reset();
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

function viewSale($id) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/sale/getSale/'+$id;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector('#cattleCodeView').innerHTML = objData.data.cattle_code;
                document.querySelector('#salePriceView').innerHTML = '$' + parseFloat(objData.data.sale_price).toFixed(2);
                document.querySelector('#saleDateView').innerHTML = objData.data.sale_date;
                document.querySelector('#observationsView').innerHTML = objData.data.observations || 'Sin observaciones';
                document.querySelector('#statusView').innerHTML = objData.data.status;
            }
            $('#modalSaleView').modal('show');
        }
    }
}
