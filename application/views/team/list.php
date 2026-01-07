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
.user_img{height: 80px;}
   </style>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?= @$title; ?>  <a href="<?php echo base_url('admin/Dashboard/AddTeam/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Team</a> 
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
           <!-- /.box-header -->
           <div class="col-md-12" id="hiddenSms">
            <?php if(!empty($this->session->flashdata('msg'))){ echo $this->session->flashdata('msg');  } ?></div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th >Sr No.</th>
                  <th>Name</th>
                  <th>POST</th>
                  <th>Profile</th>
                  <th>Added on</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";
                if(!empty($list)){
                foreach ($list as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?= $value['name']; ?></td>
                  <td><?= $value['post']; ?></td>
                  <td class="text-center">
                      <img src="<?= base_url('assets/profile_image/'.$value['profile']); ?>" class="user_img">
                  </td>

                  <td><?= @$value['add_date'] ?  date('d-m-Y',$value['add_date']) : ''; ?></td>
                  <td> 
                        <?php if($value['status']==1){ ?>
                            <label class="label label-success"> Active </label>
                        <?php }else{ ?>
                            <label class="label label-danger"> Inactive </label>
                        <?php } ?>
                   </td>
                
                  <td>
                    <a href="<?= base_url('admin/Dashboard/EditTeam/'.base64_encode($value['id'])); ?>" class="btn btn-info btn-xs" title="Edit/View" > Edit/View </a>
                  </td>

                </tr>

                  <?php $counter ++ ; } } ?>
                
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
<?php /*
<!-- jQuery 3 -->
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script> 
<!-- DataTables -->
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>*/?>


<script>
function Verfiy_Video(id,status) {
     var status = $('#my_'+id).attr('data');

     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/unitStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Unit?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Unit?");}
    // alert(Vid);   
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        if(response == 1){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/act.png")?>'); $('#my_'+id).attr('data',1); } 
        if(response == 2){ $('.status_img_'+id).attr('src','<?php echo base_url("assets/delete.png")?>'); $('#my_'+id).attr('data',2); }
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