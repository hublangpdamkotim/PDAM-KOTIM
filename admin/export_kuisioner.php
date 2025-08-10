<?php
include '../includes/koneksi.php';

// Set header untuk file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=kuisioner_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
    <th>No</th>
    <th>Wilayah</th>
    <th>Jenis Kelamin</th>
    <th>Usia</th>
    <th>Pendidikan</th>
    <th>Pekerjaan</th>
    <th>P1</th>
    <th>P2</th>
    <th>P3</th>
    <th>P4</th>
    <th>P5</th>
    <th>P6</th>
    <th>P7</th>
    <th>P8</th>
    <th>P9</th>
    <th>Saran</th>
    <th>Tanggal</th>
</tr>";

$no = 1;
$query = $conn->query("SELECT * FROM kuisioner ORDER BY tanggal DESC");
while ($row = $query->fetch_assoc()) {
    echo "<tr>
        <td>$no</td>
        <td>{$row['wilayah']}</td>
        <td>{$row['jenis_kelamin']}</td>
        <td>{$row['usia']}</td>
        <td>{$row['pendidikan']}</td>
        <td>{$row['pekerjaan']}</td>
        <td>{$row['p1']}</td>
        <td>{$row['p2']}</td>
        <td>{$row['p3']}</td>
        <td>{$row['p4']}</td>
        <td>{$row['p5']}</td>
        <td>{$row['p6']}</td>
        <td>{$row['p7']}</td>
        <td>{$row['p8']}</td>
        <td>{$row['p9']}</td>
        <td>" . htmlspecialchars($row['saran']) . "</td>
        <td>{$row['tanggal']}</td>
    </tr>";
    $no++;
}
echo "</table>";
exit;
