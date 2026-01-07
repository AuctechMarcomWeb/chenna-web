<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-Commerecre | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
<link rel="shortcut icon" href="<?php echo site_url();?>assets/favicon_1.ico" type="image/x-icon"> 
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url('assets/images/android-icon-36x36.png'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/dist/css/skins/_all-skins.min.css">
   <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/plugins/iCheck/square/blue.css">
  
 
  <script src="<?php echo site_url(); ?>assets/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script> -->
  <script src="<?php echo site_url(); ?>assets/admin/js/jquery-ui.min.js"></script>

  <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms2").fadeOut(5000);
  }



  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   
  

  <style type="text/css">
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;

    /*padding: 23px;*/
    border: 1px solid #888;
    width: 37%;
}

/* The Close Button */
.close {
    color: #820505;
    float: right;
    font-size: 28px;
    font-weight: bold;
    padding-right: 13px;
}

.login-page2{
  background-image: url(<?php  echo base_url('/assets/admin.jpg');?>) !important;
  background-size: cover !important;
}
.login-page1{

  background-image: url(<?php  echo base_url('/assets/admin.png');?>) !important;

}
.login-page3{
  background-image: url(<?php  echo base_url('/assets/admin.png');?>) !important;

}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

h4{
  text-align:center;
}
.container form{
  width:250px;
  margin:20px auto;
}
i{
  cursor:pointer;
}
   </style>
</head>
  <?php $TypeOfLogin = $this->uri->segment('1'); ?>

<body class="hold-transition <?php echo  $TypeOfLogin = $this->uri->segment('1');?>  <?php  if($TypeOfLogin == 'admin'){ echo  'login-page2';} if($TypeOfLogin == 'school'){echo  'login-page1';} if($TypeOfLogin == 'vendor') { echo 'login-page3'; } ?> ">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="login-box-body">
  <div class="login-logo">
   <img src="<?php echo site_url().'assets/logo.png' ?>" style="max-width:224px;"> <br/> Recover Password
  </div>
    
  <?php echo $this->session->flashdata('login_message'); ?>

     <div id="show_message" style="display: none;">
       <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Password Change Successfully</div>
     </div>
  
  

      <div class="form-group has-feedback">
        <input type="hidden" name="loginType" class="form-control" value="2">
      </div>
     
      <div class="form-group has-feedback" id="hide_mobile">
        <input type="number" id="mobile" name="mobile" class="form-control" placeholder="Mobile" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "10">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span id="error"></span>
      </div>

     <div class="form-group has-feedback" style="display: none;" id="show_otp">
         <span>OTP Send Your Registred Mobile Number.</span>
         <input type="number" id="otp" name="mobile" class="form-control" placeholder="Enter OTP" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "6">
           <span id="otp_error"></span>

      </div>

      <div class="form-group has-feedback" style="display: none;" id="show_password">
        <span>Enter New Password</span>
         <input type="password"  name="password" id="password" class="form-control" placeholder="Enter New Password" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"maxlength = "13">
         <div class="input-group-prepend" style=" margin-top: -29px;margin-left: 281px;">
              <div class="input-group-text"><i class="fa fa-eye-slash" style="font-size:24px" id="eye"></i></div>
            </div>
         <br>

         <span>Enter Confirm Password</span>
         <input type="password"   id="confPassword" class="form-control" placeholder="Enter Confirm Password" required maxlength = "13" oninput="match_password();">
         <div class="input-group-prepend" style=" margin-top: -29px;margin-left: 281px;">
              <div class="input-group-text"><i class="fa fa-eye-slash" style="font-size:24px" id="eye2"></i></div>
            </div>
          <span id="pass_error"></span>
           

      </div>
     
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
           
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4" id="hide_btn">
          <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="check_mobile()">Submit</button>
        </div>

        <div class="col-xs-4" style="display:none" id="show_btn">
          <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="check_otp()">Submit</button>
        </div>

        <div class="col-xs-4" style="display:none" id="show_btn_last">
          <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="change_password()" id="chngPass">Submit</button>
        </div>
        <!-- /.col -->
      </div>
  
      
      <!-- /.login-box-body -->



  <div id="myModal" class="modal" style="">
  <!-- Modal content -->


  

