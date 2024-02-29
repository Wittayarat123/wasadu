<?php
require_once('../connections/mysqli.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $w_id = $_POST['w_id'];
    $w_name = $_POST['w_name'];
    $w_price = $_POST['w_price'];
    $c_id = $_POST['c_id'];
    $w_brand = $_POST['w_brand'];
    $w_detail = $_POST['w_detail'];
    $w_textcom = $_POST['w_textcom'];
    // $w_img = '';

    // if (isset($_FILES["imageFile"]) && $_FILES["imageFile"]["error"] === UPLOAD_ERR_OK) {
    //     $imageFile = $_FILES["imageFile"];

    //     // Retrieve file details
    //     $fileName = $imageFile["name"];
    //     $tempFilePath = $imageFile["tmp_name"];
    //     $fileSize = $imageFile["size"];

    //     // Move the uploaded file to a desired location
    //     $targetDirectory = "../assets/img_w/"; // Directory where you want to store the images
    //     $targetFilePath = $targetDirectory . $fileName;

    //     if (move_uploaded_file($tempFilePath, $targetFilePath)) {

    // อัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
    $update_query = "UPDATE tb_wasadu SET 
                        w_name = '$w_name', 
                        w_price = '$w_price',
                        c_id = '$c_id', 
                        w_brand = '$w_brand',
                        w_detail = '$w_detail',
                        w_textcom = '$w_textcom'
                    WHERE 
                        w_id = $w_id";
    $update_result = mysqli_query($Connection, $update_query);

    if ($update_result) {
        echo '<script>alert("อัปเดตข้อมูลพัสดุสำเร็จ");window.location="show.php";</script>';
    } else {
        echo '<script>alert("เกิดข้อผิดพลาดในการอัปเดต");window.location="show.php";</script>';
    }
}
//     }
// }
