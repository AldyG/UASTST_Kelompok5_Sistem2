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

    public function getMahasiswaByNIM($nim) {
        $sql = "SELECT ipk, totalsks FROM mahasiswa WHERE nim = $nim";

        return $this->query($sql, [$nim])->getResultArray();
    }

    public function getMataKuliahByNIM($nim) {
        $sql = "SELECT rencana_studi.kode_matkul, mata_kuliah.nama, mata_kuliah.sks, mahasiswa.ipk, rencana_studi.pernah_update
                FROM rencana_studi
                JOIN mata_kuliah ON rencana_studi.kode_matkul = mata_kuliah.kode
                JOIN mahasiswa ON rencana_studi.nim_mahasiswa = mahasiswa.nim
                WHERE rencana_studi.nim_mahasiswa = $nim";

        // Execute the query and return the result
        return $this->query($sql, [$nim])->getResultArray();
    }

    public function markUpdated($nim, $kodeMatkul, $newValue) {
        $sql = "UPDATE rencana_studi SET pernah_update = ? WHERE nim_mahasiswa = ? AND kode_matkul = ?";

        $this->query($sql, [$newValue, $nim, $kodeMatkul]);
    }

    public function updateIPAndIPK($nim, $newIP, $newIPK, $newTotalSKS) {
        $sql = "UPDATE mahasiswa SET ip = ?, ipk = ?, totalsks = ? WHERE nim = ?";

        $this->query($sql, [$newIP, $newIPK, $newTotalSKS, $nim]);
    }

    public function getIndeksMataKuliah($nim, $kodeMatkul) {
        $sql = "SELECT indeks FROM nilai
                WHERE nim_mahasiswa = $nim AND kode_matkul = '$kodeMatkul'";

        // Execute the query and return the result
        return $this->query($sql, [$nim, $kodeMatkul])->getResultArray();
    }

    public function createNewNilaiMatkul($nim, $kodeMatkul, $indeks) {
        // Insert a new row into the 'nilai' table
        $data = [
            'nim_mahasiswa' => $nim,
            'kode_matkul' => $kodeMatkul,
            'indeks' => $indeks
        ];
        $this->db->table('nilai')->insert($data);
    }

    public function updateIndeksMatkul($nim, $kodeMatkul, $indeks) {
        $sql = "UPDATE nilai SET indeks = ? WHERE nim_mahasiswa = ? AND kode_matkul = ?";

        $this->query($sql, [$indeks, $nim, $kodeMatkul]);
    }
    
}
