@extends('layouts.main')

@section('content')
<!-- Pie Chart Library CSS & JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    body {
        background: linear-gradient(135deg, #f0f4f8, #e2e2e2);
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    .animate-card {
        transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .animate-card:hover {
        transform: scale(1.05);
        background-color: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .animate-card:active {
        transform: scale(0.95);
    }

    .card-icon {
        background-color: #007bff;
        padding: 12px;
        border-radius: 50%;
        font-size: 32px;
        color: white;
    }

    h6 {
        margin: 0;
        font-weight: bold;
        color: #333;
        line-height: 1.5;
    }

    .alert {
        margin-bottom: 20px;
        font-weight: bold;
        color: #4CAF50;
        border: 1px solid #4CAF50;
        background-color: #d4edda;
        border-radius: 8px;
        padding: 10px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .container-fluid {
        margin-top: 20px;
    }

    .section-dashboard {
        padding: 30px 20px;
        background-color: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body h5 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #007bff;
    }

    .card {
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
    }

    .col-lg-4 {
        display: flex;
        justify-content: center;
    }

    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .modal-body {
        padding: 20px;
        background-color: #f9f9f9;
    }

    table th {
        background-color: #007bff;
        color: white;
    }

    table tr:hover {
        background-color: #f1f1f1;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .modal-footer {
        padding: 15px;
    }

    .card-body {
        padding: 20px;
        background-color: #ffffff;
    }

    /* .blink {
        animation: blink-animation 1s steps(2, start) infinite;
        -webkit-animation: blink-animation 1s steps(2, start) infinite;
    }

    @keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }

    @-webkit-keyframes blink-animation {
        to {
            visibility: hidden;
        }
    } */

</style>

<section class="section-dashboard">
    <br>
    <h5 class="card-title text-center" style="font-size: 35px; font-weight: 700; letter-spacing: 2px;">
            Dashboard Risk & Opportunity Register
    </h5>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <form method="GET" action="{{ route('dashboard.index') }}">
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manajemen')
                <div class="form-group">
                    <label for="departemen">Filter by Departemen:</label>
                    <select name="departemen" id="departemen" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Select Departemen --</option>
                        @foreach($departemenList as $departemen)
                            <option value="{{ $departemen }}" {{ $selectedDepartemen == $departemen ? 'selected' : '' }}>
                                {{ $departemen }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </form>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }} {{ Auth::user()->nama_user }} 👋
                </div>
            @endif

            <div id="highRiskDescription" class="alert mt-3 fw-bold fs-5 text-center" role="alert"></div>

            <!-- Status Pie Chart -->
            <div class="col-lg-4">
                <div class="card animate-card">
                    <div class="card-body">
                        <h5>Status Risiko</h5>
                        <canvas id="statusPieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tingkatan Pie Chart -->
            <div class="col-lg-4">
                <div class="card animate-card">
                    <div class="card-body">
                        <h5>Tingkatan Risiko / Peluang</h5>
                        <canvas id="tingkatanPieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Status Bar Chart -->
            <div class="col-lg-6 mt-4">
                <div class="card animate-card">
                    <div class="card-body">
                        <h5>Status Risiko (Bar Chart)</h5>
                        <canvas id="statusBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tingkatan Bar Chart -->
            <div class="col-lg-6 mt-4">
                <div class="card animate-card">
                    <div class="card-body">
                        <h5>Tingkatan Risiko (Bar Chart)</h5>
                        <canvas id="tingkatanBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Table with status details -->
                    <table class="table table-striped">
                        <tbody>
                            @foreach($statusDetails as $status => $details)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $status }}</td>
                                    <td>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Issue</th>
                                                    <th>Resiko</th>
                                                    <th>Peluang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($details as $index => $resiko)
                                                    <tr data-id="{{ $resiko->id_divisi }}" onclick="navigateToRiskRegister(this)">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $resiko->nama_issue }}</td>
                                                        <td>{{ $resiko->nama_resiko }}</td>
                                                        <td>{{ $resiko->peluang }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tingkatan Modal -->
    <div class="modal fade" id="tingkatanModal" tabindex="-1" aria-labelledby="tingkatanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Table with tingkatan details -->
                    <table class="table table-striped">
                        <tbody>
                            @foreach($tingkatanDetails as $tingkatan => $details)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tingkatan }}</td>
                                    <td>
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Issue</th>
                                                    <th>Resiko</th>
                                                    <th>Peluang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($details as $index => $resiko)
                                                    <tr data-id="{{ $resiko->id_divisi }}" onclick="navigateToRiskRegister(this)">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <a href="{{ route('riskregister.tablerisk', ['id' => $resiko->id_divisi]) }}">{{ $resiko->nama_issue }}</a>
                                                        </td>
                                                        <td>{{ $resiko->nama_resiko }}</td>
                                                        <td>{{ $resiko->peluang }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusDetails = @json($statusDetails);
        const tingkatanDetails = @json($tingkatanDetails);

        // Peta warna status
const statusColorMap = {
    'CLOSE': '#32CD32',         // Hijau
    'ON PROGRES': '#FFD700',   // Kuning
    'OPEN': '#FF6347'           // Merah

};

const statusLabels = @json($statusCounts->keys());
const statusColors = statusLabels.map(label => statusColorMap[label.toUpperCase()] || 'rgb(204, 204, 204)');

// Status Pie Chart
const statusPieChart = new Chart(document.getElementById('statusPieChart'), {
    type: 'pie',
    data: {
        labels: statusLabels,
        datasets: [{
            data: @json($statusCounts->values()),
            backgroundColor: statusColors
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        let total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let value = tooltipItem.raw;
                        let percentage = ((value / total) * 100).toFixed(2) + '%';
                        return tooltipItem.label + ': ' + value + ' (' + percentage + ')';
                    }
                }
            }
        },
        onClick: (event, elements) => {
            if (elements.length > 0) {
                const segmentIndex = elements[0].index;
                const selectedStatus = statusPieChart.data.labels[segmentIndex];
                fetchFilteredData('status', selectedStatus);
            }
        }
    }

});

