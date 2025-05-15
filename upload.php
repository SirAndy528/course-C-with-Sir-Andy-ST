<?php
// upload.php
// Script untuk memproses upload file .cpo

// Folder tempat menyimpan file upload
$uploadDir = __DIR__ . '/uploads/';

// Buat folder uploads jika belum ada
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileUpload'])) {
        $file = $_FILES['fileUpload'];

        // Cek error upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die("Terjadi kesalahan saat upload file.");
        }

        // Validasi ekstensi file .cpo
        $allowedExtension = 'cpo';
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($fileExt !== $allowedExtension) {
            die("Hanya file dengan ekstensi .cpo yang diperbolehkan.");
        }

        // Buat nama file unik untuk menghindari overwrite
        $newFileName = uniqid('file_', true) . '.' . $fileExt;

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            echo "<h2>File berhasil diupload!</h2>";
            echo "<p>Nama file asli: " . htmlspecialchars($file['name']) . "</p>";
            echo "<p>Nama file disimpan: " . htmlspecialchars($newFileName) . "</p>";
            echo '<p><a href="index.html">Kembali ke halaman utama</a></p>';
        } else {
            echo "Gagal memindahkan file.";
        }
    } else {
        echo "Tidak ada file yang diupload.";
    }
} else {
    echo "Metode request tidak valid.";
}
?>