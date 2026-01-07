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
      Manage Brands
      <a href="<?php echo base_url('admin/Dashboard/addbrand/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Brand</a>
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
                  <th>Sr No.</th>
                  <th>Brand Name</th>
                  <th>Brand Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['brand_name']?></td>
                  <td>
                  <?php if( $value['brand_image']!=""){ ?><img src="<?php echo base_url('assets/brand_images').'/'.$value['brand_image'];?>" width="80px" height="80px"><?php } else { ?> <img src="<?php echo base_url('assets/default.jpg');?>" width="120px" height="80px" > <?php } ?></td>
                  <td>
                   <?php  if($value['status']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>
                  <td><a href="<?php echo site_url().'admin/Dashboard/UpdateBrand/'.$value['id']?>"><button class="btn btn-info">Edit</button> </a></td>
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
<!-- jQuery 3 -->
 <script src="<?php echo base_url()?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script> 
<!-- DataTables -->
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script>
function Verfiy_Video(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/brandStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Brand?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Brand?");}
       
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