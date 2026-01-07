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
.set_img{
  margin-top: -12px;
    height: 25px;
    width: 25px;
}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
     Membership Plan
     <a href="<?php echo base_url('admin/Membership/addPlan/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Plan</a>
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
                  <th style="width:150px;">Plan&nbsp;Price&nbsp;(<i class="fa fa-rupee"></i>)</th>
                  <th>Wallet&nbsp;Amount</th>
                  <th>No.&nbsp;Of&nbsp;Users</th>
                  <th>Description</th>
                  <th style="width:50px">Status</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) { 
                   $count = $this->db->get_where('user_membership_plan',array('plan_id'=>$value['id']))->num_rows();

                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['plan']?></td>
                  <td><?php echo $value['plan_price'] ?></td>
                   <td><a href="<?php echo base_url(); ?>admin/Membership/planList/<?php echo $value['id']?>"><?php echo $count; ?></a></td>
                  <td><?php echo $value['description'] ?></td>
                  <td style="width:100px;">

                     <span>
                        <?php  
                         $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:UsersStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].' set_img"></a> '; ?>
                         &nbsp;
                      <a href="<?php echo base_url();?>admin/Membership/update_plan/<?php echo $value['id']; ?>" title="Edit Plan Information"><i class="fa fa-edit" style="font-size:28px;"></i>
                      </a>
                     </span> 
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
     var Vid = id;
     var url = "<?php echo site_url('admin/Membership/UsersStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Plan?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Plan?");}       
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