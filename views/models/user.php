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

        $stmt = $this->conn->prepare(
            "INSERT INTO users (nama,username,password,role) VALUES (?,?,?,'user')"
        );
        $stmt->bind_param("sss",$nama,$username,$password);
        return $stmt->execute();
    }

    public function getAll(){
        return $this->conn->query("SELECT * FROM users WHERE role='user'");
    }
}