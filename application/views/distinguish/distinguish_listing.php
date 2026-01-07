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
      <h1> Manage Distinguishes
       <a href="<?php echo base_url('admin/Dashboard/add_dist/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Distinguish</a>
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
                  <th style="width:70px">Sr No.</th>
                  <th style="padding-left: 50px ">Distinguish Name</th>
                  <th style="width:70px">Status</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td style="padding-left: 50px "><a href="<?php echo site_url().'admin/Dashboard/Updatedist/'.$value['id']?>"><?php echo $value['distinguish_name']?></a></td>
                  <td >
                   <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';
                         ?>
                  </td>
                </tr>

                  <?php  $counter ++ ; } ?>
                
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
<!-- jQuery 3 -->
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script> 
<!-- DataTables -->
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/DistStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this ?");}
       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
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