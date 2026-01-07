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
     Manage Orders
      <?php /*
<a href="<?php echo base_url('admin/Order/AddOrder/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Order</a>
      </h1>
      */?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <?php $adminData = $this->session->userdata('adminData');
                  if ($adminData['Type'] == '1') { 

                  $getData = $this->Order_model->getOrderList($adminData['Type']);
                  /*$OrderStatus = $this->Order_model->GetOrderStatus($this->uri->segment(4),'order_master','status');*/
                 /* echo "<pre>"; print_r($getData); exit;*/ ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                 
                  <th>Order Number</th>
                  <th>Customer Name</th>
                  
                  <th>City</th>
                  <th>Location</th>
                  <th>Final Amount</th>
                  <th>Payment Type</th>
                  <th>Order Date</th>
                  <th>Order Status</th>
                  <th>Invoice</th>
                </tr>
                </thead>
                <tbody>



                <?php
               /* echo "<pre>";
                print_r($getData); exit;*/
                 $counter ="1";
                foreach ($getData as $value) {
                  $OrderStatus = $this->Order_model->GetOrderStatus($value['order_master_id'],'order_master','status');
                  $AllOrderDetail = $this->Order_model->AllOrderDetail($value['order_master_id'])?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo site_url().'admin/Order/ViewOrder/'.$value['order_master_id']?>"><?php echo $orderNO = $this->Order_model->GetSingleData($value['order_master_id'],'order_master','order_number')?></a></td>

                  <td><a href="<?php echo site_url().'admin/Users/UpdateUsers/'.$AllOrderDetail['user_master_id']?>">Name :<?php echo $this->Order_model->GetUserName($value['order_master_id'],'username')?>
                     <br> Mob : <?php echo $this->Order_model->GetUserName($value['order_master_id'],'phone_no')?>
                  </a></td>

                  <td><?php echo $this->Order_model->Getlocation($value['order_master_id'],'district_city_town')?></td>

                  <td><?php echo $this->Order_model->Getlocation($value['order_master_id'],'locality')?></td>

            <?php $paymentStatus = $this->Order_model->getDataByrowArray('transaction_history','txn_id',$orderNO); ?>

                  <td> <i class="fa fa-inr"></i> <?php echo $this->Order_model->GetOrderStatus($value['order_master_id'],'order_master','final_price') ?> </td>
                  <td> <?php if( $AllOrderDetail['payment_type'] == 1){ echo '<b>COD</b>';

                      }
                      if( $AllOrderDetail['payment_type'] == 2) {
                            echo '<b>Online Payment</b><br>';
                            if($paymentStatus['payment_status'] == '2'){
                              echo "<b style='color:green'>Success</b>";
                            }else if($paymentStatus['payment_status'] == '3'){
                             echo "<b style='color:red'>Failed</b>";
                            }
                            else if($paymentStatus['payment_status'] == '4'){
                             echo "<b style='color:blue'>Refund</b>";
                            }else if($paymentStatus['payment_status'] == '1'){
                             echo "<b style='color:#ff6c00'>Pending</b>";
                            }

                       }
                      if( $AllOrderDetail['payment_type'] == 3){ echo '<b>Wallet</b>';} ?> </td>

                  <td><?php echo date('d-M-y', $this->Order_model->GetSingleData2($value['order_master_id'],'purchase_master','add_date')) ?>
                  </td>
                  <td>
                  <?php 
                  
                  $status= $this->Order_model->OrderStatus($value['order_master_id']);
                      if( $status==1){ echo '<b style="color:#ff6c00">Pending</b>';}
                      if( $status==2){ echo '<b style="color:#f00">Cancelled</b>';}
                      if( $status==3){ echo '<b style="color:#559c0a">Accepted</b>';} 
                      if( $status==4){ echo '<b style="color:#559c0a">Shipped</b>';}
                      if( $status==5){ echo '<b style="color:#559c0a">Delivered</b>';}
                    ?>
                  </
                  td>
                  
                  
                   <?php $link = singlerowparameter2('pdf_link','id',$value['order_master_id'],'order_master') ?>
                  <td><a href="<?php echo ($link!='') ? $link:' ' ?>" target="_blank"> <?php echo ($link!='') ? 'View Invoice':' NO Invoice' ?> </a></td> 
                </tr>

                  <?php $counter ++ ; } ?>
                    </tbody>
               
              </table>
              </div>
                  <?php

                  }  if ($adminData['Type'] == '2'){
                      
                   $getData = $this->Order_model->getOrderList($adminData['Type'],$adminData['Id']);
                   /*echo "<pre>";
                   print_r($getData);exit;*/
                   $counter = "1";?>
                   <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                 
                  <th>Order Number</th>
                  
                  <th>Location</th>
                  <th>City</th>
                  <th>Final Amount</th>
                    <th>Payment Type</th>
                  <th>Order Date</th>
                  <th style="width:150px">Product Status</th>
                </tr>
                </thead>
                <tbody> 
                  <?php
                foreach ($getData as $value) {

                  $OrderStatus = $this->Order_model->GetOrderStatus($value['order_master_id'],'order_master','status');
                  $AllOrderDetail = $this->Order_model->AllOrderDetail($value['order_master_id'])?>
                  
                <tr>
                  <td><?php echo $counter; ?></td>
                  <!-- <td><a href="<?php //echo site_url().'admin/Order/ViewOrder/'.$value['id']?>">
                  <?php //echo$this->Order_model->GetSingleData($value['product_master_id'],'product_master','product_name')?> </a></td> -->
                  <td><a href="<?php echo site_url().'admin/Order/ViewOrder/'.$value['order_master_id'].'/'.$adminData['Id']?>"><?php echo$this->Order_model->GetSingleData($value['order_master_id'],'order_master','order_number')?> </a></td>
                  
                   <td><?php echo$this->Order_model->Getlocation($value['order_master_id'],'district_city_town')?></td>

                  <td><?php echo$this->Order_model->Getlocation($value['order_master_id'],'locality')?></td>

                  <td> <i class="fa fa-inr"></i> <?php echo $this->Order_model->GetOrderStatus($value['order_master_id'],'order_master','final_price') ?> </td>
                  <td> <?php if( $AllOrderDetail['payment_type'] == 1){ echo '<b>COD</b>';}
                      if( $AllOrderDetail['payment_type'] == 2){ echo '<b>Online Payment</b>';}
                      if( $AllOrderDetail['payment_type'] == 3){ echo '<b>Wallet</b>';} ?> </td>

                  <td><?php echo date('d-M-y', $this->Order_model->GetSingleData2($value['order_master_id'],'purchase_master','add_date')) ?>
                  </td>
                  <td>
                  <?php 
                    $product_status = $this->Order_model->GetSingleData2($value['order_master_id'],'purchase_master','status');
                    /*echo $product_status;  
*/
                      if($product_status=='1'){ echo '<b style="color:#ff6c00">Pending</b>';}
                      if($product_status=='2'){ echo '<b style="color:#f00" >Cancel</b>' ;}
                      if($product_status=='3'){ echo '<b style="color:#559c0a" >Accept</b>' ;} 
                      if($product_status=='4'){ echo '<b style="color:#559c0a" >Shipped</b>' ;}
                      if($product_status=='5'){ echo '<b style="color:#559c0a" >Delivered <i class="fa fa-check-circle"></i></b>';} ?>
                 
                  </td>
                </tr>

                  <?php $counter ++ ; } ?>
                  </tbody>
               
              </table>
              </div>
                  <?php
                 } ?>
                
              
           
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

<?php  
   /* $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
       echo '<a href="javascript:OrderStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';           */             
  ?>
<script>
function OrderStatus(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Order/OrderStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Order ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Order ?");}       
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