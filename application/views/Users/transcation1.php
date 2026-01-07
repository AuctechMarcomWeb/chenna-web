
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
      Manage Credit
      <a href="<?php echo base_url('admin/Credit/AddCredit/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Credit</a>
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
                  <th style="width:70px;">Sr No.</th>
                  <th>User Number</th>
                  <th>Payable Value</th>
                  
                  <th style="width:250px">Add Date</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $counter ="1";
                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><!-- <a href="<?php //echo site_url().'admin/Dashboard/UpdateCoupon/'.$value['id']?>"> --><?php echo singlerowparameter2('phone_no','id',$value['user_master_id'],'user_master') ?><!--  </a> --></td>
                  <td><?php echo ($value['debit_credit']==1)?' - '.$value['amount'] :'+ '.$value['amount']; ?><?php echo "<br><p style='color:brown'>".$value['remark']."</p>" ?></td>
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