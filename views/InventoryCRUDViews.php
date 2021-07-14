<?php
    $id = null; 
    $productTitle = null; 
    $productDescription = null; 
    $productImageName_1 = null; 

    $getId = $_GET["Id"]; 
    $getAction = $_GET["action"]; 

    global $wpdb; 

    if ( ! empty($getId))
    {

    }
    else 
    {

    }// end if 

?>
<div class="container">
    <h2>Inventory CRUD Page</h2>

    <h2>Form Validation</h2>
    
    <form action="" class="was-validated" method="post">
        <?php $nounce = wp_create_nonce( 'inventory_nonce' ) ?>


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
                <input type="file" class="custom-file-input" id="photo"  name="photo" required /> 
                
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

