<h3 class="glitch mb-4" data-text="USER DASHBOARD">
USER DASHBOARD
</h3>
<h5 class="mt-5">🎯 Rekomendasi Untuk Anda</h5>
<div class="row">
<?php if(isset($rekomendasi)): 
while($r=$rekomendasi->fetch_assoc()): ?>
<div class="col-md-3 mb-3">
<div class="card p-2 text-center">
<img src="assets/img/<?= $r['foto'] ?>" 
style="height:150px; object-fit:cover;">
<h6><?= $r['judul'] ?></h6>
</div>
</div>
<?php endwhile; endif; ?>
</div>

<form method="POST" class="mb-4">
    <select name="genre" class="form-control w-25 d-inline">
        <option value="">Semua Genre</option>
        <?php while($g=$genres->fetch_assoc()): ?>
            <option value="<?= $g['genre'] ?>">
                <?= $g['genre'] ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button class="btn btn-primary">Filter</button>
</form>

<div class="row">
<?php while($b=$buku->fetch_assoc()): ?>

<div class="col-md-3 mb-4">
    <div class="card p-2 text-center">

        <img src="assets/img/<?= $b['foto'] ?>" 
             class="img-fluid mb-2"
             style="height:200px; object-fit:cover;">

        <h6><?= $b['judul'] ?></h6>
        <small><?= $b['genre'] ?></small>

        <p class="mt-2">
            Stok:
            <?php if($b['stok'] > 0): ?>
                <span class="badge bg-success"><?= $b['stok'] ?></span>
            <?php else: ?>
                <span class="badge bg-danger">Habis</span>
            <?php endif; ?>
        </p>

        <div class="d-grid gap-2">
            <?php if($b['stok'] > 0): ?>
            <button type="button" class="btn btn-success btn-sm w-100" 
                    data-bs-toggle="modal" 
                    data-bs-target="#pinjamModal<?= $b['id'] ?>">
                Pinjam Buku
            </button>
            <?php endif; ?>

            <form method="POST" action="index.php?url=user/wishlist">
                <input type="hidden" name="buku" value="<?= $b['id'] ?>">
                <button type="submit" class="btn btn-warning btn-sm w-100">
                    ❤️ Wishlist
                </button>
            </form>
        </div>

        <?php if($b['stok'] > 0): ?>
        <div class="modal fade" id="pinjamModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content cyber-modal">

              <div class="modal-header">
                <h5 class="modal-title">Form Peminjaman Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <form method="POST" action="index.php?url=user/pinjam">
              <input type="hidden" name="buku" value="<?= $b['id'] ?>">
              <div class="modal-body text-start">
                <p>Nama buku: <strong><?= htmlspecialchars($b['judul']) ?></strong></p>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="alert alert-warning mb-0">
                    Jika terlambat mengumpulkan, denda Rp 1000/hari akan dikenakan.
                </div>
              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success">Ya, Pinjam</button>
              </div>
              </form>

            </div>
          </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php endwhile; ?>
</div>
<div class="card mt-4 p-3">
<canvas id="userChart"></canvas>
</div>

<script>
new Chart(document.getElementById('userChart'),{
type:'doughnut',
data:{
labels:['Total Pinjam','Total Denda'],
datasets:[{
data:[
<?= $statUser['total'] ?>,
<?= $statUser['denda'] ?>
],
backgroundColor:[
'rgba(0,255,255,0.7)',
'rgba(255,0,85,0.7)'
]
}]
},
options:{
plugins:{ legend:{ labels:{ color:'#fff' } } }
}
});
</script>