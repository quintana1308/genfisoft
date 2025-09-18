@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-bank text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Empresas</p>
                                <p class="card-title">{{ $stats['total_companies'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-favourite-28 text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Empresas Activas</p>
                                <p class="card-title">{{ $stats['active_companies'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-key-25 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Licencias Activas</p>
                                <p class="card-title">{{ $stats['active_licenses'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-money-coins text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Ingresos Totales</p>
                                <p class="card-title">${{ number_format($stats['total_revenue'], 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-time-alarm text-warning"></i> Licencias por Vencer</h5>
                </div>
                <div class="card-body">
                    @if($expiringLicenses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
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
                                            <span class="badge badge-info">{{ strtoupper($license->plan_type) }}</span>
                                        </td>
                                        <td>{{ $license->end_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge badge-warning">{{ $license->getDaysRemaining() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.company.licenses', $license->company_id) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="nc-icon nc-key-25"></i>
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
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-simple-add text-success"></i> Empresas Recientes</h5>
                </div>
                <div class="card-body">
                    @if($recentCompanies->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
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
                                                <span class="badge badge-success">Activa</span>
                                            @else
                                                <span class="badge badge-danger">Sin Licencia</span>
                                            @endif
                                        </td>
                                        <td>{{ $company->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.companies.edit', $company->id) }}" 
                                               class="btn btn-sm btn-warning">
                                                <i class="nc-icon nc-ruler-pencil"></i>
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
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-chart-bar-32 text-info"></i> Estadísticas Adicionales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-single-02 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Total Usuarios</p>
                                                <p class="card-title">{{ $stats['total_users'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-key-25 text-secondary"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Total Licencias</p>
                                                <p class="card-title">{{ $stats['total_licenses'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-time-alarm text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Por Vencer (30d)</p>
                                                <p class="card-title">{{ $stats['expiring_licenses'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="text-center">
                                        <a href="{{ route('admin.companies') }}" class="btn btn-success">
                                            <i class="nc-icon nc-bank"></i> Gestionar Empresas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Actualizar estadísticas cada 5 minutos
    setInterval(function() {
        location.reload();
    }, 300000);
});
</script>
@endpush
