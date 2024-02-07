<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

// Fetch all merchant ids from the Merchant table
$merchantIdsQuery = mysqli_query($connection, "SELECT id FROM Merchant");
$merchantIds = [];
while ($row = mysqli_fetch_assoc($merchantIdsQuery)) {
    $merchantIds[] = $row['id'];
}

if (isset($_REQUEST['update-pincode'])) {
    $pincodeToUpdate = isset($_REQUEST['pincode_to_update']) ? $_REQUEST['pincode_to_update'] : '';
    $newPincode = isset($_REQUEST['new_pincode']) ? $_REQUEST['new_pincode'] : '';
    $selectedMerchantIds = isset($_REQUEST['merchant_ids']) ? $_REQUEST['merchant_ids'] : [];

    // Validate pincode before updating
    if (!empty($pincodeToUpdate) && is_numeric($pincodeToUpdate) && !empty($newPincode) && is_numeric($newPincode)) {
        // Check if the pincode exists in the PincodeMerchant table
        $existingPincodeQuery = mysqli_query($connection, "SELECT pincode FROM PincodeMerchant WHERE pincode = '$pincodeToUpdate'");
        $existingPincode = mysqli_fetch_assoc($existingPincodeQuery);

        if ($existingPincode) {
            // Validate merchant_ids against existing merchant ids
            $invalidMerchantIds = array_diff($selectedMerchantIds, $merchantIds);

            if (empty($invalidMerchantIds)) {
                // All entered merchant ids are valid, proceed with updating
                $merchant_ids = implode(',', $selectedMerchantIds);
                $update_query = mysqli_query($connection, "UPDATE PincodeMerchant SET pincode = '$newPincode', merchant_ids = '$merchant_ids' WHERE pincode = '$pincodeToUpdate'");

                if ($update_query) {
                    $msg = "Pincode updated successfully";
                } else {
                    $msg = "Error updating pincode!";
                }
            } else {
                // Display an error for invalid merchant ids
                $msg = "Invalid Merchant Ids: " . implode(', ', $invalidMerchantIds);
            }
        } else {
            // Display an error if the pincode to update doesn't exist
            $msg = "Pincode '$pincodeToUpdate' does not exist. Please enter a valid pincode to update.";
        }
    } else {
        $msg = "Invalid pincode. Please enter valid numeric values for both old and new pincode.";
    }
}
?>

<!-- The HTML form for updating pincode -->
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <!-- ... (similar code for header) ... -->
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Pincode to Update <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="pincode_to_update" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>New Pincode <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="new_pincode" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Merchant Ids</label>
                                <select class="form-control select2" name="merchant_ids[]" multiple required>
                                    <?php foreach ($merchantIds as $id): ?>
                                        <option value="<?php echo $id; ?>"><?php echo $id; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Hold down the Ctrl (windows) / Command (Mac) button to select multiple merchants.</small>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button name="update-pincode" class="btn btn-primary submit-btn">Update Pincode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script type="text/javascript">
    <?php
    if(isset($msg)) {
        echo 'swal("' . $msg . '");';
    }
    ?>
</script>
