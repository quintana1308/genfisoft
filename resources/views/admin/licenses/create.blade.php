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
                        <i class="fa-solid fa-key" style="color: #6B8E3F;"></i>
                        Nueva Licencia
                    </h2>
                    <p class="text-muted mb-0">Crear licencia para {{ $company->name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.companies.licenses', $company->id) }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
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
                    <form method="POST" action="{{ route('admin.licenses.store', $company->id) }}">
                        @csrf
                        
                        <!-- Sección: Información de la Licencia -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-info-circle"></i>
                                Información de la Licencia
                            </h6>
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
                        </div>

                        <!-- Sección: Información de Pago -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-credit-card"></i>
                                Información de Pago
                            </h6>
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
                        </div>
                        
                        <!-- Información del plan seleccionado -->
                        <div id="planInfo" style="display: none;">
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa-solid fa-list-check"></i>
                                    Características del Plan
                                </h6>
                                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
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

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4" style="gap: 0.5rem;">
                            <a href="{{ route('admin.companies.licenses', $company->id) }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600;">
                                <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-check"></i> Crear Licencia
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
