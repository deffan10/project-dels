<?php

// 1. Data mahasiswa magang
$mahasiswa = [
    ["nama" => "Alifia Rizqa Unizila", "angkatan" => 2021, "foto" => "partime_1.jpg"],
    ["nama" => "Abdurrasyid Ridla",     "angkatan" => 2021, "foto" => "partime_2.jpg"],
    ["nama" => "Ardian Mulyadi",      "angkatan" => 2021, "foto" => "partime_3.jpg"],
    ["nama" => "Arif Prasetyo",       "angkatan" => 2021, "foto" => "partime_4.jpg"],
    ["nama" => "Firman Dwi Aditya",       "angkatan" => 2021, "foto" => "partime_5.jpg"],
    ["nama" => "Febri Arif Nurrahman",      "angkatan" => 2022, "foto" => "partime_6.jpg"],
    ["nama" => "Gondho Adi Saputra",      "angkatan" => 2023, "foto" => "partime_7.jpg"],
    ["nama" => "Halimah Siti Rahmawati",    "angkatan" => 2024, "foto" => "partime_8.jpg"]
];

// 2. Ambil input tahun angkatan dari form
$angkatan = isset($_GET['angkatan']) ? trim($_GET['angkatan']) : '';

// 3. Filter data jika pengguna memilih angkatan tertentu
if ($angkatan != '') {
    $hasil = array_filter($mahasiswa, function ($mhs) use ($angkatan) {
        return $mhs['angkatan'] == $angkatan;
    });
} else {
    $hasil = $mahasiswa; // tampilkan semua
}

// Catatan: file ini tidak menampilkan output apa pun.
// File ini hanya menyiapkan variabel: $angkatan dan $hasil
// yang akan digunakan oleh file 'index.php'.
