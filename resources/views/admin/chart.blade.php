@extends('layouts.admin.app')

@section('header')
Dashboard Charts
@endsection

@section('styles')
<style>
    /* Custom responsive container for charts */
    .chart-container {
        position: relative;
        height: 300px; /* Set a fixed height for each chart container */
        width: 100%;
    }
    /* Optional: Improve card style */
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 1.5rem;
    }
    h5.card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Dashboard Overview</h3>

    <!-- Grid Layout -->
    <div class="row">

        <!-- Total Counts Chart -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Counts</h5>
                    <div class="chart-container">
                        <canvas id="totalCountChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart: Doctors by Specialization -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Doctors by Specialization</h5>
                    <div class="chart-container">
                        <canvas id="specializationPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Bar Chart: Top Specializations -->
        <div class="col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Top Specializations</h5>
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="topSpecializationsBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Scripts -->
<script>
    // Data passed from the controller
    const totalUsers = {{ $totalUsers }};
    const totalDoctors = {{ $totalDoctors }};
    const totalSpecializations = {{ $totalSpecializations }};
    const totalAppointments = {{ $totalAppointments }};

    const specializationCounts = @json($specializationCounts);
    const topSpecializations = @json($topSpecializations);

    // Total Counts Chart
    const totalCountChartCtx = document.getElementById('totalCountChart').getContext('2d');
    new Chart(totalCountChartCtx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Doctors', 'Specializations', 'Appointments'],
            datasets: [{
                label: 'Total Count',
                data: [totalUsers, totalDoctors, totalSpecializations, totalAppointments],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Total Counts Overview' }
            },
            scales: { 
                y: { beginAtZero: true, ticks: { precision: 0 } } 
            }
        }
    });

    // Pie Chart: Doctors by Specialization
    const specializationPieChartCtx = document.getElementById('specializationPieChart').getContext('2d');
    new Chart(specializationPieChartCtx, {
        type: 'pie',
        data: {
            labels: specializationCounts.map(item => item.name),
            datasets: [{
                label: 'Doctors Count',
                data: specializationCounts.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                title: { display: true, text: 'Doctors by Specialization' }
            }
        }
    });

    // Horizontal Bar Chart: Top Specializations
    const topSpecializationsBarChartCtx = document.getElementById('topSpecializationsBarChart').getContext('2d');
    new Chart(topSpecializationsBarChartCtx, {
        type: 'bar',
        data: {
            labels: topSpecializations.map(item => item.name),
            datasets: [{
                label: 'Number of Doctors',
                data: topSpecializations.map(item => item.count),
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal bar chart
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Top Specializations' }
            },
            scales: { 
                x: { beginAtZero: true, ticks: { precision: 0 } } 
            }
        }
    });
</script>
@endsection
