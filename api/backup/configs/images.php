<?php

require("connection.php");

$limit = 50;

$query = mysqli_query($connection, "SELECT * FROM products") or die(mysqli_error($connection));

while ($data = mysqli_fetch_assoc($query)) {
    $originalImagePath = "../../" . $data["product_image"];
    
    // Detect image type
    $imageType = exif_imagetype($originalImagePath);
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $originalImage = imagecreatefromjpeg($originalImagePath);
            break;
        case IMAGETYPE_PNG:
            $originalImage = imagecreatefrompng($originalImagePath);
            break;
        case IMAGETYPE_WEBP:
            $originalImage = imagecreatefromwebp($originalImagePath);
            break;
        default:
            die("Unsupported image type: " . $originalImagePath);
    }

    $originalWidth = imagesx($originalImage);
    $originalHeight = imagesy($originalImage);

    // Padding of 40px on each side
    $padding = 40;
    $size = max($originalWidth, $originalHeight) + (2 * $padding);

    $squareImage = imagecreatetruecolor($size, $size);
    $white = imagecolorallocate($squareImage, 255, 255, 255);
    imagefill($squareImage, 0, 0, $white);

    $x = ($size - $originalWidth) / 2;
    $y = ($size - $originalHeight) / 2;

    imagecopy($squareImage, $originalImage, $x, $y, 0, 0, $originalWidth, $originalHeight);

    $newImagePath = "../../" . $data["product_image"];
    imagejpeg($squareImage, $newImagePath, 100);

    imagedestroy($originalImage);
    imagedestroy($squareImage);

    echo "Image has been resized and centered successfully.";
}
?>
