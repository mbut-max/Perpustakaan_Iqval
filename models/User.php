<?php
require_once "config/database.php";

class User extends Database {

    public function login($username,$password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($user && password_verify($password,$user['password'])){
            return $user;
        }

        return false;
    }

    public function register($data){
        $nama = $data['nama'];
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Check if username already exists
        $checkStmt = $this->conn->prepare("SELECT id FROM users WHERE username=?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            return false; // Username already exists
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO users (nama,username,password,role) VALUES (?,?,?,'user')"
        );
        $stmt->bind_param("sss",$nama,$username,$password);
        return $stmt->execute();
    }

    public function insert($data){
        $nama = $data['nama'];
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $checkStmt = $this->conn->prepare("SELECT id FROM users WHERE username=?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            return false;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO users (nama,username,password,role) VALUES (?,?,?,'user')"
        );
        $stmt->bind_param("sss", $nama, $username, $password);
        return $stmt->execute();
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=? AND role='user'");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($data){
        $id = $data['id'];
        $nama = $data['nama'];
        $username = $data['username'];

        $user = $this->getById($id);
        if (!$user) {
            return false;
        }

        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare(
                "UPDATE users SET nama=?, username=?, password=? WHERE id=?"
            );
            $stmt->bind_param("sssi", $nama, $username, $password, $id);
        } else {
            $stmt = $this->conn->prepare(
                "UPDATE users SET nama=?, username=? WHERE id=?"
            );
            $stmt->bind_param("ssi", $nama, $username, $id);
        }

        return $stmt->execute();
    }

    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=? AND role='user'");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAll(){
        return $this->conn->query("SELECT * FROM users WHERE role='user'");
    }
}