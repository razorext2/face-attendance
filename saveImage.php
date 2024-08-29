<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $uploadDirectory = 'labels/Abdi/capturedImg';
        $uploadFile = $uploadDirectory . basename($image['name']);

        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            echo "File successfully uploaded.";
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No image file found.";
    }
} else {
    echo "Invalid request method.";
}
