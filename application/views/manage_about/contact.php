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
      <h1><?= @$title; ?>  <!-- <a href="<?php echo base_url('admin/Dashboard/AddFAQ/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add FAQ</a> --> 
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
                  <th>Mobile&nbsp;No.</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Send&nbsp;Date</th>
                  <th>Status</th>
                 <!--  <th>Action</th> -->
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
                  <td><?= $value['phone']; ?></td>
                  <td><?= $value['email']; ?></td>
                  <td><?= $value['subject']; ?></td>
                  <td><?= $value['messages']; ?></td>

                  <td><?= @$value['add_date'] ?  date('d-m-Y',$value['add_date']) : ''; ?></td>
                   
                    <td >
                      <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" data="'.$value['status'].'" id="my_'.$value['id'].'" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';
                         ?>
                  </td>
                
              <!--     <td>
                    <a href="<?= base_url('admin/Dashboard/EditFAQ/'.base64_encode($value['id'])); ?>" class="btn btn-info btn-xs" title="Edit/View" > Edit/View </a>
                  </td> -->

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
     var url = "<?php echo site_url('admin/Dashboard/contactStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this contact?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this contact?");}
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