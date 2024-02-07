    <?php 
    session_start();
    if(empty($_SESSION['name']))
    {
        header('location:index.php');
    }
    include('header.php');
    include('includes/connection.php');

    $id = $_GET['id'];
    $fetch_query = mysqli_query($connection, "select * from Merchant where id='$id'");
    $row = mysqli_fetch_array($fetch_query);

    if(isset($_REQUEST['save-doc']))
    {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $product_delivered = $_REQUEST['product_delivered'];

        $update_query = mysqli_query($connection, "update Merchant set id='$id', name='$name', product_delivered='$product_delivered' where id='$id'");
        if($update_query>0)
        {
            $msg = "Merchnat updated successfully";
            $fetch_query = mysqli_query($connection, "select * from Merchant where id='$id'");
            $row = mysqli_fetch_array($fetch_query);   
        }
        else
        {
            $msg = "Error!";
        }
    }

    ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4 ">
                            <h4 class="page-title">Edit Merchant</h4>
                        </div>
                        <div class="col-sm-8  text-right m-b-20">
                            <a href="doctors.php" class="btn btn-primary btn-rounded float-right">Back</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form method="post" >
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Id <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" name="id" required> 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" type="text" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Products Deliverd <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="product_delivered" required>
                                        </div>
                                    </div>
                                <div class="m-t-20 text-center">

                                    <button name="save-doc" class="btn btn-primary submit-btn">Update Merchant</button>
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