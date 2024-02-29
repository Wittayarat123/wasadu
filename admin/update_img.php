<?php
require_once('../connections/mysqli.php');

// Check if the form was submitted
isset($_GET['w_id']) ? $id = $_GET['w_id'] : $id = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if a file was uploaded
    if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] === UPLOAD_ERR_OK) {
        $imageFile = $_FILES["imageFile"];

        // Retrieve file details
        $fileName = $imageFile["name"];
        $tempFilePath = $imageFile["tmp_name"];
        $fileSize = $imageFile["size"];

        // Move the uploaded file to a desired location
        $targetDirectory = "../assets/img_w/"; // Directory where you want to store the images
        $targetFilePath = $targetDirectory . $fileName;

        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
            // Image uploaded successfully
            // Perform the database update here
            // You can use SQL UPDATE statement to update the image path or any other image-related data in the database

            // Example SQL query:
            $sql = "UPDATE tb_wasadu SET w_img = '$fileName' WHERE w_id = $id";
                        if ($Connection->query($sql) === TRUE) {
                            echo "<script>window.location='show.php?w_id&do=ok';</script>";
                        } else {
                            echo "<script>alert('พบข้อผิดพลาด');window.location='show.php';</script>" . $Connection->error;
                        }
                    } else {
                        echo "<script>alert('พบข้อผิดพลาด');window.location='show.php';</script>";
                    }
                } else {
                    echo "<script>alert('พบข้อผิดพลาด');window.location='show.php';</script>";
                }
        }
 