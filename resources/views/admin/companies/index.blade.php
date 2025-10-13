@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-building" style="color: #6B8E3F;"></i>
                        Gestión de Empresas
                    </h2>
                    <p class="text-muted mb-0">Administra las empresas del sistema</p>
                </div>
                <div>
                    <a href="{{ route('admin.companies.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                        <i class="fa-solid fa-plus"></i> Nueva Empresa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de tabla -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-table-list" style="color: #6B8E3F;"></i>
                            Listado de Empresas
                        </h5>
                        <span class="badge" style="background: #E8EFE0; color: #567232; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                            <i class="fa-solid fa-database"></i> Base de Datos
                        </span>
                    </div>
                </div>

                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="companiesTable" style="width: 100%; margin-bottom: 0;">
                            <thead class="thead-light" style="background: #6B8E3F !important;">
                                <tr style="background: #6B8E3F !important;">
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Empresa</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">RIF/NIT</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Usuarios</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Licencia</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Vence</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Estado</th>
                                    <th style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Registrada</th>
                                    <th class="text-center" style="background: #6B8E3F !important; color: white !important; font-weight: 700 !important; text-transform: uppercase !important; padding: 1rem 1.25rem; border: none !important;">Acciones</th>
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
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-building" style="color: white !important;"></i>
                    Detalles de la Empresa
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="companyDetailsContent" style="padding: 1.5rem; background: #F9FAFB;">
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
        paging: false,
        info: false,
        lengthChange: false,
        scrollX: false,
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
                        'active': '<span class="badge" style="background: #D1FAE5; color: #059669; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVA</span>',
                        'expired': '<span class="badge" style="background: #FEE2E2; color: #DC2626; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">VENCIDA</span>',
                        'suspended': '<span class="badge" style="background: #FEF3C7; color: #D97706; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">SUSPENDIDA</span>',
                        'no_license': '<span class="badge" style="background: #E5E7EB; color: #6B7280; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">SIN LICENCIA</span>'
                    };
                    return badges[data] || '<span class="badge" style="background: #E5E7EB; color: #6B7280; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">N/A</span>';
                }
            },
            { data: "license_expires", name: "license_expires" },
            { 
                data: "status", 
                name: "status",
                render: function(data) {
                    return data === 'Activa' ? 
                        '<span class="badge" style="background: #D1FAE5; color: #059669; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVA</span>' : 
                        '<span class="badge" style="background: #FEE2E2; color: #DC2626; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">INACTIVA</span>';
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
                            <button class="btn btn-sm" onclick="viewCompany(${data})" title="Ver Detalles" style="background: #3B82F6; color: white; border-radius: 0.375rem 0 0 0.375rem; padding: 0.5rem 0.75rem; border: none;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="{{ url('admin/companies') }}/${data}/edit" class="btn btn-sm" title="Editar" style="background: #F59E0B; color: white; border-radius: 0; padding: 0.5rem 0.75rem; border: none;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="/admin/companies/${data}/licenses" class="btn btn-sm" title="Gestionar Licencias" style="background: #8FAF64; color: white; border-radius: 0 0.375rem 0.375rem 0; padding: 0.5rem 0.75rem; border: none;">
                                <i class="fa-solid fa-key"></i>
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
                    <!-- Información General -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-circle-info"></i>
                            Información General
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Nombre</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.name}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Razón Social</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.business_name || 'N/A'}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">RIF/NIT</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.tax_id}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Email</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.email}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Teléfono</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.phone || 'N/A'}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Dirección</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.company.address || 'N/A'}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-chart-line"></i>
                            Estadísticas
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Usuarios</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.users_count}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Ganado</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${response.cattle_count}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estado Licencia</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${licenseStatus}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Vence</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${licenseExpiry}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Días Restantes</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${daysRemaining}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Registrada</label>
                                <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;">${new Date(response.company.created_at).toLocaleDateString('es-ES')}</div>
                            </div>
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
