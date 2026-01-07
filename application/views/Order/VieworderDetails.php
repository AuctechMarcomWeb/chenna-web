 
<?php 
$adminData = $this->session->userdata('adminData');
$purchaseData = $this->db->get_where('purchase_master',array('order_master_id'=>$getData['id']))->result_array();

$check_return = $this->db->query("SELECT * FROM `purchase_master` WHERE `order_master_id` = ".$getData['id']." AND `status` = '8'")->num_rows();
?>


<script type="text/javascript">
  window.onload=function(){
    $("#hiddenSms").fadeOut(5000);
  }
</script> 

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php $adminData = $this->session->userdata('adminData'); ?>
    <section class="content-header">
      <h1>Order Details</h1>
     
    </section>
<style type="text/css">
  
  ._1Y9Evw ._1vKxDm {
    background: #2874f0;
    color: #fff;
    box-shadow: none;
    border: 1px solid #2874f0;
    padding: 8px 12px;
    border-radius: 2px;
    text-transform: uppercase;
    cursor: pointer;
    text-align: center;
    width: 196px;
}.address_Tilte {
    font-weight: 500;
}

.OrderTitle{
  background:#2874f0;      
  color: #fff;  
  text-transform: uppercase; 
  border: 1px solid #2874f0; font-size: 18px; 
  text-align: center; 
  padding: 7px 10px; 
  margin-top: 0;
}
.ProductImg{
  width: 175px;
  max-height:150px;
  overflow-y: hidden;
  border-radius: 4px;
  box-shadow: 0 1px 3px rgba(0,0,0,.15);
}
.addres_box{
  position: relative;
  right: 0.3em;
  width:27%;

}



@media (min-width: 992px) {
        .responsive_theme {margin-top:-115px !important}
}
</style>
    <!-- Main content -->
       <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
    <section class="content">
      <div class="row">
      
        <div class="col-md-12">

     

 <!--Shipping Address  -->  
          <div class="col-sm-4">
            <div class="box box-solid">
              <div class="box-body" style="height: 220px;">
                  <h4 class="box-header with-border"><b>Customer  Informationnnn</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
                    <?php 

                   
                    $user_info = $this->db->get_where('user_master',array('id'=>$getData['user_master_id']))->row_array(); 
                   
                    ?>
                      <h4 class="box-header" style="margin-top: -15px;"><?php echo ucwords($user_info['username']) ?></h4>

                      <div style="margin-left: 15px;margin-top: -6px;">
                        <p style="font-size: 15px "><?php echo "<b>Phone -".$user_info['mobile']."</b>" ?></p>
                        <p style="font-size: 15px "><?php echo "<b>Email -".$user_info['email_id']."</b>" ?></p> 
                      </div>
                </div>
              </div>
           </div>
   <!--End Shipping Address  -->

