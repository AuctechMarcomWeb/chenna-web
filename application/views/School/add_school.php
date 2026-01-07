 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add School
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/AddNewSchool/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">School Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="school_name" id="inputEmail3" placeholder="School Name" required>
                  </div>
                </div>
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Contact Person</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="person_name" id="inputEmail3" placeholder="Contact Person" required>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Contact Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="phone_no" id="inputEmail3" placeholder="Contact Number" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Email</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="school_email" id="school_email" placeholder="Email-id " required  onchange="check(this.value)">
                      <div id="err_email" style="color:red"></div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Password</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="password" id="inputEmail3" placeholder="Password " required>
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-info pull-right"> Submit</button>
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
    

    function CheckEmail(value) {

      var url = "<?php echo site_url('admin/School/CheckEmailExist');?>";
      
      $.ajax({
          type: "POST", 
          url:url , 
          data: {email: value},
          success:function(response){
            console.log(response);
                if(response > 0)
                {
                  $('#err_email').html("This Email Already Exsist");
                }
                if(response ==0)
                {
                  $('#err_email').html("");
                }
            
            }
          });
         

        }
  </script>