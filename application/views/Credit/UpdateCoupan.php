 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Update Coupon</h1>
     
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
            
            <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/UpdateCouponData').'/'.$getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Coupon Code</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="CouponCode" required placeholder=" Coupon Code"  value= "<?php echo  $getData['coupon_code']?>">
                  </div>
                </div>
                

        
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Coupon Type</label>

                  <div class="col-sm-10">
                        <select class="form-control" name="CouponType" required id="CouponType">
                          <option value ="">Select Coupon Type</option>
                          
                            <option value="1" <?php echo ($getData['coupon_type']=='1')?'Selected':'' ;?> >Flat</option>
                            <option value="2" <?php echo ($getData['coupon_type']=='2')?'Selected':'' ;?> >Percentage</option>
                            
                        </select>
                  </div>
                </div>

                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Amount</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="amountPer" required placeholder="Amount/Percentage" value= "<?php echo  $getData['coupn_discount']?>">
                  </div>
                </div>
                 <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Minimum Amount</label>
                  <div class="col-sm-10">
                    
                    <input type="text" class="form-control" name="min_amount" required placeholder="Minimum Amount"  value= "<?php echo  $getData['minimum_applicable_amount']?>">
                  </div>
                </div>  
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label" required >Start Date:</label>
                <div class="col-sm-10">
                  <div class="input-group date ">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control " id="datepicker" required name="StartDate"   value=" <?php echo date('d-m-Y',$getData['start_date'])?> ">
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
                  <input type="text" class="form-control" required id="datepicker2" name="EndDate"  value=" <?php echo date('d-m-Y',$getData['end_date'])?> ">
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


  