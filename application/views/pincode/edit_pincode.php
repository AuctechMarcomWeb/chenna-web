 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Pincode</h1>
     
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
            
            <form class="form-horizontal"  action="<?php echo site_url();?>admin/Dashboard/edit_pincode_data/<?php echo $data['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Pincode*</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="pin_code" required placeholder="pin code" value="<?php echo $data['pin_code'];?>">
                  </div>
                </div>
                
               
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Location*</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="pin_status">
                      <option value="">Select Location*</option>
                      <option value="1"<?php echo  $data['pin_status'] =='1' ? 'selected': '' ; ?>>In City</option/>
                      <option value="2"<?php echo  $data['pin_status'] =='2' ? 'selected': '' ; ?>>Out City</option/>
                    </select>
                  </div>
                </div>
              
             <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Location Name*</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="location_name" required placeholder="location_name" value="<?php echo $data['location_name'];?>">
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


  