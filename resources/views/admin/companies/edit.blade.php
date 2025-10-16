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
                        Editar Empresa
                    </h2>
                    <p class="text-muted mb-0">{{ $company->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.companies') }}" class="btn" style="background: #6B8E3F; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; border: none;">
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
                    <form method="POST" action="{{ route('admin.companies.update', $company->id) }}">
                        @csrf
                        @method('PUT')
                        
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
                                           name="name" value="{{ old('name', $company->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Razón Social</label>
                                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                                           name="business_name" value="{{ old('business_name', $company->business_name) }}">
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
                                           name="tax_id" value="{{ old('tax_id', $company->tax_id) }}" required>
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email', $company->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" value="{{ old('phone', $company->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ciudad</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           name="city" value="{{ old('city', $company->city) }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estado/Provincia</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           name="state" value="{{ old('state', $company->state) }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>País</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                           name="country" value="{{ old('country', $company->country) }}">
                                    @error('country')
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
                                        <label>Estado de la Empresa</label>
                                        <select class="form-control @error('status_id') is-invalid @enderror" name="status_id">
                                            <option value="1" {{ old('status_id', $company->status_id) == 1 ? 'selected' : '' }}>Activa</option>
                                            <option value="2" {{ old('status_id', $company->status_id) == 2 ? 'selected' : '' }}>Inactiva</option>
                                        </select>
                                        @error('status_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  name="address" rows="3" placeholder="Dirección completa de la empresa">{{ old('address', $company->address) }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.companies.licenses', $company->id) }}" class="btn btn-outline-primary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600;">
                                <i class="fa-solid fa-key"></i> Gestionar Licencias
                            </a>
                            <div class="d-flex gap-2" style="gap: 0.5rem;">
                                <a href="{{ route('admin.companies') }}" class="btn" style="background: #6c757d; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                    <i class="fa-solid fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                    <i class="fa-solid fa-save"></i> Actualizar Empresa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            
    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-12">
            <h5 style="font-weight: 700; color: #262626; margin-bottom: 1rem;">Información Adicional</h5>
        </div>
    </div>
    <div class="row">
        <!-- Card Usuarios -->
        <div class="col-md-4 mb-3">
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

        <!-- Card Estado Licencia -->
        <div class="col-md-4 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Estado Licencia</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; font-size: 1.5rem; 
                                @if($company->license && $company->license->isValid())
                                    color: #059669;
                                @else
                                    color: #DC2626;
                                @endif
                            ">
                                @if($company->license && $company->license->isValid())
                                    Activa
                                @else
                                    Inactiva
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

        <!-- Card Registrada -->
        <div class="col-md-4 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden; background: linear-gradient(to right, #F4F7F0, white);">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p style="margin: 0; font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px;">Registrada</p>
                            <h3 style="margin: 0.5rem 0 0 0; font-weight: 800; color: #262626; font-size: 1.5rem;">{{ $company->created_at->format('d/m/Y') }}</h3>
                        </div>
                        <div style="width: 60px; height: 60px; border-radius: 12px; background: #FEF3C7; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-calendar-days" style="font-size: 1.5rem; color: #D97706;"></i>
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
