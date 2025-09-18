@extends('layouts.app', [
'class' => '',
'elementActive' => 'admin'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="nc-icon nc-ruler-pencil"></i> Editar Empresa: {{ $company->name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.companies.update', $company->id) }}">
                        @csrf
                        @method('PUT')
                        
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" rows="3">{{ old('address', $company->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="nc-icon nc-check-2"></i> Actualizar Empresa
                                    </button>
                                    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
                                        <i class="nc-icon nc-minimal-left"></i> Volver
                                    </a>
                                    <a href="{{ route('admin.company.licenses', $company->id) }}" class="btn btn-info">
                                        <i class="nc-icon nc-key-25"></i> Gestionar Licencias
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">Información Adicional</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                                                <p class="card-category">Estado Licencia</p>
                                                <p class="card-title">
                                                    @if($company->license && $company->license->isValid())
                                                        <span class="text-success">Activa</span>
                                                    @else
                                                        <span class="text-danger">Inactiva</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                                <p class="card-category">Registrada</p>
                                                <p class="card-title">{{ $company->created_at->format('d/m/Y') }}</p>
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
