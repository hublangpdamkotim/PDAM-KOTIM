<?php
// kuisioner.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Isi Kuisioner - PDAM Tirta Mentaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-5 mb-5">
        <h2 class="mb-4">Form Isi Kuisioner Kepuasan Pelanggan</h2>

        <form action="proses_kuisioner.php" method="post">

            <!-- Wilayah -->
            <div class="mb-3">
                <label class="form-label">Wilayah</label>
                <select name="wilayah" class="form-select" required>
                    <option value="">-- Pilih Wilayah --</option>
                    <option value="Wilayah I">Wilayah I (Jend Sudirman - Cilik Riwut)</option>
                    <option value="Wilayah II">Wilayah II (Cilik Riwut - A Yani)</option>
                    <option value="Wilayah III">Wilayah III (A Yani - Kapten Mulyono)</option>
                    <option value="Wilayah IV">Wilayah IV (Kapten Mulyono - Jend Sudirman)</option>
                </select>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="lk" value="Laki-Laki" required>
                    <label class="form-check-label" for="lk">Laki-Laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="pr" value="Perempuan" required>
                    <label class="form-check-label" for="pr">Perempuan</label>
                </div>
            </div>

            <!-- Usia -->
            <div class="mb-3">
                <label for="usia" class="form-label">Usia <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="usia" name="usia" min="1" max="120" required>
            </div>

            <!-- Pendidikan -->
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                <select class="form-select" id="pendidikan" name="pendidikan" required>
                    <option value="" selected disabled>Pilih pendidikan terakhir</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="S1">D3</option>
                    <option value="S1">S1</option>
                    <option value="S1">S2</option>
                </select>
            </div>

            <!-- Pekerjaan -->
            <div class="mb-3">
                <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                <select class="form-select" id="pekerjaan" name="pekerjaan" required>
                    <option value="" selected disabled>Pilih pekerjaan</option>
                    <option value="PNS">PNS</option>
                    <option value="TNI-POLRI">TNI-POLRI</option>
                    <option value="Swasta">Swasta</option>
                    <option value="Wirausaha">Wirausaha</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <!-- Pertanyaan 1-9 -->
            <?php
            $questions = [
                "Bagaimana pendapat saudara mengenai layanan yang diberikan PERUMDAM Tirta Mentaya?",
                "Bagaimana pendapat saudara tentang kemudahan pembayaran rekening bulanan dan pengaduan gangguan pelanggan PERUMDAM Tirta Mentaya?",
                "Bagaimana pendapat saudara tentang kecepatan penyelesaian aduan gangguan pelanggan PERUMDAM Tirta Mentaya?",
                "Bagaimana pendapat saudara tentang biaya penyelesaian aduan gangguan pelanggan PERUMDAM Tirta Mentaya?",
                "Bagaimana pendapat saudara tentang kualitas dan aliran air di rumah pelanggan?",
                "Bagaimana pendapat saudara tentang kemampuan/kompetensi petugas menyelesaikan aduan pelanggan?",
                "Bagaimana pendapat saudara tentang perilaku petugas pelayanan kepada pelanggan?",
                "Bagaimana pendapat saudara tentang kelengkapan sarana dan prasarana dalam pelayanan kepada pelanggan?",
                "Bagaimana pendapat saudara tentang nilai tagihan bulanan pemakaian air?"
            ];

            $options = [
                ["Tidak Sesuai", "Kurang Sesuai", "Sesuai", "Sangat Sesuai"],
                ["Tidak Mudah", "Kurang Mudah", "Mudah", "Sangat Mudah"],
                ["Tidak cepat/ lambat", "Kurang Cepat", "Cepat", "Sangat Cepat"],
                ["Sangat Mahal", "Mahal", "Murah", "Gratis"],
                ["Tidak Baik", "Kurang Baik", "Baik", "Sangat Baik"],
                ["Tidak Kompeten", "Kurang Kompeten", "Kompeten", "Sangat Kompeten"],
                ["Tidak Ramah", "Kurang Ramah", "Ramah", "Sangat Ramah"],
                ["Buruk", "Cukup", "Baik", "Sangat Baik"],
                ["Sangat Mahal", "Mahal", "Wajar", "Murah"]
            ];

            foreach ($questions as $index => $question) {
                echo '<fieldset class="mb-4">';
                echo '<legend class="form-label">' . ($index + 1) . '. ' . $question . ' <span class="text-danger">*</span></legend>';
                foreach ($options[$index] as $optIndex => $optText) {
                    $optValue = $optIndex + 1;
                    $inputId = "q" . ($index + 1) . "_opt" . $optValue;
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" name="q' . ($index + 1) . '" id="' . $inputId . '" value="' . $optValue . '" required>';
                    echo '<label class="form-check-label" for="' . $inputId . '">' . $optValue . '. ' . $optText . '</label>';
                    echo '</div>';
                }
                echo '</fieldset>';
            }
            ?>

            <!-- Saran dan Masukan -->
            <div class="mb-3">
                <label for="saran" class="form-label">Saran dan masukan saudara untuk perbaikan kinerja PERUMDAM Tirta Mentaya kedepannya</label>
                <textarea class="form-control" id="saran" name="saran" rows="4" placeholder="Masukkan saran dan masukan Anda"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Kirim Kuisioner</button>
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
