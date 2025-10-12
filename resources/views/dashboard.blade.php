@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content')
<div class="content">
    <!-- Fila 1: Gráficos -->
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-header">
                    <h6 class="card-title text-success">Inventario Actual</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-header">
                    <h6 class="card-title text-success">Situación Reproductiva Actual</h6>
                </div>
                <div class="card-body">
                    <canvas id="reproductiveChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-header">
                    <h6 class="card-title text-success">Situación Productiva Actual</h6>
                </div>
                <div class="card-body">
                    <canvas id="productiveChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 2: Cards de estadísticas -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa-solid fa-cross text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Muertes del Mes</p>
                                <p class="card-title">{{ $totalDeath }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa-solid fa-house-medical text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Animales en Enfermería</p>
                                <p class="card-title">{{ $totalNursing }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa-solid fa-money-bill text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Gastos Bienes del Mes</p>
                                <p class="card-title">$ {{ $totalEstate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa-solid fa-money-check-dollar text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Costos Hechuras</p>
                                <p class="card-title">$ {{ $totalCost }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 3: Card adicional de insumos -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="fa-solid fa-money-bill-1-wave text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Gastos Insumos del Mes</p>
                                <p class="card-title">$ {{ $totalInput }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 4: Tabla Gastos Insumos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0"><i class="fa-solid fa-wheat-awn text-success"></i> Gastos Insumos - Propietarios</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="tableInputOwner" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Propietario</th>
                                    <th>Cantidades</th>
                                    <th>Gastos</th>
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

    <!-- Fila 5: Tabla Categorías por Sexo -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0"><i class="fa-solid fa-list text-success"></i> Categorías por Sexo</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="tableCategoriesBySex" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Categoría</th>
                                    <th>Machos</th>
                                    <th>Hembras</th>
                                    <th>Total</th>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const tableInputOwner = $('#tableInputOwner').DataTable({
        dom: 'lBfrtip',
        processing: true,
        serverSide: true,
        paging: false,
        info: false,
        lengthChange: false,
        scrollX: true,
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "Ningún dato disponible en esta tabla",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            loadingRecords: "Cargando...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: ">",
                previous: "<"
            },
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"
        },
        ajax: {
            url: "/dashboard/data", // Laravel route
            type: "GET",
            dataSrc: "data"
        },
        columns: [{
                data: "owner",
                name: "owner"
            },
            {
                data: "total_quantity",
                name: "total_quantity"
            },
            {
                data: "total_spent",
                name: "total_spent"
            }
        ],
        buttons: [{
                extend: "copyHtml5",
                text: "<i class='fa fa-copy'></i> Copiar",
                titleAttr: "Copiar",
                className: "btn btn-secondary"
            },
            {
                extend: "excelHtml5",
                text: "<i class='fa fa-file-excel-o'></i> Excel",
                titleAttr: "Exportar a Excel",
                className: "btn btn-success"
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fa fa-file-pdf-o'></i> PDF",
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger"
            },
        ],
        responsive: true,
        destroy: true,
        pageLength: 10,
        order: [
            [0, "asc"]
        ]
    });

    if (document.querySelector("#reproductiveChart")) {
        fetch('/chart/reproductive-stats')
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('reproductiveChart').getContext('2d');

                // 📌 Paleta de colores inspirada en girasoles
                const colorPalette = [
                    '#4A5D23', // Verde oscuro
                    '#A8A060', // Verde oliva/beige
                    '#D85F1F', // Naranja oscuro
                    '#F39237', // Naranja medio
                    '#FFD700', // Amarillo brillante
                    '#E8B923', // Amarillo mostaza
                    '#6B7C2E', // Verde medio
                    '#C67D35', // Naranja terracota
                    '#FFC857', // Amarillo suave
                    '#8B9556'  // Verde oliva claro
                ];

                // 📌 Asignar colores según el índice
                const backgroundColors = data.labels.map((_, index) => {
                    return colorPalette[index % colorPalette.length];
                });

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.counts,
                            backgroundColor: backgroundColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 20
                                }
                            },

                            datalabels: {
                                formatter: (value, context) => {
                                    return value; // Mostrar cantidad real
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [
                        ChartDataLabels,
                        {
                            id: 'centerText',
                            beforeDraw: (chart) => {
                                const {
                                    width,
                                    height,
                                    ctx
                                } = chart;
                                ctx.save();
                                ctx.font = 'bold 30px Arial';
                                ctx.fillStyle = '#000';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(data.total, width / 2, height / 2.2);
                                ctx.restore();
                            }
                        }
                    ]
                });
            });
    }

    if (document.querySelector("#productiveChart")) {
        fetch('/chart/productive-stats')
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('productiveChart').getContext('2d');

                // 📌 Paleta de colores inspirada en girasoles
                const colorPalette = [
                    '#4A5D23', // Verde oscuro
                    '#A8A060', // Verde oliva/beige
                    '#D85F1F', // Naranja oscuro
                    '#F39237', // Naranja medio
                    '#FFD700', // Amarillo brillante
                    '#E8B923', // Amarillo mostaza
                    '#6B7C2E', // Verde medio
                    '#C67D35', // Naranja terracota
                    '#FFC857', // Amarillo suave
                    '#8B9556'  // Verde oliva claro
                ];

                // 📌 Asignar colores según el índice
                const backgroundColors = data.labels.map((_, index) => {
                    return colorPalette[index % colorPalette.length];
                });

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.counts,
                            backgroundColor: backgroundColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 20
                                }
                            },

                            datalabels: {
                                formatter: (value, context) => {
                                    return value; // Mostrar cantidad real
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [
                        ChartDataLabels,
                        {
                            id: 'centerText',
                            beforeDraw: (chart) => {
                                const {
                                    width,
                                    height,
                                    ctx
                                } = chart;
                                ctx.save();
                                ctx.font = 'bold 30px Arial';
                                ctx.fillStyle = '#000';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(data.total, width / 2, height / 2.2);
                                ctx.restore();
                            }
                        }
                    ]
                });
            });
    }

    if (document.querySelector("#categoryChart")) {
        fetch('/chart/category-stats')
            .then(res => res.json())
            .then(data => {
                const ctx = document.getElementById('categoryChart').getContext('2d');

                // 📌 Paleta de colores inspirada en girasoles
                const colorPalette = [
                    '#4A5D23', // Verde oscuro
                    '#A8A060', // Verde oliva/beige
                    '#D85F1F', // Naranja oscuro
                    '#F39237', // Naranja medio
                    '#FFD700', // Amarillo brillante
                    '#E8B923', // Amarillo mostaza
                    '#6B7C2E', // Verde medio
                    '#C67D35', // Naranja terracota
                    '#FFC857', // Amarillo suave
                    '#8B9556'  // Verde oliva claro
                ];

                // 📌 Asignar colores según el índice
                const backgroundColors = data.labels.map((_, index) => {
                    return colorPalette[index % colorPalette.length];
                });

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.counts,
                            backgroundColor: backgroundColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 20
                                }
                            },

                            datalabels: {
                                formatter: (value, context) => {
                                    return value; // Mostrar cantidad real
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 14
                                }
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    },
                    plugins: [
                        ChartDataLabels,
                        {
                            id: 'centerText',
                            beforeDraw: (chart) => {
                                const {
                                    width,
                                    height,
                                    ctx
                                } = chart;
                                ctx.save();
                                ctx.font = 'bold 30px Arial';
                                ctx.fillStyle = '#000';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.fillText(data.total, width / 2, height / 2.2);
                                ctx.restore();
                            }
                        }
                    ]
                });
            });
    }

    // Tabla de categorías por sexo
    if (document.querySelector("#tableCategoriesBySex")) {
        $('#tableCategoriesBySex').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            paging: true,
            info: true,
            lengthChange: true,
            scrollX: true,
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Buscar:",
                loadingRecords: "Cargando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: ">",
                    previous: "<"
                },
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"
            },
            ajax: {
                url: "/dashboard/categories-by-sex",
                type: "GET",
                dataSrc: "data"
            },
            columns: [
                { data: "category", name: "category" },
                { data: "machos", name: "machos" },
                { data: "hembras", name: "hembras" },
                { data: "total", name: "total" }
            ],
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "<i class='fa fa-copy'></i> Copiar",
                    titleAttr: "Copiar",
                    className: "btn btn-secondary"
                },
                {
                    extend: "excelHtml5",
                    text: "<i class='fa fa-file-excel-o'></i> Excel",
                    titleAttr: "Exportar a Excel",
                    className: "btn btn-success"
                },
                {
                    extend: "pdfHtml5",
                    text: "<i class='fa fa-file-pdf-o'></i> PDF",
                    titleAttr: "Exportar a PDF",
                    className: "btn btn-danger"
                },
            ],
            responsive: true,
            destroy: true,
            pageLength: 10,
            order: [[0, "asc"]]
        });
    }

});
</script>
<script>
$(document).ready(function() {
    // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
    //demo.initChartsPages();
});
</script>
@endpush