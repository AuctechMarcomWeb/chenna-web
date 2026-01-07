 <div class="content-wrapper">
    
    <section class="content-header">
      <h1>
       View Transaction Detail 

       <button onclick="window.history.go(-1)" class="btn btn-info" style="float: right; padding-right: 10px; ">Back </button>
      </h1>
    </section>

   

  
    <?php $adminData = $this->session->userdata('adminData');  ?>
    <?php  $getdata2 = $this->transaction_model->GetDataFeeMaster( $getdata['txn_id']);
 
 //print_r($getdata2); exit;    
            if($getdata2['fee_mode']==1){$fee_mode = 'Yearly';}
            if($getdata2['fee_mode']==2){$fee_mode = 'Half-Yearly';}
            if($getdata2['fee_mode']==3){$fee_mode = 'Quarterly';}
            if($getdata2['fee_mode']==4){$fee_mode = 'Montly';} 

            $inst_month = $this->Transaction_model->GetInstallment($getdata2['fee_mode'],$getdata2['inst_month']);
             ?>

    <section class="content">
      <div class="row">
        <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
        <div class="col-md-12">
          <!-- Horizontal Form -->
      
            <div class="box box-info">
            <!-- form start -->
            <form class="form-horizontal" method="POST" enctype="multipart/form-data">
              <div class="box-body">

                 <h3 style="text-align: center; margin-bottom: 15px; margin-top: 10px"> School & Branch</h3>

                <div class="form-group">

                   <label for="inputEmail3" class="col-sm-2 control-label"> School Name</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $this->transaction_model->GetSingleData('school_master','id','school_name',$getdata2['school_id']); ?>">
                  </div>

                   

                  

                </div>
                <div class="form-group">

                    <label for="inputEmail3" class="col-sm-2 control-label"> Branch Address</label>
                  <div class="col-sm-8">
                    <textarea class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled ><?php echo $this->transaction_model->GetSingleData('branch_master','id','school_address',$getdata2['branch_id']); ?>
                        
                    </textarea>
                  </div>

                  

                  
                </div>
              <hr>

                

                <h3 style="text-align: center; margin-bottom: 15px; margin-top: 10px"> Amount Detail</h3>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Transaction Id</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $getdata['txn_id']; ?>">
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label"> On Date</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo date('d-M-y', $getdata['add_date']) ?>" >
                  </div>

                </div>
                <div class="form-group">

                  <label for="inputEmail3" class="col-sm-2 control-label"> Fee Mode</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo $fee_mode ?>" >
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label"> Fee Paid</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $getdata['amount']; ?>">
                  </div>

                  

                </div>

                   <div class="form-group">

                  
                  <label for="inputEmail3" class="col-sm-2 control-label"> Fee Paid of</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $inst_month; ?>">
                  </div>

                  

                </div>

               <hr>

                <h3 style="text-align: center; margin-bottom: 15px; margin-top: 10px"> Student Detail</h3>



                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"> Student Name</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $getdata2['std_name']; ?>">
                  </div>

                  <label for="inputEmail3" class="col-sm-2 control-label"> Father Name</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo $getdata2['father_name']; ?>" >
                  </div>

                </div>
                <div class="form-group">

                  <label for="inputEmail3" class="col-sm-2 control-label"> Class</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo $this->Transaction_model->GetSingleData('class_master', 'id', 'class', $getdata2['std_class'])?>" >
                  </div>
                  <label for="inputEmail3" class="col-sm-2 control-label">Roll no </label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="fee_amount" id="fee_amount" placeholder="Yearly Fee" disabled value="<?php echo $getdata2['std_roll_no']; ?>">
                  </div>

                 
                  

                </div>

                  <div class="form-group">

                  <label for="inputEmail3" class="col-sm-2 control-label"> Section </label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control"  name="yealy_discount" id="yealy_discount" placeholder="Fee Discount" disabled value="<?php echo $this->Transaction_model->GetSingleData('section_master', 'id', 'sections', $getdata2['std_batch'])?>" >
                  </div>
                                    

                </div>

                <hr>

               
            
            </form>
          </div>


         
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>



  