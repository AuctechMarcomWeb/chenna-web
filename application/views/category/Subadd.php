 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add Sub-Category
       
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
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/addSubCatPost/'.$this->uri->segment('4'));?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row" style="margin-left: 10px;">

                  <div class="col-sm-4">
                  <label>Category Name</label>
                        <select class="form-control" name="catgyName" required>
                          <option value ="">Select Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>" <?php  echo ($this->uri->segment('4')==$allCatgy['id'] ? 'Selected' :'')?>><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
               
                  <div class="col-sm-4">
                   <label>Subcategory </label>
                    
                    <input type="text" class="form-control" name="subCat" placeholder="Subcategory Name" required>
                  </div>
                  <div class="col-sm-4">
                   <label>Image</label>
                    <input type="file" class="form-control" name="uploadFileApp"  required>
                  </div>
                </div><br>
             
                 
                  
                  <div class="col-sm-4">
                      <label>GST Rate(%)</label>
                    <input type="number" onKeyPress="if(this.value.length==4) return false;" value="0" class="form-control"  name="gst" placeholder="Enter Value in percent">
                  </div>
                </div>   

               


              <div class="box-footer">
                 <input type="hidden" name="Url" value="">
                
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