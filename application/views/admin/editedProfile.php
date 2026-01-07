 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Profile
       </h1>
     
      
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
      <div class="row">
        <div class="col-md-12">   
          <div class="box box-info">
            
           
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateAdminProfile').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">



                <div class="col-md-12" style=""> 
                  <div class="row" >
                      
                        <div class="col-sm-4">
                            <label for="inputEmail3" class="control-label">Name</label>
                            <input type="text" class="form-control"  name="name" id="name" placeholder="Name" value = "<?php  echo $getData['name']?>" required>
                         </div>

                        <div class="col-sm-4">
                          <label for="inputEmail3" class=" control-label">Email</label>
                          <input type="email" class="form-control"  name="email" id="email" placeholder="Email" value="<?php echo $getData['email']?>" required>
                        </div>


                        <div class="col-sm-4">
                          <label for="inputEmail3" class="control-label">Password</label>
                          <input type="password" class="form-control"  name="password" id="password" placeholder="Password" value = "<?php  echo base64_decode($getData['password'])?>" required>
                        </div>

                  </div>
                </div>

             
                <div class="col-md-12" style=""> 
                  <div class="row" >

                    <div class="col-sm-4">
                      <label for="inputEmail3" class="control-label">Contact Number</label>
                      <input type="number" class="form-control"  name="phone_no" id="phone_no" placeholder="Contact Number" value = "<?php  echo $getData['phone_no']?>" onKeyPress="if(this.value.length==12) return false;" >
                    </div>


                    <div class="col-sm-4">
                       <label for="inputEmail3" class="control-label">Profile Pic</label>
                        <input type="file" id="exampleInputFile" name="uploadFile">
                         <?php if($getData['profile_pic']!=" ") {?><img src="<?php echo base_url()."assets/Website/img/".$getData['profile_pic']; ?>" style="width: 115px;"> <?php } ?>
                      </div>
                 </div>
                </div>
            
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right">Update</button>
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