<script type="text/javascript">
  window.onload = function () {
    $("#hiddenSms").fadeOut(5000);
  }
</script>

<style type="text/css">
  .ratingpoint {
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
    <h1>Manage Tags <a href="<?php echo base_url('admin/Dashboard/addTag/'); ?>" class="btn btn-info"
        style="float: right; padding-right: 10px; ">Add Tag</a>
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
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $counter = "1";

                foreach ($getData as $value)
                { ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td style="padding-left: 50px "><?php echo $value['name'] ?></td>
                    <td>
                      <?php if ($value['status'] == '1')
                      { ?>
                        <span class="label label-success">Activated</span>
                      <?php } else
                      { ?>
                        <span class="label label-danger">Deactivated</span>
                      <?php } ?>
                    </td>

                    <td>
                      <a href="<?= base_url('admin/Dashboard/UpdateTag/' . $value['id']); ?>"
                        class="btn btn-info">Edit</a>
                      <a href="<?= base_url('admin/Dashboard/viewTagProducts/' . $value['id']); ?>"
                        class="btn btn-primary" style="margin-left: 5px;">View Tag List</a>
                      <a href="<?= base_url('admin/Dashboard/deleteTag/' . $value['id']); ?>" class="btn btn-danger"
                        style="margin-left: 5px;" onclick="return confirm('Are you sure you want to delete this tag?')">
                        Delete
                      </a>
                    </td>


                  </tr>

                  <?php $counter++;
                } ?>

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
<script src="<?php echo base_url()?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>*/ ?>


<script>
  function Verfiy_Video(id, status) {
    var status = $('#my_' + id).attr('data');

    var Vid = id;
    var url = "<?php echo site_url('admin/Dashboard/unitStatus'); ?>/" + id;
    if (status == 1) { var r = confirm("Are you sure! You want to Deactivate this Unit?"); }
    if (status == 2) { var r = confirm("Are you sure! You want to Activate this Unit?"); }
    // alert(Vid);   
    if (r == true) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "text",
        success: function (response) {
          if (response == 1) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/act.png") ?>'); $('#my_' + id).attr('data', 1); }
          if (response == 2) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/delete.png") ?>'); $('#my_' + id).attr('data', 2); }
          //console.log(response);
        }
      });
    }
  }

  $(function () {
    $('#example1').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    });
  });




</script>