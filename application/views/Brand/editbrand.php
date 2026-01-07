<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>Update Brand</h1>
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
          
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateBrandData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">

            <div class="row" style="margin-left: 10px;">
                  
              
                  <div class="col-sm-4">
                   <label>Brand Name</label>
                    
                    <input type="text" class="form-control" name="BrandName" placeholder=" Brand Name" value="<?php  echo $getData['brand_name']?>" required>
                  </div>
                   <div class="col-sm-4">
                       <label>Brand Icon</label>
                       
                       <input type="file" id="exampleInputFile" name="uploadFileBrand" class="form-control">
                        <?php if($getData['brand_image']!=" ") {?><img src="<?php echo base_url()."assets/brand_images/".$getData['brand_image']; ?>" style="width: 200px;margin-top:5px;"> <?php } ?>
                     </div>
                  <div class="col-sm-4">
                       
                    <label>Status</label>
                    <select class="form-control select2" name="status" required="">
                      <option value="1" <?php echo ($getData['status']=='1' ? 'selected': '')?>>Activated</option>
                    <option value="2" <?php echo ($getData['status']=='2' ? 'selected': '')?>>Deactivated</option>
                    </select>
                 
                  </div>


                </div><br>
            
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

  <script type="text/javascript">
    window.onload = function () {
     var id = $('[name="catgyName"]').val();
     var subId = $('[name="SubCatId"]').val();
     /*alert(subId);*/
     var Url = "<?php  echo base_url('admin/Dashboard/getsubCatgy2')?>/"+id+"/"+subId;
     
      $.ajax({
          type: "POST",
          url: Url,
          success: function(result){
            console.log(result)
          if(result!='')
            {
              $('#subCategory').html(result);
            } else
            {
              $('#msg').html('');
            }
           
          }
        });
      /*alert(id);*/
    };

  </script>


