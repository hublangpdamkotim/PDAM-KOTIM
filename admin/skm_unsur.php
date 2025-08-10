<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../includes/koneksi.php';

// Fungsi ambil rata-rata nilai kuisioner
function getRata($conn, $kolom) {
    $query = $conn->query("SELECT AVG($kolom) AS rata FROM kuisioner");
    $hasil = $query->fetch_assoc();
    return round($hasil['rata'] ?? 0, 2);
}

// Fungsi konversi ke kategori SKM
function kategoriSKM($skm) {
    if ($skm >= 88.31) return 'A (Sangat Baik)';
    elseif ($skm >= 76.61) return 'B (Baik)';
    elseif ($skm >= 65.00) return 'C (Kurang Baik)';
    else return 'D (Tidak Baik)';
}

// Data SKM per unsur (p1-p9)
$unsur = [];
$total_skm = 0;

for ($i = 1; $i <= 9; $i++) {
    $rata = getRata($conn, "p$i");
    $skm = round($rata * 25, 2);
    $total_skm += $skm;

    $unsur[] = [
        'unsur' => "U$i",
        'nilai' => $skm,
        'kategori' => kategoriSKM($skm)
    ];
}

$ikm_unit = round($total_skm / 9, 2);
$kategori_unit = kategoriSKM($ikm_unit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai SKM per Unsur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
            width: 240px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">PDAM Admin</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="skm_unsur.php" class="active">Nilai SKM per Unsur</a>
    <a href="kuisioner.php">Data Kuisioner</a>
    <a href="logout.php" class="text-danger mt-4">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h3 class="mb-4">Tabel Nilai SKM Per Unsur</h3>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-warning">
            <tr>
                <th>Unsur</th>
                <?php foreach ($unsur as $u): ?>
                    <th><?= $u['unsur'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>IKM per unsur</th>
                <?php foreach ($unsur as $u): ?>
                    <td><?= $u['nilai'] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <th>Kategori</th>
                <?php foreach ($unsur as $u): ?>
                    <td><?= $u['kategori'] ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="5">IKM Unit Layanan</th>
                <td colspan="4"><strong><?= $ikm_unit ?> (<?= $kategori_unit ?>)</strong></td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>
