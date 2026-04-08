<h4 class="mb-3">Edit Anggota</h4>

<form method="POST" action="index.php?url=admin/updateUser" class="row g-3">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <div class="col-md-4">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Password Baru (opsional)</label>
        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak berubah">
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?url=admin/anggota" class="btn btn-secondary ms-2">Batal</a>
    </div>
</form>
