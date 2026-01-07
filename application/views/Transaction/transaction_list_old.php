<!-- Content Wrapper. Contains page content -->
<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script>
<link rel="stylesheet" href="<?php echo site_url('assets/admin/css/paginationcssFile.css'); ?>">
<div class="content-wrapper" style="min-height: 916px;">
<style type="text/css">

button.pause:hover
  {
    cursor: default;
  }
  .ratingpoint{
    color: red;
  }
  i.fa.fa-fw.fa-trash {
    font-size: 29px;
    color: darkred;
}
i.fa.fa-eye {
    font-size: 25px;
    color: darkturquoise;
}
i.fa.fa-ban {
    font-size: 28px;
    color: red;
}
i.fa.fa-fw.fa-check-circle-o {
    color: green;
    font-size: 28px;
}
</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> Manage School Transaction </h1>

      <?php $adminData = $this->session->userdata('adminData');  ?>
    </section>
    <!-- Main content+++++++++++++++++++++++++++ -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
               
            </div>
            <!-- /.box-header -->
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-12" id="Message"></div>
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
             <div class="clearfix"></div>
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row">
              <div class="col-sm-12" style="margin-bottom: 2px;">
                            <!-- search box create here -->
               <div  style="margin-bottom:15px">            
                <?php /*
                <form class="form-inline" action="<?php echo site_url();?>admin/Dashboard/paymentList" method="GET">
                 <?php
                    $sdate  = $this->session->userdata('sdate');
                    $edate  = $this->session->userdata('edate');
                    $filter = $this->session->userdata('filter');
                ?>
                <div class="form-group">
                  <label>FROM</label>
                     <div class="input-group date">
                     <div class="input-group-addon">
                     <i class="fa fa-calendar"></i>
                      </div>
                       <input class="form-control pull-right" value="<?php echo (!empty($sdate)? $sdate: '');?>" name="sdate" id="datepicker" type="text">
                <!-- /.input group -->
                      </div>
                  </div>
                   <div class="form-group">
                   <label>TO</label>
                     <div class="input-group date">
                     <div class="input-group-addon">
                     <i class="fa fa-calendar"></i>
                      </div>
                       <input class="form-control pull-right" value="<?php echo (!empty($edate)? $edate: '');?>" name="edate" id="datepicker1" type="text">
                <!-- /.input group -->
                      </div>
                  </div>
                  <div class="form-group">
                    <select class="form-control" name="filter">
                      <option value="">Filter By</option>
                      <option value="2" <?php echo ($filter == 2?'selected':''); ?> >Pendding</option>
                      <option value="1" <?php echo ($filter == 1?'selected':''); ?> >Complete</option>
                      <option value="3" <?php echo ($filter == 3?'selected':''); ?> >Cancel</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success">Search</button> 
                </form>*/?>
                </div>
                <!-- search box create here id="example1" -->
              <table  class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                <thead>
                <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 30px;" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">S.No</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">Transaction ID</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">School</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">Branch</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">Student Name </th>
                  <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">Std Class/Section</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 194px;" aria-label="Platform(s): activate to sort column ascending">Pay Mode</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">By Wallet</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 160px;" aria-label="Browser: activate to sort column ascending">By Payment  </th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 194px;" aria-label="Platform(s): activate to sort column ascending">Amount</th><th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width:170px;" aria-label="CSS grade: activate to sort column ascending">Status</th></tr>
                </thead>
                <tbody id="showAllData">   
                <?php
                // get category list code ...... <td><a href="'.site_url().'admin/Dashboard/userView/'.$user['id'].'">'.ucfirst($user['name']).'</a></td><td>'.$user['mobile'].'</td>

                if($adminData['Type']==1){
                  $count = 1;
                /*   echo "<pre>"; 
                  print_r($result); exit;*/

  /*$this->Transaction_model->GetSingleData('school_master', 'id', 'school_name', $getFees['school_id']).'/'.$this->Transaction_model->GetSingleData('branch_master', 'id', 'school_address', $getFees['branch_id'])*/
                   
                   foreach ($result as $value) {
                        
                    $getFees = $this->transaction_model->getFee($value['txn_id']);
                      //
                    
                    if($getFees['fee_mode']== 1){ $fee = 'Yearly'; }
                    if($getFees['fee_mode']== 2){ $fee = 'Half Yearly'; }
                    if($getFees['fee_mode']== 3){ $fee = 'Quarterly'; }
                    if($getFees['fee_mode']== 4){ $fee = 'Monthly'; } 
                         echo '<tr>
                              <td>'.$count.'</td>
                              <td><a href="'.site_url().'admin/Transaction/View/'.$value['Thid'].'">'.$value['txn_id'].'</a></td>

                              <td>'.$this->Transaction_model->GetSingleData('school_master', 'id', 'school_name', $getFees['school_id']).'</td>
                              <td>'.$this->Transaction_model->GetSingleData('branch_master', 'id', 'school_address', $getFees['branch_id']).'</td>

                              <td>'.$getFees['std_name'].'</td>
                              <td>'.$this->Transaction_model->GetSingleData('class_master', 'id', 'class', $getFees['std_class']).' / '.$this->Transaction_model->GetSingleData('section_master', 'id', 'sections', $getFees['std_batch']).'</td>
                              <td>'.$fee.'</td>
                              
                              <td>'.$value['wallet_used_amount'].'</td>
                              <td>'.$value['payment_amount'].'</td>
                              
                              <td>'.$value['amount'].'</td>
                             
                              <td>';
                             if ($value['THstatus'] == 1) {
                               echo ' <button type="button" class="btn btn-block btn-xs btn-sm btn-flat btn-warning pause">Pending</button>';
                              }else if ($value['THstatus'] == 2){
                               echo '<button type="button" class="btn btn-block btn-sm btn-sm btn-flat  btn-success pause">Success</button>';
                              }else{
                              echo ' <button type="button" class="btn btn-block btn-danger btn-sm btn-sm btn-flat  pause">Failed</button>';  
                              }
                         echo'<!-- <a href="javascript:deleteRecoed('.$value['THstatus'].')" ><i class="fa fa-fw fa-trash"></i></a>-->
                               </td>
                               </tr>';
                      $count++;
                    }
                   
                   ?>
                   <?php /*
                   <td>';
                             if ($value['statusType'] == 1) {
                               echo '<button type="button" class="btn btn-block btn-xs btn-sm btn-flat btn-warning pause">Pending</button>';
                              }else if ($value['statusType'] == 2){
                              echo ' <button type="button" class="btn btn-block btn-sm btn-sm btn-flat  btn-success pause">Completed</button>';
                              }else{
                              echo ' <button type="button" class="btn btn-block btn-danger btn-xs btn-sm btn-flat  pause">Cancel</button>';  
                              }
                         echo'<!-- <a href="javascript:deleteRecoed('.$value['id'].')" ><i class="fa fa-fw fa-trash"></i></a>-->
                               </td>*/?>
                  <?php }else { 
                       $count = 1;
                    foreach ($result as $value) {
                        
                    $getFees = $this->transaction_model->getFee($value['txn_id']);

                    if($getFees['school_id']==$adminData['Id'])
                    {
                    if($getFees['fee_mode']== 1){ $fee = 'Yearly'; }
                    if($getFees['fee_mode']== 2){ $fee = 'Half Yearly'; }
                    if($getFees['fee_mode']== 3){ $fee = 'Quarterly'; }
                    if($getFees['fee_mode']== 4){ $fee = 'Monthly'; } 
                         echo '<tr>
                              <td>'.$count.'</td>
                              <td><a href="'.site_url().'admin/Transaction/View/'.$value['Thid'].'">'.$value['txn_id'].'</a></td>

                              <td>'.$this->Transaction_model->GetSingleData('school_master', 'id', 'school_name', $getFees['school_id']).'</td>
                              <td>'.$this->Transaction_model->GetSingleData('branch_master', 'id', 'school_address', $getFees['branch_id']).'</td>

                              <td>'.$getFees['std_name'].'</td>
                             <td>'.$this->Transaction_model->GetSingleData('class_master', 'id', 'class', $getFees['std_class']).' / '.$this->Transaction_model->GetSingleData('section_master', 'id', 'sections', $getFees['std_batch']).'</td>
                              <td>'.$fee.'</td>
                              
                              <td>'.$value['wallet_used_amount'].'</td>
                              <td>'.$value['payment_amount'].'</td>
                              
                              <td>'.$value['amount'].'</td>
                             
                              <td>';
                             if ($value['THstatus'] == 1) {
                               echo ' <button type="button" class="btn btn-block btn-xs btn-sm btn-flat btn-warning pause">Pending</button>';
                              }else if ($value['THstatus'] == 2){
                               echo '<button type="button" class="btn btn-block btn-sm btn-sm btn-flat  btn-success pause">Success</button>';
                              }else{
                              echo ' <button type="button" class="btn btn-block btn-danger btn-sm btn-sm btn-flat  pause">Failed</button>';  
                              }
                         echo'<!-- <a href="javascript:deleteRecoed('.$value['THstatus'].')" ><i class="fa fa-fw fa-trash"></i></a>-->
                               </td>
                               </tr>';
                    }
                      $count++;
                   }

                  } 
                  ?>

                
                </tbody>
              </table>
               <ul class="tsc_pagination" style="float:right;">
                    <!-- Show pagination links -->
                    <?php
                        foreach ($links as $link) {
                        echo "<li>". $link."</li>";
                        }
                     ?>
                </ul>
              </div></div>
            </div>
            <!-- /.box-body --> 
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  </section>
    <!-- /.content +++++++++++++++++++++++++++++++++++++++++-->
</div>
<script type="text/javascript">
  function deleteRecoed(id) {
      var r = confirm("Are you sure! You want to delete this payment history?");
      if (r == true) {
        $.ajax({ 
        type: "POST", 
        url: "<?php echo site_url('admin/Dashboard/deletePaymentHistory');?>", 
        data: "histroy="+id, 
        success:function(response){
        console.log(response);
        if (response == 2) {
            $('#Message').html('<div class="alert alert-warning">Somthing is worng.please try again.</div>');
              $("#Message").fadeOut(5000);
        }else{
          $('#showAllData').html(response);
          $('#Message').html('<div class="alert alert-success">payment history has been delete successfully done.</div>');
          $("#Message").fadeOut(5000);
        }
        } 
        });
      }
  }
</script>
  <script type="text/javascript">
   $(function () {
        //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy',
    });
    $('#datepicker1').datepicker({
      autoclose: true,
      format:'dd-mm-yyyy',
    });
  });
  </script>