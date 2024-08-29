<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && isset($_POST['label'])) {
        $image = $_FILES['image'];
        $label = $_POST['label'];

        // Tentukan lokasi untuk menyimpan gambar
        $uploadDir = 'labels/';
        $uploadFile = $uploadDir . $label . "/capturedImg/" . basename($image['name']);

        // Simpan gambar
        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            echo "Image saved successfully for label: $label";
        } else {
            echo "Failed to save image";
        }
    } else {
        echo "No image or label received";
    }
} else {
    echo "Invalid request method";
}
