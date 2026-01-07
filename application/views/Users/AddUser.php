 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Add User</h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
       
      
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Users/AddUsersData/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
            <!--   <div class="col-md-12" style="text-align: center; background-color: #eee  ">

              <h3 style="padding-bottom: 25px;">Users Informations</h3>
              </div> -->
                <?php /*
                  <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Full Name <span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="UsersName" required placeholder="Full Name">
                  </div>
                </div>


                */?>

                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"> Username <span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="UsersUserName" required placeholder="Username">
                  </div>
                </div>

                 <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label"> Email-Id <span style="color: red">*</span></label>
                  <div class="col-sm-4">
                    <input type="email" class="form-control" name="UsersEmail" required placeholder="Email">
                  </div>
                    
                <!-- </div>
                <div class="form-group"> -->
                <label for="inputEmail3" class="col-sm-2 control-label"> Contact No. <span style="color: red">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="UsersCntct" onchange="ContactnumberCheck(this.value)" required placeholder="Contact Number">
                    <span id="phone_check" style="color:red"></span>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Home Address<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="address1" rows="4" required placeholder="Company Address"></textarea>
                  </div>
                </div>

                <hr>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Name<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="CompanyName" required placeholder="Company Name">
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Phone No.<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="CompanyPhone" required placeholder="Company Phone Number">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Address<span style="color: red">*</span></label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="address2" rows="4" required placeholder="Company Address"></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Company Pan No.</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="CompanyPan" required placeholder="CompanyPan">
                  </div>


                  <label for="inputEmail3" class="col-sm-2 control-label">Company TIN No.<span style="color: red">*</span></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="CompanyTin" required placeholder="Company TIN No.">
                  </div>
                </div>
                
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Upload Pic</label>
                  <div class="col-sm-4">
                   <input type="file" class="form-control" name="uploadFileUsers" >
                  </div>
                </div>
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

  <script type="text/javascript">
     function ContactnumberCheck(num) {
   
      $.ajax({
        type: "POST",
        url: "<?php  echo base_url('admin/Users/CheckContact')?>/"+num,
               
        success: function(result){
          console.log(result)
        if(result==1)
          {
            $('#phone_check').html("Contact Number Already Exsist");
          }else{
            $('#phone_check').html("");
          } 
                
        }
      });
            
      }


  </script>


  