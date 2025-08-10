<?php
// proses_kuisioner.php

include 'includes/koneksi.php';  // panggil koneksi database

function input($data) {
    return htmlspecialchars(trim($data));
}

// Ambil data POST dan validasi
$wilayah = isset($_POST['wilayah']) ? input($_POST['wilayah']) : '';
$jenis_kelamin = isset($_POST['jenis_kelamin']) ? input($_POST['jenis_kelamin']) : '';
$usia = isset($_POST['usia']) ? (int)$_POST['usia'] : 0;
$pendidikan = isset($_POST['pendidikan']) ? input($_POST['pendidikan']) : '';
$pekerjaan = isset($_POST['pekerjaan']) ? input($_POST['pekerjaan']) : '';
$saran = isset($_POST['saran']) ? input($_POST['saran']) : '';

// Jawaban kuisioner q1 - q9
$q = [];
for ($i = 1; $i <= 9; $i++) {
    $key = 'q' . $i;
    if (isset($_POST[$key]) && in_array($_POST[$key], ['1', '2', '3', '4'])) {
        $q[$i] = (int)$_POST[$key];
    } else {
        die("Data jawaban kuisioner tidak lengkap atau tidak valid.");
    }
}

// Validasi sederhana
if (empty($wilayah) || empty($jenis_kelamin) || $usia <= 0 || empty($pendidikan) || empty($pekerjaan)) {
    die("Data wajib belum lengkap.");
}

// Prepare dan bind parameter
$stmt = $conn->prepare("INSERT INTO kuisioner 
    (wilayah, jenis_kelamin, usia, pendidikan, pekerjaan, p1, p2, p3, p4, p5, p6, p7, p8, p9, saran) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssissiiiiiiiiis", 
    $wilayah, $jenis_kelamin, $usia, $pendidikan, $pekerjaan,
    $q[1], $q[2], $q[3], $q[4], $q[5], $q[6], $q[7], $q[8], $q[9], $saran
);

// Eksekusi
if ($stmt->execute()) {
    header("Location: kuisioner_sukses.php");
    exit;
} else {
    echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
