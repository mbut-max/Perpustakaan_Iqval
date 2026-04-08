<div class="row justify-content-center">
<div class="col-md-4">
<div class="card shadow">
<div class="card-body">
<h4 class="text-center">Register</h4>
<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger">
    <?= $_SESSION['error'] ?>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
<form method="POST" action="index.php?url=auth/simpan">
<input name="nama" class="form-control mb-2" placeholder="Nama" required>
<input name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<button class="btn btn-success w-100">Daftar</button>
</form>
</div>
</div>
</div>
</div>