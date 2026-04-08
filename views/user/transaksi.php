<h4 class="mb-3">Transaksi Saya</h4>

<table class="table table-bordered">
<tr>
    <th>Buku</th>
    <th>Pinjam</th>
    <th>Jatuh Tempo</th>
    <th>Status</th>
    <th>Denda</th>
    <th>Aksi</th>
</tr>

<?php foreach($transaksi as $row): ?>
<tr>
    <td><?= $row['judul'] ?></td>
    <td><?= $row['tanggal_pinjam'] ?></td>
    <td><?= $row['tanggal_jatuh_tempo'] ?></td>
    <td>
        <?php if($row['status']=='dipinjam'): ?>
            <span class="badge bg-warning">Dipinjam</span>
        <?php else: ?>
            <span class="badge bg-success">Dikembalikan</span>
        <?php endif; ?>
    </td>
    <td>
        <?php if($row['denda'] > 0): ?>
            <span class="badge bg-danger"><?= formatRupiahShort($row['denda']) ?></span>
        <?php else: ?>
            <span class="badge bg-secondary">-</span>
        <?php endif; ?>
    </td>
    <td>
        <?php if($row['status']=='dipinjam'): ?>
            <button type="button" class="btn btn-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#kembaliModal<?= $row['id'] ?>">
                Kembalikan
            </button>
<div class="modal fade" id="kembaliModal<?= $row['id'] ?>">
  <div class="modal-dialog">
    <div class="modal-content cyber-modal">

      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Pengembalian</h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <p>Buku:</p>
        <h5 class="text-warning"><?= $row['judul'] ?></h5>

        <?php
        $today = date('Y-m-d');
        $dendaPreview = 0;

        if($today > $row['tanggal_jatuh_tempo']){
            $selisih = (strtotime($today) - strtotime($row['tanggal_jatuh_tempo']))/86400;
            $dendaPreview = $selisih * 1000;
        }
        ?>

        <?php if($dendaPreview > 0): ?>
            <p class="text-danger">
            Denda sementara: <?= formatRupiahShort($dendaPreview) ?>
            </p>
        <?php else: ?>
            <p class="text-success">Tidak ada denda</p>
        <?php endif; ?>

      </div>

      <div class="modal-footer">
        <form method="POST" action="index.php?url=user/kembali">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button type="submit" class="btn btn-danger">
            Ya, Kembalikan
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>