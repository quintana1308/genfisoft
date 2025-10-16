@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-key" style="color: #6B8E3F;"></i>
                        Licencias de {{ $company->name }}
                    </h2>
                    <p class="text-muted mb-0">Gestiona las licencias de la empresa</p>
                </div>
                <div class="d-flex gap-2" style="gap: 0.5rem;">
                    <a href="{{ route('admin.companies') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> Volver
                    </a>
                    <a href="{{ route('admin.licenses.create', $company->id) }}" class="btn" style="background: #6B8E3F; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; border: none;">
                        <i class="fa-solid fa-plus"></i> Nueva Licencia
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Información -->
    <div class="row mb-4">
        <!-- Card Usuarios -->
        <div class="col-md-3 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Usuarios</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; color: #262626; font-size: 2rem;">{{ $company->users()->count() }}</h3>
                        </div>
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: #D1FAE5; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-users" style="font-size: 1.5rem; color: #059669;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Estado Actual -->
        <div class="col-md-3 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Estado Actual</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; font-size: 1.25rem; 
                                @if($company->license && $company->license->isValid())
                                    color: #059669;
                                @else
                                    color: #DC2626;
                                @endif
                            ">
                                @if($company->license && $company->license->isValid())
                                    Activa
                                @else
                                    Sin Licencia
                                @endif
                            </h3>
                        </div>
                        <div style="width: 60px; height: 60px; border-radius: 12px; 
                            @if($company->license && $company->license->isValid())
                                background: #D1FAE5;
                            @else
                                background: #FEE2E2;
                            @endif
                            display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-key" style="font-size: 1.5rem; 
                                @if($company->license && $company->license->isValid())
                                    color: #059669;
                                @else
                                    color: #DC2626;
                                @endif
                            "></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Vence -->
        <div class="col-md-3 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Vence</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; color: #262626; font-size: 1.25rem;">
                                @if($company->license)
                                    {{ $company->license->end_date->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </h3>
                        </div>
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: #FEF3C7; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-calendar-days" style="font-size: 1.5rem; color: #D97706;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Días Restantes -->
        <div class="col-md-3 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Días Restantes</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; color: #262626; font-size: 2rem;">
                                @if($company->license && $company->license->isValid())
                                    {{ $company->getDaysUntilExpiration() }}
                                @else
                                    0
                                @endif
                            </h3>
                        </div>
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: #FEE2E2; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-clock" style="font-size: 1.5rem; color: #DC2626;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Licencias -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-table-list" style="color: #6B8E3F;"></i>
                        Historial de Licencias
                    </h6>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="licensesTable" style="width: 100%; margin-bottom: 0;">
                            <thead class="thead-light">
                                <tr>
                                    <th>Clave de Licencia</th>
                                    <th>Plan</th>
                                    <th>Inicio</th>
                                    <th>Vencimiento</th>
                                    <th>Usuarios</th>
                                    <th>Ganado</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($company->licenses as $license)
                                <tr class="{{ $license->status === 'active' ? 'table-success' : '' }}">
                                    <td>
                                        <code>{{ $license->license_key }}</code>
                                        @if($license->status === 'active')
                                            <span class="badge badge-success ml-1">ACTUAL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ strtoupper($license->plan_type) }}</span>
                                    </td>
                                    <td>{{ $license->start_date->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $license->end_date->format('d/m/Y') }}
                                        @if($license->isExpiringSoon(30) && $license->status === 'active')
                                            <i class="nc-icon nc-time-alarm text-warning" title="Vence pronto"></i>
                                        @endif
                                    </td>
                                    <td>{{ $license->max_users }}</td>
                                    <td>{{ $license->max_cattle }}</td>
                                    <td>${{ number_format($license->price, 2) }}</td>
                                    <td>
                                        @switch($license->status)
                                            @case('active')
                                                @if($license->isExpired())
                                                    <span class="badge badge-danger">Vencida</span>
                                                @else
                                                    <span class="badge badge-success">Activa</span>
                                                @endif
                                                @break
                                            @case('suspended')
                                                <span class="badge badge-warning">Suspendida</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge badge-secondary">Inactiva</span>
                                                @break
                                            @default
                                                <span class="badge badge-dark">{{ $license->status }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            @if($license->status === 'active')
                                                <button class="btn btn-info btn-sm" onclick="renewLicense({{ $license->id }})" title="Renovar">
                                                    <i class="nc-icon nc-refresh-69"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.licenses.toggle-status', $license->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Suspender" 
                                                            onclick="return confirm('¿Suspender esta licencia?')">
                                                        <i class="nc-icon nc-button-pause"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.licenses.toggle-status', $license->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm" title="Activar"
                                                            onclick="return confirm('¿Activar esta licencia?')">
                                                        <i class="nc-icon nc-button-play"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="dataTables_empty">
                                        <div class="empty-state-container">
                                            <i class="fa-solid fa-key empty-state-icon"></i>
                                            <h5 class="empty-state-title">No hay licencias registradas</h5>
                                            <p class="empty-state-description">Esta empresa aún no tiene licencias asociadas. Crea la primera licencia para comenzar.</p>
                                            <a href="{{ route('admin.licenses.create', $company->id) }}" class="empty-state-button">
                                                <i class="fa-solid fa-plus"></i>
                                                Crear Primera Licencia
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para renovar licencia -->
<div class="modal fade" id="renewLicenseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Renovar Licencia</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="renewLicenseForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Meses a Extender *</label>
                        <select class="form-control" name="months" required>
                            <option value="1">1 mes</option>
                            <option value="3">3 meses</option>
                            <option value="6">6 meses</option>
                            <option value="12" selected>12 meses</option>
                            <option value="24">24 meses</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Precio de Renovación *</label>
                        <input type="number" class="form-control" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Referencia de Pago</label>
                        <input type="text" class="form-control" name="payment_reference">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">Cancelar</button>
                    <button type="submit" class="btn btn-success">Renovar Licencia</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Estilos para el mensaje de tabla vacía */
.dataTables_empty {
    padding: 0 !important;
}

.empty-state-container {
    background: #F9FAFB;
    border-radius: 0.75rem;
    padding: 3rem 2rem;
    margin: 1rem;
    text-align: center;
    border: 2px dashed #E5E7EB;
}

.empty-state-icon {
    font-size: 4rem;
    color: #9CA3AF;
    margin-bottom: 1.5rem;
    display: block;
}

.empty-state-title {
    color: #374151;
    font-weight: 600;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.empty-state-description {
    color: #6B7280;
    margin-bottom: 2rem;
    font-size: 1rem;
}

.empty-state-button {
    background: #6B8E3F !important;
    color: white !important;
    padding: 0.875rem 2rem !important;
    border-radius: 0.5rem !important;
    font-weight: 600 !important;
    border: none !important;
    text-decoration: none !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    transition: all 0.2s ease !important;
}

.empty-state-button:hover {
    background: #5A7A35 !important;
    color: white !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(107, 142, 63, 0.3) !important;
    text-decoration: none !important;
}

.empty-state-button:focus,
.empty-state-button:active {
    color: white !important;
    text-decoration: none !important;
}

/* Mejorar la visualización de DataTables */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_processing,
.dataTables_wrapper .dataTables_paginate {
    color: #374151;
    font-weight: 500;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5rem 0.75rem;
    margin: 0 0.125rem;
    border-radius: 0.375rem;
    border: 1px solid #D1D5DB;
    background: white;
    color: #374151;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #6B8E3F;
    color: white;
    border-color: #6B8E3F;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #6B8E3F;
    color: white;
    border-color: #6B8E3F;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable
    $('#licensesTable').DataTable({
        dom: 'lBfrtip',
        processing: true,
        paging: true,
        pageLength: 10,
        info: true,
        lengthChange: true,
        scrollX: false,
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados que coincidan con la búsqueda",
            emptyTable: "No hay licencias registradas para esta empresa",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            loadingRecords: "Cargando...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros"
        },
        buttons: [
            {
                extend: "copyHtml5",
                text: "<i class='fa fa-copy'></i> Copiar",
                titleAttr: "Copiar datos al portapapeles",
                className: "btn btn-outline-secondary btn-sm",
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: "excelHtml5",
                text: "<i class='fa fa-file-excel-o'></i> Excel",
                titleAttr: "Exportar a Excel",
                className: "btn btn-outline-success btn-sm",
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fa fa-file-pdf-o'></i> PDF",
                titleAttr: "Exportar a PDF",
                className: "btn btn-outline-danger btn-sm",
                exportOptions: {
                    columns: ':not(:last-child)'
                },
                orientation: 'landscape',
                pageSize: 'A4'
            }
        ],
        responsive: true,
        destroy: true,
        order: [[2, "desc"]],
        columnDefs: [
            {
                targets: -1,
                orderable: false,
                searchable: false
            }
        ]
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});

function renewLicense(licenseId) {
    $('#renewLicenseForm').attr('action', `{{ url('admin/licenses') }}/${licenseId}/renew`);
    $('#renewLicenseModal').modal('show');
}
</script>
@endpush
