@extends('layouts.app', [
'class' => '',
'elementActive' => 'cattle'
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
                                <h3 class="mb-0"><i class="fa-solid fa-cow text-success"></i> Animales</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('cattle.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i> Agregar Animal</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="tableCattle" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Rebaño</th>
                                        <th>Categoría</th>
                                        <th>Clasificación</th>
                                        <th>F. de entrada</th>
                                        <th>C. de entrada</th>
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
    aria-hidden="true" id="modalCattleView">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Información del Animal</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 p-3">
                        Código<br>
                        <span class="text-muted" id="codeView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Sexo<br>
                        <span class="text-muted" id="sexoView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Categoría<br>
                        <span class="text-muted" id="categoryView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Estatus<br>
                        <span class="text-muted" id="statusView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Rebaño<br>
                        <span class="text-muted" id="herdView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Próxima Revisión<br>
                        <span class="text-muted" id="dateRevisionView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Propietario<br>
                        <span class="text-muted" id="ownerView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Color<br>
                        <span class="text-muted" id="colorView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Clasificación<br>
                        <span class="text-muted" id="classificationView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Guía<br>
                        <span class="text-muted" id="guideView"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 p-3">
                        Fecha de Entrada<br>
                        <span class="text-muted" id="dateStartView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Fecha de Salida<br>
                        <span class="text-muted" id="dateEndView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Causa de Entrada<br>
                        <span class="text-muted" id="causeEntryView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Precio de compra<br>
                        <span class="text-muted" id="pricePurchaseView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Peso Ingreso<br>
                        <span class="text-muted" id="incomeWeightView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Peso Salida<br>
                        <span class="text-muted" id="outputWeightView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Estado Reproductivo<br>
                        <span class="text-muted" id="statusReproductiveView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Estado Productivo<br>
                        <span class="text-muted" id="statusProductiveView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Padre<br>
                        <span class="text-muted" id="fatherView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Madre<br>
                        <span class="text-muted" id="motherView"></span>
                    </div>
                    <div class="col-md-4 p-3">
                        Fecha de Nacimiento<br>
                        <span class="text-muted" id="dateBirthView"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 p-3">
                        <h5 class="mb-3"><i class="fa-solid fa-baby text-info"></i> Hijos de este animal</h5>
                        <div id="childrenListView">
                            <p class="text-muted">Sin hijos registrados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal Edit -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalCattleEdit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Animal</h5>

                <!--begin::Close-->
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <!--end::Close-->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="col-12">
                        <form id="formCattleEdit">
                            <input type="hidden" name="idEdit" id="idEdit">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Código <span class="text-danger">*</span></label>
                                        <input type="text" name="codeEdit" id="codeEdit" class="form-control"
                                            placeholder="Código">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Sexo <span class="text-danger">*</span></label>
                                        <select name="sexoEdit" id="sexoEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                            <option value="Hembra">Hembra</option>
                                            <option value="Macho">Macho</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Categoría <span
                                                class="text-danger">*</span></label>
                                        <select name="categoryEdit" id="categoryEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Estatus <span class="text-danger">*</span></label>
                                        <select name="statusEdit" id="statusEdit" class="form-control" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Rebaño <span class="text-danger">*</span></label>
                                        <select name="herdEdit" id="herdEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Proxima revisión</label>
                                        <input type="date" name="dateRevisionEdit" id="dateRevisionEdit"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Propietario</label>
                                        <select name="ownerEdit" id="ownerEdit" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Color <span class="text-danger">*</span></label>
                                        <select name="colorEdit" id="colorEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Clasificación <span
                                                class="text-danger">*</span></label>
                                        <select name="classificationEdit" id="classificationEdit" class="form-control"
                                            required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Guía</label>
                                        <select name="guideEdit" id="guideEdit" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de entrada <span
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
                                        <label class="col-form-label">Causa de entrada <span
                                                class="text-danger">*</span></label>
                                        <select name="causeEntryEdit" id="causeEntryEdit" class="form-control" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Precio de compra <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="pricePurchaseEdit" id="pricePurchaseEdit"
                                            class="form-control" step="any" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Peso Ingreso <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="incomeWeightEdit" id="incomeWeightEdit"
                                            class="form-control" step="any" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Peso Salida</label>
                                        <input type="number" name="outputWeightEdit" id="outputWeightEdit"
                                            class="form-control" step="any">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado reproductivo</label>
                                        <select name="statusReproductiveEdit" id="statusReproductiveEdit"
                                            class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado productivo</label>
                                        <select name="statusProductiveEdit" id="statusProductiveEdit"
                                            class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Padre</label>
                                        <select name="fatherEdit" id="fatherEdit" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Madre</label>
                                        <select name="motherEdit" id="motherEdit" class="form-control">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de nacimiento</label>
                                        <input type="date" name="dateBirthEdit" id="dateBirthEdit" class="form-control">
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
<script src="{{ asset('paper') }}/js/paper-cattle.js"></script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    cattle.index();
    cattle.create();
    cattle.edit();
});
</script>
@endpush