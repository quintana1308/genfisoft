@extends('layouts.app', [
'class' => '',
'elementActive' => 'cattleCreate'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-cow" style="color: #6B8E3F;"></i>
                        Registrar Nuevo Animal
                    </h2>
                    <p class="text-muted mb-0">Completa la información del animal</p>
                </div>
                <div>
                    <a href="{{ route('cattle.index') }}" class="btn btn-outline-secondary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.5rem;">
                    <form id="formCattleNew">
                        <!-- Sección: Información Básica -->
                        <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa-solid fa-info-circle"></i>
                                    Información Básica del Animal
                                </h6>
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
                                            revisión</label>
                                        <input type="date" name="dateRevision" id="dateRevision" class="form-control">
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
                                            <option value="{{ $classification->id }}">{{ $classification->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label"><i class="fa-solid fa-book"></i> Guía</label>
                                        <select name="guide" id="guide" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                            @foreach($data['guides'] as $guide)
                                            <option value="{{ $guide->id }}">{{ $guide->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <!-- Sección: Datos de Ingreso y Salida -->
                            <div class="form-section">
                                <h6 class="form-section-title">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Datos de Ingreso y Salida
                                </h6>
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
                            </div>

                        <!-- Botón de envío -->
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end gap-3 pt-4" style="gap: 1rem !important;">
                                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                                    <i class="fa-solid fa-times"></i> Cancelar
                                </button>
                                <button type="submit" id="buttomSubmit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 0.75rem; font-weight: 600;">
                                    <i class="fa-solid fa-check"></i> Registrar Animal
                                </button>
                            </div>
                        </div>
                    </form>
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