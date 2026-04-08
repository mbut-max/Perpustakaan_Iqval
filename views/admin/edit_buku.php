<h4 class="mb-3">Edit Data Buku</h4>

<form method="POST" action="index.php?url=admin/updateBuku" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $buku['id'] ?>">
    <input type="hidden" name="current_foto" value="<?= $buku['foto'] ?>">

    <div class="row gy-3">
        <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($buku['judul']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Pengarang</label>
            <input type="text" name="pengarang" class="form-control" value="<?= htmlspecialchars($buku['pengarang']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($buku['tahun']) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($buku['stok']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Genre</label>
            <select name="genre" class="form-control" required>
                <option <?= $buku['genre'] === 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                <option <?= $buku['genre'] === 'Novel' ? 'selected' : '' ?>>Novel</option>
                <option <?= $buku['genre'] === 'Sains' ? 'selected' : '' ?>>Sains</option>
                <option <?= $buku['genre'] === 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                <option <?= $buku['genre'] === 'Motivasi' ? 'selected' : '' ?>>Motivasi</option>
                <option <?= $buku['genre'] === 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Foto Baru (opsional)</label>
            <input type="file" name="foto" class="form-control">
            <?php if (!empty($buku['foto'])): ?>
                <small class="text-muted">Foto saat ini: <?= htmlspecialchars($buku['foto']) ?></small>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?url=admin/buku" class="btn btn-secondary ms-2">Batal</a>
    </div>
</form>
