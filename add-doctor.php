<?php
session_start();
if(empty($_SESSION['name']) || $_SESSION['role']!=1)
{
    header('location:index.php');
}

include('header.php');
include('includes/connection.php');
    
    if(isset($_REQUEST['add-doctor']))
    {
      $id = $_REQUEST['id'];
      $name = $_REQUEST['name'];
      $product_delivered = $_REQUEST['product_delivered'];

      
      $insert_query = mysqli_query($connection, "insert into Merchant set id='$id', name='$name', product_delivered='$product_delivered'");

      if($insert_query>0)
      {
          $msg = "Merchant created successfully";
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
                        <h4 class="page-title">Add Merchant</h4>
                         
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

                                <button name="add-doctor" class="btn btn-primary submit-btn">Create Merchant</button>
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