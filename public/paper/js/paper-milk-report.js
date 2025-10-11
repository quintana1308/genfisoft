var milkReport = {
    init: function() {
        // Establecer fechas por defecto (lunes a viernes de la semana actual)
        const today = new Date();
        const dayOfWeek = today.getDay();
        
        // Calcular el lunes de esta semana
        const monday = new Date(today);
        monday.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1));
        
        // Calcular el viernes de esta semana
        const friday = new Date(monday);
        friday.setDate(monday.getDate() + 4);
        
        document.querySelector('#start_date').value = monday.toISOString().split('T')[0];
        document.querySelector('#end_date').value = friday.toISOString().split('T')[0];

        // Evento del botón generar reporte
        document.querySelector('#btnGenerateReport').addEventListener('click', function() {
            milkReport.generateReport();
        });
    },

    generateReport: function() {
        const startDate = document.querySelector('#start_date').value;
        const endDate = document.querySelector('#end_date').value;

        if (!startDate || !endDate) {
            Swal.fire("Atención", "Debe seleccionar ambas fechas", "warning");
            return;
        }

        if (startDate > endDate) {
            Swal.fire("Atención", "La fecha de inicio no puede ser mayor a la fecha fin", "warning");
            return;
        }

        fetch(base_url + '/milk/weeklyReport?start_date=' + startDate + '&end_date=' + endDate, {
            method: 'GET',
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                milkReport.displayReport(data);
            } else {
                Swal.fire("Error", data.msg || "Error al generar el reporte", "error");
            }
        })
        .catch(error => {
            Swal.fire("Error", "Hubo un problema en la solicitud", "error");
            console.error("Error:", error);
        });
    },

    displayReport: function(data) {
        const reportData = data.data;
        const startDate = data.start_date;
        const endDate = data.end_date;

        // Mostrar contenedor del reporte
        document.querySelector('#reportContainer').style.display = 'block';

        // Mostrar período
        document.querySelector('#periodRange').innerHTML = startDate + ' al ' + endDate;

        // Calcular totales
        let totalLiters = 0;
        let totalIncome = 0;
        let totalDays = 0;
        let avgPriceSum = 0;

        reportData.forEach(item => {
            totalLiters += parseFloat(item.total_liters);
            totalIncome += parseFloat(item.total_price);
            totalDays += parseInt(item.days_produced);
            avgPriceSum += parseFloat(item.avg_price_per_liter);
        });

        const avgPrice = reportData.length > 0 ? avgPriceSum / reportData.length : 0;

        // Mostrar resumen en tarjetas
        document.querySelector('#totalLiters').innerHTML = totalLiters.toFixed(2) + ' L';
        document.querySelector('#totalIncome').innerHTML = '$' + totalIncome.toFixed(2);
        document.querySelector('#avgPrice').innerHTML = '$' + avgPrice.toFixed(2);

        // Llenar tabla
        const tbody = document.querySelector('#reportTableBody');
        tbody.innerHTML = '';

        if (reportData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay datos para el período seleccionado</td></tr>';
        } else {
            reportData.forEach(item => {
                const row = `
                    <tr>
                        <td>${item.cattle ? item.cattle.code : 'N/A'}</td>
                        <td>${item.days_produced}</td>
                        <td>${parseFloat(item.total_liters).toFixed(2)} L</td>
                        <td>$${parseFloat(item.avg_price_per_liter).toFixed(2)}</td>
                        <td>$${parseFloat(item.total_price).toFixed(2)}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Actualizar footer
        document.querySelector('#totalDays').innerHTML = totalDays;
        document.querySelector('#totalLitersFooter').innerHTML = totalLiters.toFixed(2) + ' L';
        document.querySelector('#avgPriceFooter').innerHTML = '$' + avgPrice.toFixed(2);
        document.querySelector('#totalIncomeFooter').innerHTML = '$' + totalIncome.toFixed(2);
    }
}

function exportToExcel() {
    Swal.fire("Información", "Función de exportación a Excel en desarrollo", "info");
}

function exportToPDF() {
    Swal.fire("Información", "Función de exportación a PDF en desarrollo", "info");
}
