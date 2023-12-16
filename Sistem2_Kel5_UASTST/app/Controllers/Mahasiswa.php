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

        // UNBLOCK WHEN DATABASE DONE
        $user = $this->modelMahasiswa->getDataByNIM($nim);

        // // For testing purposes, using hardcoded credentials
        // $validNIM = '18221000';
        // $validPassword = '$2a$10$.8ttdgn4FLkTAH6FJTScFuzZMDJ1NNizMpxhHeAn/gb5MDmIW68Ri';

        $session = session();
        // UNBLOCK WHEN DATABASE DONE
        if ($user && password_verify($password, $user['password'])) {
        // if ($nim == $validNIM && password_verify($password, $validPassword)) {
            // Jika login sukses, set sesi dan redirect ke halaman home
            // Simpan data pengguna ke dalam sesi
            $userData = [
                'nim' => $user['nim'],
                'nama' => $user['nama'],
                'ipk' => $user['ipk'],
                'totalsks' => $user['totalsks'],
                // Data pengguna lainnya...
            ];

            $session->set('logged_in', true);
            $session->set('user_data', $userData);
            $session->remove('error');

            // Redirect ke halaman home
            return redirect()->to('mahasiswa/home');
        } else if ($nim == null || $user == null) {
            $session->set('error', 'Wrong NIM!');
            return redirect()->to('mahasiswa/login');
        } else if ($password == null || ($user && !password_verify($password, $user['password']))) {
            $session->set('error', 'Wrong Password!');
            return redirect()->to('mahasiswa/login');
        }
    }

    public function home() {
        $session = session();
        if (!$session->get('user_data')) {
            return redirect()->to('/mahasiswa/logout');
        }
        // Kode untuk tampilan dan verifikasi login
        return view('mahasiswa/home');
    }
}
