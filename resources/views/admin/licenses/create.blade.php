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
                    <h4 class="card-title">
                        <i class="nc-icon nc-simple-add"></i> Nueva Licencia para {{ $company->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.licenses.store', $company->id) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Plan *</label>
                                    <select class="form-control @error('plan_type') is-invalid @enderror" 
                                            name="plan_type" id="planType" required>
                                        <option value="">Seleccione un plan</option>
                                        <option value="basic" {{ old('plan_type') == 'basic' ? 'selected' : '' }}>
                                            Básico - 3 usuarios, 200 ganado
                                        </option>
                                        <option value="premium" {{ old('plan_type') == 'premium' ? 'selected' : '' }}>
                                            Premium - 10 usuarios, 1000 ganado
                                        </option>
                                        <option value="enterprise" {{ old('plan_type') == 'enterprise' ? 'selected' : '' }}>
                                            Empresarial - 50 usuarios, 5000 ganado
                                        </option>
                                    </select>
                                    @error('plan_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Precio *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Inicio *</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Vencimiento *</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           name="end_date" value="{{ old('end_date', date('Y-m-d', strtotime('+1 year'))) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Referencia de Pago</label>
                                    <input type="text" class="form-control @error('payment_reference') is-invalid @enderror" 
                                           name="payment_reference" value="{{ old('payment_reference') }}" 
                                           placeholder="Número de transferencia, referencia bancaria, etc.">
                                    @error('payment_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notas</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              name="notes" rows="3" placeholder="Observaciones adicionales">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información del plan seleccionado -->
                        <div class="row" id="planInfo" style="display: none;">
                            <div class="col-md-12">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        <h6>Características del Plan:</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p><strong>Usuarios máximos:</strong> <span id="maxUsers">-</span></p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Ganado máximo:</strong> <span id="maxCattle">-</span></p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Funcionalidades:</strong></p>
                                                <ul id="features" class="list-unstyled"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="nc-icon nc-check-2"></i> Crear Licencia
                                    </button>
                                    <a href="{{ route('admin.company.licenses', $company->id) }}" class="btn btn-secondary">
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
    const planLimits = {
        'basic': {
            max_users: 3,
            max_cattle: 200,
            features: ['Reportes básicos', 'Gestión de ganado']
        },
        'premium': {
            max_users: 10,
            max_cattle: 1000,
            features: ['Reportes básicos', 'Gestión de ganado', 'Veterinaria', 'Finanzas']
        },
        'enterprise': {
            max_users: 50,
            max_cattle: 5000,
            features: ['Reportes básicos', 'Gestión de ganado', 'Veterinaria', 'Finanzas', 'Reportes avanzados', 'Acceso API']
        }
    };

    $('#planType').change(function() {
        const selectedPlan = $(this).val();
        
        if (selectedPlan && planLimits[selectedPlan]) {
            const plan = planLimits[selectedPlan];
            
            $('#maxUsers').text(plan.max_users);
            $('#maxCattle').text(plan.max_cattle);
            
            const featuresList = plan.features.map(feature => `<li><i class="nc-icon nc-check-2 text-success"></i> ${feature}</li>`).join('');
            $('#features').html(featuresList);
            
            $('#planInfo').show();
        } else {
            $('#planInfo').hide();
        }
    });

    // Trigger change event if there's an old value
    if ($('#planType').val()) {
        $('#planType').trigger('change');
    }

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
