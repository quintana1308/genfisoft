@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    
    <!-- Header del Dashboard -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-chart-line" style="color: #6B8E3F;"></i>
                        Dashboard Administrador
                    </h2>
                    <p class="text-muted mb-0">Resumen general de tu operación ganadera</p>
                </div>
                <div>
                    <span class="badge" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem;">
                        <i class="fa-solid fa-calendar"></i> {{ date('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Rápidas -->
    <div class="row mb-3">
        <!-- Card 1: Total Empresas -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #D1FAE5, #ECFDF5); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-building" style="font-size: 1.25rem; color: #10B981;"></i>
                        </div>
                        <span class="badge" style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">TOTAL</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['total_companies'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Total Empresas</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Empresas Activas -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #DBEAFE, #EFF6FF); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-heart" style="font-size: 1.25rem; color: #3B82F6;"></i>
                        </div>
                        <span class="badge" style="background: #DBEAFE; color: #2563EB; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVAS</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['active_companies'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Empresas Activas</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Licencias Activas -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #FEF3C7, #FFFBEB); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-key" style="font-size: 1.25rem; color: #F59E0B;"></i>
                        </div>
                        <span class="badge" style="background: #FEF3C7; color: #D97706; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVAS</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['active_licenses'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Licencias Activas</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Ingresos Totales -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #E8EFE0, #F4F7F0); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-money-check-dollar" style="font-size: 1.25rem; color: #6B8E3F;"></i>
                        </div>
                        <span class="badge" style="background: #E8EFE0; color: #567232; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">TOTAL</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">${{ number_format($stats['total_revenue'], 2) }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Ingresos Totales</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Empresas Recientes -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-building" style="color: #10B981;"></i>
                        Empresas Recientes
                    </h6>
                </div>
                <div class="card-body" style="padding: 1.25rem;">
                    @if($recentCompanies->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-items-center" id="tableRecentCompanies" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Email</th>
                                        <th>Licencia</th>
                                        <th>Registrada</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCompanies as $company)
                                    <tr>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->email }}</td>
                                        <td>
                                            @if($company->license && $company->license->isValid())
                                                <span class="badge" style="background: #D1FAE5; color: #059669; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVA</span>
                                            @else
                                                <span class="badge" style="background: #FEE2E2; color: #DC2626; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">SIN LICENCIA</span>
                                            @endif
                                        </td>
                                        <td>{{ $company->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.companies.edit', $company->id) }}" 
                                               class="btn btn-sm" style="background: #8FAF64; color: white; border-radius: 0.375rem; padding: 0.5rem 0.75rem; border: none;">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay empresas registradas recientemente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Licencias por Vencer -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-clock" style="color: #F59E0B;"></i>
                        Licencias por Vencer
                    </h6>
                </div>
                <div class="card-body" style="padding: 1.25rem;">
                    @if($expiringLicenses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-items-center" id="tableExpiringLicenses" style="width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Plan</th>
                                        <th>Vence</th>
                                        <th>Días</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringLicenses as $license)
                                    <tr>
                                        <td>{{ $license->company->name }}</td>
                                        <td>
                                            <span class="badge" style="background: #DBEAFE; color: #2563EB; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">{{ strtoupper($license->plan_type) }}</span>
                                        </td>
                                        <td>{{ $license->end_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge" style="background: #FEF3C7; color: #D97706; padding: 0.375rem 0.75rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">{{ $license->getDaysRemaining() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.companies.licenses', $license->company_id) }}" 
                                               class="btn btn-sm" style="background: #8FAF64; color: white; border-radius: 0.375rem; padding: 0.5rem 0.75rem; border: none;">
                                                <i class="fa-solid fa-key"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No hay licencias próximas a vencer.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas Adicionales -->
    <div class="row mb-3">
        <!-- Card: Total Usuarios -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #E0E7FF, #EEF2FF); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-users" style="font-size: 1.25rem; color: #6366F1;"></i>
                        </div>
                        <span class="badge" style="background: #E0E7FF; color: #4F46E5; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">TOTAL</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['total_users'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Total Usuarios</p>
                </div>
            </div>
        </div>

        <!-- Card: Total Licencias -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #F3E8FF, #FAF5FF); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-id-card" style="font-size: 1.25rem; color: #A855F7;"></i>
                        </div>
                        <span class="badge" style="background: #F3E8FF; color: #9333EA; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">TOTAL</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['total_licenses'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Total Licencias</p>
                </div>
            </div>
        </div>

        <!-- Card: Por Vencer -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #FEE2E2, #FEF2F2); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-clock" style="font-size: 1.25rem; color: #EF4444;"></i>
                        </div>
                        <span class="badge" style="background: #FEE2E2; color: #DC2626; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">30 DÍAS</span>
                    </div>
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $stats['expiring_licenses'] }}</h3>
                    <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Por Vencer (30d)</p>
                </div>
            </div>
        </div>

        <!-- Card: Botón Gestionar -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(135deg, #6B8E3F, #8FAF64);">
                <div class="card-body d-flex align-items-center justify-content-center" style="padding: 1.25rem; min-height: 120px;">
                    <a href="{{ route('admin.companies') }}" class="btn" style="background: white; color: #6B8E3F; font-weight: 700; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.2s;">
                        <i class="fa-solid fa-building"></i> Gestionar Empresas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inicializar DataTable para Licencias por Vencer
    $('#tableExpiringLicenses').DataTable({
        dom: 'lBfrtip',
        processing: true,
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
            }
        ],
        responsive: true,
        destroy: true,
        pageLength: 5,
        order: [[2, "asc"]]
    });

    // Inicializar DataTable para Empresas Recientes
    $('#tableRecentCompanies').DataTable({
        dom: 'lBfrtip',
        processing: true,
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
            }
        ],
        responsive: true,
        destroy: true,
        pageLength: 5,
        order: [[3, "desc"]]
    });

    // Actualizar estadísticas cada 5 minutos
    setInterval(function() {
        location.reload();
    }, 300000);
});
</script>
@endpush
