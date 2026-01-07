 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Manage Settings</h1>
    </section>
<style type="text/css">
  .img_siz{
    margin-top: 10px;
    border:1px solid gray;
    padding: 5px;
  }
  .err_color{color: red;}
</style>
    <!-- Main content -->
    <?php
     // echo '<pre>';
     // print_r($getData); die();

    ?>

    <section class="content">
    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <div class="col-md-12">   
          <div class="box box-info">
            
           
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/Settings');?>" method="POST" enctype="multipart/form-data">
            
            <h3  style="text-align: center; ">Google Console Setting </h3>
              <div class="box-body">

              <div class="form-group"> 
              <div class="col-sm-6">
                  <label for="inputEmail3" class="6 control-label">App Version</label>
                    <input type="text" class="form-control"  name="app_verison" id="app_verison" placeholder="App Version" required value = "<?php  echo $getData['app_verison']?>">
                  <span style="color: red;"><?php echo form_error('app_verison');?></span>
                </div>
                

               <div class="col-sm-6">
                  <label for="inputEmail3" class="control-label">Application Type</label>
                    <Select class="form-control"  name="type" id="type" placeholder="Application Type">
                    <option value= "1" <?php  echo ($getData['type']=='1') ? 'Selected' :''  ?> >Hard</option>
                    <option value= "2" <?php  echo ($getData['type']=='2') ? 'Selected' :''  ?> >Soft</option>
                    </Select>
                  <span style="color: red;"><?php echo form_error('type');?></span>
                </div>
            </div>
                
                 
                <hr>
                <h3  style="text-align: center; ">Order Setting </h3>
                
                
                <div class="form-group">

                <div class="col-sm-6">
                  <label for="inputEmail3" class="control-label">Min Order (RM) </label>
                    <input type="text" class="form-control"  name="min_order_bal" id="min_order_bal" placeholder="Min Order" required value = "<?php  echo $getData['min_order_bal']?>">
                    <span style="font-size:12px;color:#c31b1b">Minimum price for a order against which the shipping amount will be added.</span>
                    <span style="color: red;"><?php echo form_error('min_order_bal');?></span>
                </div>
                
                
                 <div class="col-sm-6">
                   <label for="inputEmail3" class="control-label">Shipping Amount (RM)</label>
                    <input type="text" class="form-control" required id="shipping_amount" placeholder="Shipping Amount" name="shipping_amount" value ="<?php echo $getData['shipping_amount'] ?>">
                    
                     <span style="font-size:12px; color:#c31b1b">Total shipping charges taken against the above minimum order price.</span>
                    <span style="color: red;"><?php echo form_error('shipping_amount');?></span>
                  </div>
                </div>
                
                
                 <hr>
                
               <!--  <h3  style="text-align: center; ">Referral Setting </h3>
                                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Referral Amount (Rs)</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="referel_to_pay" id="referel_to_pay" placeholder="Referel Amount 1" required value = "<?php  echo $getData['referel_to_pay']?>">
                    
                     <span style="font-size:12px; color:#c31b1b">Total amount credited to the referred person</span>

                    <span style="color: red;"><?php echo form_error('referel_to_pay');?></span>
                  </div>

                  </div>
                <div class="form-group">
               
                  <label for="inputEmail3" class="col-sm-2 control-label">Referral code user Amount (Rs)</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" required  name="referel_to_get" id="referel_to_get" placeholder="Referel Amount 2" value = "<?php  echo $getData['referel_to_get']?>">
                  
                   <span style="font-size:12px; color:#c31b1b">Total amount received by the referred person</span>
                   <span style="color: red;"><?php echo form_error('referel_to_get');?></span>
                   </div>
                </div>
                   <div class="form-group">
               
                  <label for="inputEmail3" class="col-sm-2 control-label">Minimum First Purchased Amount (Rs)</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" required  name="min_first_purchase_amt" id="min_first_purchase_amt" value = "<?php  echo $getData['min_first_purchase_amt']?>">
                  
                   <span style="font-size:12px; color:#c31b1b">Minimum first purchase price for a amount will not be added</span>
                   <span style="color: red;"><?php echo form_error('min_first_purchase_amt');?></span>
                   </div>
                </div> -->
 
              
              <!--  <h3  style="text-align: center; ">Profile Completed 
                Setting</h3>
                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Amount (Rs.) </label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="profile_complete_amt" placeholder="Enter amount" required value = "<?php  echo $getData['profile_complete_amt']?>">
                    <span style="font-size:12px;color:#c31b1b">Minimum price for profile completion.</span>
                    <span style="color: red;"><?php //echo form_error('min_order_bal');?></span>
                  </div>
                </div> -->


              <div class="form-group">
                <div class="col-md-12">
                         <label>Address: <span class="err_color">*</span></label>
                          <textarea class="form-control" name="address" rows="4" style="resize: none"><?=  @$_POST['address'] ? @$_POST['address'] : @$getData['address']; ?></textarea>
                          <span class="email_err err_color"><?php echo form_error('address'); ?></span>
                  </div>
              </div>


        
              <div class="form-group">

                 <div class="col-md-4">
                      <label>Contact Number: <span class="err_color">*</span></label>
                        <input type="text" name="contact_no" value="<?=  @$_POST['contact_no'] ? @$_POST['contact_no'] : @$getData['contact_no']; ?>"  class="form-control"  autocomplete="off" placeholder="Contact Number:" >
                        <span class="email_err err_color"><?php echo form_error('contact_no'); ?></span>
                </div>

                  <div class="col-md-4">
                        <label>Email ID: <span class="err_color">*</span></label>
                          <input type="text" name="email_id" value="<?=  @$_POST['email_id'] ? @$_POST['email_id'] : @$getData['email']; ?>"  class="form-control"  autocomplete="off" placeholder="Email ID:" >
                          <span class="email_err err_color"><?php echo form_error('email_id'); ?></span>
                  </div>

                   <div class="col-md-4">                     
                        <label>Facebook Link:</label>
                          <input type="text" name="facebook" value="<?=  @$_POST['facebook'] ? @$_POST['facebook'] : @$getData['facebook']; ?>"  class="form-control"  autocomplete="off" placeholder="Facebook Link:" >
                          <span class="email_err err_color"><?php echo form_error('facebook'); ?></span>
                  </div>
              </div>

            <div class="form-group"> <!-- layer 2 -->
                  <div class="col-md-4">                     
                        <label>Twitter Link:</label>
                          <input type="text" name="twitter" value="<?=  @$_POST['twitter'] ? @$_POST['twitter'] : @$getData['twitter']; ?>"  class="form-control"  autocomplete="off" placeholder="Twitter Link:" >
                          <span class="email_err err_color"><?php echo form_error('twitter'); ?></span>
                  </div>

                    <div class="col-md-4">
                        <label>Instagram Link:</label>
                          <input type="text" name="instagram" value="<?=  @$_POST['instagram'] ? @$_POST['instagram'] : @$getData['instagram']; ?>"  class="form-control"  autocomplete="off" placeholder="Instagram Link:" >
                          <span class="email_err err_color"><?php echo form_error('instagram'); ?></span>
                  </div>

                  <div class="col-md-4">
                        <label>What's App:</label>
                          <input type="text" name="whats_app" value="<?=  @$_POST['whats_app'] ? @$_POST['whats_app'] : @$getData['whats_app']; ?>"  class="form-control"  autocomplete="off" placeholder="What's App Link:" >
                          <span class="email_err err_color"><?php echo form_error('whats_app'); ?></span>
                  </div>
                
              </div>


            <div class="form-group"> <!-- layer 2 -->
                  <div class="col-md-4">                     
                        <label>Messenger Link:</label>
                          <input type="text" name="messenger" value="<?=  @$_POST['messenger'] ? @$_POST['messenger'] : @$getData['messenger']; ?>"  class="form-control"  autocomplete="off" placeholder="Messenger Link:" >
                          <span class="email_err err_color"><?php echo form_error('messenger'); ?></span>
                  </div>

                  <div class="col-md-4">
                        <label>Gmail Link:</label>
                          <input type="text" name="gmail_link" value="<?=  @$_POST['gmail_link'] ? @$_POST['gmail_link'] : @$getData['gmail']; ?>"  class="form-control"  autocomplete="off" placeholder="Gmail Link Link:" >
                          <span class="email_err err_color"><?php echo form_error('gmail_link'); ?></span>
                  </div>

                  <div class="col-md-4">
                        <label>Google Play Store URL:</label>
                          <input type="text" name="app_link" value="<?=  @$_POST['app_link'] ? @$_POST['app_link'] : @$getData['app_url']; ?>"  class="form-control"  autocomplete="off" placeholder="APP Link:" >
                          <span class="email_err err_color"><?php echo form_error('app_link'); ?></span>
                  </div>
              </div>

            <div class="form-group"> <!-- layer 2 -->
                  <div class="col-md-12">                     
                        <label>Apple Play Store URL:</label>
                          <input type="text" name="apple_link" value="<?=  @$_POST['apple_link'] ? @$_POST['apple_link'] : @$getData['apple_link']; ?>"  class="form-control"  autocomplete="off" placeholder="Messenger Link:" >
                          <span class="email_err err_color"><?php echo form_error('apple_link'); ?></span>
                  </div>
              </div>



             <div class="form-group"> <!-- layer 3 -->
                  <div class="col-md-6">                      
                         <label>fevicon Icon:</label>
                          <input type="file"  name="fevicon" class="form-control">
                          <img src="<?= base_url('assets/Website/img/'.@$getData['fevicon_icon']); ?>" class="img_siz" id="blah" style="height: 50px;width:50px;" > 
                  </div>

                  <div class="col-md-6">                      
                        <label>Logo:</label>
                          <input type="file"  name="logo" class="form-control">
                          <label>Logo size should be less than: 507 X 505 px.</label> 
                          <span class="err_color"> <?= $this->session->flashdata('bnn_err'); ?> </span><br>
                          <img src="<?= base_url('assets/Website/img/'.@$getData['logo']); ?>" class="img_siz" id="logo_img" style="height: 100px;width:100px;" > 
                      </div>
                </div> <!-- end -->


              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
                </form>

                
     <!--          <div class="form-group" style="margin-top:30px;">
               <form method="Post" enctype="multipart/form-data" action="<?php echo base_url();?>admin/Dashboard/UpdateSettingBanner">
                  <label for="inputEmail3" class="col-sm-2 control-label">Feature banner</label>
                  <div class="col-sm-8">
                    <input type="file" class="form-control" name="uploadBanner" required>
                  
                   <span style="font-size:12px; color:#c31b1b">Add new Feature banner </span>
                 
                   </div>
                    <div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Add"></div>
                  </form>
                   <span style="margin-left:300px;"><img src="<?php echo base_url();?>assets/banner_images/<?php echo $getData['banner']?>" style="width:200px;height:200px;"></span>

                </div>  -->      
           
          
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
 <script type="text/javascript">
   function readURL(input,id) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#'+id).attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

   $('[name="fevicon"]').change(function(){  readURL(this,'blah'); });
   $('[name="logo"]').change(function(){  readURL(this,'logo_img'); });


 </script>
  </div>