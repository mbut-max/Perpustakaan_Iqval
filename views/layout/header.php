<!DOCTYPE html>
<?php
function formatRupiahShort($amount) {
    $amount = intval($amount);

    if ($amount >= 1000) {
        $kValue = $amount / 1000;
        if (floor($kValue) == $kValue) {
            return 'Rp ' . intval($kValue) . 'k';
        }
        return 'Rp ' . rtrim(rtrim(number_format($kValue, 1, '.', ''), '0'), '.') . 'k';
    }

    return 'Rp ' . number_format($amount, 0, ',', '.');
}
?>
<html>
<head>
<title>Perpustakaan Cyberpunk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php if(isset($_SESSION['user'])): ?>
<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="logo">CYBERLIB</h4>

        <?php if($_SESSION['user']['role']=='admin'): ?>
            <a href="index.php?url=admin/dashboard">Dashboard</a>
            <a href="index.php?url=admin/buku">Kelola Buku</a>
            <a href="index.php?url=admin/anggota">Kelola Anggota</a>
            <a href="index.php?url=admin/transaksi">Transaksi</a>
        <?php else: ?>
            <a href="index.php?url=user/dashboard">Dashboard</a>
            <a href="index.php?url=user/transaksi">Transaksi Saya</a>
            <a href="index.php?url=user/wishlist">Wishlist</a>
        <?php endif; ?>

        <a href="index.php?url=auth/logout" class="logout">Logout</a>
    </div>

    <div class="cyber-grid"></div>


    <!-- CONTENT -->
    <div class="content">
<?php else: ?>
<div class="content-full">
<?php endif; ?>