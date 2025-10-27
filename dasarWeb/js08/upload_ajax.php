<?php
if (isset($_FILES['file'])) {
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $maxsize = 5*1024*1024;
    $responses = array();

    // Cek apakah multi upload atau single
    $files = $_FILES['file'];
    $fileCount = is_array($files['name']) ? count($files['name']) : 1;

    for ($i = 0; $i < $fileCount; $i++) {
        $file_name = is_array($files['name']) ? $files['name'][$i] : $files['name'];
        $file_size = is_array($files['size']) ? $files['size'][$i] : $files['size'];
        $file_tmp = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowedExtensions)) {
            $responses[] = "File $file_name bukan gambar yang valid.";
            continue;
        }
        if ($file_size > $maxsize) {
            $responses[] = "File $file_name melebihi ukuran maksimum 5MB.";
            continue;
        }
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        if (move_uploaded_file($file_tmp, $targetDir . $file_name)) {
            $responses[] = "Gambar $file_name berhasil diunggah.";
        } else {
            $responses[] = "Gagal mengunggah gambar $file_name.";
        }
    }
    echo implode("<br>", $responses);
}
?>