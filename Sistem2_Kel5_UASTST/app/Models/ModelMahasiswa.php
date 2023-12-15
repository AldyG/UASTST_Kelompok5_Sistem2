<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model {
    protected $table = 'mahasiswa'; // Change to the actual table name

    public function getNilaiByNIM($nim) {
        // Query the 'mahasiswa' table to get data based on NIM
        $query = $this->where('nim', $nim)->first();

        // If a matching user is found, return the data
        // Otherwise, you might want to handle this case based on your requirements
        return ($query) ? $query : null;
    }
}
