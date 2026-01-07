<?php $order_number =$this->uri->segment(4);
$get_order = $this->db->get_where('user_membership_plan',array('order_number'=>$order_number))->row_array();
$plan_data = $this->db->get_where('member_plan',array('id'=>$get_order['plan_id']))->row_array();
$status = $get_order['status'];
$oder_id = $get_order['id'];
$deliverBoyId = $this->db->query("SELECT * FROM assign_membership_order where order_id='$oder_id'")->row_array();
$BoyId=$deliverBoyId['deliverBoyId'];
$deliverBoy = $this->db->query("SELECT * FROM deliver_boy_master where id='$BoyId'")->row_array();
$ifOrderExist =  $this->db->get_where('assign_membership_order',array('order_id'=> $oder_id))->num_rows();
$user_id = $get_order['user_id'];
$userInfo = $this->db->query("SELECT * FROM user_master where id='$user_id'")->row_array();
 ?>



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
  position: fixed;
  top: 7.5em;
  right: 0.3em;
  width:27%;

}
</style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="col-sm-4">
            <div class="box box-solid">
              <div class="box-body">
               <h4 class="box-header with-border"><b>Membership Plan</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
                  <address style="padding-left: 10px">
                     
                      <span>Plan&nbsp;Price:&nbsp;</span>
                      <span style="margin-left: 130px;"><i class="fa fa-rupee"></i>&nbsp;<?php echo $plan_data['plan'];?></span>
                  </address>
                   <address style="padding-left: 10px">
                      <span style="margin-top:">Wallet Amount:</span>
                      <span style="margin-left: 100px;"><?php echo $plan_data['plan_price'];?></span>
                  </address>
             </div>
          </div>
        </div> 


      <div class="col-sm-4 addres_box">
              <div class="box box-solid">
                <div class="box-body">
                   <h4 class="box-header with-border"><b>Payment Detail</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
           
                 <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <tr>
                        <th style="width:50%">Customer Number :</th>
                        <td><?php echo $userInfo['phone_no'];?></td>
                      </tr>
                      <tr>
                        <th style="width:50%">Order Invoice:</th>
                        <td> <a href="<?php echo ($get_order['invoice_link']!='') ? $get_order['invoice_link']:' ' ?>" target="_blank"> <?php echo ($get_order['invoice_link']!='') ? 'View Invoice':' No Invoice' ?> 
                        </a>
                        </td>
                      </tr>
                      <tr>
                        <th style="width:50%">Purchase Date:</th>
                        <td><?php echo date("d-m-Y H:i:s",$get_order['add_date']);?></td>
                      </tr>
                      <tr>
                        <th style="width:50%">Delivery&nbsp;Boy&nbsp;Name:</th>
                        <td><?php echo $deliverBoy['name'];?> </td>
                      </tr> 
                      <tr>
                        <th style="width:50%">Customer&nbsp;Sign:</th>
                        <td>
                          <?php if(!empty($get_order['signature'])){?>
                             <img src="https://mrnmrsekart.com/assets/sign/<?php echo $get_order['signature'];?>" style="width:100px;height:100px;"> </td>
                           <?php } ?>
                      </tr>
                       
                    </tbody></table>
                  </div> 

                </div>
              </div>
            </div>


         <div class="col-sm-4">
            <div class="box box-solid">
              <div class="box-body">
               <h4 class="box-header with-border"><b>Assign Order</b> <i class="fa fa-address-card-o" aria-hidden="true"></i></h4>
                  <address style="padding-left: 10px">
                     
                      <span>Order&nbsp;Number:&nbsp;</span>
                      <span style="margin-left: 70px;"><?php echo $order_number;?></span>
                  </address>
                   <address style="padding-left: 10px">
                      <span style="margin-top:">Assign:</span>
                      <span style="margin-left: 120px;">
                        <?php if($ifOrderExist > 0 AND ($get_order['status']!='3' AND $get_order['status']!='4')): ?>
                        <a href="#" data-toggle="modal" data-target="#myModal" onclick="Getvalue('<?php echo $get_order['id']; ?>');" style="color:maroon;"><?php echo $deliverBoy['name']; ?></a>
                        <?php  elseif(($get_order['status']!='3' AND $get_order['status']!='4')) :?>
                        <a href="#" data-toggle="modal" data-target="#myModal" onclick="Getvalue('<?php echo $get_order['id']; ?>')" style="color:maroon;">Order Assign</a> 
                        <?php else:
                        echo $deliverBoy['name'];
                        endif;
                        ?>
                      </span>
                  </address>
             </div>
          </div>
        </div> 
              
        </div>

      <div class="col-md-12">
          
          <!-- Horizontal Form -->

