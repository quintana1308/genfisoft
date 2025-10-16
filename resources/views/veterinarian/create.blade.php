@extends('layouts.app', [
'class' => '',
'elementActive' => 'veterinarianCreate'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-syringe" style="color: #6B8E3F;"></i>
                        Registrar Nuevo Servicio
                    </h2>
                    <p class="text-muted mb-0">Completa la información del servicio veterinario</p>
                </div>
                <div>
                    <a href="{{ route('veterinarian.index') }}" class="btn" style="background: #6B8E3F; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600; border: none;">
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
                    <form id="formVeterinarianNew">
                        <!-- Sección: Información del Servicio -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-info-circle"></i>
                                Información del Servicio
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-cow"></i> Animal <span
                                                class="text-danger">*</span></label>
                                        <select name="cattle" id="cattleForm" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['cattles'] as $cattle)
                                            <option value="{{ $cattle->id }}">{{ $cattle->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-syringe"></i> Producto <span
                                                class="text-danger">*</span></label>
                                        <select name="product" id="product" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['products'] as $product)
                                            <option value="{{ $product->id }}">{{ $product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-stethoscope"></i> Síntoma</label>
                                        <input type="text" name="symptoms" id="symptoms" class="form-control"
                                            placeholder="Síntoma">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            ingreso <span class="text-danger">*</span></label>
                                        <input type="date" name="dateStart" id="dateStart" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            salida</label>
                                        <input type="date" name="dateEnd" id="dateEnd" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-spinner"></i> Estatus <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            @foreach($data['status'] as $status)
                                            <option value="{{ $status->id }}">{{ $status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección: Observaciones -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fa-solid fa-notes-medical"></i>
                                Observaciones
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-eye"></i> Observación</label>
                                        <textarea name="observation" id="observation" class="form-control" rows="4" placeholder="Escribe observaciones adicionales..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 mt-4" style="gap: 0.5rem;">
                            <a href="{{ route('veterinarian.index') }}" class="btn" style="background: #6c757d; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-times"></i> Cancelar
                            </a>
                            <button type="submit" id="buttomSubmit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                                <i class="fa-solid fa-check"></i> Registrar Servicio
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
<script src="{{ asset('paper') }}/js/paper-veterinarian.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    veterinarian.create();
});
</script>
@endpush