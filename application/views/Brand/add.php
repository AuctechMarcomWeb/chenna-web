<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>Add Brand  </h1>
   
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
         
           <!-- form start -->
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/addBrandData/');?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">


         <div class="row" style="margin-left: 10px;">

                  <div class="col-sm-6">
                   <label>Brand Name</label>
                    
                    <input type="text" class="form-control" name="BrandName" placeholder=" Brand Name" required>
                  </div>
               
                  <div class="col-sm-6">
                         <label>Brand Icon</label>
                       
                       <input type="file" id="exampleInputFile" name="uploadFileBrand" class="form-control">
                     </div>

               
                  
                
                </div>
                <br>
               
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