</div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/admin/dist/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin/dist/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>"></script>
<script>

function check_mobile() {

 var mobile = $('#mobile').val();

if(mobile=='') {

   $('#error').text('Please Enter Mobile Number.').css("color","red");
   return false;

 } else {

   $('#error').text('');

   $.ajax({
         url:'<?php echo base_url('admin/welcome/check_mobile'); ?>',
         type:'POST',
         data:{mobile:mobile},
         dataType:'text',
         success:function(response){

          if(response=='0'){

             $('#error').text('Please Enter Valid Mobile Number.').css("color","red");

          } else { 

            $('#error').text('');
            $('#show_otp').show();
            $('#hide_mobile').hide();
            $('#show_btn').show();
            $('#hide_btn').hide();

          }
         }
     });

  }

}

function check_otp() {
  var mobile = $('#mobile').val();
  var otp = $('#otp').val();

  if(otp=='') {

   $('#otp_error').text('Please Enter OTP.').css("color","red");
   return false;

 } else {

   $('#otp_error').text('');

   $.ajax({
         url:'<?php echo base_url('admin/welcome/check_otp'); ?>',
         type:'POST',
         data:{'mobile':mobile,'otp':otp},
         dataType:'text',
         success:function(response){
           if(response=='0'){

            $('#otp_error').text('Please Enter Valid OTP.').css("color","red");

          } else { 

            $('#otp_error').text('');
            $('#show_password').show();
            $('#show_otp').hide();
            $('#show_btn_last').show();
            $('#show_btn').hide();
           

          }
         
         }
     });

 }

}


function change_password() {
  var mobile = $('#mobile').val();
  var password = $('#password').val();
  if(password=='') {

   $('#pass_error').text('Please Enter Password.').css("color","red");
   return false;

 } else {

    $.ajax({
         url:'<?php echo base_url('admin/welcome/change_password'); ?>',
         type:'POST',
         data:{'mobile':mobile,'password':password},
         dataType:'text',
         success:function(response){
           if(response=='1') {
             $('#show_message').show();
            setTimeout(function(){ 
                window.location.href="https://shopmet.com/seller-login";
               }, 3000);
           }

           
         
         }
     });

 }

}

function match_password(){
 var password  = $('#password').val();
 var confPassword = $('#confPassword').val();
 if(password==confPassword) {

  $('#chngPass').attr("disabled",false);
  $('#pass_error').text('').css("color","red");
 } else {

  $('#pass_error').text("Old Password And New password doesn't match.").css("color","red");
  $('#chngPass').attr("disabled",true);

 }


}




</script>

<script type="text/javascript">
  $(function(){
  
  $('#eye').click(function(){
       
        if($(this).hasClass('fa-eye-slash')){
           
          $(this).removeClass('fa-eye-slash');
          
          $(this).addClass('fa-eye');
          
          $('#password').attr('type','text');
            
        }else{
         
          $(this).removeClass('fa-eye');
          
          $(this).addClass('fa-eye-slash');  
          
          $('#password').attr('type','password');
        }
    });
});

  $(function(){
  
  $('#eye2').click(function(){
       
        if($(this).hasClass('fa-eye-slash')){
           
          $(this).removeClass('fa-eye-slash');
          
          $(this).addClass('fa-eye');
          
          $('#confPassword').attr('type','text');
            
        }else{
         
          $(this).removeClass('fa-eye');
          
          $(this).addClass('fa-eye-slash');  
          
          $('#confPassword').attr('type','password');
        }
    });
});
</script>



</body>
</html>
