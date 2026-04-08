<h4 class="mb-3">Edit Transaksi</h4>

<form method="POST" action="index.php?url=admin/updateTransaksi" class="row g-3">
    <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">
    <div class="col-md-4">
        <label class="form-label">Nama Anggota</label>
        <select name="user_id" class="form-control" required>
            <?php while($u=$user->fetch_assoc()): ?>
                <option value="<?= $u['id'] ?>" <?= $transaksi['user_id'] == $u['id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['nama']) ?> (<?= htmlspecialchars($u['username']) ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Judul Buku</label>
        <select name="buku_id" class="form-control" required>
            <?php while($b=$buku->fetch_assoc()): ?>
                <option value="<?= $b['id'] ?>" <?= $transaksi['buku_id'] == $b['id'] ? 'selected' : '' ?>><?= htmlspecialchars($b['judul']) ?> - <?= htmlspecialchars($b['pengarang']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label">Tgl Pinjam</label>
        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= htmlspecialchars($transaksi['tanggal_pinjam']) ?>" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Jatuh Tempo</label>
        <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="<?= htmlspecialchars($transaksi['tanggal_jatuh_tempo']) ?>" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
            <option value="dipinjam" <?= $transaksi['status'] == 'dipinjam' ? 'selected' : '' ?>>dipinjam</option>
            <option value="dikembalikan" <?= $transaksi['status'] == 'dikembalikan' ? 'selected' : '' ?>>dikembalikan</option>
        </select>
    </div>
    <div class="col-md-2">
        <label class="form-label">Tgl Kembali</label>
        <input type="date" name="tanggal_kembali" class="form-control" value="<?= htmlspecialchars($transaksi['tanggal_kembali']) ?>">
    </div>
    <div class="col-md-2">
        <label class="form-label">Denda</label>
        <input type="number" name="denda" class="form-control" value="<?= htmlspecialchars($transaksi['denda']) ?>">
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?url=admin/transaksi" class="btn btn-secondary ms-2">Batal</a>
    </div>
</form>
