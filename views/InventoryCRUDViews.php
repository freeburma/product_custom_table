<?php
    $id = null; 
    $productTitle = null; 
    $productDescription = null; 

    $dirName = "imgs"; 
    $productFileBase = get_template_directory() ; 
    $productFilePath = $productFileBase . "/" . $dirName . "/"; 

    if ( ! file_exists($productFilePath))
    {
        mkdir($productFilePath); 
        
    }// end if 

    // //// Getting theme path and url
    // echo "get_template_directory_uri : ". get_template_directory_uri() . "<br />"; 
    // echo "get_stylesheet_directory_uri: ". get_stylesheet_directory_uri() . "<br />"; 
    // echo "get_stylesheet_uri: ". get_stylesheet_uri() . "<br />"; 
    // echo "get_theme_root_uri: ". get_theme_root_uri() . "<br />"; 
    // echo "get_theme_root: ". get_theme_root() . "<br />";   
    // echo "get_theme_roots: ". get_theme_roots() . "<br />";   
    // echo "get_stylesheet_directory: ". get_stylesheet_directory() . "<br />"; 
    // echo "get_template_directory: ". get_template_directory() . "<br />"; 
    // echo "get_theme_file_uri: ". get_theme_file_uri() . "<br />";   

    // //// Plugin 
    // echo "plugin_dir_path: ". plugin_dir_path(__DIR__) . "<br />";   
    // echo "plugin_dir_url: ". plugin_dir_url(__DIR__) . "<br />";   



    $productImageName_1 = null; 

    date_default_timezone_set('Pacific/Auckland');  // Change to your default timezone 
    $productStoreDate = date("Y-m-d H:i:s");       // Expected output: 2021-07-15 05:02:21 pm

    $getId = $_GET["Id"]; 
    $getAction = $_GET["action"]; 

    global $wpdb; 

    if ( ! empty($getId))
    {

    }
    else 
    {
        $nounce = $_POST["inventory_nonce"]; 

        if (isset($_POST["AddingProduct"]))
        {
            if (wp_verify_nonce( $nounce, 'inventory_nonce' ))
            {
                $productTitle = null; 
                $productDescription = null; 
                $productImageName_1 = null; 

                $productTitle = sanitize_text_field( $_POST["title"] ); 
                $productDescription = sanitize_text_field( $_POST["description"] ); 
                // $productImageName_1 = sanitize_text_field( $_POST["photo_1"] ); 
                $productImageName_1 = sanitize_text_field( $_FILES["photo_1"]["name"]); 

                //// Preparing data to db 
                $productQuery = $wpdb->prepare(" INSERT INTO wp_custom_inventory
                                                 (`Title`, `ProductDescription`, `FilePath`, `ImageName_1`, `StoreDate`)     
                                                 VALUES (%s, %s, %s, %s, %s)", 
                                                 $productTitle, $productDescription, $dirName, $productImageName_1, $productStoreDate
                                                ); 

                $wpdb->query($productQuery); 

                //// ============ Write the photo to a file =============
                //// Ref: https://www.w3schools.com/php/php_file_upload.asp
                $target_file = $productFilePath . basename($_FILES["photo_1"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if (isset($_POST["submit"]))
                {
                    $check = getimagesize($_FILES["photo_1"]["tmp_name"]);
                    if ($check !== false) 
                    {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else 
                    {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) 
                {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size - Change the Max_Post_Size in "php.ini"
                if ($_FILES["photo_1"]["size"] > 128000000) 
                {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") 
                {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } 
                else 
                {
                    if (move_uploaded_file($_FILES["photo_1"]["tmp_name"], $target_file)) 
                    {
                        echo "The file " . htmlspecialchars(basename($_FILES["photo_1"]["name"])) . " has been uploaded.";
                    } 
                    else 
                    {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

               


            }// end if 

            //// Redirecting to this page
            print('<script>window.location.href="admin.php?page=tutorial_product_crud"</script>');

        }// end if 

    }// end if 

?>
<div class="container">
    <h2>Inventory CRUD Page</h2>

    <h2>Form Validation</h2>
    
    <form class="was-validated" method="post" enctype="multipart/form-data" >
        <?php $nounce = wp_create_nonce( 'inventory_nonce' ) ?>
        <input type="hidden" name="inventory_nonce" value="<?php echo $nounce ?>" />


        <div class="form-group">
            <label for="title">Product Title:</label>
            <input type="text" class="form-control" id="title" placeholder="Enter Product Title" name="title" required>

            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

      

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea rows="10" cols="10" class="form-control" id="description" placeholder="Enter Description" name="description" required></textarea>

            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <div class="form-group ">
            <div class="custom-file col-lg-3 col-md-3 col-s-3 col-xs-3">
                <input type="file" class="custom-file-input" id="photo"  name="photo_1" required /> 
                
                <div class="custom-file-label valid-feedback">Photo uploaded.</div>
                <div class="custom-file-label invalid-feedback">Upload your photo.</div>
            </div>

            <div class="fileName">Upload your photo.</div>


        </div>

        <div class="form-group">
        <?php 
            if ( ! empty($getId) && ($getAction == "detail" || $getAction == "edit" )) // Showing detail to update
            {
        ?>
                <button type="submit" class="btn btn-primary" name="UpdatingProduct" class="btn btn-primary">Update</button>
        <?php
            }
            else if ( ! empty($getId) && $getAction == "delete") // Deleting
            {
        ?>
                <button type="submit" class="btn btn-danger" name="DeletingProduct" class="btn btn-primary">Delete</button>

        <?php
            }
            else 
            {
        ?>
                <button type="submit" class="btn btn-info" name="AddingProduct" class="btn btn-primary">Add New</button>
        <?php
            }// end if 
        ?>
        </div>

    </form>
</div>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() 
    {
        var fileName = $(this).val().split("\\").pop();
        $(".fileName").addClass("selected").html(fileName);
    });
   
</script>

