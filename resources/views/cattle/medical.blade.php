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
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-syringe" style="color: white !important;"></i>
                    Información del Servicio
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                <!-- Información del Servicio -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i>
                        Detalles del Servicio
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Producto</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="productView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Síntoma</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="symptomsView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">F. de Ingreso</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateStartView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">F. de Salida</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateEndView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estado</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="statusView"></div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-notes-medical"></i>
                        Observaciones
                    </h6>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Observación</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="observationView"></div>
                        </div>
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