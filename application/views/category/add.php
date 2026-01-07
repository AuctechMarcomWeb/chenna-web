 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add Category
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/addCategoryPost/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row" style="margin-left: 10px;">

                  <div class="col-sm-4">
                  <label>Parent Category</label>
                    <input type="text" class="form-control"  placeholder="Parent Category Name" readonly="" value="<?=$getData['name'];?>" >
                    <input type="hidden"value="<?=$getData['id'];?>" name="mai_id">
                  </div>

                  <div class="col-sm-4">
                  <label>Category Name</label>
                    <input type="text" class="form-control"  name="Category" id="inputEmail3" placeholder="Category Name" required>
                  </div>

                
                
                
                  <div class="col-sm-4">
                   <label>Image</label>
                    
                    <input type="file" id="exampleInputFile" name="uploadFileApp" required class="form-control">
                  </div>
                </div><br>
              
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