<?php  #####################################################################
       ####################   TYPE -1 FOR ADMIN     ########################
       #####################################################################   ?>
 
            <div class="col-sm-8">
                <div class="box box-solid">
                  <div class="box-body" style="padding-bottom:0px !important">
                      <h4 class="OrderTitle"> Order-ID  ─ <?php echo $order_number;?>
                         
                      </h4>
           
                <div  style="margin: 10px 25px ;">   
                  <center><h3> Order Status</h3></center> 
                <form class="form-horizontal"  action="<?php echo site_url('admin/Membership/UpdateOrderStatus').'/'.$this->uri->segment(4).'/'.$adminData["Id"]; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                  <input type="hidden" class="form-control" name="Url" value="<?php echo $_SERVER['REQUEST_URI']?>">
                  <input type="hidden" name="order_number" value="<?php echo $get_order['order_number'];?>">
                  <input type="hidden" name="description" value="<?php echo $get_order['description'];?>">
                
                  <input type="hidden" name="mobile" value="<?php echo $userInfo['phone_no'];?>">
                 <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                  <div class="col-sm-10">
                   <?php  if($status =='3') { ?>
                    <input type="text" class="form-control"  required value="<?php echo ucwords('Completed')?>" Disabled>
                    <?php } elseif($status=='4') { ?>
                    <input type="text" class="form-control"  required value="<?php echo ucwords('Cancelled')?>" Disabled>
                    <?php } else {   ?>
                    <select name="StatusUpdate" style="color:black"  class="form-control" onchange="getval(this);">
                     <option value="1" <?php echo ($status =='1')?'Selected':'' ?> <?php echo ($status >'1')?'Disabled':'' ?> >Process (Order Receive)</option>
                     <option value="2" <?php echo ($status =='2')?'Selected':'' ?> <?php echo ($status >'2')?'Disabled':'' ?>> Process Completed</option>
                     <option value="3" <?php echo ($status =='3')?'Selected':'' ?> <?php echo ($status >'3')?'Disabled':'' ?>> Completed </option>
                      <option value="4" <?php echo ($status =='4')?'Selected':'' ?> <?php echo ($status >'4')?'Disabled':'' ?>> Canceled </option>
                     
                   </select>
                   <?php }?>
                  </div>
                  </div>
                
                <?php if($status!='4') {?>
                
                <div class="form-group" id="row_dim" style="display:none;">
                  <label for="inputEmail3" class="col-sm-2 control-label">Remark</label>
                  <div class="col-sm-10">
                  
                    <textarea rows="5" cols ="3" class="form-control"   name="remark"></textarea>

                  </div>
                </div>
                  <div class="box-footer">
                    
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                  <?php } ?>
                         </form>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <!--/.col (right) -->
        </div>
      
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <script type="text/javascript">
     function ContactnumberCheck(num) {
    alert(num);
      $.ajax({
        type: "POST",
        url: "<?php  echo base_url('admin/Vendor/CheckContact')?>/"+num,
               
        success: function(result){
          console.log(result)
        if(result==1)
          {
            $('#phone_check').html("Contact Number Already Exsist");
          }else{
            $('#phone_check').html("");
          } 
                
        }
      });
            
      }


  </script>
<script>
function Getvalue(Id)
  {
  $("#mods1").load('<?php echo base_url('admin/Product/action2'); ?>', {"orderAssign_membership": Id} );
  }


</script>
<script>
  
  function getval(sel){
    var value  = sel.value;
    if(value ==1){
      $('#row_dim').hide();
    }
    if(value ==2){
      $('#row_dim').hide();
    }
    if(value ==3){
      $('#row_dim').hide();
    }
    if(value ==4){
      $('#row_dim').show();
    }
  }
 
</script>
  <!--+++++++++ Order Assign For deliver boy+++++++++++++= -->

              <div class="container">
                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog modal-md">
                  
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title text-center text-primary"><b>Order Assign to deliver boy</b></h3><hr style="border:1px solid #B4BFC6;">
                      </div>
                      <div class="modal-body" id="mods1">
                      </div>

                    </div>
                    
                  </div>
                </div>
               </div>
  