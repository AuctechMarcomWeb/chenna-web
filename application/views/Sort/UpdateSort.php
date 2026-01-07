<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>     Update Sort    <h1>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
       <!--/.col (left) -->
       <!-- right column -->
       <div class="col-md-12">
         
         <div class="box box-info">
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateSortData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
                  <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Sort Name</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="SortName" placeholder=" Sort Name" value="<?php echo $getData['sort_name']?>">
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