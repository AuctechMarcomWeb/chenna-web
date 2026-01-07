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
      Membership Users
     <?php /*  <a href="<?php echo base_url('admin/Users/AddUsers/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add User</a>
      </h1> */?>
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
                  <th>Order&nbsp;Number</th>
                  <th>Customer&nbsp;Number</th>
                  <th style="width:150px;">Plan Price&nbsp;(<i class="fa fa-rupee"></i>)</th>
                  <th>Description</th>
                  <th>Purchase&nbsp;Date</th>
                  <th style="width:50px">Status</th>
                  <th>Invoice</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) { 
                   $userInfo = $this->db->get_where('user_master',array('id'=>$value['user_id']))->row_array();
                   $planInfo = $this->db->get_where('member_plan',array('id'=>$value['plan_id']))->row_array();
                   

                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['order_number']?></td>
                  <td><?php echo $userInfo['phone_no']; ?></td>
                  <td><?php echo $planInfo['plan']?></td>
                  <td><?php echo $planInfo['description'] ?></td>
                  <td><?php echo date('d-M-Y H:i:s',$value['add_date']); ?></td>
                  <td>
                   <?php  if($value['status']=='1') { ?>
                           <span class="label label-warning" style="font-size:12px;">Process (Order Receive)</span>
                    <?php } elseif($value['status']=='2') { ?>
                          <span class="label label-info" style="font-size:12px;">Process Completed</span>
                  <?php } elseif($value['status']=='3') { ?>
                          <span class="label label-success" style="font-size:12px;">Completed</span>
                  <?php } else { ?>
                            <span class="label label-danger" style="font-size:12px;">Cancel</span>
                    <?php } ?> 
                  </td>
                 <td><a href="<?php echo ($value['invoice_link']!='') ? $value['invoice_link']:' ' ?>" target="_blank"> <?php echo ($value['invoice_link']!='') ? 'View Invoice':' NO Invoice' ?> </a>
                  </td>
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