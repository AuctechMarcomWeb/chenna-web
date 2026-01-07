 <?php $adminData= $this->session->userdata('adminData'); ?>

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
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Profile Management</h1>
     <?php  $type = @$_GET['Type'];?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="<?=(empty($type))?'active':''?>"><a href="#tab_1" data-toggle="tab">Profile</a></li>
                        <li class="<?=(!empty($type))?'active':''?>"><a href="#tab_2" data-toggle="tab">Documents</a></li>
                      </ul>
                    <div class="tab-content">
                    <div class="tab-pane <?=(empty($type))?'active':''?>" id="tab_1">
                      <form class="form-horizontal"  action="<?php echo site_url();?>admin/Users/myAccount/<?=$getData['id'];?>" method="POST" enctype="multipart/form-data">
                      <div class="row">

                       <div class="col-md-4">
                        <?php if(!empty($getData['profile_pic'])){ ?>

                          <img src="<?php echo base_url();?>/assets/Website/img/<?=$getData['profile_pic'];?>" class="img-circle" alt="User Image" style="width:160px;height:150px;margin-left: 100px;">

                        <?php } else { ?>

                          <img src="<?php echo base_url();?>/assets/images/account02.png" class="img-circle" alt="User Image" style="width:150px;height:150px;margin-left: 100px;">

                        <?php } ?>

                          <br><br>
                           
                           <input type="file" name="uploadFileVendor">
                           <p style="margin-top: 10px;">Email Address</p>
                           <p><b><?=$getData['email']?></b>&nbsp;&nbsp; 

                          <?php if($getData['email_verify']=='1'){ ?>
                            <span class="text-danger" style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span></p>
                         <?php  } else { ?>

                            <span class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span></p>
                            <input type="button" class="btn btn-danger" value="Verify Now" onclick="verify_email(<?=$getData['id'];?>)">

                         <?php } ?>
                            


                           <p style="margin-top: 10px;">Mobile No.</p>
                           <p><b><?=$getData['mobile']?></b>&nbsp;&nbsp; 

                            <?php if($getData['mobile_verify']=='1'){ ?>

                            <span class="text-danger"  style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span></p>

                           <?php  } else { ?>

                            <span  class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span></p>

                            <input type="button" class="btn btn-danger" value="Verify Now" onclick="verify_mobile(<?=$getData['id'];?>)">

                         <?php } ?>
                       </div>

                         <div class="col-md-8">
                          <div class="row" style="margin-left: 10px;">
                            <div class="col-sm-6">
                               <label>Full Name*</label>
                              
                              <input type="text" class="form-control" name="name" required placeholder=" Name" value="<?=$getData['name'];?>">
                            </div>
                          
                            <div class="col-sm-6">
                               <label>Mobile No.*</label>
                                <input type="text" class="form-control" minlength="10" maxlength="10" name="mobile" required placeholder=" Mobile Number" onchange="check_mobile(this.value)" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10" value="<?=$getData['mobile'];?>" readonly>
                                <span style="color:red" id="mobile_error"></span>
                            </div>
                         
                           
                          </div><br>

                          <div class="row" style="margin-left: 10px;">

                             <div class="col-sm-6">
                            <label>WhatsApp No</label>
                               <input type="text" class="form-control" name="whatsaap_number" minlength="10" maxlength="10"  placeholder="WhatsApp No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10" value="<?=$getData['whatsaap_number'];?>">
                            </div>

                            <div class="col-sm-6">
                              <label>Email Id*</label>
                               <input type="email" class="form-control" name="email" placeholder="Email Id" required="" onchange="check_email(this.value)" value="<?=$getData['email'];?>">
                      
                                <span style="color:red" id="email_error"></span>
                            </div>
                          </div><br>

                           <div class="row" style="margin-left: 10px;">
                            <div class="col-sm-12" >
                               <label>Address*</label>
                              <input value="<?=$getData['address'];?>" type="text" class="form-control"  name="address" placeholder="Address">
                            </div>
                          </div><br>


                          
                         <div class="row" style="margin-left: 10px;">
                            <div class="col-sm-6" >
                               <label>Locality*</label>
                              <input type="text" value="<?=$getData['locality'];?>" class="form-control" name="locality" placeholder="Locality">
                            </div>

                            <div class="col-sm-6" >
                               <label>Pincode*</label>
                               <input type="number"  value="<?=$getData['pincode'];?>" class="form-control"  name="pincode" placeholder="Pincode">
                            </div>
                            
                            
                          </div><br>


                          <div class="row" style="margin-left: 10px;">
                           <div class="col-sm-6">
                            <label>State*</label>
                             <select class="form-control select2" name="state_id"  onchange="get_city_by_id(this.value)">
                                <option value="">--Select State--</option>
                                <?php  foreach ($stateList as $key => $stateList) { ?>
                                  <option value="<?=$stateList['id']?>" <?=($getData['state_id']==$stateList['id'])?'selected':''?>><?=$stateList['name']?></option>
                                   <?php } ?>
                                </select>
                            </div>

                            <div class="col-sm-6">
                              <label>City*</label>
                               <select class="form-control select2" name="city_id" id="set_city" >
                                  <option value="">--Select City--</option>
                                   <?php 
                                    $city = $this->db->get_where('cities_list',array('state_id'=>$getData['state_id']))->result_array();
                                   foreach ($city as $key => $city) { ?>
                                              <option value="<?php echo $city['id']; ?>"<?php echo ($city['id']==$getData['city_id'])?'Selected':'' ?>><?php echo $city['name'];?></option>
                                              
                                            <?php  } ?>
                               </select>
                            </div>
                          </div><br>

                          <?php if($adminData['Type']=='1') { ?>

                           <div class="row" style="margin-left: 10px;">
                             <div class="col-sm-3">
                               <input type="checkbox" name="mobile_verify" <?=($getData['mobile_verify']=='1')?'checked':''?> >&nbsp;&nbsp;&nbsp;<b>Is Phone Verified</b>
                             </div>
                             <div class="col-sm-3">
                                <input type="checkbox" name="email_verify" <?=($getData['email_verify']=='1')?'checked':''?> >&nbsp;&nbsp;&nbsp; <b>Is Email Verified</b>
                             </div>
                             <div class="col-sm-3">
                                <input type="checkbox" name="account_verify" <?=($getData['account_verify']=='1')?'checked':''?> >&nbsp;&nbsp;&nbsp; <b>Is Account Verified</b>
                             </div>

                           </div><br>

                           <div class="row" style="margin-left: 10px;">
                             <div class="col-sm-3">
                               <input type="checkbox" name="kyc_verify" <?=($getData['kyc_verify']=='1')?'checked':''?> >&nbsp;&nbsp;&nbsp; <b>Is KYC Done</b>
                             </div>
                             <div class="col-sm-3">
                                <input type="checkbox" name="status" <?=($getData['status']=='1')?'checked':''?> >&nbsp;&nbsp;&nbsp; <b>Is Active</b>
                             </div>
                             <div class="col-sm-3">
                               <a href="<?php echo base_url();?>admin/users/sendSmsEmail/<?=$getData['id'];?>"><span class="btn btn-info">Send Alert</span></a>
                             </div>

                           </div>




                          <?php } ?>





                      </div>

                  </div>

                          <div class="box-footer">
                            
                            <button type="submit" class="btn btn-info pull-right submit" id="submit_button">Submit</button>
                          </div>

                          </form>
                          
            </div>
                        
                      <div class="tab-pane <?=(!empty($type))?'active':''?>" id="tab_2">

                      <form class="form-horizontal"  action="<?php echo site_url();?>admin/Users/SaveProfileDocument/<?=$getData['id'];?>" method="POST" enctype="multipart/form-data">
                      <div id="product_html">
                        <div class="row" style="margin-left: 10px;">
                           <div class="col-sm-4" >
                               <label>Document Title*</label>
                              <input type="text"  class="form-control" required="" name="title[]" placeholder="Document Title">

                              <input type="hidden" name="staff_id" class="form-control" value="<?=$getData['id']?>">
                            </div>

                            <div class="col-sm-4" >
                               <label>Serial No.*</label>
                               <input type="text"   class="form-control" required="" name="serial_number[]" placeholder="Serial No.">
                            </div>

                            <div class="col-sm-4" >
                               <label>Upload Soft Copy*</label>
                               <input type="file"  class="form-control" required="" name="document[]" placeholder="Pincode">

                              <div id="add_more_1" style="margin-top: 10px;">
                                <button type="button" class="btn btn-info pull-right"  onclick="addMoreDoc(2);">Add More</button>
                              </div>
                            </div>
                        </div>
                    </div>

          <?php if($adminData['Type']=='1') { ?>

                <div class="row" style="margin-left:10px;">
                <a href="<?php echo base_url();?>admin/users/verify_all/<?=$getData['id']?>/1"> <span class="btn btn-success">Verify All</span></a>
                <a href="<?php echo base_url();?>admin/users/verify_all/<?=$getData['id']?>/2"><span class="btn btn-info">Unverify All</span></a>

          <?php } ?>
                 
              </div>
              <table  class="table table-bordered table-striped" style="margin-top: 50px;">
                
                <thead>
                  <tr>
                    <th>SR</th>
                    <th>TITLE</th>
                    <th>NARATION</th>
                    <th>UPLOAD&nbsp;DATE</th>
                    <th>SOFTCOPY</th>
                    <th style="width: 165px;">ACTION</th>
                  </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                 $getDocData = $this->db->get_where('staff_kyc_document',array('staff_id'=>$getData['id']))->result_array();
                foreach ($getDocData as $value) {?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td><?=$value['title'];?><br>
                        <?php  if($value['verify_status']=='1') { ?>
                          <span class="text-success" style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span>
                       <?php  } else { ?>
                          <span class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span>

                       <?php  } ?>
                        

                      </td>
                      <td><?=$value['serial_number'];?></td>
                      <td><?=date('d-M-Y h:i A',$value['add_date']);?></td>
                      <td>
                        <a href="<?php echo base_url();?>/assets/Website/img/<?=$value['document'];?>" download>
                        <img src="<?php echo base_url();?>/assets/Website/img/<?=$value['document'];?>" class="" alt="User Image" style="width:150px;height:100px;cursor: pointer;">
                      </a>
                      </td>
                      <?php if($adminData['Type']=='2'){?>
                       <td>
                          <?php if($value['verify_status']=='2'){ ?>
                            <a href="<?php echo base_url();?>admin/users/deleteDoc/<?=$value['id'];?>" onclick="return confirm('Are you sure you want to delete this Document?');"><span class="btn btn-danger">Delete</span></a>
                          <?php } ?>

                      </td>

                     <?php } else { ?>

                        <td>
                          <a href="<?php echo base_url();?>admin/users/deleteDoc/<?=$value['id'];?>/<?=$getData['id'];?>" onclick="return confirm('Are you sure you want to delete this Document?');"><span class="btn btn-danger">Delete</span></a>
                          <?php if($value['verify_status']=='1'){ ?>
                          <a href="<?php echo base_url();?>admin/users/verify/<?=$value['id'];?>/2/<?=$getData['id'];?>" onclick="return confirm('Are you sure you want to Unverify this Document?');"><span class="btn btn-info">Unverify</span></a>
                          <?php } else { ?>
                          <a href="<?php echo base_url();?>admin/users/verify/<?=$value['id'];?>/1/<?=$getData['id'];?>" onclick="return confirm('Are you sure you want to verify this Document?');"><span class="btn btn-info">Verify</span></a>
                          <?php } ?>
                          

                        </td>

                     <?php } ?>
                    </tr>

                  <?php $counter ++ ; } ?>
                
                </tbody>
               
              </table>

                        <div class="box-footer">
                        
                        <button type="submit" class="btn btn-info pull-right submit" id="submit_button">Submit</button>
                      </div>
                    </form>
                       
                      </div>
                       
                      </div>
                     
                    </div>
                    
                  </div>
               </div>









                
            
              
             
              <!-- /.box-body -->
              
              <!-- /.box-footer -->
            
          </div>
          <!-- /.box -->
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog" style="width:350px;">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modalTitleV">Verify Mobile Number</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="show_html">
         
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-info" id="mobileOtpSubmit" onclick="verify_mobile_otp('<?php echo $getData['id'] ?>')">Submit</button>
          <button type="submit" class="btn btn-info" id="emailOtpSubmit" onclick="verify_email_otp('<?php echo $getData['id'] ?>')">Submit</button>
        </div>
        
      </div>
    </div>
  </div>
  
