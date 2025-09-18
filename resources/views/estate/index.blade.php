@extends('layouts.app', [
'class' => '',
'elementActive' => 'estate'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-0"><i class="fa-solid fa-filter text-success mb-3"></i> Filtrar por fecha</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Desde</label>
                                <input type="date" id="filterStart" class="form-control">
                            </div>
                            <div class="col-5">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Hasta</label>
                                <input type="date" id="filterEnd" class="form-control">
                            </div>
                            <div class="col-2" style="align-content: end;">
                                <span id="resetDate" class="btn btn-secondary m-0" style="background-color: #2A6D3C;" type="button">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8 mb-3">
                                <h3 class="mb-0"><i class="fa-solid fa-tractor text-success"></i> Bienes</h3>
                            </div>
                            <div class="col-4 text-right" id="containerRegister"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableEstate" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Descripción</th>
                                        <th>F. de compra</th>
                                        <th>Precio</th>
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
            <div class="col-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h6 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-tractor text-success"></i>
                                    Nuevo Bien
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <form id="formEstate">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-heading"></i> Descripción</label>
                                <input type="text" name="description" id="description" class="form-control"
                                    placeholder="Descripción" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> F. de
                                    compra</label>
                                <input type="date" name="datePurchase" id="datePurchase" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-money-bill-1"></i> Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" name="price" id="price" class="form-control" step="any"
                                        required>
                                </div>
                            </div>
                            <div id="statusContainer">
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
@endsection

@push('scripts')
<script src="{{ asset('paper') }}/js/paper-estate.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    estate.index();
    estate.form();
});
</script>
@endpush