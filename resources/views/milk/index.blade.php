@extends('layouts.app', [
'class' => '',
'elementActive' => 'milk'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8 mb-3">
                                <h3 class="mb-0"><i class="fa-solid fa-droplet text-success"></i> Producción de Leche</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableMilk" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Código Vaca</th>
                                        <th>Litros</th>
                                        <th>Precio/Litro</th>
                                        <th>Total</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h6 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-droplet text-success"></i>
                                    Registrar Producción
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <form id="formMilk" method="POST" action="javascript:void(0);">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-cow"></i>
                                    Vaca <span class="text-danger">*</span></label>
                                <select name="cattle_id" id="cattle_id" class="form-control" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach($cattles as $cattle)
                                    <option value="{{ $cattle->id }}">{{ $cattle->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha <span class="text-danger">*</span></label>
                                <input type="date" name="production_date" id="production_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-droplet"></i> Litros <span class="text-danger">*</span></label>
                                <input type="number" name="liters" id="liters" class="form-control" 
                                       step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-dollar-sign"></i> Precio por Litro <span class="text-danger">*</span></label>
                                <input type="number" name="price_per_liter" id="price_per_liter" class="form-control" 
                                       step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                                <textarea name="observations" id="observations" class="form-control" rows="2"></textarea>
                            </div>
                            <button type="submit" id="buttomSubmit" class="btn btn-info btn-round"><i
                                    class="fa-solid fa-check"></i> Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Producción -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalMilkView">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-droplet" style="color: white !important;"></i>
                    Detalle de Producción
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                <!-- Información de Producción -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i>
                        Detalles de Producción
                    </h6>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Vaca</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="cattleCodeView"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="productionDateView"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Litros</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="litersView"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Precio/Litro</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="pricePerLiterView"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Total</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="totalPriceView"></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Observaciones</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="observationsView"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper/js/paper-milk.js') }}?v={{ time() }}"></script>
<script>
$(document).ready(function() {
    if (typeof milk !== 'undefined') {
        milk.index();
        milk.form();
    } else {
        console.error('El objeto milk no está definido.');
    }
});
</script>
@endpush
