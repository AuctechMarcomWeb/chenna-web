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
      Manage Parent Categories
       <a href="<?php echo base_url('admin/Dashboard/addParentCategory/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Parent Category</a>
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
                  <th>Name</th>
                  <th>No. of Products</th>
                  <th>No. Categories</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                foreach ($result as $value) { 
                  $this->db->limit(5);
                  $this->db->select('category_name');
                  $Catgory = $this->db->get_where('category_master',array('mai_id'=>$value['id'], 'status !='=> '3'))->result_array();
                  $TotMainCatPord = $this->user_model->TotalGetMainCatProd($value['id']);

                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['name']?></td>
                  <td><?php echo $TotMainCatPord?></td>
                  <td>

                       <ul>
                        <?php foreach ($Catgory as $key => $Catgory) {?>
                           <li><?=$Catgory['category_name']?></li>
                        <?php }?>
                        
                       </ul>
                      
                    <a href="<?php echo site_url().'admin/Dashboard/Category/'.$value['id']?>" style="margin-left: 20px;">
                      Manage Category (<?php echo $this->user_model->getCatCount($value['id'])?>)
                    </a>
                  
                  </td>
                  <td>

                   <?php if($value['status']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>
                  <td><a href="<?php echo site_url().'admin/Dashboard/UpdateParenrCategory/'.$value['id']?>"><button class="btn btn-info">Edit</button> </a></td>
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
 


<script>
function StatusUpdate(id,status) {
     var Vid= id;
     var url = "<?php echo site_url('admin/Dashboard/CatgyStatus');?>/"+id;
    
    if(status == 1){  var r =  confirm("Are you sure! You want to Deactivate this Category?");}
    if(status == 2){  var r =  confirm("Are you sure! You want to Activate this Category?");}
       
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