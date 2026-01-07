<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Update Color</h1>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
      
       <div class="col-md-12">
         
         <div class="box box-info">
          
             <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/updateColorData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
                <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-4">
                   <label>Color Name</label>
                    
                    <input type="text" required="" class="form-control" name="ColorName" placeholder="Color Name" value="<?php echo $getData['name'];?>">
                  </div>
                  <div class="col-sm-4">
                   <label>Color Image</label>
                    
                    <input type="file"  class="form-control" name="ColorImage">
                    <br>
                    <?php if($getData['image']!=" ") {?><img src="<?php echo base_url()."assets/banner_images/boy/".$getData['image']; ?>" style="width: 125px;height:120px;"> <?php } ?>
                  </div>
                  <div class="col-sm-4">
                  <label>Status:</label>
                   <select class="form-control" name="status">
                    <option value="1" <?php echo ($getData['status']=='1' ? 'selected': '')?>>Activated</option>
                    <option value="2" <?php echo ($getData['status']=='2' ? 'selected': '')?>>Deactivated</option>
                   </select>
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