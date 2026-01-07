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

.logo{ height: 60px;width: 60px;  }
.statusbtn{cursor: context-menu;}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Manage Vouchers
   <small><a href="<?= base_url('admin/ManageCoupon/addVoucher'); ?>" class="fs_14"><b>Add Voucher</b></a></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <!--   <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Manage Coupons</li>
            </ol> -->
          <div class="box">
            <!-- /.box-header -->
            
            <div class="col-md-12" id="hiddenSms">
            <?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                 <tr>
                    <th>Sr No.</th>
                    <th >Voucher Code</th>
                    <th>Voucher Amount</th>
                    <th>Minimum Cart Amount</th>
                    <th>No Of Uses</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php if (!empty($vouchers)):  $i = 1; foreach(array_reverse($vouchers) as $vouchers){ ?>
                      <tr>
                          <td><?php echo $i; ?></td>

                          <td style="width: 100px; word-break: break-all;"><?= @$vouchers['voucher_code']; ?></td>
                          <td><?= @$vouchers['voucher_value']; ?></td>
                         
                          <td><?= @$vouchers['min_cart_value']; ?></td>
                          <td><?= @$vouchers['no_of_uses']; ?></td>
                          <td>Start Date: <?= date('d/m/Y', @$vouchers['add_date']); ?></td>
                    
                          <td>
                              <?php if($vouchers['status'] == 1){ ?>
                                  <label class=" label  label-success" >Activated</label>

                              <?php } if($vouchers['status'] == 2){ ?>
                                  <label class=" label  label-danger  " >Deactivated</label>
                              <?php } ?>
                          </td>
                          <td><a href="<?php echo base_url("admin/ManageCoupon/editVoucher/".base64_encode($vouchers['id'])); ?>" title="View/Edit" > <button type="button" class="btn btn-info  btn-xs custome_btn">View/Edit</button></a>

                        <a href="<?php echo base_url("admin/ManageCoupon/deleteVoucher/".base64_encode($vouchers['id'])); ?>">
                          <img src="<?php echo base_url();?>assets/img/delete_icon.png" style="height:20px;width:20px;">
                        </a>

                          </td>
                    </tr>
                  <?php $i++; } ?>
                
              </tbody>
            <?php endif; ?>
               
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
function UsersStatus(id,status) {
    var Vid= id;
    var url = "<?php echo site_url('admin/Users/UsersStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Users ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Users ?");}       
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