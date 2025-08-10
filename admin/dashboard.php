<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../includes/koneksi.php';

// Total data
$total = $conn->query("SELECT COUNT(*) AS total FROM kuisioner")->fetch_assoc()['total'] ?? 0;

// Fungsi distribusi
function getDistribusi($conn, $kolom) {
    global $total;
    $data = [];
    $result = $conn->query("SELECT $kolom AS label, COUNT(*) AS jumlah FROM kuisioner GROUP BY $kolom");
    while ($row = $result->fetch_assoc()) {
        $persen = $total > 0 ? round(($row['jumlah'] / $total) * 100, 2) : 0;
        $data[] = ['label' => $row['label'], 'jumlah' => $row['jumlah'], 'persen' => $persen];
    }
    return $data;
}

function getRata($conn, $kolom) {
    $query = $conn->query("SELECT AVG($kolom) AS rata FROM kuisioner");
    $hasil = $query->fetch_assoc();
    return round($hasil['rata'] ?? 0, 2);
}

$jk = getDistribusi($conn, 'jenis_kelamin');
$pendidikan = getDistribusi($conn, 'pendidikan');
$pekerjaan = getDistribusi($conn, 'pekerjaan');
$wilayah = getDistribusi($conn, 'wilayah');

// Usia kelompok
$usia_result = $conn->query("
SELECT 
  CASE 
    WHEN usia < 21 THEN '<21 Tahun'
    WHEN usia BETWEEN 21 AND 30 THEN '21-30 Tahun'
    WHEN usia BETWEEN 31 AND 40 THEN '31-40 Tahun'
    WHEN usia BETWEEN 41 AND 50 THEN '41-50 Tahun'
    WHEN usia BETWEEN 51 AND 60 THEN '51-60 Tahun'
    ELSE '>60 Tahun'
  END AS label,
  COUNT(*) AS jumlah
FROM kuisioner
GROUP BY label
");
$usia = [];
while ($row = $usia_result->fetch_assoc()) {
    $persen = $total > 0 ? round(($row['jumlah'] / $total) * 100, 2) : 0;
    $usia[] = ['label' => $row['label'], 'jumlah' => $row['jumlah'], 'persen' => $persen];
}

// Penilaian P1–P9
$penilaian = [];
for ($i = 1; $i <= 9; $i++) {
    $penilaian[] = [
        'label' => "Pertanyaan $i",
        'value' => getRata($conn, "p$i")
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
        .progress-bar {
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center mb-4">PDAM Admin</h4>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="skm_unsur.php">Nilai SKM per Unsur</a>
    <a href="kuisioner.php">Data Kuisioner</a>
    <a href="logout.php" class="text-danger mt-4">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="d-flex justify-content-end mb-3">
    <a href="export_dashboard.php" class="btn btn-success">Export Statistik ke Excel</a>
</div>
    <h3 class="mb-4">Statistik Kuisioner Pelanggan</h3>

    <!-- Wilayah -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Wilayah</div>
        <div class="card-body">
            <?php foreach ($wilayah as $w): ?>
                <p><?= $w['label'] ?>: <strong><?= $w['jumlah'] ?></strong> (<?= $w['persen'] ?>%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-info" style="width: <?= $w['persen'] ?>%"><?= $w['persen'] ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Jenis Kelamin -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Jenis Kelamin</div>
        <div class="card-body">
            <?php foreach ($jk as $j): ?>
                <p><?= $j['label'] ?>: <strong><?= $j['jumlah'] ?></strong> (<?= $j['persen'] ?>%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar" style="width: <?= $j['persen'] ?>%"><?= $j['persen'] ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pendidikan -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Pendidikan</div>
        <div class="card-body">
            <?php foreach ($pendidikan as $p): ?>
                <p><?= $p['label'] ?>: <strong><?= $p['jumlah'] ?></strong> (<?= $p['persen'] ?>%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-secondary" style="width: <?= $p['persen'] ?>%"><?= $p['persen'] ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pekerjaan -->
    <div class="card mb-4">
        <div class="card-header bg-warning">Pekerjaan</div>
        <div class="card-body">
            <?php foreach ($pekerjaan as $p): ?>
                <p><?= $p['label'] ?>: <strong><?= $p['jumlah'] ?></strong> (<?= $p['persen'] ?>%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-dark" style="width: <?= $p['persen'] ?>%"><?= $p['persen'] ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Usia -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">Kelompok Usia</div>
        <div class="card-body">
            <?php foreach ($usia as $u): ?>
                <p><?= $u['label'] ?>: <strong><?= $u['jumlah'] ?></strong> (<?= $u['persen'] ?>%)</p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-primary" style="width: <?= $u['persen'] ?>%"><?= $u['persen'] ?>%</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Penilaian Kuisioner -->
    <div class="card mb-5">
        <div class="card-header bg-dark text-white">Rata-rata Penilaian P1 - P9</div>
        <div class="card-body">
            <?php foreach ($penilaian as $q): ?>
                <p><?= $q['label'] ?>: <strong><?= $q['value'] ?> / 5</strong></p>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" style="width: <?= $q['value'] * 20 ?>%"><?= $q['value'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>
