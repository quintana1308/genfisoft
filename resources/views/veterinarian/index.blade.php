@extends('layouts.app', [
'class' => '',
'elementActive' => 'veterinarian'
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
                                <h3 class="mb-0"><i class="fa-solid fa-house-medical text-success"></i> Servicio Veterinario</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('veterinarian.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Agregar servicio</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableVeterinarian" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Animal</th>
                                        <th>Producto</th>
                                        <th>Síntoma</th>
                                        <th>Fecha de ingreso</th>
                                        <th>Fecha de salida</th>
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
    aria-hidden="true" id="modalVeterinarianView">
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
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Animal</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="cattleView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Producto</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="productView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Síntoma</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="symptomsView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Ingreso</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateStartView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Salida</label>
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


<!-- modal Edit -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalVeterinarianEdit">
    <div class="modal-dialog" style="max-width: 60%; width: 60%;">
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-syringe" style="color: white !important;"></i>
                    Editar Servicio
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                <form id="formVeterinarianEdit">
                    <input type="hidden" name="idEdit" id="idEdit">
                    
                    <!-- Información del Servicio -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-circle-info"></i>
                            Información del Servicio
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Animal <span class="text-danger">*</span></label>
                                    <select name="cattleEdit" id="cattleEdit" class="form-control" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Producto <span class="text-danger">*</span></label>
                                    <select name="productEdit" id="productEdit" class="form-control" required>
                                        <option value="">-- Seleccione --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Síntoma</label>
                                    <input type="text" name="symptomsEdit" id="symptomsEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Fecha de ingreso <span class="text-danger">*</span></label>
                                    <input type="date" name="dateStartEdit" id="dateStartEdit" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Fecha de salida</label>
                                    <input type="date" name="dateEndEdit" id="dateEndEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Estatus <span class="text-danger">*</span></label>
                                    <select name="statusEdit" id="statusEdit" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-notes-medical"></i>
                            Observaciones
                        </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Observación</label>
                                    <textarea type="text" name="observationEdit" id="observationEdit" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-end gap-2" style="gap: 0.5rem;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600;">
                            <i class="fa-solid fa-times"></i> Cancelar
                        </button>
                        <button type="submit" id="buttomSubmit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                            <i class="fa-solid fa-save"></i> Actualizar Servicio
                        </button>
                    </div>
                </form>
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
    veterinarian.index();
    veterinarian.create();
    veterinarian.edit();
});
</script>
@endpush