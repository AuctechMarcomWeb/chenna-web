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
      Manage Pincode
      <a href="<?php echo base_url('admin/Dashboard/add_pincode/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Pincode</a>
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
              <div class="col-sm-12" style="overflow: auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Pincode</th>
                  <th>Location</th>
                  <th>Location&nbsp;Name</th>
                  <th>Action</th>
                  
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['pin_code'];?></td>
                  <td><?php if($value['pin_status']=='1'){ echo"In City"; } else{ echo"Out City";}?></td>
				  <td><?php echo $value['location_name'];?></td>
                  <td><a href="<?php echo base_url();?>admin/Dashboard/edit_pincode/<?php echo $value['id'];?> " title="Update Pincode" class="btn btn-info">Edit</a>
                  &nbsp;&nbsp;&nbsp;
                  <a href="<?php echo base_url();?>admin/Dashboard/delete_pincode/<?php echo $value['id'];?> " title="Delete Pincode" class="btn btn-danger">Delete</a>
                  </td>
                </tr>

                  <?php $counter ++ ; } ?>
                
                </tbody>
               
              </table>
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

<script type="text/javascript">
function confirm_click()
{
return confirm("Are you sure logout delivery Boy?");
}

</script>

<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/DeliveryStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Delivery Boy ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Delivery Boy ?");}

   
       
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


  
