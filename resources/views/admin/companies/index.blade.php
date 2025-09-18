@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="card-title"><i class="nc-icon nc-bank"></i> Gestión de Empresas</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.companies.create') }}" class="btn btn-success btn-sm">
                                <i class="nc-icon nc-simple-add"></i> Nueva Empresa
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="companiesTable" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>RIF/NIT</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Usuarios</th>
                                    <th>Licencia</th>
                                    <th>Vence</th>
                                    <th>Estado</th>
                                    <th>Registrada</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles de empresa -->
<div class="modal fade" id="companyDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Empresa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="companyDetailsContent">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#companiesTable').DataTable({
        dom: 'lBfrtip',
        processing: true,
        serverSide: false,
        paging: true,
        info: true,
        lengthChange: true,
        scrollX: true,
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron empresas",
            emptyTable: "No hay empresas registradas",
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
            url: "{{ route('admin.companies.data') }}",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "name", name: "name" },
            { data: "tax_id", name: "tax_id" },
            { data: "email", name: "email" },
            { data: "phone", name: "phone", defaultContent: "N/A" },
            { 
                data: "users_count", 
                name: "users_count",
                className: "text-center"
            },
            { 
                data: "license_status", 
                name: "license_status",
                render: function(data) {
                    const badges = {
                        'active': '<span class="badge badge-success">Activa</span>',
                        'expired': '<span class="badge badge-danger">Vencida</span>',
                        'suspended': '<span class="badge badge-warning">Suspendida</span>',
                        'no_license': '<span class="badge badge-secondary">Sin Licencia</span>'
                    };
                    return badges[data] || '<span class="badge badge-secondary">N/A</span>';
                }
            },
            { data: "license_expires", name: "license_expires" },
            { 
                data: "status", 
                name: "status",
                render: function(data) {
                    return data === 'Activa' ? 
                        '<span class="badge badge-success">Activa</span>' : 
                        '<span class="badge badge-danger">Inactiva</span>';
                }
            },
            { data: "created_at", name: "created_at" },
            {
                data: "actions",
                name: "actions",
                orderable: false,
                searchable: false,
                className: "text-center",
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-info btn-sm" onclick="viewCompany(${data})" title="Ver Detalles">
                                <i class="nc-icon nc-zoom-split"></i>
                            </button>
                            <a href="{{ url('admin/companies') }}/${data}/edit" class="btn btn-warning btn-sm" title="Editar">
                                <i class="nc-icon nc-ruler-pencil"></i>
                            </a>
                            <a href="{{ url('admin/companies') }}/${data}/licenses" class="btn btn-success btn-sm" title="Gestionar Licencias">
                                <i class="nc-icon nc-key-25"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ],
        buttons: [
            {
                extend: "copyHtml5",
                text: "<i class='fa fa-copy'></i> Copiar",
                titleAttr: "Copiar",
                className: "btn btn-secondary btn-sm"
            },
            {
                extend: "excelHtml5",
                text: "<i class='fa fa-file-excel-o'></i> Excel",
                titleAttr: "Exportar a Excel",
                className: "btn btn-success btn-sm"
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fa fa-file-pdf-o'></i> PDF",
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger btn-sm"
            }
        ],
        responsive: true,
        pageLength: 25,
        order: [[0, "asc"]]
    });

    // Función para ver detalles de empresa
    window.viewCompany = function(companyId) {
        $.get(`{{ url('admin/companies') }}/${companyId}`)
            .done(function(response) {
                let licenseStatus = 'Sin Licencia';
                let licenseExpiry = 'N/A';
                let daysRemaining = 'N/A';
                
                if (response.license_status !== 'no_license') {
                    const statusLabels = {
                        'active': 'Activa',
                        'expired': 'Vencida',
                        'suspended': 'Suspendida'
                    };
                    licenseStatus = statusLabels[response.license_status] || 'Desconocido';
                    
                    if (response.company.license) {
                        licenseExpiry = new Date(response.company.license.end_date).toLocaleDateString('es-ES');
                        daysRemaining = response.days_until_expiration !== null ? 
                            response.days_until_expiration + ' días' : 'N/A';
                    }
                }

                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>Información General</strong></h6>
                            <p><strong>Nombre:</strong> ${response.company.name}</p>
                            <p><strong>Razón Social:</strong> ${response.company.business_name || 'N/A'}</p>
                            <p><strong>RIF/NIT:</strong> ${response.company.tax_id}</p>
                            <p><strong>Email:</strong> ${response.company.email}</p>
                            <p><strong>Teléfono:</strong> ${response.company.phone || 'N/A'}</p>
                            <p><strong>Dirección:</strong> ${response.company.address || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Estadísticas</strong></h6>
                            <p><strong>Usuarios:</strong> ${response.users_count}</p>
                            <p><strong>Ganado:</strong> ${response.cattle_count}</p>
                            <p><strong>Estado Licencia:</strong> ${licenseStatus}</p>
                            <p><strong>Vence:</strong> ${licenseExpiry}</p>
                            <p><strong>Días Restantes:</strong> ${daysRemaining}</p>
                            <p><strong>Registrada:</strong> ${new Date(response.company.created_at).toLocaleDateString('es-ES')}</p>
                        </div>
                    </div>
                `;
                
                $('#companyDetailsContent').html(content);
                $('#companyDetailsModal').modal('show');
            })
            .fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudieron cargar los detalles de la empresa.'
                });
            });
    };
});
</script>
@endpush
