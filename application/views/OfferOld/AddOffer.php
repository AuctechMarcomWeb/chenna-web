 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add Offer
       
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
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/AddOfferData/');?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Offer Name</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="offerName" placeholder=" Offer Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"  >Category Name</label>

                  <div class="col-sm-10">
                        <select class="form-control" name="catgyName" id="category" onchange="getSubCatList()">
                          <option value ="">Select Category</option>
                          <?php foreach ($getCatgy as $allCatgy) {?>
                            <option value="<?php echo $allCatgy['id'] ?>"><?php echo ucfirst( $allCatgy['category_name']) ?></option>
                            <?php } ?>
                        </select>
                  </div>
                </div>



              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label" >Sub Category</label>
                   <div class="col-sm-10">
                  <select class="form-control select2" id="subCategory"   name="SubCat[]" multiple="multiple" data-placeholder="Select Sub Category"   style="width: 100%;">
                    <option value ="">Select Sub Category</option>

                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" name="StartDate">Start Date:</label>
                <div class="col-sm-10">
                  <div class="input-group date ">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control " id="datepicker" name="StartDate" >
                  </div>
                </div>
                <!-- /.input group -->
              </div>

              
             <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">End Date:</label>
              <div class="col-sm-10">
                <div class="input-group date ">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control" id="datepicker2" name="EndDate">
                </div>
              </div>
              <!-- /.input group -->
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


  