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

    public function statistikUser($userId){
        $totalPinjam = $this->conn->query("SELECT COUNT(*) as total FROM transaksi WHERE user_id=$userId")->fetch_assoc();
        $totalKembali = $this->conn->query("SELECT COUNT(*) as total FROM transaksi WHERE user_id=$userId AND status='dikembalikan'")->fetch_assoc();
        $aktif = $this->conn->query("SELECT COUNT(*) as total FROM transaksi WHERE user_id=$userId AND status='dipinjam'")->fetch_assoc();
        $denda = $this->conn->query("SELECT SUM(denda) as total FROM transaksi WHERE user_id=$userId")->fetch_assoc();

        return [
            'total_pinjam' => $totalPinjam['total'],
            'total_kembali' => $totalKembali['total'],
            'aktif' => $aktif['total'],
            'denda' => $denda['total'] ?? 0
        ];
    }

    public function pinjam($user,$buku,$tglPinjam = null,$jatuhTempo = null){

        $tglPinjam = $tglPinjam ?: date('Y-m-d');
        $jatuhTempo = $jatuhTempo ?: date('Y-m-d', strtotime("+$this->lamaPinjam days"));

        $stmt = $this->conn->prepare(
            "INSERT INTO transaksi 
            (user_id,buku_id,tanggal_pinjam,tanggal_jatuh_tempo,status,denda)
            VALUES (?,?,?,?, 'dipinjam',0)"
        );

        $stmt->bind_param("iiss",$user,$buku,$tglPinjam,$jatuhTempo);
        $stmt->execute();

        $this->conn->query("UPDATE buku SET stok=stok-1 WHERE id=" . intval($buku));
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

    public function getByUser($userId){
        $stmt = $this->conn->prepare(
            "SELECT t.*, b.judul, b.pengarang 
             FROM transaksi t 
             JOIN buku b ON t.buku_id = b.id 
             WHERE t.user_id = ? 
             ORDER BY t.tanggal_pinjam DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll(){
        return $this->conn->query("SELECT t.*, b.judul, u.nama FROM transaksi t JOIN buku b ON t.buku_id = b.id JOIN users u ON t.user_id = u.id ORDER BY t.id DESC");
    }

    public function getById($id){
        $stmt = $this->conn->prepare(
            "SELECT t.*, b.judul, u.nama FROM transaksi t JOIN buku b ON t.buku_id = b.id JOIN users u ON t.user_id = u.id WHERE t.id=?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($data){
        $tanggal_kembali = !empty($data['tanggal_kembali']) ? $data['tanggal_kembali'] : null;
        $status = $data['status'];
        $denda = isset($data['denda']) ? intval($data['denda']) : 0;

        $stmt = $this->conn->prepare(
            "INSERT INTO transaksi (user_id,buku_id,tanggal_pinjam,tanggal_jatuh_tempo,tanggal_kembali,status,denda) VALUES (?,?,?,?,?,?,?)"
        );
        $stmt->bind_param(
            "iissssi",
            $data['user_id'],
            $data['buku_id'],
            $data['tanggal_pinjam'],
            $data['tanggal_jatuh_tempo'],
            $tanggal_kembali,
            $status,
            $denda
        );

        return $stmt->execute();
    }

    public function update($data){
        $tanggal_kembali = !empty($data['tanggal_kembali']) ? $data['tanggal_kembali'] : null;
        $denda = isset($data['denda']) ? intval($data['denda']) : 0;

        $stmt = $this->conn->prepare(
            "UPDATE transaksi SET user_id=?, buku_id=?, tanggal_pinjam=?, tanggal_jatuh_tempo=?, tanggal_kembali=?, status=?, denda=? WHERE id=?"
        );
        $stmt->bind_param(
            "iissssii",
            $data['user_id'],
            $data['buku_id'],
            $data['tanggal_pinjam'],
            $data['tanggal_jatuh_tempo'],
            $tanggal_kembali,
            $data['status'],
            $denda,
            $data['id']
        );

        return $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM transaksi WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

public function kembaliUser($id,$userId){

        // Pastikan transaksi milik user
        $stmt = $this->conn->prepare("
            SELECT tanggal_jatuh_tempo,buku_id 
            FROM transaksi 
            WHERE id=? AND user_id=? AND status='dipinjam'
        ");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        if (!$data) {
            return false;
        }

        $today = date('Y-m-d');
        $denda = 0;

        if ($today > $data['tanggal_jatuh_tempo']) {
            $selisih = (strtotime($today) - strtotime($data['tanggal_jatuh_tempo'])) / 86400;
            $denda = intval($selisih * $this->dendaPerHari);
        }

        $stmt = $this->conn->prepare("
            UPDATE transaksi 
            SET tanggal_kembali=?, status='dikembalikan', denda=? 
            WHERE id=? AND user_id=?
        ");
        $stmt->bind_param("siii", $today, $denda, $id, $userId);
        $updated = $stmt->execute();

        if ($updated) {
            $this->conn->query("UPDATE buku SET stok=stok+1 WHERE id=" . intval($data['buku_id']));
            return true;
        }

        return false;
    }
    }