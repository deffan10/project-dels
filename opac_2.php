<?php
// --- 1. PENGATURAN KONEKSI ---
// Ganti ini dengan info database Anda
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'perpustakaan_adel'; // <-- GANTI NAMA DATABASE ANDA

// Buat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// Variabel untuk hasil
$hasil_pencarian = [];
$query_pencarian = '';

// --- 2. LOGIKA PENCARIAN ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty(trim($_POST['query']))) {

    $query_pencarian = trim($_POST['query']);

    // GANTI 'koleksi', 'judul', 'penulis' jika nama tabel/kolom Anda berbeda
    $sql = "SELECT id, judul, pengarang, penerbit, subjek FROM koleksi WHERE judul LIKE ? OR pengarang LIKE ?";

    // Siapkan statement
    $stmt = mysqli_prepare($conn, $sql);

    // Buat kata kunci pencarian (tambahkan % untuk 'LIKE')
    $sql_query = "%" . $query_pencarian . "%";

    // Bind parameter ( "ss" berarti dua parameter Tipe String)
    mysqli_stmt_bind_param($stmt, "ss", $sql_query, $sql_query);

    // Eksekusi
    mysqli_stmt_execute($stmt);

    // Ambil hasilnya
    $result = mysqli_stmt_get_result($stmt);

    // Masukkan semua hasil ke array
    $hasil_pencarian = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Tutup statement
    mysqli_stmt_close($stmt);
}

// Tutup koneksi database
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OPAC Sederhana (MySQLi)</title>
    <style>
        /* CSS Sederhana (Sama seperti sebelumnya) */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #0056b3;
            text-align: center;
        }

        .search-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            width: 70%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-form input[type="submit"] {
            padding: 8px 12px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .result-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .result-item h3 {
            margin: 0 0 5px 0;
            color: #333;
        }

        .result-item p {
            margin: 4px 0;
            font-size: 0.9em;
        }

        .result-item .kode {
            font-weight: bold;
            color: #c9302c;
        }

        .no-results {
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>🔍 OPAC Sederhana</h1>

        <div class="search-form">
            <form action="" method="POST"> <input type="text" name="query"
                    value="<?php echo htmlspecialchars($query_pencarian); ?>"
                    placeholder="Cari judul atau penulis...">
                <input type="submit" value="Cari">
            </form>
        </div>

        <div class="search-results">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (count($hasil_pencarian) > 0) {
                    echo "<p>Ditemukan " . count($hasil_pencarian) . " hasil:</p>";

                    // Loop setiap hasil (GANTI nama kolom jika perlu)
                    foreach ($hasil_pencarian as $koleksi) {
                        echo '<div class="result-item">';
                        echo '<h3>' . htmlspecialchars($koleksi['judul']) . '</h3>';
                        echo '<p><strong>ID:</strong> ' . htmlspecialchars($koleksi['id']) . '</p>';
                        echo '<p><strong>Pengarang:</strong> ' . htmlspecialchars($koleksi['pengarang']) . '</p>';
                        echo '<p><strong>Penerbit:</strong> ' . htmlspecialchars($koleksi['penerbit']) . '</p>';
                        echo '<p><strong>Subjek:</strong> ' . htmlspecialchars($koleksi['subjek']) . '</p>';
                        echo '</div>';
                    }
                } else if (!empty($query_pencarian)) {
                    // Jika mencari tapi tidak ada hasil
                    echo '<p class="no-results">Tidak ada hasil ditemukan.</p>';
                }
            }
            ?>
        </div>
    </div>

</body>

</html>