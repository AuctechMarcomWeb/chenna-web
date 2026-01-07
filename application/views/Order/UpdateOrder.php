 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Order</h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
      
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
           <!--  <?php //$adminData = $this->session->userdata('adminData');
                   
                         ?> -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/Order/UpdateOrderStatus').'/'.$getData['Purchase_id'];?>" method="POST" enctype="multipart/form-data">
             <center><h4>Product Detail</h4></center>
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Product Name </label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" required value="<?php echo $getData['product_name']?>" Disabled>
                  </div>
                </div>
           
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Order By</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" required value="<?php echo ucwords($getData['User_name'])?>" Disabled>
                  </div>

                <label for="inputEmail3" class="col-sm-2 control-label"> Product By </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control"  value="<?php echo ucwords($getData['Vendor_name']); ?>" Disabled>
                  </div>
                </div>
               

                 <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Product Price </label>
                  <div class="col-sm-2">
                    <input type="email" class="form-control" name="VendorEmail" required  value="<?php echo $getData['price'] ?>" Disabled>
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label"> Quantity </label>
                  <div class="col-sm-2">
                    <input type="email" class="form-control"  value="<?php echo $getData['quantity'] ?>" Disabled>
                  </div>

                 
                    
                <label for="inputEmail3" class="col-sm-2 control-label"> Final Price </label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control"  required value="<?php echo $getData['final_price'] ?>" Disabled>
                    
                  </div>
                </div>
                    <hr>
                 <center><h4>Order Detail</h4></center>

                <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Order Number </label>
                  <div class="col-sm-4">
                     <input type="text" class="form-control"  required value="<?php echo ucwords($getData['order_number']) ?>" Disabled>
                  </div>

                  <!-- <label for="inputEmail3" class="col-sm-2 control-label">Quantity</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control"  required value="<?php echo $getData['Order_Quantity']?>" Disabled>
                  </div> -->
                </div>
                 <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Total Price </label>
                  <div class="col-sm-4">
                     <input type="text" class="form-control"  required value="<?php echo ucwords($getData['Order_total_price']) ?>" Disabled>
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label">Final Price</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control"  required value="<?php echo $getData['Order_final_price']?>" Disabled>
                  </div>
                </div>
                <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">Deliver To </label>
                  <div class="col-sm-4">
                     <input type="text" class="form-control"  required value="<?php echo ucwords($getData['Address_to']) ?>" Disabled>
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label">Contact no.</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control"  required value="<?php echo $getData['Address_phone_no']?>" Disabled>
                  </div>
                </div>
                <div class="form-group">
                 <label for="inputEmail3" class="col-sm-2 control-label">State </label>
                  <div class="col-sm-4">
                     <input type="text" class="form-control"  required value="<?php echo ucwords($getData['state_name']) ?>" Disabled>
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label">Locality</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control"  required value="<?php echo ucwords($getData['Address_locality'])?>" Disabled>
                  </div>
                </div>

               

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" Disabled name="address1"  required placeholder="Company Address"> <?php echo $getData['Address_area'].", ". $getData['Address_locality'].", ". $getData['Address_Landmark'].". Pin-code  ".$getData['Address_pincode'] ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                   <?php  if($getData['Purchase_status']=='6') { ?>
                    <input type="text" class="form-control"  required value="<?php echo ucwords('Item Delivered')?>" Disabled>
                    <?php } elseif($getData['Purchase_status']=='2') { ?>
                    <input type="text" class="form-control"  required value="<?php echo ucwords('Cancel')?>" Disabled>
                    <?php }else{   ?>
                    <select name="StatusUpdate" style="color:black"  class="form-control">
                     <option value="1" <?php echo ($getData['Purchase_status'] =='1')?'Selected':'' ?>> Pending</option>
                     <option value="3" <?php echo ($getData['Purchase_status'] =='3')?'Selected':'' ?>> Accept</option>
                     <option value="4" <?php echo ($getData['Purchase_status'] =='4')?'Selected':'' ?>> In Process</option>
                     <option value="5" <?php echo ($getData['Purchase_status'] =='5')?'Selected':'' ?>> Shipped</option>
                     <option value="6" <?php echo ($getData['Purchase_status'] =='6')?'Selected':'' ?>> Delivered </option>
                   </select>
                   <?php }?>
                  </div>
                </div>

                 
                <?php if($getData['Purchase_status']!='6' && $getData['Purchase_status']!='2') {?>

                  <div class="box-footer">
                    
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                  <?php } ?>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <script type="text/javascript">
     function ContactnumberCheck(num) {
    alert(num);
      $.ajax({
        type: "POST",
        url: "<?php  echo base_url('admin/Vendor/CheckContact')?>/"+num,
               
        success: function(result){
          console.log(result)
        if(result==1)
          {
            $('#phone_check').html("Contact Number Already Exsist");
          }else{
            $('#phone_check').html("");
          } 
                
        }
      });
            
      }


  </script>


  