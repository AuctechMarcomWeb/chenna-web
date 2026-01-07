
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>   

   <style type="text/css">
   .ratingpoint{
    color: red;
  }
  i.fa.fa-fw.fa-trash {
    font-size: 30px;
    color: darkred;
    top: 5px;
    position: relative;
}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Credit Wallet
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
                <div class="row">
                <div class="col-md-8">
                <form action="<?php echo base_url().'admin/Users/creditAmountPost/'.$getData['id']; ?>" method="post">
                   <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Mobile No.</label>
                        <div class="col-sm-10">
                          
                          <input type="text" class="form-control" value="<?php echo $getData['phone_no']; ?>" readonly/>
                       <br> </div>
                      </div>
                 
                      <div class="form-group">
                         <label for="inputEmail3" class="col-sm-2 control-label">Enter Amount(Rs.)</label>
                        <div class="col-sm-10">
                          
                         <br> <input type="number" class="form-control" name="amount" placeholder="Enter Value" required="">
                        </div>
                      </div>

                     <div class="form-group">
                   <div class="col-sm-12 text-right">
                          
                         <br> <input type="submit" class="btn btn-info" name="submit" Value="Submit">
                        </div>
                      </div>
</form>
                </div>
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


