<?php
session_start();
include '../includes/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kuisioner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-left: 250px;
            padding: 30px;
        }
        .sidebar {
            position: fixed;
            height: 100%;
            width: 240px;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center text-white mb-4">PDAM Admin</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="skm_unsur.php">Nilai SKM per Unsur</a>
    <a href="data_kuisioner.php" class="active">Data Kuisioner</a> 
    <a href="logout.php" class="text-danger mt-4">Logout</a>
</div>

<!-- Main content -->
<div class="container">
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Kuisioner Pelanggan</h3>
    <a href="export_kuisioner.php" class="btn btn-success">Export ke Excel</a>
</div>
        <table class="table table-bordered table-hover align-middle table-striped">
            <thead class="table-dark text-center">
                <tr>
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
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = $conn->query("SELECT * FROM kuisioner ORDER BY tanggal DESC");
                while ($row = $query->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['wilayah']) ?></td>
                    <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                    <td><?= htmlspecialchars($row['usia']) ?></td>
                    <td><?= htmlspecialchars($row['pendidikan']) ?></td>
                    <td><?= htmlspecialchars($row['pekerjaan']) ?></td>
                    <td><?= $row['p1'] ?></td>
                    <td><?= $row['p2'] ?></td>
                    <td><?= $row['p3'] ?></td>
                    <td><?= $row['p4'] ?></td>
                    <td><?= $row['p5'] ?></td>
                    <td><?= $row['p6'] ?></td>
                    <td><?= $row['p7'] ?></td>
                    <td><?= $row['p8'] ?></td>
                    <td><?= $row['p9'] ?></td>
                    <td><?= nl2br(htmlspecialchars($row['saran'])) ?></td>
                    <td><?= date("d-m-Y", strtotime($row['tanggal'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
