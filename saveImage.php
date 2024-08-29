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
            $imageUrl = "http://localhost/frontend/" . $uploadDir . $label . "/capturedImg/" . basename($image['name']);
            echo json_encode(["imageUrl" => $imageUrl]);
        } else {
            echo json_encode(["error" => "Failed to save image"]);
        }
    } else {
        echo json_encode(["error" => "No image or label received"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
