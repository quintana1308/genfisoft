@extends('layouts.app')

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-user-edit" style="color: #6B8E3F;"></i>
                        Editar Usuario
                    </h2>
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.5rem;">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Sección: Información Personal -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-info-circle"></i>
                                Información Personal
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombre Completo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Nueva Contraseña</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Dejar vacío para mantener la actual">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Dejar vacío si no desea cambiar la contraseña</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" 
                                               placeholder="Confirmar nueva contraseña">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_id">Empresa <span class="text-danger">*</span></label>
                                        <select class="form-control @error('company_id') is-invalid @enderror" 
                                                id="company_id" name="company_id" required>
                                            <option value="">Seleccionar empresa...</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" 
                                                    {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rol <span class="text-danger">*</span></label>
                                        <select class="form-control @error('role') is-invalid @enderror" 
                                                id="role" name="role" required>
                                            <option value="">Seleccionar rol...</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Gerente</option>
                                            <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operador</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rebaño">Rebaño</label>
                                        <input type="text" class="form-control @error('rebaño') is-invalid @enderror" 
                                               id="rebaño" name="rebaño" value="{{ old('rebaño', $user->rebaño) }}" 
                                               placeholder="Nombre del rebaño asignado">
                                        @error('rebaño')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="additional_companies">Empresas Adicionales (Opcional)</label>
                                        <select class="form-control" id="additional_companies" name="additional_companies[]" multiple>
                                            @foreach($companies as $company)
                                                @if($company->id != $user->company_id)
                                                    <option value="{{ $company->id }}" 
                                                        {{ $user->companies->contains($company->id) ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples empresas. 
                                            El usuario podrá cambiar entre estas empresas desde su perfil.
                                        </small>
                                        @error('additional_companies')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                   id="is_active" name="is_active" value="1"
                                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Usuario Activo
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Los usuarios inactivos no pueden acceder al sistema
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Información adicional del usuario -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Información del Usuario</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>Empresa Actual:</strong>
                                                    <p>{{ $user->company ? $user->company->name : 'Sin empresa' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Último Acceso:</strong>
                                                    <p>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Fecha de Registro:</strong>
                                                    <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong>Estado:</strong>
                                                    <p>
                                                        @if($user->is_active)
                                                            <span class="badge badge-success">Activo</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactivo</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4" style="gap: 0.5rem;">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600;">
                                <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-save"></i> Actualizar Usuario
                            </button>
                        </div>
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

    // Validación del formulario
    $('form').on('submit', function(e) {
        var password = $('#password').val();
        var confirmPassword = $('#password_confirmation').val();
        
        // Solo validar si se está intentando cambiar la contraseña
        if (password || confirmPassword) {
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden'
                });
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La contraseña debe tener al menos 8 caracteres'
                });
                return false;
            }
        }
    });

    // Advertencia si se está editando el propio usuario
    @if($user->id === Auth::id())
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Estás editando tu propio usuario. Ten cuidado al cambiar el rol o estado.',
            confirmButtonText: 'Entendido'
        });
    @endif
});
</script>
@endpush
