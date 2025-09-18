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
                        Animal<br>
                        <span class="text-muted" id="cattleView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Producto<br>
                        <span class="text-muted" id="productView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Síntoma<br>
                        <span class="text-muted" id="symptomsView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Fecha de Ingreso<br>
                        <span class="text-muted" id="dateStartView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Fecha de salida<br>
                        <span class="text-muted" id="dateEndView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Estado<br>
                        <span class="text-muted" id="statusView"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 p-3">
                        Observación<br>
                        <span class="text-muted" id="observationView"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal Edit -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalVeterinarianEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Servicio</h5>

                <!--begin::Close-->
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <!--end::Close-->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <form id="formVeterinarianEdit">
                            <input type="hidden" name="idEdit" id="idEdit">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Animal <span
                                                class="text-danger">*</span></label>
                                        <select name="cattleEdit" id="cattleEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Producto <span
                                                class="text-danger">*</span></label>
                                        <select name="productEdit" id="productEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Síntoma <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="symptomsEdit" id="symptomsEdit"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de ingreso <span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="dateStartEdit" id="dateStartEdit" class="form-control"
                                            required>
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
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Observación <span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" name="observationEdit" id="observationEdit"
                                            class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 m-4">
                                    <button type="submit" id="buttomSubmit"
                                        class="btn btn-info btn-round">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    veterinarian.index();
    veterinarian.create();
    veterinarian.edit();
});
</script>
@endpush