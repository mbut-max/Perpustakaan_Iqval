<?php
require_once BASEPATH . "core/Controller.php";

class AdminController extends Controller {

    public function dashboard(){

    $model = $this->model('Transaksi');
    $data['stat'] = $model->statistik();

    $this->view('admin','dashboard',$data);
}
    public function buku(){
    $model = $this->model('Buku');

    if(isset($_POST['cari'])){
        $data['buku'] = $model->search($_POST['keyword']);
    }else{
        $data['buku'] = $model->getAll();
    }

    $this->view('admin','buku',$data);
}

    public function tambahBuku(){

    $namaFile = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp,"../assets/img/".$namaFile);

    $_POST['foto'] = $namaFile;

    $this->model('Buku')->insert($_POST);

    header("Location:index.php?url=admin/buku");
}

    public function editBuku($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('Buku');
        $data['buku'] = $model->getById($id);

        if (!$data['buku']) {
            die("Buku tidak ditemukan");
        }

        $this->view('admin', 'edit_buku', $data);
    }

    public function updateBuku()
    {
        if (!isset($_POST['id'])) {
            die("ID tidak ditemukan");
        }

        $id = intval($_POST['id']);
        $model = $this->model('Buku');
        $buku = $model->getById($id);

        if (!$buku) {
            die("Buku tidak ditemukan");
        }

        $foto = $buku['foto'];
        if (isset($_FILES['foto']) && $_FILES['foto']['name']) {
            $namaFile = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($tmp, "../assets/img/" . $namaFile);
            $foto = $namaFile;
        }

        $_POST['foto'] = $foto;
        $_POST['id'] = $id;

        if ($model->update($_POST)) {
            header("Location:index.php?url=admin/buku");
            exit;
        } else {
            echo "Gagal memperbarui data";
        }
    }

    public function anggota(){
        $data['user']=$this->model('User')->getAll();
        $this->view('admin','anggota',$data);
    }

    public function tambahUser(){
        if (!isset($_POST['nama'], $_POST['username'], $_POST['password'])) {
            die("Data tidak lengkap");
        }

        $model = $this->model('User');
        if ($model->insert($_POST)) {
            header("Location:index.php?url=admin/anggota");
            exit;
        }

        echo "Gagal menambahkan user. Username mungkin sudah digunakan.";
    }

    public function editUser($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('User');
        $data['user'] = $model->getById($id);

        if (!$data['user']) {
            die("User tidak ditemukan");
        }

        $this->view('admin', 'edit_anggota', $data);
    }

    public function updateUser()
    {
        if (!isset($_POST['id'], $_POST['nama'], $_POST['username'])) {
            die("Data tidak lengkap");
        }

        $model = $this->model('User');
        if ($model->update($_POST)) {
            header("Location:index.php?url=admin/anggota");
            exit;
        }

        echo "Gagal memperbarui user.";
    }

    public function hapusUser($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('User');

        if ($model->delete($id)) {
            header("Location: index.php?url=admin/anggota");
            exit;
        } else {
            echo "Gagal menghapus user";
        }
    }

    public function transaksi(){
        $data['transaksi']=$this->model('Transaksi')->getAll();
        $data['user']=$this->model('User')->getAll()->fetch_all(MYSQLI_ASSOC);
        $data['buku']=$this->model('Buku')->getAll()->fetch_all(MYSQLI_ASSOC);
        $this->view('admin','transaksi',$data);
    }

    public function tambahTransaksi()
    {
        if (!isset($_POST['user_id'], $_POST['buku_id'], $_POST['tanggal_pinjam'], $_POST['tanggal_jatuh_tempo'], $_POST['status'])) {
            die("Data transaksi tidak lengkap");
        }

        $model = $this->model('Transaksi');
        if ($model->insert($_POST)) {
            header("Location:index.php?url=admin/transaksi");
            exit;
        }

        echo "Gagal menambahkan transaksi.";
    }

    public function editTransaksi($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('Transaksi');
        $data['transaksi'] = $model->getById($id);
        $data['user'] = $this->model('User')->getAll();
        $data['buku'] = $this->model('Buku')->getAll();

        if (!$data['transaksi']) {
            die("Transaksi tidak ditemukan");
        }

        $this->view('admin', 'edit_transaksi', $data);
    }

    public function updateTransaksi()
    {
        if (!isset($_POST['id'], $_POST['user_id'], $_POST['buku_id'], $_POST['tanggal_pinjam'], $_POST['tanggal_jatuh_tempo'], $_POST['status'])) {
            die("Data transaksi tidak lengkap");
        }

        $model = $this->model('Transaksi');
        if ($model->update($_POST)) {
            header("Location:index.php?url=admin/transaksi");
            exit;
        }

        echo "Gagal memperbarui transaksi.";
    }

    public function hapusTransaksi($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('Transaksi');

        if ($model->delete($id)) {
            header("Location: index.php?url=admin/transaksi");
            exit;
        } else {
            echo "Gagal menghapus transaksi";
        }
    }

    public function hapusBuku($id = null)
    {
        if ($id == null) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        }

        if ($id == null) {
            die("ID tidak ditemukan");
        }

        $model = $this->model('Buku');

        if ($model->delete($id)) {
            header("Location: index.php?url=admin/buku");
            exit;
        } else {
            echo "Gagal menghapus data";
        }
    }
}