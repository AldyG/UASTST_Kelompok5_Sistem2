<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Mahasiswa extends Controller {
    public function __construct() {
        // parent::__construct();
        $this->modelMahasiswa = new \App\Models\ModelMahasiswa();
        helper(['url', 'session']);
    }

    public function index() {
        // Perlihatkan halaman login jika belum login
        if (!$this->session->userdata('logged_in')) {
            redirect('mahasiswa/login');
        }

        // Ambil NIM dari sesi login
        $nim = $this->session->userdata('nim');

        // Panggil model untuk mendapatkan data nilai
        $data['nilai'] = $this->ModelMahasiswa->getNilaiByNIM($nim);

        // Tampilkan data dalam bentuk tabel
        $this->load->view('mahasiswa/nilai', $data);
    }

    public function login() {
        // Kode untuk tampilan dan verifikasi login
        return view('mahasiswa/login');
    }

    public function logout() {
        // Kode untuk logout
        $this->session->unset_userdata('logged_in');
        redirect('mahasiswa/login');
    }

    public function login_process() {
        $nim = $this->input->post('nim');
        $password = $this->input->post('password');

        // Kode untuk verifikasi login, sesuai dengan sistem Anda
        // Contoh sederhana, perlu disesuaikan dengan implementasi sebenarnya
        if ($nim == 'mahasiswa' && $password == 'password') {
            // Jika login sukses, set sesi dan redirect ke halaman nilai
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('nim', $nim);
            redirect('mahasiswa');
        } else {
            // Jika login gagal, tampilkan pesan atau redirect ke halaman login
            echo "Login gagal. Pastikan NIM dan password benar.";
        }
    }
}