<





<script type="text/javascript">

function verify_mobile(id) {
  $.ajax({
         url:'<?php echo base_url('admin/users/verify_mobile'); ?>',
         type:'POST',
         data:{id:id},
         dataType:'HTML',
         success:function(response){
          
          $('#show_html').html(response);
          $('#myModal').modal('show');
         document.getElementById('emailOtpSubmit').style.display = 'none';
         document.getElementById('mobileOtpSubmit').style.display = 'block';
         }
     });


}

function verify_mobile_otp(id) {
  var otpinput = document.getElementById('mobile_otp_ver').value;
  $.ajax({
         url:'<?php echo base_url('admin/users/verify_mobile_otp'); ?>',
         type:'POST',
         data:{id:id, otp: otpinput},
         dataType:'json',
         success:function(response){
           $('#myModal').modal('hide');

           if(response.status =="success"){
            location.reload();
           }else{
              alert(response.message);
           }
           
         }
     });
}


function verify_email(id) {
  const title = document.getElementById('modalTitleV');
  title.innerText = "Verify Email";
  $.ajax({
         url:'<?php echo base_url('admin/users/verify_email'); ?>',
         type:'POST',
         data:{id:id},
         dataType:'HTML',
         success:function(response){
          
          $('#show_html').html(response);
          $('#myModal').modal('show');
         
         document.getElementById('emailOtpSubmit').style.display = 'block';
         document.getElementById('mobileOtpSubmit').style.display = 'none';
         }
     });
}

function verify_email_otp(id) {
  var otpinput = document.getElementById('email_otp_ver').value;
  $.ajax({
         url:'<?php echo base_url('admin/users/verify_email_otp'); ?>',
         type:'POST',
         data:{id:id, otp: otpinput},
         dataType:'json',
         success:function(response){
           $('#myModal').modal('hide');

           if(response.status =="success"){
            location.reload();
           }else{
              alert(response.message);
           }
           
         }
     });
}


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

<script type="text/javascript">
  function addMoreDoc(id){
   $.ajax({
         url:'<?php echo base_url('admin/users/addMoreDoc'); ?>',
         type:'POST',
         data:{id:id},
         dataType:'HTML',
         success:function(response){
          $('#product_html').append(response);
          $('#add_more_'+(id-1)).remove();
        }
     });

}

function remove_row(id){
   $('#remove_'+id).remove(); 

 }
</script> 