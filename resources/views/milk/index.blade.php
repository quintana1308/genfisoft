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
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalle de Producción</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 p-3">
                        <strong>Vaca:</strong><br>
                        <span class="text-muted" id="cattleCodeView"></span>
                    </div>
                    <div class="col-6 p-3">
                        <strong>Fecha:</strong><br>
                        <span class="text-muted" id="productionDateView"></span>
                    </div>
                    <div class="col-6 p-3">
                        <strong>Litros:</strong><br>
                        <span class="text-muted" id="litersView"></span>
                    </div>
                    <div class="col-6 p-3">
                        <strong>Precio/Litro:</strong><br>
                        <span class="text-muted" id="pricePerLiterView"></span>
                    </div>
                    <div class="col-6 p-3">
                        <strong>Total:</strong><br>
                        <span class="text-muted" id="totalPriceView"></span>
                    </div>
                    <div class="col-12 p-3">
                        <strong>Observaciones:</strong><br>
                        <span class="text-muted" id="observationsView"></span>
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
