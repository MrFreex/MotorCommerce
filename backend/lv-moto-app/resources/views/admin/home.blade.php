@extends("admin.adminpage")
@section("title")
    Home
@endsection

@section("content")
    <h1>Overview</h1>
    <p>
        In this page you can find some useful information about your website.
    </p>

    <div class="data-cards">
        <div class="data-card">
            <p>Registered Users</p>
            <h2>{{ $countUsers }}</h2>
        </div>
        <div class="data-card" style="background: linear-gradient(45deg, #485dd3, #1540ff)">
            <p>Staff Members</p>
            <h2>{{ $countAdmins }}</h2>
        </div>
    </div>

    <div class="float-el">
        <h2>Website Statistics</h2>
        <div class="charts">
            <div class="chart-grid">
                <canvas id="chart-1"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('chart-1').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true
            }
        });
    </script>
@endsection