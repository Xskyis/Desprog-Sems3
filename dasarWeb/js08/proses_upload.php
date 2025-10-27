<?php

// Lokasi penyimpanan file gambar yang diunggah
$targetDirectory = "uploads/";

// Periksa apakah direktori penyimpanan ada, jika tidak maka buat
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if ($_FILES['files']['name'][0]) {
    $totalFiles = count($_FILES['files']['name']);
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $maxsize = 5*1024*1024;

    // Loop melalui semua file yang diunggah
    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $targetFile = $targetDirectory . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $fileSize = $_FILES['files']['size'][$i];

        // Validasi hanya file gambar dan ukuran maksimal
        if (in_array($fileType, $allowedExtensions) && $fileSize <= $maxsize) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                echo "Gambar $fileName berhasil diunggah.<br>";
            } else {
                echo "Gagal mengunggah gambar $fileName.<br>";
            }
        } else {
            echo "File $fileName bukan gambar yang valid atau melebihi ukuran maksimum.<br>";
        }
    }
} else {
    echo "Tidak ada file yang diunggah.";
}

?>