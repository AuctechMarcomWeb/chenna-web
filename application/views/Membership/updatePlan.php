 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Update Plan
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal"  action="<?php echo site_url();?>admin/Membership/updatePlanData/<?php echo $getData['id'];?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Plan Price&nbsp;(<i class="fa fa-rupee"></i>)</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control"  name="plan"  value="<?php echo $getData['plan'];?>" placeholder="Plan Price" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Wallet Amount</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control"  value="<?php echo $getData['plan_price'];?>" name="plan_price"  placeholder="Wallet Price" required>
                  </div>
                </div>

                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Description</label>

                  <div class="col-sm-10">
                    <textarea class="form-control" cols="4" rows="4" name="description" maxlength="100"><?php echo $getData['description'];?></textarea>
                    <span>Maximum (100 characters)</span>
                  </div>
                </div>


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