<?php
include '../includes/koneksi.php';

// Atur header untuk Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=statistik_dashboard.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Total
$total = $conn->query("SELECT COUNT(*) AS total FROM kuisioner")->fetch_assoc()['total'] ?? 0;

function getDistribusi($conn, $kolom) {
    global $total;
    $data = [];
    $query = $conn->query("SELECT $kolom AS label, COUNT(*) AS jumlah FROM kuisioner GROUP BY $kolom");
    while ($row = $query->fetch_assoc()) {
        $persen = $total > 0 ? round(($row['jumlah'] / $total) * 100, 2) : 0;
        $data[] = [$row['label'], $row['jumlah'], $persen];
    }
    return $data;
}

function getRata($conn, $kolom) {
    $result = $conn->query("SELECT AVG($kolom) AS rata FROM kuisioner");
    $row = $result->fetch_assoc();
    return round($row['rata'] ?? 0, 2);
}

$sections = [
    'Wilayah' => getDistribusi($conn, 'wilayah'),
    'Jenis Kelamin' => getDistribusi($conn, 'jenis_kelamin'),
    'Pendidikan' => getDistribusi($conn, 'pendidikan'),
    'Pekerjaan' => getDistribusi($conn, 'pekerjaan'),
];

$usia_query = $conn->query("
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
while ($row = $usia_query->fetch_assoc()) {
    $persen = $total > 0 ? round(($row['jumlah'] / $total) * 100, 2) : 0;
    $usia[] = [$row['label'], $row['jumlah'], $persen];
}

$penilaian = [];
for ($i = 1; $i <= 9; $i++) {
    $rata = getRata($conn, "p$i");
    $penilaian[] = ["Pertanyaan $i", $rata, $rata * 20];
}

// Output
echo "<table border='1'>";
foreach ($sections as $judul => $data) {
    echo "<tr><th colspan='3' bgcolor='#ccc'>$judul</th></tr>";
    echo "<tr><th>Label</th><th>Jumlah</th><th>Persentase (%)</th></tr>";
    foreach ($data as $d) {
        echo "<tr><td>{$d[0]}</td><td>{$d[1]}</td><td>{$d[2]}</td></tr>";
    }
}
echo "<tr><th colspan='3' bgcolor='#ccc'>Kelompok Usia</th></tr>";
echo "<tr><th>Label</th><th>Jumlah</th><th>Persentase (%)</th></tr>";
foreach ($usia as $d) {
    echo "<tr><td>{$d[0]}</td><td>{$d[1]}</td><td>{$d[2]}</td></tr>";
}

echo "<tr><th colspan='3' bgcolor='#ccc'>Penilaian P1 - P9</th></tr>";
echo "<tr><th>Pertanyaan</th><th>Rata-rata</th><th>Nilai (%)</th></tr>";
foreach ($penilaian as $p) {
    echo "<tr><td>{$p[0]}</td><td>{$p[1]}</td><td>{$p[2]}</td></tr>";
}
echo "</table>";
exit;
