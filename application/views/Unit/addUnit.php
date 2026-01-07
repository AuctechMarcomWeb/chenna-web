<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Add Unit</h1>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
       <!--/.col (left) -->
       <!-- right column -->
       <div class="col-md-6">
         
         <div class="box box-info">
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/addUnitData/');?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
                  <div class="form-group">
                  <div class="col-sm-12">
                   <label>Unit Name</label>
                    <input type="text" class="form-control" name="UnitName" placeholder="Unit Name">
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