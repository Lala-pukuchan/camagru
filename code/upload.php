<?php
// Initialize the status message
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = isset($_FILES["file"]["name"]) ? basename($_FILES["file"]["name"]) : "";
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

// Allow certain file formats
$allowTypes = array('jpg', 'png', 'jpeg', 'gif');

if(isset($_POST["submit"]) && isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] != UPLOAD_ERR_NO_FILE){
    // Check if file type is valid
    if(in_array($fileType, $allowTypes)){
        // Upload file to the server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            $statusMsg = "The file ".$fileName. " has been uploaded.";
        } else {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    } else {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>
