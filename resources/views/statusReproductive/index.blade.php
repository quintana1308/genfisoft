@extends('layouts.app', [
'class' => '',
'elementActive' => 'statusReproductive'
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
                                <h3 class="mb-0"><i class="fa-solid fa-chart-column text-success"></i> Estado Reproductivo</h3>
                            </div>
                            <div class="col-4 text-right" id="containerRegister"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableStatusReproductive" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nombre</th>
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
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h6 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-chart-column text-success"></i> Nuevo Estado</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <form id="formStatusReproductive">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-a"></i> Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Estado reproductivo"
                                    required>
                            </div>
                            <div id="statusContainer">
                            </div>
                            <button type="submit" id="buttomSubmit" class="btn btn-info btn-round"><i class="fa-solid fa-check"></i> Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper') }}/js/paper-statusReproductive.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    statusReproductive.index();
    statusReproductive.form();
});
</script>
@endpush