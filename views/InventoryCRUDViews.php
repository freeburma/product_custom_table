
<div class="container">
    <h2>Inventory CRUD Page</h2>

    <h2>Form Validation</h2>
    
    <form action="" class="was-validated" method="post">
        <div class="form-group">
            <label for="title">Product Title:</label>
            <input type="text" class="form-control" id="title" placeholder="Enter Product Title" name="title" required>

            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

      

        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" required>

            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this field.</div>
        </div>

        <div class="form-group ">
            <label for="photo">Product Photo:</label> <br />

            <div class="custom-file col-lg-3 col-md-3 col-s-3 col-xs-3">
                <input type="file" class="custom-file-input" id="photo"  name="photo" required /> 
                
                <div class="custom-file-label valid-feedback">File added.</div>
                <div class="custom-file-label invalid-feedback">Please upload the file.</div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
</div>
