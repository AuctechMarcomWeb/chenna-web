<?php $adminData= $this->session->userdata('adminData');?>




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


.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Manage Shop
      <a href="<?php echo base_url('admin/shop/addShop/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add New Shop</a>
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr&nbsp;No.</th>
                  <th>Shop&nbsp;Name</th>
                  <th>Warehouse&nbsp;Id</th>
                 <?php if($adminData['Type']=='1'){ ?>
                  <th>Seller&nbsp;Name</th>
                  <th>Is&nbsp;Verified</th>
                 <?php } ?>

                  <th>Products</th>
                  <th>Status</th>
                  <th>Action</th>
               <?php if($adminData['Type']=='1'){ ?>
                  <th>Send Alert</th>
                <?php } ?>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {
                  $this->db->select('name');
                  $vendor = $this->db->get_where('staff_master',array('id'=>$value['vendor_id']))->row_array();
                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name']?><br>
                     <?php  if($value['verify_shop']=='1') { ?>
                        <span class="text-success" style="color:green;"> <i class="fa fa-check-circle" aria-hidden="true"></i> Verified</span>
                     <?php  } else { ?>
                        <span class="text-danger" style="color:red;"> <i class="fa fa-times-circle" aria-hidden="true"></i> Unverified</span>

                     <?php  } ?>
                    
                    
                  </td>
                  <td><?php echo (empty($value['warehouse_id']))?'NA':$value['warehouse_id']?></td>

              <?php if($adminData['Type']=='1'){?>

                  <td><?php echo $vendor['name']?></td>
                  <td>
                    <label class="switch">
                      <?php  if($value['verify_shop']=='1') { ?>

                        <input type="checkbox" checked="" value="1" onclick="verify_shop(this.value,<?php echo $value['id']; ?>)">
                     <?php  } else { ?>

                        <input type="checkbox" value="2" onclick="verify_shop(this.value,<?php echo $value['id']; ?>)">

                     <?php  } ?>
                      
                      <span class="slider round"></span>
                    </label>
                  </td>
                  
              <?php } ?>
                    <?php
                    $product_count = $this->db->get_where('sub_product_master',['addedBy'=>$value['vendor_id']])->num_rows();
                    ?>
                  <td><?php echo $product_count;?></td>
                  <td>
                   <?php if($value['status']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url();?>admin/shop/updateShop/<?php echo $value['id']; ?>" title="Edit  Shop"><i class="fa fa-edit" style="font-size: 25px;"></i></a>

                    <a onclick="return confirm('Are you sure you want to delete this Shop?');" href="<?php echo base_url();?>admin/shop/delete_shop/<?php echo $value['id']; ?>" title="Delete  Shop"><i class="fa fa-trash-o" style="font-size:24px;color:red;"></i></a> 
                  </td>
                   <?php if($adminData['Type']=='1'){?>
                    <td>
                       <a onclick="return confirm('Are you sure you want to Send Alert?');" href="<?php echo base_url();?>admin/shop/sendSmsEmail/<?php echo $value['id']; ?>" title="Send Product Alert"><button class="btn btn-success">Product Alert</button></a> 
                    </td>
                    <?php } ?>
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

function verify_shop(value,shop_id) {

   $.ajax({
         url:'<?php echo base_url('admin/shop/verify_shop'); ?>',
         type:'POST',
         data:{'value':value,'shop_id':shop_id},
         dataType:'text',
         success:function(response){
          
         }
     });
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