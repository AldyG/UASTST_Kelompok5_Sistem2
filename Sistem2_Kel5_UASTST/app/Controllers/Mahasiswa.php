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
        $session = session();
        $session->remove('logged_in');
        return redirect()->to('mahasiswa/login');
    }

    public function loginProcess() {
        // Retrieve user input from the login form
        $nim = $this->request->getPost('nim');
        $password = $this->request->getPost('password');

        // Kode untuk verifikasi login, sesuai dengan sistem Anda
        // Implementasi sederhana untuk keperluan uji coba
        // Gantilah dengan metode otentikasi sesuai sistem sebenarnya

        // For testing purposes, using hardcoded credentials
        $validNIM = 'mahasiswa';
        $validPassword = 'password';

        if ($nim == $validNIM && $password == $validPassword) {
            // Jika login sukses, set sesi dan redirect ke halaman home
            // Simpan data pengguna ke dalam sesi
            $userData = [
                'nim' => $nim,
                // Data pengguna lainnya...
            ];

            $session = session();
            $session->set('logged_in', true);
            $session->set('user_data', $userData);

            // Redirect ke halaman home
            return redirect()->to('mahasiswa/home');
        } else {
            // Jika login gagal, tampilkan pesan atau redirect ke halaman login
            echo "Login gagal. Pastikan NIM dan password benar.";
        }
    }

    public function home() {
        // Kode untuk tampilan dan verifikasi login
        return view('mahasiswa/home');
    }
}
