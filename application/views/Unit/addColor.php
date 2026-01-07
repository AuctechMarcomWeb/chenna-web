<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Add Color</h1>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
      
       <div class="col-md-12">
         
         <div class="box box-info">
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/addColorData/');?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
                <div class="row" style="margin-left: 10px;">
                  <div class="col-sm-6">
                   <label>Color Name</label>
                    
                    <input type="text" required="" class="form-control" name="ColorName" placeholder="Color Name">
                  </div>
                  <div class="col-sm-6">
                   <label>Color Image</label>
                    
                    <input type="file" required="" class="form-control" name="ColorImage">
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