<h4 class="mb-3">Data Anggota</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="POST" action="index.php?url=admin/tambahUser" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="nama" class="form-control" placeholder="Nama" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-md-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success w-100">Tambah Anggota</button>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-striped">
<tr>
    <th>Nama</th>
    <th>Username</th>
    <th>Aksi</th>
</tr>

<?php while($row=$user->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['nama']) ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td>
        <a href="index.php?url=admin/editUser&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
        <a href="index.php?url=admin/hapusUser&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>