
<?php

    //// Ref: https://www.w3schools.com/php/php_file_upload.asp

    $dirName = "imgs"; 
    $productFileBase = get_template_directory() ; 
    $target_dir = $productFileBase . "/" . $dirName . "/"; 

    // $target_dir = "uploads/";


    if ( ! file_exists($target_dir))
    {
        mkdir($target_dir); 
        
    }// end if 

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"]))
    {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) 
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else 
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }// end if 
    }// end if 

    // Check if file already exists
    if (file_exists($target_file)) 
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }// end if 

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 128000000) // 128 Mb
    {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }// end if 

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") 
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }// end if 

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } 
    else 
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } 
        else 
        {
            echo "Sorry, there was an error uploading your file.";
        }// end if 
    }// end if 
?>

<div class="container">
    <form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
    <input type="submit" class="btn btn-primary" value="Upload Image" name="submit">
    </form>
</div>