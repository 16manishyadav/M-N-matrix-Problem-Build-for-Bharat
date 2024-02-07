<?php
session_start();
if (empty($_SESSION['name'])) {
    header('location:index.php');
}
include('header.php');
include('includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $pincode = $_POST['pincode'];
    $pincode = mysqli_real_escape_string($connection, $pincode);

    $query = "SELECT m.name, m.product_delivered FROM Merchant m
              JOIN PincodeMerchant pm ON FIND_IN_SET(m.id, pm.merchant_ids)
              WHERE pm.pincode = '$pincode'";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Handle query error
        $error_message = "Error: " . mysqli_error($connection);
    }
}

?>

<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Filter Products by Pincode</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php } ?>

                <form method="post">
                    <div class="form-group">
                        <label for="pincode">Enter Pincode:</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter Products</button>
                </form>

                <?php if (isset($products)) { ?>
                    <h5 class="mt-3">Products delivered to Pincode <?php echo $pincode; ?>:</h5>
                    <ul>
                        <?php foreach ($products as $product) { ?>
                            <li><?php echo $product['name'] . ' - ' . $product['product_delivered']; ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php
include('footer.php');
?>
