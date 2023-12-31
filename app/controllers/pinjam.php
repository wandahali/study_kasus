<?php 

class Pinjam extends Controller{

    public function index()
    {
        $data['judul'] = 'Data Peminjaman' ;
        $data['pinjam'] = $this->model('PinjamModel')->getAllPinjam() ;
        $this->view('templates/header' , $data) ;
        $this->view('pinjam/index' , $data) ;
        $this->view('templates/footer');
    }

    public function tambah($msg = NULL)
    {
        $data['judul'] = 'Tambah Pinjam';
        $data['pesan'] = $msg;
        $data['nama_peminjam_value'] = isset($_POST['nama_peminjam']) ? $_POST['nama_peminjam'] : '';
        $data['jenis_barang_value'] = isset($_POST['jenis_barang']) ? $_POST['jenis_barang'] : '';
        $data['no_barang_value'] = isset($_POST['no_barang']) ? $_POST['no_barang'] : '';
        $data['tgl_pinjam_value'] = isset($_POST['tgl_pinjam']) ? $_POST['tgl_pinjam'] : '';
        $this->view('templates/header', $data);
        $this->view('pinjam/create', $data);
        $this->view('templates/footer');
    }
    public function simpanPinjam()
    {
        $_POST['tgl_kembali'] = date('Y-m-d H:i:s', strtotime($_POST['tgl_pinjam'] . ' +2 days'));

        if (empty($_POST['nama_peminjam']) || empty($_POST['jenis_barang']) || empty($_POST['no_barang']) || empty($_POST['tgl_pinjam'])) {
            $msg = "Data masih ada yang kosong Mohon isi kolom berikut: ";
        
            if (empty($_POST['nama_peminjam'])) {
                $msg .= "Nama Peminjam,";
            }
        
            if (empty($_POST['jenis_barang'])) {
                $msg .= " Jenis Barang,";
            }
        
            if (empty($_POST['no_barang'])) {
                $msg .= " No Barang,";
            }
        
            if (empty($_POST['tgl_pinjam'])) {
                $msg .= " Tgl Pinjam";
            }
        
            echo "<script>alert('$msg masih kosong');</script>";
            $this->tambah($msg);
            return;
        } else {
            if ($this->model('PinjamModel')->tambahPinjam($_POST) > 0) {
                header('location: ' . BASE_URL . '/Pinjam/index');
                exit;
            } else {
                header('location: ' . BASE_URL . '/Pinjam/index');
                exit;
            }
        }
        
    }

    public function edit($id){
        $data['judul'] = 'Edit Pinjaman' ;
        $data['pinjam'] = $this->model('PinjamModel')->getPinjamById($id) ;
        $this->view('templates/header' , $data) ;
        $this->view('Pinjam/edit' , $data) ;
        $this->view('templates/footer');
    }

    public function updatePinjam(){
        if($this->model('PinjamModel')->updateDataPinjam($_POST) > 0){
            header('location: ' . BASE_URL . '/Pinjam/index');
            exit;
        }else {
            header('location: ' . BASE_URL . '/Pinjam/index') ;
            exit;
        }
    }

    public function hapus($id){
        if($this->model('PinjamModel')->deletePinjam($id) > 0){
            header('location: ' . BASE_URL . '/Pinjam/index');
            exit;
        }else {
            header('location: ' . BASE_URL . '/Pinjam/index') ;
            exit;
        }
    }

    public function cari()
    {
        $data['judul'] = 'Pencarian';
        
        if (isset($_POST['search'])) {  //Jika kondisi di atas benar (yaitu ada data yang dikirimkan melalui POST dengan nama 'search'), maka kode berikut akan dijalankan
            $data['pinjam'] = $this->model('PinjamModel')->cariPinjam($_POST['search']); //
        } else {
            $data['pinjam'] = array(); //jika salah maka akan di atur menjadi array kosong
        }
        
        $this->view('templates/header', $data); //untuk menampilkan header situs web dan untuk mengiirmkan data
        $this->view('pinjam/index', $data); //untuk menampilkan tampilan utama dan untuk menampilkan data
        $this->view('templates/footer'); //untuk menampilkan footer
    }
    

}

?>
 <!-- public function cari()
    {
        $data['judul'] = 'Pencarian';
        $data['pinjam'] = $this->model('PinjamModel')->cariPinjam($_POST['search']);
        $this->view('templates/header', $data);
        $this->view('pinjam/index', $data);
        $this->view('templates/footer');
    } -->
