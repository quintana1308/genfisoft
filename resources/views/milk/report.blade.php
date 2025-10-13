@extends('layouts.app', [
'class' => '',
'elementActive' => 'milkReport'
])

@section('content')
<div class="content">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8 mb-3">
                                <h3 class="mb-0"><i class="fa-solid fa-chart-line text-success"></i> Reporte Semanal de Producción</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha Inicio</label>
                                <input type="date" id="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label"><i class="fa-solid fa-calendar-days"></i> Fecha Fin</label>
                                <input type="date" id="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-4" style="align-content: end;">
                                <button id="btnGenerateReport" class="btn btn-info btn-round">
                                    <i class="fa-solid fa-search"></i> Generar Reporte
                                </button>
                            </div>
                        </div>

                        <div id="reportContainer" style="display: none;">
                            <hr>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5>Resumen del Período: <span id="periodRange"></span></h5>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card" style="background: #d85f1f !important;">
                                        <div class="card-body">
                                            <h6 class="text-white mb-2" style="font-weight: 600; font-size: 0.875rem;">Total Litros</h6>
                                            <h2 class="text-white mb-0" id="totalLiters" style="font-weight: 800; font-size: 2rem;">0 L</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card" style="background: linear-gradient(135deg, #567232 0%, #6B8E3F 100%) !important;">
                                        <div class="card-body">
                                            <h6 class="text-white mb-2" style="font-weight: 600; font-size: 0.875rem;">Total Ingresos</h6>
                                            <h2 class="text-white mb-0" id="totalIncome" style="font-weight: 800; font-size: 2rem;">$0.00</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card" style="background: #e8b923 !important;">
                                        <div class="card-body">
                                            <h6 class="text-white mb-2" style="font-weight: 600; font-size: 0.875rem;">Precio Promedio/L</h6>
                                            <h2 class="text-white mb-0" id="avgPrice" style="font-weight: 800; font-size: 2rem;">$0.00</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="reportTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Código Vaca</th>
                                            <th>Días Producidos</th>
                                            <th>Total Litros</th>
                                            <th>Precio Promedio/L</th>
                                            <th>Total Ingresos</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportTableBody">
                                    </tbody>
                                    <tfoot class="thead-light">
                                        <tr>
                                            <th>TOTALES</th>
                                            <th id="totalDays">0</th>
                                            <th id="totalLitersFooter">0 L</th>
                                            <th id="avgPriceFooter">$0.00</th>
                                            <th id="totalIncomeFooter">$0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success" onclick="exportToExcel()">
                                        <i class="fa-solid fa-file-excel"></i> Exportar a Excel
                                    </button>
                                    <button class="btn btn-danger" onclick="exportToPDF()">
                                        <i class="fa-solid fa-file-pdf"></i> Exportar a PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper/js/paper-milk-report.js') }}?v={{ time() }}"></script>
<script>
$(document).ready(function() {
    if (typeof milkReport !== 'undefined') {
        milkReport.init();
    } else {
        console.error('El objeto milkReport no está definido.');
    }
});
</script>
@endpush
