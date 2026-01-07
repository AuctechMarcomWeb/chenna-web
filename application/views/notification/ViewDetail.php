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
    
    <!-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/plugins/select2/select2.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>View Notification<small></small> </h1>
        
      </section>
      <!-- Main content -->
      <section class="content">
          <div class="row">
            <div class="col-xs-12">
            <div class="box box-info">
          <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
          
          <div class="box-body">
            <form class="form-horizontal">
          
            <div class="form-group" >
              <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Title</label>
                <div class="col-sm-9"> 
                  <input type="text" name="title" class="form-control" id="pwd" placeholder="Enter Push Notification Title" value="<?php echo $getData['title']  ?>" disabled >
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Message</label>
              <div class="col-sm-9"> 
                <textarea class="form-control" name="message"  disabled  rows="8"> <?php echo $getData['push_msg']?></textarea>
              </div>
            </div>
            <?php $image =  ($getData['image']!="") ?  base_url('assets/notification_images').'/'.$getData['image'] :  base_url('assets/default.jpg');    ?>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-9">
                   <img src="<?php echo  $image ;?>" width="180px" height="150px">
                  </div>
                </div>
              </div>
              </div>

              <div class="box-footer">
                 <button type="button" class="btn btn-info pull-right " onclick="Send(<?php echo $getData['id']; ?>)">Resend</button>
              </div>
            </form>
              <!-- /.box -->
          <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <script src="https://adminlte.io/themes/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
     });
</script>

<script type="text/javascript">

    function Send(id){

      var r = confirm("Are you sure! Send Notification To User ?");
      var url = "<?php echo site_url('admin/Notification/ResendNotification');?>/"+id;
      if (r == true) {

        $('button[type="button"]').attr('disabled','disabled');

        $.ajax({ 
            type: "POST", 
            url: url, 
            dataType: "text", 
            success:function(response){
               window.location.assign("<?php echo site_url('admin/Notification');?>")
              }
            });
          } 

        }
</script>
     