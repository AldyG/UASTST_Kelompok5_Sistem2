<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DaftarMahasiswaModel;

class DaftarMahasiswaController extends ResourceController
{
    public function index() {
        $model = new DaftarMahasiswaModel();
        $data = $model->getAllMahasiswa();
        return $this->respond($data);
    }
}
