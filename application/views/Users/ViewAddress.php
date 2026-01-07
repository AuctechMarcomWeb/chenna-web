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
      View User Address of <?php echo $getSingleData?>
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
              <table id="example5" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Person Name</th>
                  <th>Address</th>
                  <th>Pincode</th>
                  <th>City</th>
                  <!--<th>State</th>-->

                  
                  <th>Mobile  </th>
                 <!--  <th>View Address</th> -->
                  <?php  #<br><small><i class="fa fa-check-circle" aria-hidden="true" style="color: green"></i> Verified, <i class="fa fa-times-circle" aria-hidden="true"  style="color: red"></i> Not Verified</small>?>
                 <!--  <th style="width:50px">Status</th> -->
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";
                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['area_streat_address'].", ".$value['locality'].".<br/> Landmark ".$value['landmark_optional'] ?> </td>
                  <td><?php echo $value['pincode']?></td>
                  <td><?php echo $value['district_city_town']?></td>
                  <!-- <td><?php echo $this->Manage_Users_Model->getSingleData($value['id'],'state_master','state_name')?></td> -->
                  <td><?php echo $value['phone_no'] ; ?>
                  </td>
               <!--    <td><a href="<?php echo site_url().'admin/Users/Useraddress/'.$value['id']?>"></a></td> -->
                  <!-- <td>
                   <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:UsersStatus('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                        
                         ?>
                  </td> -->
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
   
    $('#example5').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    })
  })


  
</script>