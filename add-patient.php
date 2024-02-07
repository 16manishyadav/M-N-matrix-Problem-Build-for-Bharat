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

if (isset($_REQUEST['add-pincode'])) {
    $pincode = isset($_REQUEST['pincode']) ? $_REQUEST['pincode'] : '';
    $selectedMerchantIds = isset($_REQUEST['merchant_ids']) ? $_REQUEST['merchant_ids'] : [];

    // Validate pincode before insertion
    if (!empty($pincode) && is_numeric($pincode)) {
        // Check if the pincode already exists in the PincodeMerchant table
        $existingPincodeQuery = mysqli_query($connection, "SELECT pincode FROM PincodeMerchant WHERE pincode = '$pincode'");
        $existingPincode = mysqli_fetch_assoc($existingPincodeQuery);

        if (!$existingPincode) {
            // Validate merchant_ids against existing merchant ids
            $invalidMerchantIds = array_diff($selectedMerchantIds, $merchantIds);

            if (empty($invalidMerchantIds)) {
                // All entered merchant ids are valid, proceed with insertion
                $merchant_ids = implode(',', $selectedMerchantIds);
                $insert_query = mysqli_query($connection, "INSERT INTO PincodeMerchant (pincode, merchant_ids) VALUES ('$pincode', '$merchant_ids')");

                if ($insert_query) {
                    $msg = "Pincode created successfully";
                } else {
                    $msg = "Error!";
                }
            } else {
                // Display an error for invalid merchant ids
                $msg = "Invalid Merchant Ids: " . implode(', ', $invalidMerchantIds);
            }
        } else {
            // Display an error for duplicate pincode
            $msg = "Pincode '$pincode' already exists. Please enter a different pincode.";
        }
    } else {
        $msg = "Invalid pincode. Please enter a valid numeric value.";
    }
}
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 ">
                <h4 class="page-title">Add Pincode</h4>
            </div>
            <div class="col-sm-8 text-right m-b-20">
                <a href="patients.php" class="btn btn-primary btn-rounded float-right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form method="post">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pincode <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="pincode" required>
                        </div>
                    </div>
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
                        <button name="add-pincode" class="btn btn-primary submit-btn">Create Pincode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
<script type="text/javascript">
     <?php
        if(isset($msg)) {
            echo 'swal("' . $msg . '");';
        }
    ?>
</script>
