<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
     Update Distinguish
      
     </h1>
       </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
      
       <div class="col-md-12">
         
         <div class="box box-info">
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateDistData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
                  <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Distinguish Name</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="Dist_Name" placeholder=" Distinguish Name" value="<?php echo $getData['distinguish_name']?>">
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