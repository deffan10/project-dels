<?php
// TAMPILKAN ERROR: Hapus baris ini setelah debugging selesai
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- Konfigurasi Basis Data ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'perpustakaan_adel'); // Sesuaikan dengan nama DB Anda

// --- Inisialisasi Variabel ---
$angkatan = '';
$hasil = [];

// --- 1. Mendapatkan Nilai Angkatan dari URL (GET) ---
if (isset($_GET['angkatan'])) {
    // Ambil nilai dan bersihkan dari karakter berbahaya
    $angkatan = htmlspecialchars($_GET['angkatan']);
}

// --- 2. Membuat Koneksi ke Basis Data ---
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    // Hentikan eksekusi jika koneksi gagal
    die("Koneksi gagal: " . $conn->connect_error);
}

// --- 3. Mengambil Data Mahasiswa ---
// Query hanya dijalankan jika $angkatan BUKAN string kosong ('')
if ($angkatan !== '') {

    // Siapkan query dengan Prepared Statement
    // Asumsi: Nama tabel adalah 'mahasiswa_parttime'
    $sql = "SELECT nama, foto, angkatan, nim FROM parttime WHERE angkatan = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Tampilkan error jika prepared statement gagal (cek nama tabel/kolom)
        die("Error Prepared Statement: " . $conn->error);
    }

    // Binding parameter: Menggunakan "s" (string) untuk nilai angkatan
    $stmt->bind_param("s", $angkatan);

    $stmt->execute();

    $result = $stmt->get_result();

    // Ambil semua hasil ke dalam array $hasil
    while ($row = $result->fetch_assoc()) {
        $hasil[] = $row;
    }

    $stmt->close();
}

// Tutup koneksi di sini karena kita tidak membutuhkannya lagi setelah pengambilan data
$conn->close();
