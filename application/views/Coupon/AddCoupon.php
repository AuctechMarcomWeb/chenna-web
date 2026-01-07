<style>
  .form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
  }

  .datepicker table tr td.today {
    background-color: #ffcc00 !important;

    color: #000 !important;
    border-radius: 50%;
  }

  .datepicker table tr td.active {
    background-color: #28a745 !important;

    color: #fff !important;
    border-radius: 50%;
  }

  .datepicker table tr td:hover {
    background-color: #17a2b8 !important;
    color: #fff !important;
    cursor: pointer;
  }

  .datepicker-switch {
    background: blue;
    color: white;
  }

  .datepicker-switch:hover {
    background: blue;
    color: white;
  }

  .btn-group>.multiselect {
    padding: 7px;

    width: 100% !important;
    text-align: left;
    font-size: 14px;
    color: #333;
  }

  .btn-group.open .multiselect {
    border-color: #ddd !important;

  }


  .multiselect-container {
    width: 100% !important;
    border-radius: 6px;
    padding: 5px;
  }

  .btn-group.open .dropdown-toggle {
    -webkit-box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
    box-shadow: inset 0 3px 5px rgba(255, 255, 255, 1);
  }


  .multiselect-container>li>a>label {
    font-size: 14px;
    color: #333;
  }


  .multiselect-container>li:hover {
    background-color: #f1f7ff !important;
  }

  .multiselect-container>li.active>a>label {
    font-weight: bold;
    color: #000000ff !important;
  }

  .multiselect-search {

    border: 1px solid #ddd !important;
    margin: 0px;
  }

  .multiselect-container>li.multiselect-item.multiselect-all a label {
    font-weight: bold;
    color: #000;
  }

  .input-group-btn:last-child>.btn {
    z-index: 2;
    margin-left: -6px;
    height: 34px;

  }

  .btn-default {
    background: white;
  }

  .open>.dropdown-toggle.btn-default {
    color: #333;
    background-color: white !important;
    border-color: #adadad;
  }

  .open>.dropdown-menu {
    display: block;
    padding: 14px;
    border-radius: 0px;
  }

  .dropdown-menu>.active>a {
    background: none;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Add Coupon</h1>

  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">


          <form class="form-horizontal" action="<?php echo site_url('admin/Dashboard/AddCouponData'); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="box-body">

              <!-- Coupon Code -->
              <div class="form-group col-lg-4">
                <label class="control-label">Coupon Code</label>
                <input type="text" class="form-control" name="coupon_code" value="<?= $auto_coupon_code ?>" readonly>

              </div>

             

              <!-- Discount Type -->
              <div class="form-group col-lg-4">
                <label class="control-label">Discount Type</label>
                <select class="form-control" name="discount_type" required>
                  <option value="">Select Type</option>
                  <option value="fixed">Fixed</option>
                  <option value="percent">Percentage</option>
                </select>
              </div>

              <!-- Discount Value -->
              <div class="form-group col-lg-4">
                <label class="control-label">Discount Amount</label>
                <input type="number" step="0.01" class="form-control" name="discount_value" required
                  placeholder="Discount Value">
              </div>

              

             
              <!-- Start Date -->
              <div class="form-group col-lg-4">
                <label class="control-label">Start Date</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control" id="start_date" name="start_date" required
                    placeholder="YYYY-MM-DD">
                </div>
              </div>

              <div class="form-group col-lg-4">
                <label class="control-label">End Date</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control" id="end_date" name="end_date" required
                    placeholder="YYYY-MM-DD">
                </div>
              </div>


              <!-- Usage Limit Total -->
              <div class="form-group col-lg-4">
                <label class="control-label">Total Usage Limit</label>
                <input type="number" class="form-control" name="usage_limit_total" placeholder="Total Usage Limit">
              </div>

              <!-- Usage Limit Per User -->
              <div class="form-group col-lg-4">
                <label class="control-label">Per User Limit</label>
                <input type="number" class="form-control" name="usage_limit_per_user" placeholder="Per User Limit">
              </div>

              
              <div class="form-group col-lg-4">
                <label class="control-label">Parent Categories</label>
                <select name="parent_category_id" class="form-control" id="parent_category_select">
                  <option value="">Select Parent Category</option>
                  <?php foreach ($parent_categories as $p_cat): ?>
                    <option value="<?= $p_cat->id ?>"><?= $p_cat->name ?></option>
                  <?php endforeach; ?>
                </select>

              </div>
              <!-- Categories -->
              <div class="form-group col-lg-4">
                <label class="control-label">Categories</label>
                <select name="category_ids[]" id="category_select" class="form-control" multiple>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>"><?= $cat->category_name ?></option>
                  <?php endforeach; ?>
                </select>

              </div>

              <!-- Subcategories -->
              <div class="form-group col-lg-4">
                <label class="control-label">Subcategories</label>
                <select class="form-control" id="sub_category_select" name="sub_category_ids[]" multiple>
                  <?php foreach ($subcategories as $sub): ?>
                    <option value="<?= $sub->id ?>"><?= ucfirst($sub->sub_category_name) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label class="control-label">Products</label>
                <select class="form-control" name="product_ids[]" id="product_select" multiple>
                  <?php foreach ($products as $prod): ?>
                    <option value="<?= $prod->id ?>"><?= ucfirst($prod->product_name) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>


              <!-- Exclude Products -->

              <!-- Checkboxes -->
              <div class="form-group row align-items-center">

                <div class="col-lg-4">
                  <label class="mr-2">Status</label>
                  <select class="form-control form-control-sm" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</div>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>

<script>
  $('#start_date').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true
  }).datepicker('setDate', new Date());

  $('#end_date').datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayHighlight: true
  });

  $(document).ready(function () {

    $('#category_select, #sub_category_select, #product_select').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth: '100%',
      nonSelectedText: '--Select--'
    });


    $('#parent_category_select').change(function () {
      let parent_id = $(this).val();
      $.post("<?= site_url('admin/Dashboard/getCategoriesByParent') ?>",
        { parent_id: parent_id },
        function (data) {
          $('#category_select').html(data);
          $('#category_select').multiselect('rebuild');
          $('#sub_category_select').html('').multiselect('rebuild');
          $('#product_select').html('').multiselect('rebuild');
        });
    });


    $('#category_select').change(function () {
      let cat_ids = $(this).val() ? $(this).val().join(',') : '';
      $.post("<?= site_url('admin/Dashboard/getSubCategoriesByCat') ?>",
        { cat_id: cat_ids },
        function (data) {
          $('#sub_category_select').html(data);
          $('#sub_category_select').multiselect('rebuild');
          $('#product_select').html('').multiselect('rebuild');
        });
    });

    $('#sub_category_select').change(function () {
      let sub_ids = $(this).val() ? $(this).val().join(',') : '';
      let preChecked = $('#product_select').val() || [];

      $.post("<?= site_url('admin/Dashboard/getProductsSubCategory') ?>",
        {
          sub_ids: sub_ids,
          preChecked: preChecked
        },
        function (data) {
          $('#product_select').html(data);
          $('#product_select').multiselect('rebuild');
        });
    });



  });
</script>