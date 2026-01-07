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
      Manage Delivery Boy
      <a href="<?php echo base_url('admin/Dashboard/AddDeliveryBoy/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Delivery Boy</a>
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
              <div class="col-sm-12" style="overflow: auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th style="width:600px;">Statistic</th>
                  <th>Address</th>
                  <th>Profile&nbsp;Pic</th>
                  <th>Registration&nbsp;Date</th>
                  <th colspan="6">Action</th>
                  
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name'];?></td>
                  <td><?php echo $value['mobile'];?></td>
                  <td>
                          <?php   $Delivered=$this->db->query("select * from assign_order,order_master where assign_order.deliverBoyId=".$value['id']." and assign_order.order_id=order_master.id and order_master.status='3'")->num_rows();
                      if($Delivered=='0') { ?>
                          <span style="color:green;">Total Delivered Order-<?php echo $Delivered;?>
                        <?php } else if($Delivered=='1'){?>
                           <span style="color:green;">Total Delivered Order-<?php echo $Delivered;?>
                         <?php } else {?>
                           <span style="color:green;">Total Delivered Orders-<?php echo $Delivered;?>
                        <?php } ?>
                         <?php $Canceled=$this->db->query("select * from assign_order,order_master where assign_order.deliverBoyId=".$value['id']." and assign_order.order_id=order_master.id and order_master.status='4'")->num_rows();if($Canceled=='0') { ?>
                        </span><br/>
                             <?php $Pending=$this->db->query("select * from assign_order,order_master where assign_order.deliverBoyId=".$value['id']." and assign_order.order_id=order_master.id and order_master.status='1'")->num_rows(); 
                             if($Pending=='0') { ?>
                                <span style="color:black;">Total Assign Order-<?php echo $Pending+$Delivered+$Canceled;?>
                              <?php } else if($Pending=='1') {?>
                                 <span style="color:black;">Total Assign Order-<?php echo $Pending+$Delivered+$Canceled;?>
                               <?php } else  {?>
                                 <span style="color:black;">Total Assign Orders-<?php echo $Pending+$Delivered+$Canceled;?>
                              <?php } ?>
                       <br/>
                          <span style="color:red;">Total Canceled Order-<?php echo $Canceled;?>
                        <?php } else if($Canceled=='1'){?>
                           <span style="color:red;">Total Canceled Order-<?php echo $Canceled;?>
                        <?php } else { ?>
                           <span style="color:red;">Total Canceled Orders-<?php echo $Canceled;?>
                        <?php } ?>

                      </span>
                  </td>
                  <td><?php echo $value['address'];?></td>
                  <td><img src="<?php echo base_url();?>assets/banner_images/boy/<?php echo $value['profile_pic'];?>" style="width:100px;height:100px;"> </td>
                  <td><?php echo $value['add_date'];?></td>
                  <td>
                    <?php 

                        $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> '; 

                         ?>
                  </td>
                  <td><a href="<?php echo base_url();?>admin/Dashboard/UpdateDeliveryBoy/<?php echo $value['id']; ?>" title="Edit  Information"><i class="fa fa-edit" style="font-size:30px;"></i></a> </td>
                  <td> <a href="<?php echo base_url();?>admin/Dashboard/DeliveryBoyLocation/<?php echo $value['id'];?>" title="Map Information" class="fa fa-map-marker" style="font-size:30px;"></a></td>
                  <td><a href="<?php echo base_url();?>admin/Dashboard/transaction/<?php echo $value['id'];?> " title="View Transaction" class="btn btn-primary">Transaction</a></td>
                  <td>
                   <?php if($value['login_status']=='0'){ ?>
                    <span class="btn btn-warning">New User</span>

                   <?php  } else if($value['login_status']=='1'){?>
                    <a href="<?php echo base_url();?>admin/Dashboard/DeliveryBoyLogout/<?php echo $value['id'];?>" title="Logout" onclick="confirm_click();" class="btn btn-success">Login</a>
                     <?php } else if($value['login_status']=='2'){?>
                         <span class="btn btn-danger">Logout</span>
                    <?php } ?>
                </td>
                  <td><a href="<?php echo base_url();?>admin/Dashboard/rejected/<?php echo $value['id'];?> " title="View Rejected Items" class="btn btn-danger">Rejected Items</a></td>
                </tr>

                  <?php $counter ++ ; } ?>
                
                </tbody>
               
              </table>
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

<script type="text/javascript">
function confirm_click()
{
return confirm("Are you sure logout delivery Boy?");
}

</script>

<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/DeliveryStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Delivery Boy ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Delivery Boy ?");}

   
       
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


  
