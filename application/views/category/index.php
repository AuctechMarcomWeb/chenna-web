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
      Manage Categories
       <a href="<?php echo base_url('');?>admin/Dashboard/addCategory/<?php echo $this->uri->segment('4'); ?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add Category</a>
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
                  <th>Category Name</th>
                  <th>No. Of Products</th>
                  <th>No. Subcategories</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php 
                  $counter ="1";

                foreach ($result as $value) { 
                  $this->db->limit(5);
                  $this->db->select('sub_category_name');
                  $subCatgory = $this->db->get_where('sub_category_master',array('status'=>'1','category_master_id'=>$value['id']))->result_array();
                   $TotCatPord = $this->user_model->TotalGetCatProd($value['id']);

                  ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $value['category_name']?></td>
                  <td><?php echo $TotCatPord?></td>
                  <td>

                       <ul>
                        <?php foreach ($subCatgory as $key => $subCatgory) {?>
                           <li><?=$subCatgory['sub_category_name']?></li>
                        <?php }?>
                        
                       </ul>
                      
                    <a href="<?php echo site_url().'admin/Dashboard/subCatgy/'.$value['id']?>" style="margin-left: 20px;">
                      Manage Subcategory (<?php echo $this->user_model->getSubCatCount($value['id'])?>)
                    </a>
                  
                  </td>
                  <td style="text-align: center">
                  <?php if( $value['app_icon']!=""){ ?><img src="<?php echo base_url('assets/category_images').'/'.$value['app_icon'];?>" width="80px" height="80px"><?php } else { ?> <img src="<?php echo base_url('assets/default.jpg');?>" width="120px" height="80px" > <?php } ?></td>

                 
                  <td>
                   <?php if($value['status']=='1'){ ?>
                        <span class="label label-success">Activated</span>
                     <?php } else { ?>
                        <span class="label label-danger">Deactivated</span>
                     <?php } ?>
                  </td>
                  <td><a href="<?php echo site_url().'admin/Dashboard/UpdateCategory/'.$value['id'].'/'.$value['mai_id']?>"><button class="btn btn-info">Edit</button> </a>
                  <a href="<?php echo site_url().'admin/Dashboard/DeleteCatgy/'.$value['id']; ?>"><button class="btn btn-danger">Delete</button> </a>
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