<!--Shipping Address  -->  
          <div class="col-sm-4">
            <div class="box box-solid">
              <div class="box-body" style="height: 220px;">
                  <h4 class="box-header with-border"><b>Shipping  Information</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
                    <?php 

                    $address_data = $this->db->get_where('order_address_master',array('order_master_id'=>$getData['id']))->row_array(); 
                    ?>
                      <h4 class="box-header" style="margin-top: -15px;"><?php echo ucwords(@$address_data['title']) ?> - <?php echo ucwords(@$address_data['contact_person']) ?></h4>

                      <div style="margin-left: 15px;margin-top: -6px;">
                        <p style="font-size: 15px "><?php echo @$address_data['address'].", ".@$address_data['localty'].", ".@$address_data['landmark']."<br>".@$address_data['city']." - ".@$address_data['state']."<br> Pincode - ". @$address_data['pincode']. ".<br><b>Phone -".@$address_data['mobile_number']."</b>"; ?></p> 
                      </div>
                </div>
              </div>
           </div>
   <!--End Shipping Address  -->


    <!-- Payment Detail -->
    
          <div class="col-sm-4">
              <div class="box box-solid">
                <div class="box-body">
                   <h4 class="box-header with-border"><b>Payment Detail</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
               
                 <div class="table-responsive">
                    <table class="table">
                      <tbody>

                        <tr>
                          <th style="width:50%">Order Date & Time :</th>
                          <td><?php echo date('d-M-Y H:i:s', $getData['add_date']) ?></td>
                        </tr>

                        <tr>
                          <th style="width:50%">Order no. :</th>
                          <td> <?php echo $getData['order_number']; ?></td>
                        </tr>

                        <tr>
                          <th style="width:50%">Mode Of Payment :</th>
                          <td><?php 
                             if($getData['payment_type']=='1'){ echo "COD"; }if($getData['payment_type']==2){ echo "Online Payment";} ?>
                          </td>
                        </tr>
                  
                        <tr>
                          <th> Order Cost:</th>
                          <td> <i class="fa fa-inr" style="font-size:12px !important"></i>
                             <?php echo $getData['final_price']; ?>
                            <!-- <br><small style="font-size: 10px; color:#ca3e2c;"> <b>( * Including Shipping Charge)</b></small> -->
                          </td>
                        </tr>
                       <!--  <tr>
                          <th style="width:50%">Discount Amount :</th>
                          <td><i class="fa fa-inr" style="font-size:12px !important"></i>&nbsp;<?php echo  $getData['coupon_discount'];?>
                          </td>
                        </tr> -->
            
                        <tr style="border-top-style:outset; border-top-width:2px;border-top-color:#d4d4ca; border-bottom-style:outset; border-bottom-width:2px;border-bottom-color:#d4d4ca;">
                            <th>Amount Payable:</th>
                            <td> <i class="fa fa-inr" style="font-size:12px !important"></i>
                             <?php echo $getData['final_price']; ?>
                            </td>
                        </tr>
            
                     </tbody>
                  </table>
          
              
                  </div> 

                </div>
              </div>
            </div> 

       <!-- End Payment Detail -->

          <div class="col-sm-8" style="margin-top: -70px;">
                <div class="box box-solid">
                  <div class="box-body" style="padding-bottom:0px !important">
                      <h4 class="OrderTitle"> Order-ID  ─
                         <?php echo $getData['order_number'];
                            

                         ?>(<?php echo count($purchaseData);?>)
                      </h4>
             <?php
              foreach ($purchaseData as $value) {
                   $product = $this->db->get_where('sub_product_master',array('id'=>$value['product_master_id']))->row_array();

                   $array_url  = parse_url($product['main_image']);
                   
                  if(empty($array_url['host'])) {
                        $img_url = base_url().'/assets/product_images/'.$product['main_image'];
                    } else {
                        $img_url ='https://'.$array_url['host'].''.$array_url['path'].'?raw=1';
                  }
                     
                       
                       ?>
                      <div class="media" style="margin:10px 25px;">
                          <!-- PRODUCT IMAGE -->
                          <div class="media-left col-xs-12 col-md-4" >
                              <img src="<?php echo $img_url;?>" alt="Senseras" class="media-object ProductImg"style="height: 130px;" > 
                          </div>
                     
                          <!-- /PRODUCT IMAGE -->
                          <!-- PRODUCT DETAIL -->
                         <!--  <div class="media-body"> -->
                              <div class="clearfix col-xs-12 col-md-8" style="margin-top: 5px;">
                                  <p class="pull-right">
                                    <?php if($value['status']=='7') { ?>
                                      
                                     <a href="<?php echo base_url();?>admin/Order/ApproveReturnRequest/<?php echo $value['product_master_id'];?>/<?php echo $value['order_master_id'];?>"class="btn btn-block btn-warning btn-sm" onclick="return confirm('Are you sure you want to Approve Return Request?');" style="cursor: default;">
                                          Return Pending
                                      </a> 
                                    
                                 
                                    <?php }if($value['status']=='4') { ?>
                                        <a class="btn btn-block btn-danger btn-sm"  style="cursor: default;">
                                          Cancelled
                                        </a>
                                    <?php }

                                    if($value['status']=='8') { ?>
                                      <a class="btn btn-block btn-success btn-sm"  style="cursor: default;">
                                      Return Accepted
                                    </a>
                                    <?php } ?>
                                  </p>

                                  <h4 style="margin-top: 0;">
                                    <?php echo $product['product_name']; ?> 
                                      ─ <i class="fa fa-inr" style="font-size:15px !important"></i>
                                    <?php echo  $value['final_price']; ?>
                                   </h4>

                               
                                   <p>Quantity : <b><?php echo  $value['quantity']; ?>
                                    <i class="fa fa-shopping-cart margin-r5"></i> purchases</b>
                                  </p>
                                 
                               
                 
                                  <p>Total Amount :  <b><i class="fa fa-inr" style="font-size:12px !important"></i> 
                                    <?php echo  $value['final_price'];?>
                                   </b>
                                  </p>
                                 
                                  <p>Size : <?php echo  $value['size'];?></p>  
                                  <p>Color : <?php echo  $value['color'];?></p>  
                                    
                                  
                                  
                              
                               </div>
                          <!-- </div> -->


                         
                      </div>
                    <?php  } ?>


                  <?php if(!empty($check_return)){ ?>
                  <!--<button class="btn btn-success" onclick="assignCorier(<?=$getData['id'];?>);" style="float: right;">Assign Courier For Return Order</button>-->

                  <?php }  ?> 
             
           
          </div>
          <!--/.col (right) -->
        </div>
      
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

 <script>
function assignCorier(order_id){
   $.ajax({
         url:'<?php echo base_url('admin/Order/assignCorier'); ?>',
         type:'POST',
         data:{order_id:order_id},
         dataType:'text',
         success:function(response){
          console.log(response);
          $('#setCorierHtml').html(response);
          $('#myModal').modal('show');
         }
     });

}


function getServiceInfo(order_id,count) {
  var name     = $('#name_'+count).val();
  var rate     = $('#rate_'+count).val();
  var service  = $('#service_'+count).val();
  
  $.ajax({
         url:'<?php echo base_url('admin/Order/reverseCorierOrder'); ?>',
         type:'POST',
         data:{'order_id':order_id,'name':name,'rate':rate,'service':service},
         dataType:'JSON',
         success:function(response){
          if(response.status=='1'){
           alert(response.message);
           location.reload();
          } else {
            alert(response.message);
            location.reload();
          }
         }
     }); 
}

</script>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Corier</h4>
      </div>
      <div class="modal-body" id="setCorierHtml">
        
      </div>
      
    </div>

  </div>
</div>


  