function tampilkanDeskripsiHighRisk(tingkatanDetails) {
    let jumlahHigh = 0;

    for (const [tingkatan, resikoList] of Object.entries(tingkatanDetails)) {
        if (tingkatan.toUpperCase() === 'HIGH') {
            jumlahHigh += resikoList.length;
        }
    }

    const deskripsiDiv = document.getElementById('highRiskDescription');

    if (jumlahHigh > 3) {
        deskripsiDiv.classList.add('alert-danger', 'blink');
        deskripsiDiv.classList.remove('alert-success');
        deskripsiDiv.textContent = '⚠️ Perusahaan dalam kondisi berbahaya! Segera selesaikan Risiko dengan Tingkatan High.';
    } else {
        deskripsiDiv.classList.add('alert-success');
        deskripsiDiv.classList.remove('alert-danger', 'blink');
        deskripsiDiv.textContent = '😊 Perusahaan dalam kondisi normal. Tetap selesaikan risiko yang ada.';
    }
}

// Panggil fungsi setelah DOM dan data tersedia
tampilkanDeskripsiHighRisk(tingkatanDetails);


        // Tingkatan Pie Chart
        @php
    $colorMap = [
        'LOW' => '#32CD32',
        'MEDIUM' => '#FFD700',
        'HIGH' => '#FF6347',
    ];

    $labels = $tingkatanCounts->keys();
    $colors = $labels->map(fn($label) => $colorMap[$label] ?? '#CCCCCC');
@endphp

const tingkatanPieChart = new Chart(document.getElementById('tingkatanPieChart'), {
    type: 'pie',
    data: {
        labels: @json($labels),
        datasets: [{
            data: @json($tingkatanCounts->values()),
            backgroundColor: @json($colors)
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    // Show percentage and count in tooltip
                    label: function(tooltipItem) {
                        let total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let value = tooltipItem.raw;
                        let percentage = ((value / total) * 100).toFixed(2) + '%';
                        let count = value;
                        return tooltipItem.label + ': ' + count + ' (' + percentage + ')';
                    }
                }
            }
        },
        onClick: (event, elements) => {
            if (elements.length > 0) {
                const segmentIndex = elements[0].index;
                const selectedTingkatan = tingkatanPieChart.data.labels[segmentIndex];
                fetchFilteredData('tingkatan', selectedTingkatan);
            }
        }
    }
});


        // **Bar Chart Status**
        @php
 $tingkatanColorMap = [
    'HIGH' => ['bg' => 'rgb(255, 99, 71)', 'border' => 'rgb(178, 34, 34)'],        // Merah
    'MEDIUM' => ['bg' => 'rgb(255, 215, 0)', 'border' => 'rgb(184, 134, 11)'],     // Kuning
    'LOW' => ['bg' => 'rgb(50, 205, 50)', 'border' => 'rgb(34, 139, 34)'],         // Hijau
];

