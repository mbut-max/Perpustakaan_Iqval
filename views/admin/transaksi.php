<h4 class="mb-3">Data Transaksi</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="POST" action="index.php?url=admin/tambahTransaksi" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nama Anggota</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Pilih anggota</option>
                    <?php foreach($user as $u): ?>
                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nama']) ?> (<?= htmlspecialchars($u['username']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Judul Buku</label>
                <select name="buku_id" class="form-control" required>
                    <option value="">Pilih buku</option>
                    <?php foreach($buku as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['judul']) ?> - <?= htmlspecialchars($b['pengarang']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tgl Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jatuh Tempo</label>
                <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="dipinjam">dipinjam</option>
                    <option value="dikembalikan">dikembalikan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Tgl Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Denda</label>
                <input type="number" name="denda" class="form-control" value="0">
            </div>
            <div class="col-md-2 align-self-end">
                <button class="btn btn-success w-100">Tambah Transaksi</button>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-striped">
<tr>
    <th>Nama</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Jatuh Tempo</th>
    <th>Tgl Kembali</th>
    <th>Status</th>
    <th>Denda</th>
    <th>Aksi</th>
</tr>

<?php while($row=$transaksi->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['nama']) ?></td>
    <td><?= htmlspecialchars($row['judul']) ?></td>
    <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
    <td><?= htmlspecialchars($row['tanggal_jatuh_tempo']) ?></td>
    <td><?= htmlspecialchars($row['tanggal_kembali'] ?? '') ?></td>
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
        <a href="index.php?url=admin/editTransaksi&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
        <a href="index.php?url=admin/hapusTransaksi&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>