@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content')
<div class="content">
    
    <!-- Header del Dashboard -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1" style="font-weight: 800; color: #262626;">
                        <i class="fa-solid fa-chart-line" style="color: #6B8E3F;"></i>
                        Panel de Control
                    </h2>
                    <p class="text-muted mb-0">Resumen general de tu operación ganadera</p>
                </div>
                <div>
                    <span class="badge" style="background: linear-gradient(135deg, #6B8E3F, #8FAF64); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem;">
                        <i class="fa-solid fa-calendar"></i> {{ date('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Rápidas -->
    <div class="row mb-3">
        <!-- Card 1: Muertes -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge" style="background: #FEE2E2; color: #DC2626; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">MES</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #FEE2E2, #FEF2F2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-cross" style="font-size: 1.25rem; color: #EF4444;"></i>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $totalDeath }}</h3>
                            <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Muertes del Mes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Enfermería -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge" style="background: #DBEAFE; color: #2563EB; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIVO</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #DBEAFE, #EFF6FF); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-house-medical" style="font-size: 1.25rem; color: #3B82F6;"></i>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">{{ $totalNursing }}</h3>
                            <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">En Enfermería</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Gastos Bienes -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge" style="background: #FEF3C7; color: #D97706; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">MES</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #FEF3C7, #FFFBEB); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-money-bill" style="font-size: 1.25rem; color: #F59E0B;"></i>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">${{ number_format($totalEstate, 0) }}</h3>
                            <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Gastos en Bienes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Costos Hechuras -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge" style="background: #E8EFE0; color: #567232; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">TOTAL</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #E8EFE0, #F4F7F0); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-money-check-dollar" style="font-size: 1.25rem; color: #6B8E3F;"></i>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">${{ number_format($totalCost, 0) }}</h3>
                            <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Costos Hechuras</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: Gastos Insumos -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="padding: 1.25rem;">
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge" style="background: #D1FAE5; color: #059669; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">MES</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-big" style="width: 3rem; height: 3rem; border-radius: 0.5rem; background: linear-gradient(135deg, #D1FAE5, #ECFDF5); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fa-solid fa-wheat-awn" style="font-size: 1.25rem; color: #10B981;"></i>
                        </div>
                        <div style="margin-left: 1rem;">
                            <h3 style="font-size: 1.75rem; font-weight: 800; color: #262626; margin-bottom: 0.25rem;">${{ number_format($totalInput, 0) }}</h3>
                            <p style="color: #737373; font-size: 0.8125rem; font-weight: 600; margin: 0;">Gastos en Insumos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gráficos -->
    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-chart-pie" style="color: #6B8E3F;"></i>
                        Inventario Actual
                    </h6>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <canvas id="categoryChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card" style="border: none; border-radius: 1rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1.25rem 1.5rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-heart-pulse" style="color: #6B8E3F;"></i>
                        Situación Reproductiva
                    </h6>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <canvas id="reproductiveChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card" style="border: none; border-radius: 1rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1.25rem 1.5rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-chart-line" style="color: #6B8E3F;"></i>
                        Situación Productiva
                    </h6>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <canvas id="productiveChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de Datos -->
    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <div class="card" style="border: none; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1rem 1.25rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-wheat-awn" style="color: #10B981;"></i>
                        Gastos Insumos - Propietarios
                    </h6>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="tableInputOwner" style="width: 100%; margin-bottom: 0;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="padding: 1rem 1.25rem;">Propietario</th>
                                    <th style="padding: 1rem 1.25rem;">Cantidades</th>
                                    <th style="padding: 1rem 1.25rem;">Gastos</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 1rem; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(to right, #F4F7F0, white); border-bottom: 2px solid #E8EFE0; padding: 1.25rem 1.5rem;">
                    <h6 style="margin: 0; font-weight: 700; color: #262626; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-list" style="color: #6B8E3F;"></i>
                        Categorías por Sexo
                    </h6>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center" id="tableCategoriesBySex" style="width: 100%; margin-bottom: 0;">
                            <thead class="thead-light">
                                <tr>
                                    <th style="padding: 1rem 1.25rem;">Categoría</th>
                                    <th style="padding: 1rem 1.25rem;">Machos</th>
                                    <th style="padding: 1rem 1.25rem;">Hembras</th>
                                    <th style="padding: 1rem 1.25rem;">Total</th>
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
        scrollX: false,
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
            scrollX: false,
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