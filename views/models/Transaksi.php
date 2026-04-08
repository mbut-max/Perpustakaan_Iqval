<?php
require_once "config/database.php";

class Transaksi extends Database {

    private $dendaPerHari = 1000;
    private $lamaPinjam = 7;

    public function statistik(){

    $totalBuku = $this->conn->query("SELECT COUNT(*) as total FROM buku")->fetch_assoc();
    $totalUser = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role='user'")->fetch_assoc();
    $aktif = $this->conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status='dipinjam'")->fetch_assoc();
    $denda = $this->conn->query("SELECT SUM(denda) as total FROM transaksi")->fetch_assoc();

    return [
        'buku' => $totalBuku['total'],
        'user' => $totalUser['total'],
        'aktif' => $aktif['total'],
        'denda' => $denda['total'] ?? 0
    ];
}
public function statistikUser($user){
    $total = $this->conn->query("
        SELECT COUNT(*) as total 
        FROM transaksi 
        WHERE user_id=$user
    ")->fetch_assoc();

    $denda = $this->conn->query("
        SELECT SUM(denda) as total 
        FROM transaksi 
        WHERE user_id=$user
    ")->fetch_assoc();

    return [
        'total'=>$total['total'],
        'denda'=>$denda['total'] ?? 0
    ];
}

    public function pinjam($user,$buku){

        $tglPinjam = date('Y-m-d');
        $jatuhTempo = date('Y-m-d', strtotime("+$this->lamaPinjam days"));

        $stmt = $this->conn->prepare(
            "INSERT INTO transaksi 
            (user_id,buku_id,tanggal_pinjam,tanggal_jatuh_tempo,status,denda)
            VALUES (?,?,?,?, 'dipinjam',0)"
        );

        $stmt->bind_param("iiss",$user,$buku,$tglPinjam,$jatuhTempo);
        $stmt->execute();

        $this->conn->query("UPDATE buku SET stok=stok-1 WHERE id=$buku");
    }

    public function kembali($id){

        $today = date('Y-m-d');

        $stmt = $this->conn->prepare(
            "SELECT tanggal_jatuh_tempo,buku_id FROM transaksi WHERE id=?"
        );
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $denda = 0;

        if($today > $result['tanggal_jatuh_tempo']){
            $selisih = (strtotime($today)-strtotime($result['tanggal_jatuh_tempo']))/86400;
            $denda = $selisih * $this->dendaPerHari;
        }

        $stmt = $this->conn->prepare(
            "UPDATE transaksi 
             SET tanggal_kembali=?, status='dikembalikan', denda=? 
             WHERE id=?"
        );
        $stmt->bind_param("sii",$today,$denda,$id);
        $stmt->execute();

        $this->conn->query("UPDATE buku SET stok=stok+1 WHERE id=".$result['buku_id']);
    }
}