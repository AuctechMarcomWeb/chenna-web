 


 <script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Category
       </h1>
     
      
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
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Add Category</h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start -->  
           
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateCategoryPost').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                 <div class="row" style="margin-left: 10px;margin-top: 20px;">

                  <div class="col-sm-4">
                  <label>Category Name</label>
                    <input type="text" class="form-control"  name="Category" id="inputEmail3" placeholder="Category Name" value = "<?php  echo $getData['category_name']?>" required >
                    <input type="hidden" value="<?php  echo $this->uri->segment('5')?>" name="parent_id">
                  </div>
              
                
              
                  <div class="col-sm-4">
                   <label>Image</label>
                    
                    <input type="file" id="exampleInputFile" name="uploadFileApp" class="form-control">
                     <?php if($getData['app_icon']!=" ") {?><img src="<?php echo base_url()."assets/category_images/".$getData['app_icon']; ?>" style="width: 115px;margin-top: 4px;"> <?php } ?>
                  </div>
                   <div class="col-sm-4">
                       
                    <label>Status</label>
                    <select class="form-control select2" name="status" required="">
                        <option value="1" <?php echo ($getData['status']=='1' ? 'selected': '')?>>Activated</option>
                      <option value="2" <?php echo ($getData['status']=='2' ? 'selected': '')?>>Deactivated</option>
                    </select>
                 
                  </div>

                </div>

            <br>


               
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