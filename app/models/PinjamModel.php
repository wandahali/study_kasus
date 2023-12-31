<?php
require_once '../app/core/Database.php'; 
class PinjamModel{
    private $table = 'tb_peminjamans' ;
    private $db_study ;

    public function __construct()
    {
        $this->db_study = new Database ;
    }

    public function getAllPinjam()
    {
        $this->db_study->query("SELECT * FROM " . $this->table);
        return $this->db_study->resultSet();
    }

    public function getPinjamById($id)
    {
        $this->db_study->query('SELECT * FROM ' . $this->table . ' WHERE id=:id ') ;
        $this->db_study->bind('id' , $id) ;
        return $this->db_study->single() ;
    }

    public function tambahPinjam($data)
    {
        $query = "INSERT INTO tb_peminjamans (nama_peminjam, jenis_barang, no_barang, tgl_pinjam, tgl_kembali ) VALUES(:nama_peminjam, :jenis_barang, :no_barang, :tgl_pinjam, :tgl_kembali)" ;
        $this->db_study->query($query) ;
        $this->db_study->bind('nama_peminjam' , $data['nama_peminjam']) ;
        $this->db_study->bind('jenis_barang' , $data['jenis_barang']) ;
        $this->db_study->bind('no_barang' , $data['no_barang']) ;
        $this->db_study->bind('tgl_pinjam' , $data['tgl_pinjam']) ;
        $this->db_study->bind('tgl_kembali' , $data['tgl_kembali']) ;
        $this->db_study->execute() ;

        return $this->db_study->rowCount() ;
    }

    public function updateDataPinjam($data)
    {
        $query = "UPDATE tb_peminjamans SET nama_peminjam =:nama_peminjam, jenis_barang=:jenis_barang, no_barang=:no_barang, tgl_pinjam=:tgl_pinjam , tgl_kembali=:tgl_kembali   WHERE id=:id" ;
        $this->db_study->query($query) ;
        $this->db_study->bind('id' , $data['id']) ;
        $this->db_study->bind('nama_peminjam' , $data['nama_peminjam']) ;
        $this->db_study->bind('jenis_barang' , $data['jenis_barang']) ;
        $this->db_study->bind('no_barang' , $data['no_barang']) ;
        $this->db_study->bind('tgl_pinjam' , $data['tgl_pinjam']) ;
        $this->db_study->bind('tgl_kembali' , $data['tgl_kembali']) ;
        $this->db_study->execute() ;

        return $this->db_study->rowCount() ;
    }

    public function deletePinjam($id)
    {
        $this->db_study->query('DELETE FROM ' . $this->table . ' WHERE id=:id') ;
        $this->db_study->bind('id' , $id) ;
        $this->db_study->execute() ;

        return $this->db_study->rowCount() ;
        
    }
    public function cariPinjam($keyword)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE nama_peminjam LIKE :keyword OR jenis_barang LIKE :keyword";
        $this->db_study->query($query);
        
        $this->db_study->bind('keyword', '%' . $keyword . '%');
        
        return $this->db_study->resultSet();
    }
    
}

?>