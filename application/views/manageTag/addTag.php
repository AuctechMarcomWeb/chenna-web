<style>
  .form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
  }

  .product-checkbox-list .checkbox {
    margin-bottom: 6px;
  }

  .product-checkbox-list input[type="checkbox"] {
    accent-color: #007bff;
    transform: scale(1.1);
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Add Tag</h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">

        <div class="box box-info">
          <form class="form-horizontal" action="<?= site_url('admin/Dashboard/addTag'); ?>" method="POST"
            enctype="multipart/form-data">
            <div class="box-body row">

              <div class="form-group col-sm-6">
                <label>Tag Name</label>
                <input type="text" class="form-control" name="TagName" placeholder="Tag Name" required>
              </div>

              <div class="form-group col-sm-6">
                <label>Parent Category</label>
                <select class="form-control select2" id="parent_cat" name="parent_cat" style="width: 100%;">
                  <option value="">Select Parent Category</option>
                  <?php foreach ($parentCategories as $p): ?>
                    <option value="<?= $p['id']; ?>"><?= ucfirst($p['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>


              <div class="form-group col-sm-6">
                <label>Category</label>
                <select class="form-control select2" id="category" name="category" style="width: 100%;">
                  <option value="">Select Category</option>
                </select>
              </div>

              <!-- Subcategory -->
              <div class="form-group col-sm-6">
                <label>Subcategory</label>
                <select class="form-control select2" id="subcategory" name="subcategory" style="width: 100%;">
                  <option value="">Select Subcategory</option>
                </select>
              </div>

              <!-- Product Checkbox List -->
              <div class="form-group col-sm-6">
                <label>Select Product (s)</label>
                <div class="product-checkbox-list" id="product_list_box"
                  style="max-height: 100px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                   <option value="">Select Product</option>
                  <!-- <?php
                  $product_ids = json_decode($getData['product_ids'], true);
                  foreach ($productData as $value):
                    $checked = (is_array($product_ids) && in_array($value['id'], $product_ids)) ? 'checked' : '';
                    ?>
                    <div class="checkbox">

                      <label style="display: flex; align-items: center; gap: 6px;">
                        <input type="checkbox" name="product_id[]" value="<?= $value['id']; ?>" <?= $checked; ?>>
                        <?= ucfirst($value['product_name']); ?>
                      </label>
                    </div>
                  <?php endforeach; ?> -->
                </div>
              </div>

              <!-- Status -->
              <div class="form-group col-sm-6">
                <label>Status</label>
                <select class="form-control select2" name="status" required>
                  <option value="1">Activated</option>
                  <option value="2">Deactivated</option>
                </select>
              </div>

              <div class="col-sm-12">
                <button type="submit" class="btn btn-info pull-right">Add Tag</button>
              </div>

            </div>
          </form>

        </div>
        <!-- /.box -->

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<script>
  $(document).ready(function () {

    function loadProducts(sub_id, preChecked = []) {
      if (!sub_id) {
        $('#product_list_box').html('');
        return;
      }

      $.post('<?= site_url("admin/Dashboard/getProductsBySubCategory") ?>', { sub_id, preChecked }, function (res) {
        $('#product_list_box').html(res);
      });
    }

    $('#parent_cat').on('change', function () {
      let parent_id = $(this).val();
      $('#category').html('<option value="">Loading...</option>');
      $.post('<?= site_url("admin/Dashboard/getCategoriesByParent") ?>', { parent_id }, function (res) {
        $('#category').html(res);
        $('#subcategory').html('<option value="">Select Subcategory</option>');
        $('#product_list_box').html('');
      });
    });

    $('#category').on('change', function () {
      let cat_id = $(this).val();
      $('#subcategory').html('<option value="">Loading...</option>');
      $.post('<?= site_url("admin/Dashboard/getSubCategoriesByCat") ?>', { cat_id }, function (res) {
        $('#subcategory').html(res);
        $('#product_list_box').html('');
      });
    });

    $('#subcategory').on('change', function () {
      let sub_id = $(this).val();
      loadProducts(sub_id);
    });

  });
</script>