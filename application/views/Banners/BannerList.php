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
      Manage Banners
      <a href="<?php echo base_url('admin/Dashboard/AddBanner/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Banner</a>
      </h1>
      
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
           <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="">Sr No.</th>
                  <th style="">Banner Type</th>
                  <th>Banner On</th>
                  <th style="width:350px;">Banner Image</th>
                  <th style="">Status</th>
                  <th style="">Edit</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <!-- <td> <a href="<?php echo site_url().'admin/Dashboard/UpdateBannerData/'.$value['id']?>">
                    <?php 
                     if($value['banner_on']=='2'):
                      echo"Product";
                    elseif($value['banner_on']=='1'):
                     echo"Sub-Category";
                     elseif($value['banner_on']=='3'):
                       echo"keywords";
                     else:
                       echo"Details";
                     endif;
                     ?> 

                   </a></td> -->
                   <td>
                    <?php 
                     if($value['bannerType']=='1'){
                         echo"App";
                      }
                     else if($value['bannerType']=='2'){
                        echo"Web";
                     }

                     ?> 
                   </td>

                  <td> <?= ($value['level']==1) ? 'Header' :'Body'; ?> </td>
                  
                  <td><img src="<?php echo base_url('assets/banner_images').'/'.$value['banner_image'];?>" style="max-width: 320px; min-width: 120px"></td>
                
                  <td>
                   <?php  if($value['status']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>

                   <td>
                    <a href="<?= base_url('admin/Dashboard/UpdateBannerData/'.$value['id']); ?>" class="btn btn-info btn-xs"> Edit </a>
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
function Verfiy_Video(id,status) {
  var status = $('#my_'+id).attr('data');
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/BannerStatus');?>/"+id;
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Banner ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Banner ?");}

   
       
    if (r == true) {
    $.ajax({ 
      type: "POST", 
      url: url, 
      dataType: "text", 
      success:function(response){
        console.log(response);
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