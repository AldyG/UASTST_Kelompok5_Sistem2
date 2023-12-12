<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMahasiswa extends Model {
    protected $table = 'nilai_mahasiswa'; // Gantilah dengan nama tabel yang sesuai

    public function getNilaiByNIM($nim) {
        // Contoh: Mengambil data nilai dari sistem lain (gunakan curl atau library HTTP yang sesuai)
        $apiEndpoint = "https://example.com/api/nilai/$nim"; // Gantilah dengan endpoint yang sesuai
        $dataNilai = $this->callApi($apiEndpoint);

        // Memproses data nilai jika diperlukan
        // Misalnya, simpan data ke dalam tabel 'nilai_mahasiswa'
        if ($dataNilai) {
            $this->insert($dataNilai); // Gunakan method insert yang sesuai dengan kebutuhan Anda
        }

        return $dataNilai;
    }

    protected function callApi($url) {
        // Contoh: Menggunakan cURL untuk mendapatkan data dari API
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        curl_close($ch);

        // Ubah respons JSON menjadi array jika diperlukan
        return json_decode($response, true);
    }
}
