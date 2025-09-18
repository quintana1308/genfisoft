@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Crear Usuario</h4>
                        <p class="card-category">Registrar un nuevo usuario en el sistema</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.users.store') }}">
                            @csrf
                            
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_id">Empresa <span class="text-danger">*</span></label>
                                        <select class="form-control @error('company_id') is-invalid @enderror" 
                                                id="company_id" name="company_id" required>
                                            <option value="">Seleccionar empresa...</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Gerente</option>
                                            <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operador</option>
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
                                               id="rebaño" name="rebaño" value="{{ old('rebaño') }}" 
                                               placeholder="Nombre del rebaño asignado">
                                        @error('rebaño')
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
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
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
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Información de Roles</h5>
                                        </div>
                                        <div class="card-body">
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
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Crear Usuario
                                        </button>
                                    </div>
                                </div>
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
