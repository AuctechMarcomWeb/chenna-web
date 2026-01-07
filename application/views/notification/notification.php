<!-- Content Wrapper. Contains page content -->
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
    <style type="text/css">
      .location{
              font-size: 20px;
              color: sienna;
              text-decoration:justify;
      }
    </style>
    <script type="text/javascript">
      function puch(){
        var r = confirm('Are you sure. you want to sent Push Notification.');
        if (r == true) {
           return true;
        }else{
          return false;
        }
      }
    </script>
    <script type="text/javascript">
      function puch1(){
        var r = confirm('Are you sure. you want to sent  SMS.');
        if (r == true) {
           return true;
        }else{
          return false;
        }
      }
    </script>
    <script type="text/javascript">
      function puch2(){
        var r = confirm('Are you sure. you want to sent  SMS && Push  Notification.');
        if (r == true) {
           return true;
        }else{
          return false;
        }
      }
    </script>
    
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>Sent Push Notification<small></small> </h1>
        
      </section>
      <!-- Main content -->
      <section class="content">
          <div class="row">
            <div class="col-xs-12">
            <div class="box box-info">
             <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
           
          <div class="box-body">
               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="radio" checked name="Notification_On" class="radio_btn" id="1"  value="1" style="margin-left:15px">&nbsp;&nbsp; <lable for="1"> Notification </lable>
                   <!--  <input type="radio" name="Notification_On" class="radio_btn"  id="2" value="2" style="margin-left:15px">&nbsp;&nbsp;  <lable for="2"> SMS </lable>
                    <input type="radio" name="Notification_On" class="radio_btn" id="3" value="3" style="margin-left:15px">&nbsp;&nbsp; <lable for="3"> Both </lable> -->
                </div>
              </div>
    <div  class="abc" id="pro_1" style="margin-top:40px;">
     <form name='registration' class="form-horizontal" action="<?php echo site_url('admin/Notification/sentNotification/');?>" method="post" enctype="multipart/form-data" onsubmit="return puch()">  
            <div class="form-group" >
              <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Title</label>
                <div class="col-sm-9"> 
                  <input type="hidden" name="Notification_On" value="1">
                  <input type="text" name="title" class="form-control" required placeholder="Enter Push Notification Title">
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Message</label>
              <div class="col-sm-9"> 
                <textarea class="form-control" required name="message" rows="8" ></textarea>
              </div>
            </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-9">
                  <input type="file" id="exampleInputFile" name="uploadImage">
                </div>
              </div>
              </div>
              <div class="box-footer">
               <input type="submit"  class="btn btn-primary pull-right" value="Send">
              </div>
            </form>
        </div>
      <div  class="abc" id="pro_2" style="display: none; margin-top:40px;" >
       <form name='registration' class="form-horizontal" action="<?php echo site_url('admin/Notification/sentNotification/');?>" method="post" enctype="multipart/form-data" onsubmit="return puch1()">  
            <div class="form-group" >
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Message</label>
              <div class="col-sm-9">
                <input type="hidden" name="Notification_On" value="2"> 
                <textarea class="form-control" required name="message1" rows="8" ></textarea>
              </div>
            </div>
            </div>
            <div class="box-footer">
               <input type="submit"  class="btn btn-primary pull-right" value="Send">
              </div>
        </form>
        </div>
 <div  class="abc" id="pro_3" style="display: none; margin-top:40px;">
  <form name='registration' class="form-horizontal" action="<?php echo site_url('admin/Notification/sentNotification/');?>" method="post" enctype="multipart/form-data" onsubmit="return puch2()">  
            <div class="form-group" >
              <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Title</label>
                <div class="col-sm-9">
                 <input type="hidden" name="Notification_On" value="3"> 
                  <input type="text" name="title1" class="form-control"required placeholder="Enter Push Notification Title">
          <span>Title is not applicable for SMS.</span>
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Select Users</label>
                <div class="col-sm-9"> 
                  <select class="form-control" name="user_limit" required>
                        <option value="">-select users for send sms and notification-</option>
                      <option value="1">1 to 100</option>
                      <option value="2">101 to 200</option>
                      <option value="3">201 to 300</option>
                      <option value="4">301 to 400</option>
                      <option value="4">401 to 500</option>
          </select>
          
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Message</label>
              <div class="col-sm-9"> 
                <textarea class="form-control" required name="message2" rows="8" ></textarea>
              </div>
            </div>

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-9">
                  <input type="file" id="exampleInputFile" name="uploadImage1">
           <span>Image is not applicable for SMS.</span>
                </div>
              </div>
              </div>
              <div class="box-footer">
               <input type="submit"  class="btn btn-primary pull-right" value="Send">
              </div>

          </form>   
        </div>

    
        
 </div>
              
           
              <!-- /.box -->
          <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    
 <script>
    $('.radio_btn').on('click', function(){
      var id = $(this).attr('id');
        $('.abc').hide();
        $('#pro_'+id).show();
    });
</script>   