<?php
require_once "config/database.php";

class Buku extends Database {

    public function getAll(){
        return $this->conn->query("SELECT * FROM buku");
    }

    public function insert($data){
        $stmt = $this->conn->prepare(
            "INSERT INTO buku (judul,pengarang,penerbit,tahun,stok)
             VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param(
            "sssii",
            $data['judul'],
            $data['pengarang'],
            $data['penerbit'],
            $data['tahun'],
            $data['stok']
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
}