@extends('layouts.app', [
'class' => '',
'elementActive' => 'death'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h6 class="mb-0"><i class="fa-solid fa-filter text-success mb-3"></i> Filtrar por fecha
                                </h6>
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
                                <span id="resetDate" class="btn btn-secondary m-0" style="background-color: #2A6D3C;"
                                    type="button">
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
                                <h3 class="mb-0"><i class="fa-solid fa-cross text-success"></i> Muertes de animales</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableDeath" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Animal</th>
                                        <th>motivo</th>
                                        <th>Fecha</th>
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
                                <h6 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-cross text-success"></i>
                                    Nueva muerte
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <form id="formDeath">
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-user-tie"></i>
                                    Animal</label>
                                <select name="cattleId" id="cattleId" class="form-control">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($cattles as $cattle)
                                    <option value="{{ $cattle->id }}">{{ $cattle->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha</label>
                                <input type="date" name="date" id="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><i class="fa-solid fa-hashtag"></i> Motivo</label>
                                <textarea name="reason" id="reason" class="form-control" required></textarea>
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
<script src="{{ asset('paper') }}/js/paper-death.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    death.index();
    death.form();
});
</script>
@endpush