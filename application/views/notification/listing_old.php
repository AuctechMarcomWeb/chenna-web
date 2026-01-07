
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
      Manage Push Notification
      <a href="<?php echo base_url('admin/Notification/Notification/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Send Notification</a>
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
                  <th>Title</th>
                 <!--  <th>Offer Name</th>
                  <th>Offer Name</th> -->

                  <th>Type</th>
                  <th>Image</th>
                  <th>Date</th>
                 
                  <th style="width:180px">Status</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                $counter ="1";

                foreach ($getData as $value) {?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo base_url('admin/Notification/View')."/".$value['id'] ?>"><?php echo $value['title']?></a></td>
                  <td><?php echo ($value['type']==1) ? 'General':'' ?></td>
                  <td><?php if( $value['image']!=""){ ?><img src="<?php echo base_url('assets/notification_images').'/'.$value['image'];?>" width="80px" height="80px"><?php } else { ?> <img src="<?php echo base_url('assets/default.jpg');?>" width="120px" height="80px" > <?php } ?></td>
                  <td><?php echo date('d-M-Y',$value['add_date'])?></td>
                  <td>
                    <button type="button" class="btn btn-info" onclick="Send(<?php echo $value['id']; ?>)">Resend</button>
                    
                   <?php  
                      $status = ($value['status']=='1') ? 'assets/act.png' :'assets/delete.png';
                         echo '<a href="javascript:Verfiy_Video('.$value['id'].','.$value['status'].')" class="val" myId ="'.$value['id'].'"><img src="'.base_url($status).'" width="29px" class="status_img_'.$value['id'].'"></a> ';                        
                    ?>

                    


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
     var Vid= id;
     var url = "<?php echo site_url('admin/Notification/changeStatus');?>/"+id;
      alert(url);
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Notification ?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Notification ?");}       
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

<script type="text/javascript">

    function Send(id){

      var r = confirm("Are you sure! Send Notification To User ?");
      var url = "<?php echo site_url('admin/Notification/ResendNotification');?>/"+id;
      if (r == true) {

        $.ajax({ 
            type: "POST", 
            url: url, 
            dataType: "text", 
            success:function(response){
              window.location.reload();
              
              }
            });
          } 

        }
</script>