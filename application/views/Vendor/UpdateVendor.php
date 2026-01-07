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
      <h1>Update Seller</h1>
     
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
            <form class="form-horizontal"  action="<?php echo site_url('');?>admin/Vendor/UpdateVendorData/<?=$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                     <label>Name*</label>
                    
                    <input type="text" class="form-control" name="name" required placeholder=" Name" value="<?=$getData['name'];?>">
                  </div>
                
                  <div class="col-sm-4">
                     <label>Mobile*</label>
                     <input type="text" class="form-control" minlength="10" maxlength="10" name="mobile" required placeholder=" Mobile Number" onchange="check_mobile(this.value)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10" value="<?=$getData['mobile'];?>">
                      <span style="color:red" id="mobile_error"></span>
                  </div>
               
                  <div class="col-sm-4">
                  <label>WhatsApp No</label>
                     <input type="text" class="form-control" name="whatsaap_number" minlength="10" maxlength="10"  placeholder="WhatsApp No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10" value="<?=$getData['whatsaap_number'];?>">
                  </div>
                </div><br>

                <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                    <label>Email Id*</label>
                     <input type="email" class="form-control" name="email" placeholder="Email Id" required="" onchange="check_email(this.value)" value="<?=$getData['email'];?>">
                      <span style="color:red" id="email_error"></span>
                  </div>
                  <div class="col-sm-4">
                    <label>Password*</label>
                     <input type="password" class="form-control" name="password" placeholder="Password" >
                      <span style="color:red" id="email_error"></span>
                  </div>
                  <div class="col-sm-4" >
                     <label>Address</label>
                     <input value="<?=$getData['address'];?>" type="text" class="form-control"  name="address" placeholder="Address">
                  </div>
                </div><br>


                
               <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4" >
                     <label>Locality</label>
                     <input type="text" value="<?=$getData['locality'];?>" class="form-control"  name="locality" placeholder="Locality">
                  </div>

                  <div class="col-sm-4" >
                     <label>Pincode</label>
                     <input type="number"  value="<?=$getData['pincode'];?>" class="form-control"  name="pincode" placeholder="Pincode">
                  </div>
                  <div class="col-sm-4">
                    <label>State</label>
                    <select class="form-control select2" name="state_id"  onchange="get_city_by_id(this.value)">
                      <option value="">--Select State--</option>
                      <?php  foreach ($stateList as $key => $stateList) { ?>
                        <option value="<?=$stateList['id']?>" <?=($getData['state_id']==$stateList['id'])?'selected':''?>><?=$stateList['name']?></option>
                     
                       <?php } ?>
                      
                    </select>
                  </div>
                  
                </div><br>


                <div class="row" style="margin-left: 10px;">
                 
                  <div class="col-sm-4">
                    <label>City</label>
                     <select class="form-control select2" name="city_id" id="set_city" >
                      <option value="">--Select City--</option>
                       <?php 
                        $city = $this->db->get_where('cities_list',array('state_id'=>$getData['state_id']))->result_array();
                       foreach ($city as $key => $city) { ?>
                                  <option value="<?php echo $city['id']; ?>"<?php echo ($city['id']==$getData['city_id'])?'Selected':'' ?>><?php echo $city['name'];?></option>
                                  
                                <?php  } ?>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>Status</label>
                    <select class="form-control select2" name="status" required="">
                      <option value="1" <?php echo ($getData['status']=='1' ? 'selected': '')?>>Activated</option>
                    <option value="2" <?php echo ($getData['status']=='2' ? 'selected': '')?>>Deactivated</option>
                    </select>
                 </div>
                </div><br>

              
            
              
             
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
 function check_mobile(mobile){
  $.ajax({
         url:'<?php echo base_url('admin/dashboard/check_mobile4'); ?>',
         type:'POST',
         data:{mobile:mobile},
         success:function(response){
         if(response=='1'){
          $('#mobile_error').text('Mobile Number Already Exits.'); 
          $('#submit_button').attr("disabled",true);
          
         }else{
         $('#mobile_error').text(''); 
         $('#submit_button').attr("disabled",false); 
         }
         }
     });
 }

  function check_email(email){
  $.ajax({
         url:'<?php echo base_url('admin/dashboard/check_email4'); ?>',
         type:'POST',
         data:{email:email,id:''},
         success:function(response){
         if(response=='1'){
          $('#email_error').text('Email Id Already Exits.'); 
          $('#submit_button').attr("disabled",true);
          
         }else{
         $('#email_error').text(''); 
         $('#submit_button').attr("disabled",false); 
         }
         }
     });
 }

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

 $(document).ready(function() {
        $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
        });
    });
</script>  