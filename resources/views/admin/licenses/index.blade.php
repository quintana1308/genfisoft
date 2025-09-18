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
                            <h4 class="card-title">
                                <i class="nc-icon nc-key-25"></i> Licencias de {{ $company->name }}
                            </h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('admin.licenses.create', $company->id) }}" class="btn btn-success btn-sm">
                                <i class="nc-icon nc-simple-add"></i> Nueva Licencia
                            </a>
                            <a href="{{ route('admin.companies') }}" class="btn btn-secondary btn-sm">
                                <i class="nc-icon nc-minimal-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información de la empresa -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="nc-icon nc-single-02 text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Usuarios</p>
                                                <p class="card-title">{{ $company->users()->count() }}</p>
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
                                                <i class="nc-icon nc-key-25 text-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Estado Actual</p>
                                                <p class="card-title">
                                                    @if($company->license && $company->license->isValid())
                                                        <span class="text-success">Activa</span>
                                                    @else
                                                        <span class="text-danger">Sin Licencia</span>
                                                    @endif
                                                </p>
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
                                                <i class="nc-icon nc-calendar-60 text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Vence</p>
                                                <p class="card-title">
                                                    @if($company->license)
                                                        {{ $company->license->end_date->format('d/m/Y') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>
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
                                                <i class="nc-icon nc-time-alarm text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Días Restantes</p>
                                                <p class="card-title">
                                                    @if($company->license && $company->license->isValid())
                                                        {{ $company->getDaysUntilExpiration() }}
                                                    @else
                                                        0
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de licencias -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
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
                                                <form method="POST" action="{{ route('admin.licenses.toggle', $license->id) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Suspender" 
                                                            onclick="return confirm('¿Suspender esta licencia?')">
                                                        <i class="nc-icon nc-button-pause"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.licenses.toggle', $license->id) }}" style="display: inline;">
                                                    @csrf
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
                                    <td colspan="9" class="text-center">
                                        <p class="text-muted">No hay licencias registradas para esta empresa.</p>
                                        <a href="{{ route('admin.licenses.create', $company->id) }}" class="btn btn-success">
                                            <i class="nc-icon nc-simple-add"></i> Crear Primera Licencia
                                        </a>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Renovar Licencia</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
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
