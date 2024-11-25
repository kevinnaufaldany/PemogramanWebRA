<?php
session_start();
if (!isset($_SESSION['result'])) {
    echo "Tidak ada data yang diproses.";
    exit;
}

$result = $_SESSION['result'];

// Pisahkan browser dan sistem operasi
$browserData = $result['browser'];
$os = "Tidak diketahui";
$browser = "Tidak diketahui";

if (preg_match('/Windows NT [\d\.]+/', $browserData, $matches)) {
    $os = $matches[0];
} elseif (preg_match('/Mac OS X [\d\_]+/', $browserData, $matches)) {
    $os = str_replace('_', '.', $matches[0]);
}

if (preg_match('/(Chrome\/[\d\.]+|Firefox\/[\d\.]+|Safari\/[\d\.]+)/', $browserData, $matches)) {
    $browser = $matches[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pendataan</title>
    <link rel="stylesheet" href="style-result.css">
</head>
<body>
    <div class="container result-container">
        <h2>Hasil Pendataan Mahasiswa</h2>

        <!-- Data Mahasiswa -->
        <table class="result-table">
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($result['name']) ?></td>
            </tr>
            <tr>
                <th>NIM</th>
                <td><?= htmlspecialchars($result['nim']) ?></td>
            </tr>
            <tr>
                <th>Email ITERA</th>
                <td><?= htmlspecialchars($result['email']) ?></td>
            </tr>
            <tr>
                <th>Nomor HP</th>
                <td><?= htmlspecialchars($result['phone']) ?></td>
            </tr>
            <tr>
                <th>Pesan</th>
                <td><?= nl2br(htmlspecialchars($result['bio'])) ?></td>
            </tr>
        </table>

        <!-- Data Sistem -->
        <div class="title">Informasi Sistem</div>
        <table class="result-table">
            <tr>
                <th>Sistem Operasi</th>
                <td><?= htmlspecialchars($os) ?></td>
            </tr>
            <tr>
                <th>Browser</th>
                <td><?= htmlspecialchars($browser) ?></td>
            </tr>
        </table>

        <!-- Isi File -->
        <div class="title">Isi File Transkrip</div>
        <table class="result-table">
            <tr>
                <th>Baris</th>
                <th>Konten</th>
            </tr>
            <?php foreach ($result['fileContent'] as $index => $line): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($line) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="back">
            <a href="index.html" class="btn">Kembali</a>
        </div>
    </div>

</body>
</html>
