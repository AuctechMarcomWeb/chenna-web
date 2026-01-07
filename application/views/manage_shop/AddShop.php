 
<?php $adminData = $this->session->userdata('adminData');?>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<style type="text/css">
  .btn-group>.btn:first-child {
    margin-left: 0;
    width: 325px;

}
.multiselect-container>li>a>label.radio, .multiselect-container>li>a>label.checkbox {
    margin: 0;
    width: 320px;
}
</style>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Shop</h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <form class="form-horizontal"  action="<?php echo site_url('admin/shop/addShop/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">


<?php  if($adminData['Type']=='1'){ ?>

                <div class="row" style="margin-left: 10px;">
                 <div class="col-sm-4">
                     <label>Select Seller*</label>
                    <select class="form-control select2" name="vendor_id" required="">
                      <option value="">--Select Seller--</option>
                      <?php  foreach ($VendorList as $key => $VendorList) { ?>
                        <option value="<?=$VendorList['id']?>"><?=$VendorList['name']?></option>
                     
                       <?php } ?>
                      
                    </select>
                  </div>


                  <div class="col-sm-4">
                     <label>Shop Name*</label>
                    
                    <input type="text" class="form-control" name="name" required placeholder=" Name">
                  </div>
                
                  
               
                  <div class="col-sm-4">
                     <label>Slug (URL For Shop Page)</label>
                    
                    <input type="text" class="form-control" name="slug" required placeholder="Slug (URL For Shop Page)">
                  </div>
                </div><br>

                <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                     <label>Business Legal Name (Registered Name)*</label>
                    
                    <input type="text" class="form-control" name="bussiness_name" required placeholder="Business Legal Name (Registered Name)">
                  </div>
                   <div class="col-sm-4">
                     <label>Mobile*</label>
                     <input type="text" class="form-control" minlength="10" maxlength="10" name="mobile" required placeholder=" Mobile Number" onchange="check_mobile(this.value)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10">
                      <span style="color:red" id="mobile_error"></span>
                  </div>

                  <div class="col-sm-4">
                     <label>Email Id*</label>
                     <input type="email" class="form-control"  name="email_id" required placeholder=" Email Id">
                      <span style="color:red" id="mobile_error"></span>
                  </div>

                  
                  
                </div><br>


                
               <div class="row" style="margin-left: 10px;">

                <div class="col-sm-4">
                  <label>WhatsApp No</label>
                     <input type="text" class="form-control" name="whatsApp_number" minlength="10" maxlength="10"  placeholder="WhatsApp No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10">
                  </div>

                 <div class="col-sm-4">
                     <label>PAN No</label>
                    
                    <input type="text" class="form-control" name="pan_no"  placeholder="PAN No">
                  </div>

                   <div class="col-sm-4">
                     <label>GST Number</label>
                    
                    <input type="text" class="form-control" name="gst_number"  placeholder="GST Number">
                  </div>
                 
                  
                  
                  
                </div><br>


                <div class="row" style="margin-left: 10px;">

                  <div class="col-sm-4" >
                     <label>Address</label>
                     <input type="text" class="form-control" name="address" placeholder="Address">
                  </div>

                  <div class="col-sm-4" >
                     <label>Locality</label>
                     <input type="text" class="form-control"  name="locality" placeholder="Locality">
                  </div>

                  <div class="col-sm-4" >
                     <label>Pincode</label>
                     <input type="number" class="form-control"  name="pincode" placeholder="Pincode">
                  </div>

                 
                  
                </div><br>
                 <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                    <label>State</label>
                    <select class="form-control select2" name="state_id"  onchange="get_city_by_id(this.value)">
                      <option value="">--Select State--</option>
                      <?php  foreach ($stateList as $key => $stateList) { ?>
                        <option value="<?=$stateList['id']?>"><?=$stateList['name']?></option>
                     
                       <?php } ?>
                      
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>City</label>
                     <select class="form-control select2" name="city_id" id="set_city" >
                      <option value="">--Select City--</option>
                    </select>
                  </div>
                 </div><br>
              
     <?php } else { ?>



            <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                     <label>Shop Name*</label>
                    
                    <input type="text" class="form-control" name="name" required placeholder=" Name">
                  </div>
                
                  
               
                  <div class="col-sm-4">
                     <label>Slug (URL For Shop Page)*</label>
                    
                    <input type="text" class="form-control" name="slug" required placeholder="Slug (URL For Shop Page)">
                  </div>

                  <div class="col-sm-4">
                     <label>Business Legal Name (Registered Name)*</label>
                    
                    <input type="text" class="form-control" name="bussiness_name" required placeholder="Business Legal Name (Registered Name)">
                  </div>

                </div><br>

                <div class="row" style="margin-left: 10px;">
                  
                   <div class="col-sm-4">
                     <label>Mobile*</label>
                     <input type="text" class="form-control" minlength="10" maxlength="10" name="mobile" required placeholder=" Mobile Number" onchange="check_mobile(this.value)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10">
                      <span style="color:red" id="mobile_error"></span>
                  </div>

                  <div class="col-sm-4">
                     <label>Email Id*</label>
                     <input type="email" class="form-control"  name="email_id" required placeholder=" Email Id">
                      <span style="color:red" id="mobile_error"></span>
                  </div>

                  <div class="col-sm-4">
                  <label>WhatsApp No</label>
                     <input type="text" class="form-control" name="whatsApp_number" minlength="10" maxlength="10"  placeholder="WhatsApp No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10">
                  </div>

                  
                  
                </div><br>


                
               <div class="row" style="margin-left: 10px;">

                <div class="col-sm-4">
                     <label>PAN No</label>
                    
                    <input type="text" class="form-control" name="pan_no"  placeholder="PAN No">
                  </div>
                 

                   <div class="col-sm-4">
                     <label>GST Number</label>
                    
                    <input type="text" class="form-control" name="gst_number" placeholder="GST Number">
                  </div>
                  <div class="col-sm-4" >
                     <label>Address</label>
                     <input type="text" class="form-control"  name="address" placeholder="Address">
                  </div>
                  
                  
                  
                  
                </div><br>


                <div class="row" style="margin-left: 10px;">

                   <div class="col-sm-4" >
                     <label>Locality</label>
                     <input type="text" class="form-control"  name="locality" placeholder="Locality">
                  </div>

                  <div class="col-sm-4" >
                     <label>Pincode</label>
                     <input type="number" class="form-control"  name="pincode" placeholder="Pincode">
                  </div>

                 <div class="col-sm-4">
                    <label>State</label>
                    <select class="form-control select2" name="state_id"  onchange="get_city_by_id(this.value)">
                      <option value="">--Select State--</option>
                      <?php  foreach ($stateList as $key => $stateList) { ?>
                        <option value="<?=$stateList['id']?>"><?=$stateList['name']?></option>
                     
                       <?php } ?>
                      
                    </select>
                  </div>
                  </div><br>
                  <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                    <label>City</label>
                     <select class="form-control select2" name="city_id" id="set_city" >
                      <option value="">--Select City--</option>
                    </select>
                  </div>
                  
                </div><br>
                 



     <?php } ?>
              
             
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right submit" id="submit_button">Submit</button>
              </div>
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

 function get_city_by_id(id){
 var Url = "<?php  echo base_url('admin/Users/get_city_by_id')?>/"+id;
          $.ajax({
            type: "POST",
            url: Url,    
            success: function(result){
              console.log(result)
            $('#set_city').html(result);
                    
            }
          });
        }


</script>  