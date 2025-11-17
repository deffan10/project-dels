<?php
require 'koneksi_opac.php';

// ------------------------------
// BAGIAN LOGIC (PENCARIAN SUBJEK)
// ------------------------------
$keyword = "";
$hasil = [];

if (isset($_GET['subjek'])) {

    // keyword = nilai input
    $keyword = mysqli_real_escape_string($koneksi, $_GET['subjek']);

    if ($keyword != "") {

        // Query pencarian berdasarkan subjek
        $sql = "SELECT * FROM koleksi 
                WHERE judul LIKE '%$keyword%'
                OR pengarang LIKE '%$keyword%'
                OR penerbit LIKE '%$keyword%'
                OR subjek LIKE '%$keyword%'";

        $query = mysqli_query($koneksi, $sql);

        while ($row = mysqli_fetch_assoc($query)) {
            $hasil[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<html>

<head>
    <meta charset="UTF-8">
    <title>Perpustakaan UIN Sunan Kalijaga</title>
    <link rel="stylesheet" href="layout_2.css">
    <link rel="stylesheet" href="menu.css">

</head>

<body>
    <BR>
    <BR>
    <center>
        <div class="container">
            <h2 class="h2-opac">OPAC UIN Sunan Kalijaga</h2>
            <div class="search-form">
                <fieldset style="width:50%; border:0px solid black">
                    <form action="" method="POST">
                        <table>
                            <tr>
                                <td>
                                    <input type="text" name="subjek" placeholder="Cari berdasarkan subjek koleksi..." style="width:90%; padding:10px" value="<?= htmlspecialchars($keyword) ?>">
                                </td>
                                <td>
                                    <input type="submit" value="Cari">
                                </td>
                            </tr>

                        </table>
                    </form>
            </div>





            <form method="GET" action="">
                <table>
                    <tr>

                        <td>
                            <button type="submit" style="padding:10px">CARI</button>
                        </td>
                    </tr>

                </table>

            </form>
            </fieldset>
    </center>
    <br>

    <?php
    if ($keyword == "") {

        echo "<p><em><center>Masukkan judul atau subjek untuk mencari koleksi.</center></em></p>";
    } else if (count($hasil) == 0) {

        echo "<p><em>Tidak ada koleksi dengan subjek: <b>" . htmlspecialchars($keyword) . "</b></em></p>";
    } else {

        echo '<div class="grid-opac">';

        foreach ($hasil as $koleksi) {

            echo '<div class="card-opac">';

            // JUDUL
            echo '<h3>' . htmlspecialchars($koleksi['judul']) . '</h3>';

            // DETAIL
            echo "<p><strong>ID:</strong> " . htmlspecialchars($koleksi['id']) . "</p>";

            echo "<p><strong>Pengarang:</strong> " . htmlspecialchars($koleksi['pengarang']) . "</p>";
            echo "<p><strong>Penerbit:</strong> " . htmlspecialchars($koleksi['penerbit']) . "</p>";
            echo "<p><strong>Subjek:</strong> " . htmlspecialchars($koleksi['subjek']) . "</p>";
            echo "<hr>";

            echo '</div>';
        }

        echo '</div>';
    }
    ?>

</body>
<br>

</html>