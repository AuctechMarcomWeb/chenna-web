 
</script>
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Subcategory
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
   
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
         
           
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateSubCatData').'/'.$getData['subid'].'/'.$this->uri->segment('5');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                 <div class="row" style="margin-left: 10px;">

                  <div class="col-sm-4">
                  <label>Category Name</label>
                        <select class="form-control" name="catgyName" required >
                          <option value ="">Select Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>" <?php echo  ($getData['catId']==$allCatgy['id']?'selected':'')?>><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                

               
                  <div class="col-sm-4">
                   <label>Subcategory </label>
                    
                    <input type="text" class="form-control" name="subCat" placeholder="Subcategory Name" value ="<?php echo $getData['sub_category_name'];?>" required >
                  </div>

                  <div class="col-sm-4">
                   <label>Image</label>
                    <input type="file" class="form-control" name="uploadFileApp">
                    <?php if(!empty($getData['app_icon'])){?>
                     <img src="<?php echo base_url().'assets/category_images/'.$getData['app_icon'];?>" style="width:120px;height:100px;margin-top: 5px;">
                    <?php } ?>
                    
                  </div>

                   <div class="col-sm-4">
                       
                    <label>Status</label>
                    <select class="form-control select2" name="status" required="">
                      <option value="1" <?php echo ($getData['substatus']=='1' ? 'selected': '')?>>Activated</option>
                    <option value="2" <?php echo ($getData['substatus']=='2' ? 'selected': '')?>>Deactivated</option>
                    </select>
                 
                  </div>
                  
                  <div class="col-sm-4">
                       
                    <label>GST Rate(%)</label>
                     <input type="number" onKeyPress="if(this.value.length==4) return false;" class="form-control"  name="gst" value ="<?php echo $getData['cgst'];?>" placeholder="Enter Value in percent">
                  </div>
                </div><br/>
            
                 

               
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Vendor Commission Rate(%)</label>

                  <div class="col-sm-10">
                    <input type="text" onKeyPress="if(this.value.length==4) return false;" class="form-control" 
                     name="CommissionRate" value ="<?php echo $getData['CommissionRate'];?>" placeholder="Enter Value in percent">
                  </div > -->
                </div>  

                <?php /*
                    <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Feature</label>
                 <div class="col-sm-10">
                     <input type="radio" name="subfeature"  value="2" style="margin-left:15px" <?php echo  ($getData['f_sub'] =='2')? 'checked': '' ; ?> > &nbsp;&nbsp;  Yes 
                      <input type="radio" name="subfeature"  value="1" style="margin-left:15px"  <?php echo ($getData['f_sub'] =='1')?'checked':'' ; ?> > &nbsp;&nbsp;  NO 
                    
                    
                  </div>
                </div>
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Application Icon</label>
                  <div class="col-sm-10">
                    
                    <input type="file" id="exampleInputFile" name="uploadFileApp">
                     <?php if($getData['app_icon']!=" ") {?><img src="<?php echo base_url()."assets/category_images/".$getData['app_icon']; ?>" style="width: 115px;"> <?php } ?>
                  </div>
                </div>
              <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Website Icon</label>
                  <div class="col-sm-10">
                    
                    <input type="file" id="exampleInputFile" name="uploadFileWeb">
                    <?php if($getData['web_icon']!=" ") {?>
                     <img src="<?php echo base_url()."assets/category_images/".$getData['web_icon']; ?>" style="width: 115px;"> <?php } ?>
                  </div>
                </div>


                */ ?>
                
              <!-- /.box-body -->
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
  