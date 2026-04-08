<div class="row justify-content-center">
<div class="col-md-4">
<div class="card shadow">
<div class="card-body">
<h4 class="text-center">Login</h4>
<?php if(isset($_SESSION['error'])): ?>
<div class="alert alert-danger">
    <?= $_SESSION['error'] ?>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>
<form method="POST" action="index.php?url=auth/proses">
<input name="username" class="form-control mb-2" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
<button class="btn btn-primary w-100">Login</button>
<a href="index.php?url=auth/register" class="d-block text-center mt-2">Daftar</a>
</form>
</div>
</div>
</div>
</div>