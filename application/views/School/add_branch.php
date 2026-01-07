 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add School Branch
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/School/AddNewBranch/')."/".$this->uri->segment('4');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Address :</label>

                  <div class="col-sm-10">
                    <textarea name = "address"   class="form-control" rows="5"></textarea>
                  </div>
                </div>
            
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Contact number 1</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="phone1" id="inputEmail3" placeholder="Mobile Number" required onchange="CheckNumber(this.value)" >
                    <span id="err_number" style="color:red; font-size:12px"><b>Note</b> : Please don't Use Country code</span>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Contact number 2</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="phone2" id="inputEmail3" placeholder="Landline Number" required onchange="CheckNumber2(this.value)" >
                    <span id="err_number" style="color:red; font-size:12px"><b>Note</b> : Please don't Use State code</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> State</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="state" id="school_email" placeholder="State" required>
                      <div id="err_email" style="color:red"></div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> City</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="city" id="school_email" placeholder="City" required >
                      <div id="err_email" style="color:red"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Zip Code</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="pincode" id="school_email" placeholder="Zip Code" required >
                      <div id="err_email" style="color:red"></div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Country</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control"  name="country" id="school_email" placeholder="Country" required >
                      <div id="err_email" style="color:red"></div>
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
    
  function CheckNumber(value) {
    /* alert(value);
*/
    var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(value)) {
          if(value.length!=10){
            
             $('#err_number').html("Please Enter valid Number  ");
              return false;
            }
          }
          else {
             $('#err_number').html("Please Enter Only Number");
            return false;
         }

    }

  function CheckNumber2(value) {
    /* alert(value);
*/
    var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(value)) {
          if(value.length!=7){
            
             $('#err_number').html("Please Enter valid Number  ");
              return false;
            }
          }
          else {
             $('#err_number').html("Please Enter Only Number");
            return false;
         }

    }
  </script>