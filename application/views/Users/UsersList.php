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

  .logo {
    height: 60px;
    width: 60px;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Users
      <?php /*  <a href="<?php echo base_url('admin/Users/AddUsers/');?>" class="btn btn-info" style="float: right; padding-right: 10px; ">Add User</a>
</h1> */ ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="col-md-12" id="hiddenSms">
            <?php echo $this->session->flashdata('activate'); ?>
          </div>
          <div class="box-body">
            <table id="example111" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:70px;">Sr No.</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email ID</th>
                  <th>Register&nbsp;Date</th>
                  <th>Total Orders</th>
                  <th>Total Spent</th>
                  <th>Saved Addresses</th>
                  <th style="width:50px">Status</th>
                  <th style="width:50px">Action</th>
                  <th style="width:50px">Delete</th>
                </tr>
              </thead>
              <tbody>
                <?php $counter = 1;
                if (!empty($getData)): ?>
                  <?php foreach ($getData as $user): ?>
                    <tr>
                      <td><?= $counter++; ?></td>
                      <td><?= ucfirst($user['username']); ?></td>
                      <td>
                        <a href="<?= site_url('admin/Users/UpdateUsers/' . $user['id']) ?>">
                          <?= $user['mobile']; ?>
                        </a>
                      </td>
                      <td><?= $user['email_id']; ?></td>
                      <td>
                      <?= !empty($user['add_date']) ? date('d-m-Y', strtotime($user['add_date'])) : 'N/A'; ?>

                      </td>


                      <td class="text-center">
                        <strong><?= $user['total_orders'] ?? 0; ?></strong><br>
                        
                      </td>

                      <td class="text-center">
                        <strong>₹<?= number_format($user['total_amount_spent'] ?? 0, 2); ?></strong><br>
                       
                      </td>

                      <td>
                        <?php if (!empty($user['addresses'])): ?>
                          <?php foreach (array_slice($user['addresses'], 0, 2) as $addr): ?>
                            <div>
                              <i class="fa fa-map-marker text-danger"></i>
                              <?= $addr['address']; ?>, <?= $addr['city']; ?>
                            </div>
                          <?php endforeach; ?>
                          <?php if (count($user['addresses']) > 2): ?>
                            <small><em>+<?= count($user['addresses']) - 2; ?> more</em></small>
                          <?php endif; ?>
                        <?php else: ?>
                          <small>No address added</small>
                        <?php endif; ?>
                      </td>

                      <td class="text-center">
                        <?php if ($user['status'] == '1'): ?>
                          <span class="label label-success">Active</span>
                        <?php else: ?>
                          <span class="label label-danger">Inactive</span>
                        <?php endif; ?>
                      </td>

                      <td>
                        <a href="<?= site_url('admin/Users/UpdateUsers/' . $user['id']) ?>">
                          <button class="btn btn-sm btn-primary">Edit</button>
                        </a>
                      </td>

                      <td>
                        <a href="<?= base_url('admin/Users/delete_user/' . $user['id']) ?>"
                          onclick="return confirm('Are you sure you want to delete this user?');">
                          <button class="btn btn-sm btn-danger">Delete</button>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="11" class="text-center text-muted">No users found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- /.content -->
</div>


<script>
  function UsersStatus(id, status) {
    var Vid = id;
    var url = "<?php echo site_url('admin/Users/UsersStatus'); ?>/" + id;
    if (status == 1) { var r = confirm("Are you sure! You want to Deactivate this Users ?"); }
    if (status == 2) { var r = confirm("Are you sure! You want to Activate this Users ?"); }
    if (r == true) {
      $.ajax({
        type: "POST",
        url: url,
        dataType: "text",
        success: function (response) {
          console.log(response);
          if (response == 1) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/act.png") ?>'); }
          if (response == 2) { $('.status_img_' + id).attr('src', '<?php echo base_url("assets/delete.png") ?>'); }
          //console.log(response);
        }
      });
    }
  }


  $(function () {
    //$("#example111").DataTable();
    var table = $('#example111').DataTable({
      "lengthMenu": [[100, 200, 400, -1], [100, 200, 400, "All"]],
      "pageLength": 100
    });
  });



</script>