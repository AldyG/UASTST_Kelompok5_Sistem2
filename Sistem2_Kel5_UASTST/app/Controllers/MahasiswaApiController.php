<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MahasiswaModel;

class MahasiswaApiController extends ResourceController
{
    public function index()
    {
        $model = new MahasiswaModel();
        $data = $model->getMahasiswaData();
        return $this->respond($data);
    }
}
