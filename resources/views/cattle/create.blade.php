@extends('layouts.app', [
'class' => '',
'elementActive' => 'cattleCreate'
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
                                <h5 class="mb-2" id="titleHeaderForm"><i class="fa-solid fa-cow text-success"></i> Nuevo
                                    animal</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <form id="formCattleNew">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-barcode"></i> Código <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-barcode"></i></span>
                                            </div>
                                            <input type="text" name="code" id="code" class="form-control"
                                                placeholder="Código">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-mars-and-venus"></i> Sexo
                                            <span class="text-danger">*</span></label>
                                        <select name="sexo" id="sexo" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            <option value="Hembra">Hembra</option>
                                            <option value="Macho">Macho</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-layer-group"></i> Categoría
                                            <span class="text-danger">*</span></label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['categorys'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name}}</option>
                                            @endforeach
                                        </select>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-house-chimney-crack"></i>
                                            Rebaño <span class="text-danger">*</span></label>
                                        <select name="herd" id="herd" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['herds'] as $herd)
                                            <option value="{{ $herd->id }}">{{ $herd->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Proxima
                                            revisión <span class="text-danger">*</span></label>
                                        <input type="date" name="dateRevision" id="dateRevision" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-user-tie"></i>
                                            Propietario</label>
                                        <select name="owner" id="owner" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['owners'] as $owner)
                                            <option value="{{ $owner->id }}">{{ $owner->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-droplet"></i> Color <span
                                                class="text-danger">*</span></label>
                                        <select name="color" id="color" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['colors'] as $color)
                                            <option value="{{ $color->id }}">{{ $color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-grip"></i> Clasificación
                                            <span class="text-danger">*</span></label>
                                        <select name="classification" id="classification" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['classifications'] as $classification)
                                            <option value="{{ $classification->id }}">{{ $classification->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            entrada <span class="text-danger">*</span></label>
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
                                        <label class="col-form-label"><i class="fa-solid fa-scroll"></i> Causa de
                                            entrada <span class="text-danger">*</span></label>
                                        <select name="causeEntry" id="causeEntry" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['causeEntrys'] as $causeEntry)
                                            <option value="{{ $causeEntry->id }}">{{ $causeEntry->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-money-check-dollar"></i>
                                            Precio de compra <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="number" name="pricePurchase" id="pricePurchase"
                                                class="form-control" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-money-check-dollar"></i>
                                            Precio en finca <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="number" name="priceFarm" id="priceFarm" class="form-control"
                                                step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-weight-scale"></i> Peso
                                            Ingreso <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-weight-scale"></i></span>
                                            </div>
                                            <input type="number" name="incomeWeight" id="incomeWeight"
                                                class="form-control" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-weight-scale"></i> Peso
                                            Salida</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa-solid fa-weight-scale"></i></span>
                                            </div>
                                            <input type="number" name="outputWeight" id="outputWeight"
                                                class="form-control" step="any">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"> <i class="fa-solid fa-chart-column"></i> Estado
                                            reproductivo</label>
                                        <select name="statusReproductive" id="statusReproductive" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['statusReproductives'] as $statusReproductive)
                                            <option value="{{ $statusReproductive->id }}">{{ $statusReproductive->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-whiskey-glass"></i> Estado
                                            productivo</label>
                                        <select name="statusProductive" id="statusProductive" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['statusProductives'] as $statusProductive)
                                            <option value="{{ $statusProductive->id }}">{{ $statusProductive->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-mars"></i> Padre</label>
                                        <select name="father" id="father" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @if($data['fathers']->isEmpty())
                                                <p>No hay padres disponibles</p>
                                            @else
                                                @foreach($data['fathers'] as $father)
                                                    <option value="{{ $father->id }}">{{ $father->code }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-venus"></i> Madre</label>
                                        <select name="mother" id="mother" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @if($data['mothers']->isEmpty())
                                                <p>No hay padres disponibles</p>
                                            @else
                                                @foreach($data['mothers'] as $mother)
                                                    <option value="{{ $mother->id }}">{{ $mother->code }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha de
                                            nacimiento</label>
                                        <input type="date" name="dateBirth" id="dateBirth" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 pt-4">
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
<script src="{{ asset('paper') }}/js/paper-cattle.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    cattle.create();
});
</script>
@endpush