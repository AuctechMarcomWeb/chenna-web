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
      User Wallet Transactions
      </h1>
      <div class="text-center"><h3>Total Wallet Amount : <?php echo singlerowparameter2('wallet_amount','id',$this->uri->segment('4'),'user_master') ?> /-</h3>

      </div>
      <div class="text-right">
      <a href="<?php echo base_url().'admin/Users/creditWallet/'.$this->uri->segment('4'); ?>" class="btn btn-success">Credit Wallet</a>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>User Number</th>
                  <th>Credit Value</th>
                   <th>Payment Mode</th>
                  <th>Type</th>
                  <th>Status</th>

                  <th style="width:250px">Add Date</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $counter ="1";
                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo singlerowparameter2('phone_no','id',$value['user_master_id'],'user_master')  ?></td>
                
<td><?php echo ($value['debit_credit']==1) ? '- '.$value['amount'] : '+ '.$value['amount']; ?><?php echo "<pr><p style='color:brown'>".$value['remark']."</p>" ?></td>


                <td>
                     <?php if($value['type'] == 1){
                           $getOrderNo = $this->db->get_where('order_master',array('order_number'=>$value['txn_id']))->row_array();
                       if($getOrderNo['payment_type'] == 1){
                             echo"<p style='color:green'>COD</p>";
                           }else if($getOrderNo['payment_type'] == 2){
                             echo"<p style='color:red'>Online Payment</p>";
                           }else if($getOrderNo['payment_type'] == 3){
                             echo"<p style='color:green'>Wallet</p>";
                           }                

                     }else if($value['type'] == 2){
                           $getRechargeNo = $this->db->get_where('transaction_history',array('txn_id'=>$value['txn_id']))->row_array();
                           if($getRechargeNo['wallet_used'] == 1){
                             echo"<p style='color:green'>Wallet</p>";
                           }else {
                             echo"<p style='color:green'>Online Payment</p>";
                           }
                        }else{
                          echo"<p style='color:green'>Wallet</p>";
                          } ?>

                     </td>







              <td>
                     <?php if($value['type'] == 1){
                     
                       echo"<p style='color:maroon'>Order Place(Shopping Cart)</p>";
                     }else if($value['type'] == 2){
                       echo"<p style='color:maroon'>Recharge</p>";
                     }else if($value['type'] == 3){
                       echo"<p style='color:maroon'>Wallet</p>";
                     }else if($value['type'] == 4){
                       echo"<p style='color:maroon'>Insurance</p>";
                     }else if($value['type'] == 5){
                       echo"<p style='color:maroon'>School Fee</p>";
                     }else if($value['type'] == 6){
                       echo"<p style='color:maroon'>Policy Paid</p>";
                     }else if($value['type'] == 7){
                       echo"<p style='color:maroon'>Share & Earn</p>";
                     }else if($value['type'] == 8){
                       echo"<p style='color:maroon'>Profile Complete</p>";
                     }else if($value['type'] == 9){
                       echo"<p style='color:maroon'>Cashback on Product</p>";
                     } ?>
             </td> 



              <td>
                   <?php if($value['type'] == 1){
                       $getOrderNo = $this->db->get_where('order_master',array('order_number'=>$value['txn_id']))->row_array();
                       if($getOrderNo['status'] == 1){
                             echo"<p style='color:maroon'>Pending</p>";
                           }else if($getOrderNo['status'] == 2){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($getOrderNo['status'] == 3){
                             echo"<p style='color:green'>Success</p>";
                           }else if($getOrderNo['status'] == 2){
                             echo"<p style='color:maroon'>Cancel</p>";
                           }
                        }else if($value['type'] == 2){
                           $getRechargeNo = $this->db->get_where('recharge_master',array('transaction_id'=>$value['txn_id']))->row_array();
                           if($getRechargeNo['status'] == 1){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($getRechargeNo['status'] == 3){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($getRechargeNo['status'] == 2){
                             echo"<p style='color:green'>Success</p>";
                           }else if($getRechargeNo['status'] == 4){
                             echo"<p style='color:maroon'>Refund</p>";
                           }
                        }else if($value['type'] == 3){
                           if($value['status'] == 1){
                             echo"<p style='color:maroon'>Pending</p>";
                           }else if($value['status'] == 3){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($value['status'] == 2){
                             echo"<p style='color:green'>Success</p>";
                           }else if($value['status'] == 4){
                             echo"<p style='color:maroon'>Refund</p>";
                           }
                         }else if($value['type'] == 4){
                            echo"<p style='color:green'>Success</p>";
                         }else if($value['type'] == 5){
                            echo"<p style='color:green'>Success</p>";
                         }else if($value['type'] == 6){
                            echo"<p style='color:green'>Success</p>";
                         }else if($value['type'] == 7){
                           if($value['status'] == 1){
                             echo"<p style='color:maroon'>Pending</p>";
                           }else if($value['status'] == 3){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($value['status'] == 2){
                             echo"<p style='color:green'>Success</p>";
                           }else if($value['status'] == 4){
                             echo"<p style='color:maroon'>Refund</p>";
                           }
                         }else if($value['type'] == 8){
                           if($value['status'] == 1){
                             echo"<p style='color:maroon'>Pending</p>";
                           }else if($value['status'] == 3){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($value['status'] == 2){
                             echo"<p style='color:green'>Success</p>";
                           }else if($value['status'] == 4){
                             echo"<p style='color:maroon'>Refund</p>";
                           }
                         }else if($value['type'] == 9){
                           if($value['status'] == 1){
                             echo"<p style='color:maroon'>Pending</p>";
                           }else if($value['status'] == 3){
                             echo"<p style='color:red'>Failed</p>";
                           }else if($value['status'] == 2){
                             echo"<p style='color:green'>Success</p>";
                           }else if($value['status'] == 4){
                             echo"<p style='color:maroon'>Refund</p>";
                           }
                         }

                          ?>
              </td> 







                 
                 <td><?php echo date('d M Y, H:i', $value['add_date']); ?></td>
                </tr>
                <?php $counter ++ ; } ?>
                </tbody>
              </table>
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


<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/CouponStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Coupon ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Coupon ?");}       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>');} 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>');}
        //console.log(response);
      }
    });
    }
  }
 

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })


  
</script>