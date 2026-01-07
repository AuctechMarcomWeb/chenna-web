<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
      Update filter
      
     </h1>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <!-- left column -->
      
       <!--/.col (left) -->
       <!-- right column -->
       <div class="col-md-12">
         
         <div class="box box-info">
           <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateFilterData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
             <div class="box-body">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Select Subcategory</label>

                  <div class="col-sm-10">
                        <select class="form-control" name="subCatgy" id="subCatgy">
                          <option value ="">Select Subcategory</option>
                          <?php foreach ($SubCat as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>" <?php echo  ($getData['sub_category_master_id']==$allCatgy['id']?'selected':'')?>><?php echo ucfirst( $allCatgy['sub_category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Select Unit</label>
                  <div class="col-sm-10">
                        <select class="form-control" name="unit" id="unit">
                          <option value ="">Select Unit</option>
                          <?php foreach ($unit as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>" <?php echo  ($getData['unit_master_id']==$allCatgy['id']?'selected':'')?> ><?php echo ucfirst( $allCatgy['unit_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Distinguish</label>

                  <div class="col-sm-10">
                        <select class="form-control" name="dist" id="dist">
                          <option value ="">Select Unit</option>
                          <?php foreach ($Dist as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>" <?php echo  ($getData['distinguish_id']==$allCatgy['id']?'selected':'')?>><?php echo ucfirst( $allCatgy['distinguish_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Filter Name</label>

                  <div class="col-sm-10">
                      <input type="text" name="filter"  id="filter" class="form-control" value="<?php  echo $getData['filter_name'] ?>">
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