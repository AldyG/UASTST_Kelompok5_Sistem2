<?php namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $allowedFields = ['nim', 'nama', 'jurusan', 'ip', 'ipk', 'totalsks', 'password'];

    public function getMahasiswaData()
    {
        return $this->select('nim, ip, ipk')->findAll();
    }
}
