<h1>Product Page</h1>
<div>
    <h3>Inventory Page</h3>

    <form id="inventoryID" action="" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

        <?php $inventoryList->display() ?>

    </form>

</div>