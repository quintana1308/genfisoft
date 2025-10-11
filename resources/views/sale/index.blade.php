@extends('layouts.app', [
'class' => '',
'elementActive' => 'sale'
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
                                <h3 class="mb-0"><i class="fa-solid fa-dollar-sign text-success"></i> Ventas de animales</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableSale" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Código Animal</th>
                                        <th>Precio de Venta</th>
                                        <th>Fecha de Venta</th>
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
                                <h6 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-dollar-sign text-success"></i>
                                    Nueva venta
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <form id="formSale" method="POST" action="javascript:void(0);">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-cow"></i>
                                    Animal <span class="text-danger">*</span></label>
                                <select name="cattle_id" id="cattle_id" class="form-control" required>
                                    <option value="">-- Seleccione --</option>
                                    @foreach($cattles as $cattle)
                                    <option value="{{ $cattle->id }}">{{ $cattle->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-dollar-sign"></i> Precio de Venta <span class="text-danger">*</span></label>
                                <input type="number" name="sale_price" id="sale_price" class="form-control" 
                                       step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de Venta <span class="text-danger">*</span></label>
                                <input type="date" name="sale_date" id="sale_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-comment"></i> Observaciones</label>
                                <textarea name="observations" id="observations" class="form-control" rows="3"></textarea>
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

<!-- Modal Ver Venta -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalSaleView">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Información de Venta</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 p-3">
                        <strong>Código Animal:</strong><br>
                        <span class="text-muted" id="cattleCodeView"></span>
                    </div>
                    <div class="col-12 p-3">
                        <strong>Precio de Venta:</strong><br>
                        <span class="text-muted" id="salePriceView"></span>
                    </div>
                    <div class="col-12 p-3">
                        <strong>Fecha de Venta:</strong><br>
                        <span class="text-muted" id="saleDateView"></span>
                    </div>
                    <div class="col-12 p-3">
                        <strong>Observaciones:</strong><br>
                        <span class="text-muted" id="observationsView"></span>
                    </div>
                    <div class="col-12 p-3">
                        <strong>Estado:</strong><br>
                        <span class="text-muted" id="statusView"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper/js/paper-sale.js') }}?v={{ time() }}"></script>
<script>
$(document).ready(function() {
    if (typeof sale !== 'undefined') {
        sale.index();
        sale.form();
    } else {
        console.error('El objeto sale no está definido. Verifica que paper-sale.js se haya cargado correctamente.');
    }
});
</script>
@endpush
