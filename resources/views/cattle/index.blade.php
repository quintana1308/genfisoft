@extends('layouts.app', [
'class' => '',
'elementActive' => 'cattle'
])

@section('content')
<div class="content">
    
    <!-- Header de la página -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-cow" style="color: #6B8E3F;"></i>
                        Gestión de Animales
                    </h2>
                    <p class="text-muted mb-0">Administra tu inventario ganadero</p>
                </div>
                <div>
                    <a href="{{ route('cattle.create') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 600;">
                        <i class="fa-solid fa-plus"></i> Agregar Animal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de tabla -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-table-list" style="color: #6B8E3F;"></i>
                            Listado de Animales
                        </h5>
                        <span class="badge" style="background: #E8EFE0; color: #567232; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                            <i class="fa-solid fa-database"></i> Base de Datos
                        </span>
                    </div>
                </div>

                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="tableCattle" style="width: 100%; margin-bottom: 0;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="padding: 1rem 1.25rem;">Código</th>
                                    <th style="padding: 1rem 1.25rem;">Rebaño</th>
                                    <th style="padding: 1rem 1.25rem;">Categoría</th>
                                    <th style="padding: 1rem 1.25rem;">Clasificación</th>
                                    <th style="padding: 1rem 1.25rem;">F. de entrada</th>
                                    <th style="padding: 1rem 1.25rem;">C. de entrada</th>
                                    <th style="padding: 1rem 1.25rem;">Estado</th>
                                    <th class="text-center" style="padding: 1rem 1.25rem;">Acciones</th>
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

<!-- modal View -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalCattleView">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-cow" style="color: white !important;"></i>
                    Información del Animal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                <!-- Información General -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i>
                        Información General
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Código</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="codeView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Sexo</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="sexoView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Categoría</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="categoryView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estatus</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="statusView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Rebaño</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="herdView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Próxima Revisión</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateRevisionView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Propietario</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="ownerView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Color</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="colorView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Clasificación</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="classificationView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Guía</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="guideView"></div>
                        </div>
                    </div>
                </div>

                <!-- Información de Entrada/Salida y Pesos -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-calendar-days"></i>
                        Fechas y Pesos
                    </h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Entrada</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateStartView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Salida</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateEndView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Causa de Entrada</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="causeEntryView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Precio de compra</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="pricePurchaseView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Peso Ingreso</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="incomeWeightView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Peso Salida</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="outputWeightView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estado Reproductivo</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="statusReproductiveView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Estado Productivo</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="statusProductiveView"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Fecha de Nacimiento</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="dateBirthView"></div>
                        </div>
                    </div>
                </div>

                <!-- Información Genealógica -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-sitemap"></i>
                        Información Genealógica
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Padre</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="fatherView"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label style="font-size: 0.75rem; font-weight: 600; color: #6B7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Madre</label>
                            <div style="background: #F3F4F6; padding: 0.625rem 0.875rem; border-radius: 0.375rem; font-weight: 600; color: #262626;" id="motherView"></div>
                        </div>
                    </div>
                </div>

                <!-- Hijos del Animal -->
                <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-baby"></i>
                        Hijos de este animal
                    </h6>
                    <div id="childrenListView" style="background: #F3F4F6; padding: 1rem; border-radius: 0.375rem; min-height: 60px;">
                        <p class="text-muted mb-0" style="text-align: center;">Sin hijos registrados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal Edit -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="modalCattleEdit">
    <div class="modal-dialog" style="max-width: 60%; width: 60%;">
        <div class="modal-content" style="border-radius: 0.75rem; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white !important; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-cow" style="color: white !important;"></i>
                    Editar Animal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white !important; opacity: 1 !important; text-shadow: none;">
                    <span aria-hidden="true" style="font-size: 1.5rem; color: white !important;">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 1.5rem; background: #F9FAFB;">
                <form id="formCattleEdit">
                    <input type="hidden" name="idEdit" id="idEdit">
                    
                    <!-- Información Básica del Animal -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-circle-info"></i>
                            Información Básica del Animal
                        </h6>
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
                    </div>

                    <!-- Fechas, Pesos y Estados -->
                    <div style="background: white; border-radius: 0.5rem; padding: 1.25rem; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h6 style="color: #6B8E3F; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-calendar-days"></i>
                            Fechas, Pesos y Estados
                        </h6>
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
                        </div>
                    </div>

                    <!-- Botón de Actualizar -->
                    <div class="d-flex justify-content-end gap-2" style="gap: 0.5rem;">
                        <button type="button" class="btn" data-dismiss="modal" style="background: #6c757d; color: white !important; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                            <i class="fa-solid fa-times"></i> Cancelar
                        </button>
                        <button type="submit" id="buttomSubmit" class="btn" style="background: #6B8E3F; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; border: none;">
                            <i class="fa-solid fa-save"></i> Actualizar Animal
                        </button>
                    </div>
                </form>
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