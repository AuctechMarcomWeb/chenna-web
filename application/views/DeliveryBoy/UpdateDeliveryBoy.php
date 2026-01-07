 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Delivery Boy</h1>
     
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
            
            <form class="form-horizontal"  action="<?php echo site_url();?>admin/Dashboard/UpdateBoyData/<?php echo $getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Name*</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" value="<?php echo $getData['name'];?>" name="name" required placeholder=" Name">
                  </div>
                </div>
                
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Mobile*</label>
                  <div class="col-sm-10">
                     <input type="number" class="form-control" value="<?php echo $getData['mobile'];?>" name="mobile" required placeholder=" Mobile Number">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Alternate Mobile*</label>
                  <div class="col-sm-10">
                     <input type="number" class="form-control" value="<?php echo $getData['alternate_mobile'];?>" name="alternate_mobile" required placeholder="Alternate Mobile">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">DOB*</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" value="<?php echo $getData['dob'];?>" name="dob" required placeholder=" DOB">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Gender*</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="gender">
                      <option value="">Select Gender</option>
                      <option value="1"<?php echo ($getData['gender']=='1' ? 'Selected': '')?>>Male</option>
                      <option value="2"<?php echo ($getData['gender']=='2' ? 'Selected': '')?>>Female</option>
                    </select>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                     <input type="email" class="form-control" value="<?php echo $getData['email'];?>" name="email" required placeholder=" Email ">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Profile Pic*</label>
                  <div class="col-sm-10">
                     <input type="file" class="form-control" name="photo">
                     <input type="hidden" value="<?php echo $getData['profile_pic'];?>" name="pre_image">
                     <br>
                    <img src="<?php echo base_url();?>assets/banner_images/boy/<?php echo $getData['profile_pic'];?>" style="width:200px;height:200px;">

                  </div>
                </div>

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Address*</label>
                  <div class="col-sm-10">
  
                   <textarea cols="5" rows="5"  class="form-control" name="address" placeholder="Address" required><?php echo $getData['address'];?></textarea>
                  </div>
                </div>
                
             
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right">Submit</button>
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


  