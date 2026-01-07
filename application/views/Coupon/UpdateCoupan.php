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

  .multiselect-container {
    max-height: 200px !important;
    overflow-y: auto;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Update Coupon</h1>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <form class="form-horizontal" action="<?= site_url('admin/Dashboard/UpdateCouponData/' . $getData['id']) ?>"
            method="POST" enctype="multipart/form-data">
            <div class="box-body">

             
              <div class="form-group col-lg-4">
                <label>Coupon Code</label>
                <input type="text" class="form-control" name="coupon_code" value="<?= $getData['coupon_code'] ?>"
                  readonly>
              </div>
             

            
              <div class="form-group col-lg-4">
                <label>Discount Type</label>
                <select class="form-control" name="discount_type" required>
                  <option value="">Select Type</option>
                  <option value="fixed" <?= $getData['discount_type'] == 'fixed' ? 'selected' : '' ?>>Fixed</option>
                  <option value="percent" <?= $getData['discount_type'] == 'percent' ? 'selected' : '' ?>>Percentage</option>
                </select>
              </div>
              <div class="form-group col-lg-4">
                <label>Discount Amount</label>
                <input type="number" step="0.01" class="form-control" name="discount_value" required
                  value="<?= $getData['discount_value'] ?>" placeholder="Discount Value">
              </div>

            
           
              <div class="form-group col-lg-4">
                <label>Start Date</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control" id="start_date" name="start_date" required
                    value="<?= date('Y-m-d', strtotime($getData['start_date'])) ?>">
                </div>
              </div>
              <div class="form-group col-lg-4">
                <label>End Date</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control" id="end_date" name="end_date" required
                    value="<?= date('Y-m-d', strtotime($getData['end_date'])) ?>">
                </div>
              </div>

              
              <div class="form-group col-lg-4">
                <label>Total Usage Limit</label>
                <input type="number" class="form-control" name="usage_limit_total"
                  value="<?= $getData['usage_limit_total'] ?>">
              </div>
              <div class="form-group col-lg-4">
                <label>Per User Limit</label>
                <input type="number" class="form-control" name="usage_limit_per_user"
                  value="<?= $getData['usage_limit_per_user'] ?>">
              </div>
              
             
              <?php
              $selected_categories = !empty($getData['category_ids']) ? explode(',', $getData['category_ids']) : [];
              $selected_subcategories = !empty($getData['sub_category_ids']) ? explode(',', $getData['sub_category_ids']) : [];
              $selected_products = !empty($getData['product_ids']) ? explode(',', $getData['product_ids']) : [];
              ?>
              <div class="form-group col-lg-4">
                <label>Parent Category</label>
                <select class="form-control" id="parent_category_select" name="parent_category_id">
                  <option value="">--Select--</option>
                  <?php foreach ($parent_categories as $p): ?>
                    <option value="<?= $p->id ?>" <?= $getData['parent_category_id'] == $p->id ? 'selected' : '' ?>>
                      <?= $p->name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label>Categories</label>
                <select class="form-control" id="category_select" name="category_ids[]" multiple>
                  <?php foreach ($categories as $c): ?>
                    <option value="<?= $c->id ?>" <?= in_array($c->id, $selected_categories) ? 'selected' : '' ?>>
                      <?= $c->category_name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label>Subcategories</label>
                <select class="form-control" id="sub_category_select" name="sub_category_ids[]" multiple>
                  <?php foreach ($subcategories as $s): ?>
                    <option value="<?= $s->id ?>" <?= in_array($s->id, $selected_subcategories) ? 'selected' : '' ?>>
                      <?= $s->sub_category_name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label>Products</label>
                <select class="form-control" id="product_select" name="product_ids[]" multiple>
                  <?php foreach ($products as $p): ?>
                    <option value="<?= $p->id ?>" <?= in_array($p->id, $selected_products) ? 'selected' : '' ?>>
                      <?= $p->product_name ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

             
              <div class="form-group row align-items-center">
               
                <div class="col-lg-4">
                  <label>Status</label>
                  <select class="form-control" name="status" required>
                    <option value="1" <?= $getData['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $getData['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                  </select>
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
  $('#start_date,#end_date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
  });

  var selectedCategories = <?= json_encode($selected_categories) ?>;
  var selectedSubcategories = <?= json_encode($selected_subcategories) ?>;
  var selectedProducts = <?= json_encode($selected_products) ?>;

  $(document).ready(function () {
  
    $('#category_select, #sub_category_select, #product_select').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      buttonWidth: '100%',
      maxHeight: 200,
      nonSelectedText: '--Select--'
    });

   
    $('#parent_category_select').change(function () {
      let parent_id = $(this).val();
      $.post("<?= site_url('admin/Dashboard/getCategorieByParent') ?>", {
        parent_id: parent_id,
        preChecked: selectedCategories
      }, function (data) {
        $('#category_select').html(data).multiselect('rebuild');
        $('#sub_category_select').html('').multiselect('rebuild');
        $('#product_select').html('').multiselect('rebuild');
        if (selectedCategories.length > 0) {
          $('#category_select').val(selectedCategories).multiselect('rebuild').trigger('change');
          selectedCategories = []; 
        }
      });
    });

   
    $('#category_select').change(function () {
      let cat_ids = $(this).val() ? $(this).val().join(',') : '';
      $.post("<?= site_url('admin/Dashboard/getSubCategorieByCat') ?>", {
        cat_ids: cat_ids,
        preChecked: selectedSubcategories
      }, function (data) {
        $('#sub_category_select').html(data).multiselect('rebuild');
        $('#product_select').html('').multiselect('rebuild');

        if (selectedSubcategories.length > 0) {
          $('#sub_category_select').val(selectedSubcategories).multiselect('rebuild').trigger('change');
          selectedSubcategories = [];
        }
      });
    });

  
    $('#sub_category_select').change(function () {
      let sub_ids = $(this).val() ? $(this).val().join(',') : '';
      $.post("<?= site_url('admin/Dashboard/getProdBySubCategory') ?>", {
        sub_ids: sub_ids,
        preChecked: selectedProducts
      }, function (data) {
        $('#product_select').html(data).multiselect('rebuild');

        if (selectedProducts.length > 0) {
          $('#product_select').val(selectedProducts).multiselect('rebuild');
          selectedProducts = [];
        }
      });
    });

  
    if ($('#parent_category_select').val()) {
      $('#parent_category_select').trigger('change');
    }
  });
</script>