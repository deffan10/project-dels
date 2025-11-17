<?php
// Tampilkan error (hapus jika sistem sudah live)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- Konfigurasi Database ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'perpustakaan_adel'); // Sesuaikan dengan nama database Anda

// --- Membuat Koneksi ---
$koneksi = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// --- Cek Error Koneksi ---
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
