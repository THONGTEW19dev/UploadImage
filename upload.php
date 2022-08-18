<?php
    include 'connect.php';
    session_start();

    // file upload path

    $targetDir = "uploads/";

    if(isset($_POST['submit'])) {
        if(!empty($_FILES['file']['name'])) {
            $filename = basename($_FILES['file']['name']);
            $targetFilePath = $targetDir . $filename;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // allow certain file formats
            $allowTypes = array('jpg','png','jpeg','gif','pdf');

            if(in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                    $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('".$filename."', NOW())");
                    if($insert) {
                        $_SESSION['statusMsg'] = "The file " . $filename . " has been uploaded successfully.";
                        header("location: index.php");
                    } else {
                        $_SESSION['statusMsg'] = "File uploaded fail, please try again.";
                        header("location: index.php");
                    }
                } else {
                    $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                    header("location: index.php");
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files allowed to upload. ";
                header("location: index.php");
            }
        } else {
            $_SESSION['statusMsg'] = "Please select the files to upload.";
            header("location: index.php");
        }
    }

?>