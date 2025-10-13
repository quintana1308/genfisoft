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
                        <i class="fa-solid fa-building" style="color: #6B8E3F;"></i>
                        Registrar Nueva Empresa
                    </h2>
                    <p class="text-muted mb-0">Completa la información de la empresa</p>
                </div>
                <div>
                    <a href="{{ route('admin.companies') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
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
                    <form method="POST" action="{{ route('admin.companies.store') }}">
                        @csrf
                        
                        <!-- Sección: Información Básica -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-info-circle"></i>
                                Información Básica de la Empresa
                            </h6>
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre de la Empresa *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Razón Social</label>
                                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                           name="business_name" value="{{ old('business_name') }}">
                                    @error('business_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>RIF/NIT *</label>
                                    <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
                                           name="tax_id" value="{{ old('tax_id') }}" required>
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Sección: Información de Contacto y Ubicación -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-location-dot"></i>
                                Información de Contacto y Ubicación
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               name="city" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado/Provincia</label>
                                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                               name="state" value="{{ old('state') }}">
                                        @error('state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>País</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                               name="country" value="{{ old('country', 'Venezuela') }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  name="address" rows="3" placeholder="Dirección completa de la empresa">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4" style="gap: 0.5rem;">
                            <a href="{{ route('admin.companies') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600;">
                                <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-check"></i> Crear Empresa
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            html: '@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach',
            showConfirmButton: true
        });
    @endif
});
</script>
@endpush
