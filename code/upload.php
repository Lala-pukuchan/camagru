<?php
require 'vendor/autoload.php';

use Cloudinary\Cloudinary;

$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => 'dh4r0lwag', 
        'api_key' => '443722912745622', 
        'api_secret' => 'XxUvHyvNceEquIr9GS24C1BIiw8'
    ],
    'url' => [
        'secure' => true
    ]
]);

// Rest of your code...

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    $file = $_FILES["file"]["tmp_name"];
    $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    
    // Check if file type is valid
    if(in_array($fileType, $allowTypes)){
        try {
            // Upload the file to Cloudinary and get the response
            $response = $cloudinary->uploadApi()->upload($file, [
                'folder' => 'uploads/' // Optional: specify a folder in Cloudinary
            ]);
    
            // URL of the uploaded file
            $uploadedFileUrl = $response['secure_url'];
            
            $statusMsg = "The file has been uploaded successfully. File URL is: " . $uploadedFileUrl;
        } catch (Exception $e) {
            $statusMsg = 'Error: ' . $e->getMessage();
        }
    } else {
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
    }
} else {
    $statusMsg = 'Please select a file to upload.';
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Cloudinary File Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Select Image File to Upload:
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">
    </form>

    <?php
        // Display status message
        echo "<p>$statusMsg</p>";
    ?>
</body>
</html>
