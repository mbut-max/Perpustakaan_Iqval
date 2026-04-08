<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<h3 class="mb-4 glitch" data-text="ADMIN CONTROL PANEL">
ADMIN CONTROL PANEL
</h3>
<div class="card mt-4 p-3">
    <canvas id="statChart"></canvas>
</div>

<script>
const ctx = document.getElementById('statChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Buku','Anggota','Aktif'],
        datasets: [{
            label: 'Statistik Sistem',
            data: [
                <?= $stat['buku'] ?>,
                <?= $stat['user'] ?>,
                <?= $stat['aktif'] ?>
            ],
            borderColor: '#00ffff',
            backgroundColor: [
                'rgba(0,255,255,0.5)',
                'rgba(255,0,255,0.5)',
                'rgba(0,255,153,0.5)'
            ]
        }]
    },
    options: {
        plugins:{
            legend:{ labels:{ color:'#fff' } }
        },
        scales:{
            x:{ ticks:{ color:'#fff' } },
            y:{ ticks:{ color:'#fff' } }
        }
    }
});
</script>

<div class="row">

<div class="col-md-3">
<div class="card shadow text-center">
<div class="card-body">
<h6>Total Buku</h6>
<h3><?= $stat['buku'] ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center">
<div class="card-body">
<h6>Total Anggota</h6>
<h3><?= $stat['user'] ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center">
<div class="card-body">
<h6>Transaksi Aktif</h6>
<h3><?= $stat['aktif'] ?></h3>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card shadow text-center bg-danger text-white">
<div class="card-body">
<h6>Total Denda</h6>
<h3><?= formatRupiahShort($stat['denda']) ?></h3>
</div>
</div>
</div>

</div>