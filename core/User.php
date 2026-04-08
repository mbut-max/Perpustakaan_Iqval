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
        $password = md5($data['password']);
        return $this->conn->query("INSERT INTO users (nama,username,password) VALUES ('$nama','$username','$password')");
    }

    public function getAll(){
        return $this->conn->query("SELECT * FROM users WHERE role='user'");
    }
}