<?php namespace App\Models;

use CodeIgniter\Model;

class DaftarMahasiswaModel extends Model {
    protected $table = 'mahasiswa';
    protected $allowedFields = ['nim', 'nama', 'jurusan', 'ip', 'ipk', 'totalsks', 'password'];

    public function getAllMahasiswa() {
        return $this->select('nim, ip, ipk')->findAll();
    }
}