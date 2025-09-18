@extends('layouts.app', [
'class' => '',
'elementActive' => 'veterinarianCreate'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow p-2">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h5 class="mb-2" id="titleHeaderForm"><i
                                        class="fa-solid fa-house-medical text-success"></i> Nuevo servicio</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <form id="formVeterinarianNew">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-cow"></i> Animal <span
                                                class="text-danger">*</span></label>
                                        <select name="cattle" id="cattleForm" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['cattles'] as $cattle)
                                            <option value="{{ $cattle->id }}">{{ $cattle->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-syringe"></i> Producto <span
                                                class="text-danger">*</span></label>
                                        <select name="product" id="product" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['products'] as $product)
                                            <option value="{{ $product->id }}">{{ $product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-stethoscope"></i> Síntoma
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="symptoms" id="symptoms" class="form-control"
                                            placeholder="Síntoma">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            ingreso <span class="text-danger">*</span></label>
                                        <input type="date" name="dateStart" id="dateStart" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            salida</label>
                                        <input type="date" name="dateEnd" id="dateEnd" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-spinner"></i> Estatus <span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            @foreach($data['status'] as $status)
                                            <option value="{{ $status->id }}">{{ $status->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-eye"></i> Observación <span
                                                class="text-danger">*</span></label>
                                        <textarea name="observation" id="observation" class="form-control"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pt-4">
                                    <button type="submit" id="buttomSubmit" class="btn btn-info btn-round"><i
                                            class="fa-solid fa-check"></i> Registrar</button>
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
    veterinarian.create();
});
</script>
@endpush