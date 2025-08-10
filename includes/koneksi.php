<?php
// includes/koneksi.php

$host = 'localhost';
$dbname = 'pdam_db';       // Sesuaikan dengan nama database yang kamu buat
$username = 'root';        // Sesuaikan dengan user database kamu
$password = '';            // Sesuaikan dengan password database kamu (biasanya kosong di localhost)

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
