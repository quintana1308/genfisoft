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
                    <h4 class="card-title"><i class="nc-icon nc-simple-add"></i> Nueva Empresa</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.companies.store') }}">
                        @csrf
                        
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
                        </div>
                        
                        <div class="row">
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" rows="3">{{ old('address') }}</textarea>
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
                                        <i class="nc-icon nc-check-2"></i> Crear Empresa
                                    </button>
                                    <a href="{{ route('admin.companies') }}" class="btn btn-secondary">
                                        <i class="nc-icon nc-minimal-left"></i> Cancelar
                                    </a>
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
