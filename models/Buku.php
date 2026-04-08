<?php
require_once "config/database.php";

class Buku extends Database {

    public function getAll(){
        return $this->conn->query("SELECT * FROM buku");
    }

    public function insert($data){
        $stmt = $this->conn->prepare(
"INSERT INTO buku (judul,pengarang,penerbit,tahun,stok,genre,foto)
 VALUES (?,?,?,?,?,?,?)"
);

$stmt->bind_param(
"sssisss",
$data['judul'],
$data['pengarang'],
$data['penerbit'],
$data['tahun'],
$data['stok'],
$data['genre'],
$data['foto']
);
        return $stmt->execute();
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM buku WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($data){
        $stmt = $this->conn->prepare(
            "UPDATE buku SET judul=?, pengarang=?, penerbit=?, tahun=?, stok=?, genre=?, foto=? WHERE id=?"
        );
        $stmt->bind_param(
            "sssisssi",
            $data['judul'],
            $data['pengarang'],
            $data['penerbit'],
            $data['tahun'],
            $data['stok'],
            $data['genre'],
            $data['foto'],
            $data['id']
        );
        return $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM buku WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }

    public function search($keyword){
        $like = "%$keyword%";
        $stmt = $this->conn->prepare(
            "SELECT * FROM buku WHERE judul LIKE ? OR pengarang LIKE ?"
        );
        $stmt->bind_param("ss",$like,$like);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function getByGenre($genre){
    $stmt = $this->conn->prepare("SELECT * FROM buku WHERE genre=?");
    $stmt->bind_param("s",$genre);
    $stmt->execute();
    return $stmt->get_result();
}

public function getGenres(){
    return $this->conn->query("SELECT DISTINCT genre FROM buku");
}
public function addWishlist($user,$buku){
    $stmt = $this->conn->prepare(
    "INSERT IGNORE INTO wishlist (user_id,buku_id) VALUES (?,?)"
    );
    $stmt->bind_param("ii",$user,$buku);
    return $stmt->execute();
}

public function getWishlist($user){
    $stmt = $this->conn->prepare("
        SELECT b.* FROM wishlist w
        JOIN buku b ON w.buku_id=b.id
        WHERE w.user_id=?
    ");
    $stmt->bind_param("i",$user);
    $stmt->execute();
    return $stmt->get_result();
}

public function removeWishlist($user,$buku){
    $stmt = $this->conn->prepare(
        "DELETE FROM wishlist WHERE user_id=? AND buku_id=?"
    );
    $stmt->bind_param("ii", $user, $buku);
    return $stmt->execute();
}
}