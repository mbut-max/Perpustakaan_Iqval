<h3 class="glitch mb-4" data-text="WISHLIST">
WISHLIST
</h3>

<?php if($wishlist && $wishlist->num_rows > 0): ?>
<div class="row">
    <?php while($b = $wishlist->fetch_assoc()): ?>
    <div class="col-md-3 mb-4">
        <div class="card p-2 text-center">
            <img src="assets/img/<?= htmlspecialchars($b['foto']) ?>" 
                 class="img-fluid mb-2"
                 style="height:200px; object-fit:cover;">

            <h6><?= htmlspecialchars($b['judul']) ?></h6>
            <small><?= htmlspecialchars($b['genre']) ?></small>

            <p class="mt-2">
                Stok:
                <?php if($b['stok'] > 0): ?>
                    <span class="badge bg-success"><?= htmlspecialchars($b['stok']) ?></span>
                <?php else: ?>
                    <span class="badge bg-danger">Habis</span>
                <?php endif; ?>
            </p>

            <div class="d-grid gap-2 mt-3">
                <?php if($b['stok'] > 0): ?>
                <button type="button" class="btn btn-success btn-sm w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#pinjamModal<?= $b['id'] ?>">
                    Pinjam Buku
                </button>
                <?php endif; ?>

                <form method="POST" action="index.php?url=user/removeWishlist">
                    <input type="hidden" name="buku" value="<?= $b['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm w-100">Hapus dari Wishlist</button>
                </form>
            </div>
        </div>
    </div>

    <?php if($b['stok'] > 0): ?>
    <div class="modal fade" id="pinjamModal<?= $b['id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content cyber-modal">

          <div class="modal-header">
            <h5 class="modal-title">Pinjam Buku</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <form method="POST" action="index.php?url=user/pinjam">
            <input type="hidden" name="buku" value="<?= $b['id'] ?>">
            <input type="hidden" name="from_wishlist" value="1">
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

    <?php endwhile; ?>
</div>
<?php else: ?>
<div class="alert alert-info">
    Wishlist Anda masih kosong.
</div>
<?php endif; ?>
