@extends('layouts.app', [
'class' => '',
'elementActive' => 'profile'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-user-circle" style="color: #6B8E3F;"></i>
                        Mi Perfil
                    </h2>
                    <p class="text-muted mb-0">Gestiona tu información personal y configuración de cuenta</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <!-- Columna Principal -->
        <div class="col-lg-8">
            <!-- Información del Usuario -->
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; margin-bottom: 1.5rem;">
                <div class="card-body" style="padding: 1.5rem;">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <!-- Sección: Información Personal -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-user"></i>
                                Información Personal
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-signature"></i> Nombre Completo
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Nombre completo" required>
                                        </div>
                                        @error('name')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-envelope"></i> Correo Electrónico
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="correo@ejemplo.com" required>
                                        </div>
                                        @error('email')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-calendar-check"></i> Fecha de Registro
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $user->created_at->format('d/m/Y H:i') }}" readonly style="background-color: #f5f5f5;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón de envío -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end pt-3">
                                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 0.75rem; font-weight: 600;">
                                    <i class="fa-solid fa-check"></i> Actualizar Información
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cambiar Contraseña -->
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.5rem;">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        
                        <!-- Sección: Seguridad -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-lock"></i>
                                Cambiar Contraseña
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-key"></i> Contraseña Actual
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="current_password" placeholder="Ingresa tu contraseña actual" required>
                                        </div>
                                        @error('current_password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-key"></i> Nueva Contraseña
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="password" placeholder="Nueva contraseña" required>
                                        </div>
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">
                                            <i class="fa-solid fa-key"></i> Confirmar Nueva Contraseña
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirma tu contraseña" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón de envío -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end pt-3">
                                <button type="submit" class="btn btn-warning" style="padding: 0.75rem 2rem; border-radius: 0.75rem; font-weight: 600;">
                                    <i class="fa-solid fa-shield-halved"></i> Cambiar Contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Columna Lateral -->
        <div class="col-lg-4">
            @if($company)
            <!-- Información de la Empresa -->
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; margin-bottom: 1.5rem;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="fa-solid fa-building"></i>
                            Información de la Empresa
                        </h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-briefcase"></i> Nombre de la Empresa
                                    </label>
                                    <input type="text" class="form-control" value="{{ $company->name }}" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-id-card"></i> RIF/NIT
                                    </label>
                                    <input type="text" class="form-control" value="{{ $company->tax_id ?? 'No especificado' }}" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-phone"></i> Teléfono
                                    </label>
                                    <input type="text" class="form-control" value="{{ $company->phone ?? 'No especificado' }}" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-envelope"></i> Email
                                    </label>
                                    <input type="text" class="form-control" value="{{ $company->email ?? 'No especificado' }}" readonly style="background-color: #f5f5f5;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-location-dot"></i> Dirección
                                    </label>
                                    <textarea class="form-control" rows="2" readonly style="background-color: #f5f5f5;">{{ $company->address ?? 'No especificada' }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-certificate"></i> Estado de la Licencia
                                    </label>
                                    <div>
                                        @if($company->license)
                                            @if($company->license->isValid())
                                                <span class="badge badge-success" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                                    <i class="fa-solid fa-check-circle"></i> Activa
                                                </span>
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fa-solid fa-calendar"></i> Vence: {{ $company->license->end_date->format('d/m/Y') }}
                                                </small>
                                                @if($company->license->isExpiringSoon(7))
                                                    <small class="text-warning d-block mt-1">
                                                        <i class="fa-solid fa-exclamation-triangle"></i> Expira en {{ $company->license->getDaysRemaining() }} días
                                                    </small>
                                                @endif
                                            @elseif($company->license->isExpired())
                                                <span class="badge badge-danger" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                                    <i class="fa-solid fa-times-circle"></i> Expirada
                                                </span>
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fa-solid fa-calendar"></i> Expiró: {{ $company->license->end_date->format('d/m/Y') }}
                                                </small>
                                            @else
                                                <span class="badge badge-warning" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                                    <i class="fa-solid fa-pause-circle"></i> Inactiva
                                                </span>
                                                <small class="text-muted d-block mt-2">
                                                    Estado: {{ ucfirst($company->license->status) }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                                <i class="fa-solid fa-ban"></i> Sin Licencia
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; margin-bottom: 1.5rem;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="alert alert-warning">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        No hay empresa asignada a este usuario.
                    </div>
                </div>
            </div>
            @endif

            <!-- Cambiar Empresa Activa -->
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.5rem;">
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="fa-solid fa-building-circle-arrow-right"></i>
                            Cambiar Empresa Activa
                        </h6>
                        <div class="row">
                            <div class="col-12">
                                @if(!$user->isAdmin())
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-building"></i> Seleccionar Empresa
                                    </label>
                                    <select class="form-control" id="companySelector">
                                        @foreach($user->getAccessibleCompanies() as $accessibleCompany)
                                            <option value="{{ $accessibleCompany->id }}" 
                                                {{ $user->getActiveCompany()->id == $accessibleCompany->id ? 'selected' : '' }}>
                                                {{ $accessibleCompany->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted mt-2">
                                        <i class="fa-solid fa-info-circle"></i> Los datos mostrados corresponderán a la empresa seleccionada.
                                    </small>
                                </div>
                                @else
                                <div class="form-group">
                                    <label class="col-form-label">
                                        <i class="fa-solid fa-user-shield"></i> Vista de Administrador
                                    </label>
                                    <select class="form-control" id="companySelector">
                                        <option value="all" {{ !$user->active_company_id ? 'selected' : '' }}>
                                            <i class="fa-solid fa-globe"></i> Todas las Empresas
                                        </option>
                                        @foreach($user->getAccessibleCompanies() as $accessibleCompany)
                                            <option value="{{ $accessibleCompany->id }}" 
                                                {{ $user->active_company_id == $accessibleCompany->id ? 'selected' : '' }}>
                                                {{ $accessibleCompany->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted mt-2">
                                        <i class="fa-solid fa-info-circle"></i> Puedes ver todas las empresas o enfocarte en una específica.
                                    </small>
                                </div>
                                @endif
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
