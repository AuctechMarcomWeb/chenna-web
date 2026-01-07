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

  .product-box {
    display: inline-block;
    background: #fbf1e1;
    color: #111;
    font-size: 12px;
    padding: 3px 8px;
    margin: 4px;
    border-radius: 4px;
    white-space: nowrap;
    border: 1px solid #dd4b39;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
  }

  .switch input {
    display: none;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
  }

  input:checked+.slider {
    background-color: #337ab7;
  }

  input:checked+.slider:before {
    transform: translateX(24px);
  }

  .slider.round {
    border-radius: 24px;
  }

  slider.round:before {
    border-radius: 50%;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Coupons
      <a href="<?php echo base_url('admin/Dashboard/AddCoupon/'); ?>" class="btn btn-info"
        style="float: right; padding-right: 10px; ">Add Coupon</a>
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
                  <th>Coupon Name</th>
                  <th>Product Name</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Applied Coupon List</th>
                  <th style="width:50px">Status</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $counter = "1";

                foreach ($getData as $value)
                { ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td><a
                        href="<?php echo site_url() . 'admin/Dashboard/UpdateCoupon/' . $value['id'] ?>"><?php echo $value['coupon_code'] ?>
                      </a></td>
                    <td>
                      <?php
                      $ids = explode(',', $value['product_ids']);
                      foreach ($ids as $id)
                      {
                        $p = $this->db->get_where('sub_product_master', ['id' => $id])->row();
                        if ($p)
                        {
                          echo '<span class="product-box">' . $p->product_name . '</span>';
                        }
                      }
                      ?>
                    </td>
                    <td><?php echo date('d-M-Y', strtotime($value['start_date'])) ?></td>
                    <td><?php echo date('d-M-Y', strtotime($value['end_date'])) ?></td>

                    <td><a href="<?php echo base_url() ?>admin/Order/applyedCoupon/<?php echo $value['id']; ?>"><span
                          class="label label-success">Applied Coupon List</span></a></td>
                    <!-- <td>
                      <?php
                      $statusImg = ($value['status'] == 1) ? 'assets/act.png' : 'assets/delete.png';
                      ?>

                      <a href="javascript:void(0)" onclick="toggleCouponStatus(<?= $value['id'] ?>)"
                        data-status="<?= $value['status'] ?>" id="statusBtn_<?= $value['id'] ?>">
                        <img src="<?= base_url($statusImg) ?>" width="29px" id="statusImg_<?= $value['id'] ?>">
                      </a>
                    </td> -->
                    <td>
                      <label class="switch">
                        <input type="checkbox" <?= ($value['status'] == 1) ? 'checked' : '' ?>
                          onclick="toggleCoupon(<?= $value['id'] ?>, this)">
                        <span class="slider round"></span>
                      </label>
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


<script>
  function toggleCoupon(id, checkbox) {

    let newStatus = checkbox.checked ? 1 : 0;

    let msg = (newStatus == 1)
      ? "Are you sure you want to Activate this Coupon?"
      : "Are you sure you want to Deactivate this Coupon?";

    if (!confirm(msg)) {
      checkbox.checked = !checkbox.checked; // revert if cancelled
      return;
    }

    $.ajax({
      type: "POST",
      url: "<?php echo site_url('admin/Dashboard/CouponStatus/'); ?>" + id,
      data: { status: newStatus },
      success: function (response) {
        console.log("Updated:", response);
      }
    });
  }

  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    })
  })



</script>