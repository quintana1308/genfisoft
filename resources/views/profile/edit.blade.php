@extends('layouts.app', [
'class' => '',
'elementActive' => 'profile'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-single-02"></i> Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label>Nombre Completo</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pl-1">
                                <div class="form-group">
                                    <label>Correo Electrónico</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Rebaño</label>
                                    <input type="text" class="form-control" value="{{ $user->rebaño }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Fecha de Registro</label>
                                    <input type="text" class="form-control" value="{{ $user->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    <i class="nc-icon nc-check-2"></i> Actualizar Información
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            @if($company)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-bank"></i> Información de la Empresa</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre de la Empresa</label>
                        <input type="text" class="form-control" value="{{ $company->name }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>RIF/NIT</label>
                        <input type="text" class="form-control" value="{{ $company->tax_id ?? 'No especificado' }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" value="{{ $company->phone ?? 'No especificado' }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $company->email ?? 'No especificado' }}" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea class="form-control" rows="3" readonly>{{ $company->address ?? 'No especificada' }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Estado de la Licencia</label>
                        @if($company->license && $company->license->is_active)
                            <span class="badge badge-success">Activa</span>
                            <small class="text-muted d-block">Vence: {{ $company->license->end_date->format('d/m/Y') }}</small>
                        @else
                            <span class="badge badge-danger">Inactiva</span>
                        @endif
                    </div>

                    @if(!$user->isAdmin())
                    <div class="form-group">
                        <label>Cambiar Empresa Activa</label>
                        <select class="form-control" id="companySelector">
                            @foreach($user->getAccessibleCompanies() as $accessibleCompany)
                                <option value="{{ $accessibleCompany->id }}" 
                                    {{ $user->getActiveCompany()->id == $accessibleCompany->id ? 'selected' : '' }}>
                                    {{ $accessibleCompany->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">
                            Selecciona la empresa con la que deseas trabajar. Los datos mostrados corresponderán a la empresa seleccionada.
                        </small>
                    </div>
                    @else
                    <div class="form-group">
                        <label>Empresa Activa (Administrador)</label>
                        <select class="form-control" id="companySelector">
                            <option value="all" {{ !$user->active_company_id ? 'selected' : '' }}>
                                Todas las Empresas (Vista Administrador)
                            </option>
                            @foreach($user->getAccessibleCompanies() as $accessibleCompany)
                                <option value="{{ $accessibleCompany->id }}" 
                                    {{ $user->active_company_id == $accessibleCompany->id ? 'selected' : '' }}>
                                    {{ $accessibleCompany->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">
                            Como administrador, puedes ver todas las empresas o enfocarte en una específica.
                        </small>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-bank"></i> Información de la Empresa</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="nc-icon nc-alert-circle-i"></i>
                        No hay empresa asignada a este usuario.
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Cambiar Contraseña -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="nc-icon nc-key-25"></i> Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        
                        <div class="form-group">
                            <label>Contraseña Actual</label>
                            <input type="password" class="form-control" name="current_password" required>
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="nc-icon nc-refresh-69"></i> Cambiar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Mostrar alertas de éxito o error
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Cambio de empresa
    $('#companySelector').on('change', function() {
        var companyId = $(this).val();
        
        if (companyId === 'all') {
            // Para administradores: vista de todas las empresas
            companyId = null;
        }
        
        Swal.fire({
            title: '¿Cambiar empresa?',
            text: 'Los datos mostrados cambiarán según la empresa seleccionada',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("switch.company") }}',
                    type: 'POST',
                    data: {
                        company_id: companyId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Empresa cambiada',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Recargar la página para reflejar los cambios
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        var message = 'Error al cambiar de empresa';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', message, 'error');
                    }
                });
            } else {
                // Restaurar selección anterior si se cancela
                location.reload();
            }
        });
    });
});
</script>
@endpush
