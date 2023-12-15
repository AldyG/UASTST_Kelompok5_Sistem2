<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model {
    protected $table = 'mahasiswa'; // Change to the actual table name

    public function getDataByNIM($nim) {
        // Query the 'mahasiswa' table to get data based on NIM
        $query = $this->where('nim', $nim)->first();

        // If a matching user is found, return the data
        // Otherwise, you might want to handle this case based on your requirements
        return ($query) ? $query : null;
    }

    public function getMataKuliahByNIM($nim) {
        $sql = "SELECT rencana_studi.kode_matkul, mata_kuliah.nama, mata_kuliah.sks, mahasiswa.ipk
                FROM rencana_studi
                JOIN mata_kuliah ON rencana_studi.kode_matkul = mata_kuliah.kode
                JOIN mahasiswa ON rencana_studi.nim_mahasiswa = mahasiswa.nim
                WHERE rencana_studi.nim_mahasiswa = $nim";

        // Execute the query and return the result
        return $this->query($sql, [$nim])->getResultArray();
    }
}
