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
     <?php 
      $id=$this->uri->segment(4);
         $Delivery_Boy= $this->db->query("select * from deliver_boy_master where id=".$id." ")->row_array();
       echo  $Delivery_Boy['name'];
       $Delivery_Boy_total= $this->db->query("select SUM(total_amount) as total from delivery_boy_transaction where delivery_boy_id=".$id." ")->row_array();
       ?>  
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
                    <th style="width:70px;">Sr&nbsp;No.</th>
                    <th>Order&nbsp;Number</th>
                    <th>Product&nbsp;Name</th>
                    <th>Product&nbsp;Weight</th>
                    <th>Product&nbsp;Price</th>
                    <th>Rejected&nbsp;Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $counter ="1";
                 foreach ($getData as $value) {
                 // print_r($value); exit;
                  $getOrder = $this->db->get_where('order_master', array('id' => $value['order_master_id']))->row_array();
                  $getProduct  = $this->db->get_where('product_master', array('id' => $value['product_master_id']))->row_array();
                  $getUnit = $this->db->get_where('unit_master', array('id' => $getProduct['unit']))->row_array();

                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                 <td><a href="<?php echo base_url();?>admin/Order/ViewOrder/<?php echo $value['order_master_id'];?>"><?php echo $getOrder['order_number'];?></a></td>
                  <td><a href="<?php echo base_url();?>admin/Product/index"><?php echo $getProduct['product_name'];?></a></td>
                  <td><?php echo $getProduct['weight_litr']." ".$getUnit['unit_name'];?></td>
                  <td><?php echo $value['final_price'];?></td>
                  <td><?php echo  date('d-m-Y H:i:s' , $value['modify_date']);;?></td>
                   <td>
                   <?php if($value['reject_status']=='1'){?>
                        <a href="<?php echo base_url();?>admin/Dashboard/BoyRejectProduct/<?php echo $value['id']; ?>/<?php echo $id;?>" class="btn btn-primary">Accept</a>
                      <?php } else if($value['reject_status']=='2') { ?>
                        <span class="btn btn-success">Accepted</span>
                      <?php } ?>
                  </td>
                  <?php $counter ++ ; } ?>
                </tbody>
              </table>




  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Your Transaction Detail</h4>
        </div>
        <div class="modal-body" id="mods1">
         
        </div>
      
      </div>
      
    </div>
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
  
<!-- <script type="text/javascript">
function Getvalue(argument){
   $('input[name="transactionID"]').val(argument);
   $('#transactionID').text(argument);
   $.ajax({
        type:'POST',
        url:'<?php echo base_url('admin/Dashboard/transactionDetailsGet'); ?>',
        data:{transactionID:argument},
        
        dataType:'JSON',
        success:function(response){
           console.log(response);
        }
   })
}

</script> -->



<script type="text/javascript">
function confirm_click()
{
return confirm("Are you sure logout delivery Boy?");
}

</script>

<script>
    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        var table = 'delivery_boy_transaction';
        var act = $(this).html();
        var text = '';
        if (act == 'UnAproved') {
            text = 'Aproved';
        } else {
            text = 'UnAproved';
        }
        //alert(act);
        var text = "Are you sure! You want to "+text+" this Transaction?"
        var r = confirm(text);
        if (r) {
            var s_url = '<?php echo base_url('admin/Dashboard/ChangeStatus')?>';
            $.ajax({
                data: {'table': table, 'id': s_id},
                url: s_url,
                type: 'post',
                success: function(data){
                    if (data == '1') {
                        $('#'+get_id).removeClass('btn-warning');
                        $('#'+get_id).addClass('btn-success');
                        $('#'+get_id).text('Aproved');
                        $('#success_msg').css('color', 'green').html('<div class="alert alert-success"> Aproved Successfully.</div>').show();
                        setTimeout(function() { $("#success_msg").hide(); }, 2000);
                    } else if (data == '2') {
                        $('#'+get_id).removeClass('btn-success');
                        $('#'+get_id).addClass('btn-warning');
                        $('#'+get_id).text('UnAproved');
                        $('#success_msg').css('color', 'red').html('<div class="alert alert-danger"> UnAproved Successfully.</div>').show();
                        setTimeout(function() { $("#success_msg").hide(); }, 2000);
                    }
                }
            });
        }
    });

setTimeout(function() { $(".alert-success").hide(); }, 2000);
</script>
<script>
function Getvalue(Id)
  {
  $("#mods1").load('<?php echo base_url('admin/Dashboard/action2'); ?>', {"boyTransactionID": Id} );
  }
</script>