$statusColorMap = [
    'OPEN' => ['bg' => 'rgb(255, 99, 71)', 'border' => 'rgb(178, 34, 34)'],        // Merah
    'ON PROGRES' => ['bg' => 'rgb(255, 215, 0)', 'border' => 'rgb(184, 134, 11)'],// Kuning
    'CLOSE' => ['bg' => 'rgb(50, 205, 50)', 'border' => 'rgb(34, 139, 34)'],       // Hijau
];



    // Generate warna berdasarkan label yang muncul
    $tingkatanLabels = $tingkatanCounts->keys();
    $tingkatanBackground = $tingkatanLabels->map(fn($t) => $tingkatanColorMap[$t]['bg'] ?? '#CCCCCC');
    $tingkatanBorder = $tingkatanLabels->map(fn($t) => $tingkatanColorMap[$t]['border'] ?? '#999999');

    $statusLabels = $statusCounts->keys();
    $statusBackground = $statusLabels->map(fn($s) => $statusColorMap[$s]['bg'] ?? '#CCCCCC');
    $statusBorder = $statusLabels->map(fn($s) => $statusColorMap[$s]['border'] ?? '#999999');
@endphp

   // **Bar Chart Status**
new Chart(document.getElementById('statusBarChart'), {
    type: 'bar',
    data: {
        labels: @json($statusLabels),
        datasets: [{
            label: 'Jumlah Status Risiko',
            data: @json($statusCounts->values()),
            backgroundColor: @json($statusBackground),
            borderColor: @json($statusBorder),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// **Bar Chart Tingkatan**
new Chart(document.getElementById('tingkatanBarChart'), {
    type: 'bar',
    data: {
        labels: @json($tingkatanLabels),
        datasets: [{
            label: 'Jumlah Tingkatan Risiko',
            data: @json($tingkatanCounts->values()),
            backgroundColor: @json($tingkatanBackground),
            borderColor: @json($tingkatanBorder),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});


        // Fetch data based on filters
        function fetchFilteredData(filterType, filterValue) {
            let filteredData = [];
            if (filterType === 'status') {
                filteredData = statusDetails[filterValue] || [];
            } else if (filterType === 'tingkatan') {
                filteredData = tingkatanDetails[filterValue] || [];
            }
            displayDataInModal(filteredData, filterType, filterValue);
        }

        // Navigate to RiskRegister
        function navigateToRiskRegister(row) {
            const idDivisi = row.getAttribute('data-id');
            if (idDivisi) {
                window.location.href = `/riskregister/${id}`;
            }
        }

        function displayDataInModal(data, filterType, filterValue) {
            const modalId = filterType === 'status' ? '#statusModal' : '#tingkatanModal';
            const modalBody = document.querySelector(`${modalId} .modal-body`);
            modalBody.innerHTML = `
                <h5>${filterType === 'status' ? 'Status Data' : 'Tingkatan Data'} - ${filterValue}</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Issue</th>
                            <th>Risiko</th>
                            <th>Peluang</th>
                            <th>Departement</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.map((resiko, index) => `
                            <tr data-id="${resiko.idDivisi}">
                                <td>${index + 1}</td>
                                <td>
                                    <a href="/riskregister/${resiko.id_divisi}?keyword=${encodeURIComponent(resiko.nama_issue)}">
                                        ${resiko.nama_issue}
                                    </a>
                                </td>
                                <td>${resiko.nama_resiko}</td>
                                <td>${resiko.peluang}</td>
                                <td>${resiko.nama_divisi}</td>
                            </tr>`).join('')}
                    </tbody>
                </table>
            `;
            $(modalId).modal('show'); // Show modal
        }
    });
</script>
@endsection
