<?php
require_once BASEPATH . "core/Controller.php";

class UserController extends Controller {

    public function dashboard(){
        $data['statUser'] = 
        $this->model('Transaksi')
             ->statistikUser($_SESSION['user']['id']);
        $userGenre = $_SESSION['user']['genre_favorit'];

        if($userGenre){
            $data['rekomendasi'] = 
                $this->model('Buku')->getByGenre($userGenre);
        }

        $bukuModel = $this->model('Buku');

        if(isset($_POST['genre'])){
            $data['buku'] = $bukuModel->getByGenre($_POST['genre']);
        }else{
            $data['buku'] = $bukuModel->getAll();
        }

        $data['genres'] = $bukuModel->getGenres();

        $this->view('user','dashboard',$data);
    }

    public function pinjam(){
        $tanggal_pinjam = !empty($_POST['tanggal_pinjam']) ? $_POST['tanggal_pinjam'] : date('Y-m-d');
        $tanggal_jatuh_tempo = !empty($_POST['tanggal_jatuh_tempo']) ? $_POST['tanggal_jatuh_tempo'] : date('Y-m-d', strtotime('+7 days'));

        if (strtotime($tanggal_jatuh_tempo) < strtotime($tanggal_pinjam)) {
            die("Tanggal pengembalian harus sama atau setelah tanggal pinjam.");
        }

        $this->model('Transaksi')
             ->pinjam($_SESSION['user']['id'], $_POST['buku'], $tanggal_pinjam, $tanggal_jatuh_tempo);

        if (!empty($_POST['from_wishlist'])) {
            $this->model('Buku')->removeWishlist($_SESSION['user']['id'], $_POST['buku']);
            header("Location:index.php?url=user/wishlist");
            exit;
        }

        header("Location:index.php?url=user/dashboard");
        exit;
    }

    public function removeWishlist(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buku'])) {
            $this->model('Buku')->removeWishlist($_SESSION['user']['id'], $_POST['buku']);
        }

        header("Location:index.php?url=user/wishlist");
        exit;
    }

    public function transaksi(){
        $data['transaksi'] = $this->model('Transaksi')
                                  ->getByUser($_SESSION['user']['id']);
        $this->view('user','transaksi',$data);
    }

    public function kembali(){
        if (!isset($_POST['id'])) {
            die("ID transaksi tidak ditemukan");
        }

        $id = intval($_POST['id']);
        $success = $this->model('Transaksi')
                        ->kembaliUser($id, $_SESSION['user']['id']);

        if (!$success) {
            die("Gagal mengembalikan buku. Pastikan transaksi masih dalam status dipinjam.");
        }

        header("Location:index.php?url=user/transaksi");
        exit;
    }
    public function wishlist(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buku'])) {
            $this->model('Buku')
                 ->addWishlist($_SESSION['user']['id'], $_POST['buku']);
            header("Location:index.php?url=user/wishlist");
            exit;
        }

        $data['wishlist'] = $this->model('Buku')
                                  ->getWishlist($_SESSION['user']['id']);
        $this->view('user','wishlist',$data);
    }

}