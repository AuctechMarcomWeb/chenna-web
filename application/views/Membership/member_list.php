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
     Manage  Membership
     <!-- <a href="<?php echo base_url('admin/Membership/addPlan/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Plan</a> -->
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
                  <th>Order&nbsp;No.&nbsp;(Assign&nbsp;Order)</th>
                  <th>Customer&nbsp;Number</th>
                  <th>Plan&nbsp;Price&nbsp;(<i class="fa fa-rupee"></i>)</th>
                  <th>Wallet&nbsp;Amount</th>
                  <th style="width:50px">Order&nbsp;Status</th>
                  <th>Invoice</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) { 

                  $useinfo = $this->db->get_where('user_master',array('id'=>$value['user_id']))->row_array();
                  $memberinfo = $this->db->get_where('member_plan',array('id'=>$value['plan_id']))->row_array();
                  ?>
                  
                <tr>
                  <td><?php echo $counter; ?></td>
                   <td>
                    <a href="<?php echo base_url()?>admin/Membership/orderDetail/<?php echo $value['order_number']; ?>"><?php echo $value['order_number'] ?></a>
                        <?php 
                        $oder_id = $value['id'];
                        $deliverBoyId = $this->db->query("SELECT * FROM assign_membership_order where order_id='$oder_id'")->row_array();
                        $BoyId=$deliverBoyId['deliverBoyId'];
                        $deliverBoy = $this->db->query("SELECT * FROM deliver_boy_master where id='$BoyId'")->row_array();
                        $ifOrderExist =  $this->db->get_where('assign_membership_order',array('order_id'=> $oder_id))->num_rows();
                      ?></a>
                     <br>
                    
                    <?php if($ifOrderExist > 0 AND ($value['status']!='3' AND $value['status']!='4')): ?>
                      <a href="#" data-toggle="modal" data-target="#myModal" onclick="Getvalue('<?php echo $value['id']; ?>');" style="color:maroon;"><?php echo $deliverBoy['name']; ?></a>
                    <?php  elseif(($value['status']!='3' AND $value['status']!='4')) :?>
                     <a href="#" data-toggle="modal" data-target="#myModal" onclick="Getvalue('<?php echo $value['id']; ?>')" style="color:maroon;">Order Assign</a> 
                     <?php else:
                        echo $deliverBoy['name'];
                        endif;
                      ?>

                  </td>
                  <td><?php echo $useinfo['phone_no']?></td>
                  <td><?php echo $memberinfo['plan'] ?></td>
                  <td><?php echo $memberinfo['plan_price'] ?></td>
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
                  <td><a href="<?php echo ($value['invoice_link']!='') ? $value['invoice_link']:' ' ?>" target="_blank"> <?php echo ($value['invoice_link']!='') ? 'View Invoice':' No Invoice' ?> </a>
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

<script>
    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var user_id = $(this).attr('user_id');
        var user_wallet = $(this).attr('user_wallet');
        var s_id = $(this).attr('s_id');
        var table = 'user_membership_plan';
        var act = $(this).html();
        var text = '';
        if (act == 'UnAproved') {
            text = 'Aproved';
        } else {
            text = 'UnAproved';
        }
        //alert(act);
        var text = "Are you sure! You want to "+text+" this Membership?"
        var r = confirm(text);
        if (r) {
            var s_url = '<?php echo base_url('admin/Membership/ChangeStatus')?>';
            $.ajax({
                data: {'table': table, 'id': s_id,'user_id':user_id,'user_wallet':user_wallet},
                url: s_url,
                type: 'post',
                success: function(data){
                  console.log(data);
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
<script>
function Getvalue(Id)
  {
  $("#mods1").load('<?php echo base_url('admin/Product/action2'); ?>', {"orderAssign_plan": Id} );
  }
</script>

