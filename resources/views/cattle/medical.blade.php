@extends('layouts.app', [
'class' => '',
'elementActive' => 'cattleMedical'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header pt-4 px-4 ps-4">
                        <div class="row align-items-center">
                            <div class="col-8 mb-3">
                                <h3 class="mb-0"><i class="fa-solid fa-house-medical text-success"></i> Historial Servicios - {{ $data->code }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('cattle.index') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-left-long"></i> Regresar</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableCattleServices" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Síntoma</th>
                                        <th>F. de Ingreso</th>
                                        <th>F. de Salida</th>
                                        <th>Estado</th>
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
        </div>
    </div>
</div>

<!-- modal View -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalCattleServicesView">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Información del Servicio</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 p-3">
                        Producto<br>
                        <span class="text-muted" id="productView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Síntoma<br>
                        <span class="text-muted" id="symptomsView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        F. de Ingreso<br>
                        <span class="text-muted" id="dateStartView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        F. de Salida<br>
                        <span class="text-muted" id="dateEndView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Estado<br>
                        <span class="text-muted" id="statusView"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 p-3">
                        Observación<br>
                        <span class="text-muted" id="observationView"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper') }}/js/paper-cattle.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    const cattleId = @json($data->id); // usa esto solo si $data es el modelo y tiene id
    cattle.veterinarian(cattleId);
});
</script>
@endpush