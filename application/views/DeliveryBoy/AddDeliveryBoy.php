 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add Delivery Boy</h1>
     
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
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/AddBoyData/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Name*</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="name" required placeholder=" Name">
                  </div>
                </div>
                
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Mobile*</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" minlength="10" maxlength="10" name="mobile" required placeholder=" Mobile Number">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Alternate Mobile*</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="alternate_mobile" minlength="10" maxlength="10" required placeholder="Alternate Mobile">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">DOB*</label>
                  <div class="col-sm-10">
                     <input type="date" class="form-control" name="dob" required placeholder=" DOB">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Gender*</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="gender">
                      <option value="">Select Gender</option>
                      <option value="1">Male</option>
                      <option value="2">Female</option>
                    </select>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                     <input type="email" class="form-control" name="email" required placeholder=" Email ">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Profile Pic*</label>
                  <div class="col-sm-10">
                     <input type="file" class="form-control" name="photo">
                  </div>
                </div>

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Address*</label>
                  <div class="col-sm-10">
  
                   <textarea cols="5" rows="5" class="form-control" name="address" placeholder="Address" required></textarea>
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


  