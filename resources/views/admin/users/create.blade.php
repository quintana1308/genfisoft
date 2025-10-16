@extends('layouts.app')

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-user-plus" style="color: #6B8E3F;"></i>
                        Crear Usuario
                    </h2>
                    <p class="text-muted mb-0">Registrar un nuevo usuario en el sistema</p>
                </div>
                <div>
                    <a href="{{ route('admin.users') }}" class="btn" style="background: #6B8E3F; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; border: none;">
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
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
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
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Configuración de Acceso -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-key"></i>
                                Configuración de Acceso
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_id">Empresa Principal <span class="text-danger">*</span></label>
                                        <select class="form-control @error('company_id') is-invalid @enderror" 
                                                id="company_id" name="company_id" required>
                                            <option value="">Seleccionar empresa principal...</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            Esta será la empresa por defecto del usuario.
                                        </small>
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
                                            <option value="Administrador" {{ old('role') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                            <option value="Gerente" {{ old('role') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                            <option value="Operador" {{ old('role') == 'Operador' ? 'selected' : '' }}>Operador</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="additional_companies">Empresas Adicionales (Opcional)</label>
                                        <select class="form-control" id="additional_companies" name="additional_companies[]" multiple>
                                            <!-- Las opciones se cargarán dinámicamente según la empresa principal seleccionada -->
                                        </select>
                                        <small class="form-text text-muted">
                                            <i class="fa fa-info-circle"></i> Selecciona las empresas adicionales a las que este usuario tendrá acceso (además de la empresa principal).
                                            Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples empresas.
                                        </small>
                                        @error('additional_companies')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Información de Roles -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-users-gear"></i>
                                Información de Roles
                            </h6>
                            <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6><i class="fa fa-user-shield text-danger"></i> Administrador</h6>
                                        <small class="text-muted">
                                            Acceso completo al sistema, gestión de empresas, usuarios y licencias.
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <h6><i class="fa fa-user-tie text-warning"></i> Gerente</h6>
                                        <small class="text-muted">
                                            Gestión completa de su empresa, usuarios y datos del ganado.
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <h6><i class="fa fa-user text-info"></i> Operador</h6>
                                        <small class="text-muted">
                                            Acceso básico para registro y consulta de datos del ganado.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4" style="gap: 0.5rem;">
                            <a href="{{ route('admin.users') }}" class="btn" style="background: #6c757d; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-save"></i> Crear Usuario
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

    // Lista de todas las empresas disponibles
    const allCompanies = @json($companies);
    
    // Función para actualizar el select de empresas adicionales
    function updateAdditionalCompanies() {
        const mainCompanyId = $('#company_id').val();
        const additionalSelect = $('#additional_companies');
        
        // Limpiar opciones actuales
        additionalSelect.empty();
        
        if (mainCompanyId) {
            // Filtrar empresas excluyendo la empresa principal
            const availableCompanies = allCompanies.filter(company => company.id != mainCompanyId);
            
            // Agregar opciones filtradas
            availableCompanies.forEach(company => {
                additionalSelect.append(
                    $('<option></option>')
                        .attr('value', company.id)
                        .text(company.name)
                );
            });
            
            // Mostrar mensaje si no hay empresas adicionales disponibles
            if (availableCompanies.length === 0) {
                additionalSelect.append(
                    $('<option></option>')
                        .attr('disabled', true)
                        .text('No hay empresas adicionales disponibles')
                );
            }
        } else {
            // Si no hay empresa principal seleccionada, mostrar mensaje
            additionalSelect.append(
                $('<option></option>')
                    .attr('disabled', true)
                    .text('Primero selecciona una empresa principal')
            );
        }
    }
    
    // Actualizar empresas adicionales cuando cambie la empresa principal
    $('#company_id').on('change', updateAdditionalCompanies);
    
    // Inicializar al cargar la página
    updateAdditionalCompanies();
    
    // Validación del formulario
    $('form').on('submit', function(e) {
        var password = $('#password').val();
        var confirmPassword = $('#password_confirmation').val();
        
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
    });
});
</script>
@endpush
