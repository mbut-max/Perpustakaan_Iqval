<h4 class="mb-3">Data Buku</h4>

<form method="POST" class="mb-3 d-flex">
    <input type="text" name="keyword" class="form-control me-2" placeholder="Cari judul / pengarang">
    <button name="cari" class="btn btn-primary">Cari</button>
</form>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="POST" action="index.php?url=admin/tambahBuku" enctype="multipart/form-data">
            <div class="row g-3 align-items-end">
                <div class="col-md-3"><input name="judul" class="form-control" placeholder="Judul" required></div>
                <div class="col-md-3"><input name="pengarang" class="form-control" placeholder="Pengarang" required></div>
                <div class="col-md-2"><input name="penerbit" class="form-control" placeholder="Penerbit" required></div>
                <div class="col-md-1"><input name="tahun" type="number" class="form-control" placeholder="Tahun" required></div>
                <div class="col-md-1"><input name="stok" type="number" class="form-control" placeholder="Stok" required></div>
                <div class="col-md-2"><select name="genre" class="form-control" required>
                    <option>Teknologi</option>
                    <option>Novel</option>
                    <option>Sains</option>
                    <option>Sejarah</option>
                    <option>Motivasi</option>
                    <option>Bisnis</option>
                </select></div>
                <div class="col-md-2"><input type="file" name="foto" class="form-control" required></div>
                <div class="col-md-1"><button class="btn btn-success">Tambah</button></div>
            </div>
        </form>
    </div>
</div>

<table class="table table-bordered table-striped">
<tr>
    <th>Judul</th>
    <th>Pengarang</th>
    <th>Penerbit</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>
<?php while($row=$buku->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['judul']) ?></td>
    <td><?= htmlspecialchars($row['pengarang']) ?></td>
    <td><?= htmlspecialchars($row['penerbit']) ?></td>
    <td><?= htmlspecialchars($row['tahun']) ?></td>
    <td>
        <?php if($row['stok'] <= 0): ?>
            <span class="badge bg-danger">Habis</span>
        <?php else: ?>
            <span class="badge bg-success"><?= htmlspecialchars($row['stok']) ?></span>
        <?php endif; ?>
    </td>
    <td>
        <a href="index.php?url=admin/editBuku&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
        <a href="index.php?url=admin/hapusBuku&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>
</table>