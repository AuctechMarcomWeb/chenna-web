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
    <h1> Update Tag <h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <div class="col-md-12">

        <div class="box box-info p-4">
          <form class="form-horizontal"
            action="<?php echo site_url('admin/Dashboard/UpdateTag') . '/' . $getData['id']; ?>" method="POST"
            enctype="multipart/form-data">

            <div class="box-body row">


              <div class="form-group col-sm-6">
                <label>Tag Name</label>
                <input type="text" class="form-control" name="tagName" placeholder="Tag Name"
                  value="<?= $getData['name']; ?>" required>
              </div>


              <div class="form-group col-sm-6">
                <label>Parent Category</label>
                <select class="form-control select2" id="parent_cat" name="parent_cat" style="width: 100%;">
                  <option value="">Select Parent Category</option>
                  <?php foreach ($parentCategories as $p): ?>
                    <option value="<?= $p['id']; ?>" <?= (!empty($getData['parent_id']) && $getData['parent_id'] == $p['id']) ? 'selected' : ''; ?>>
                      <?= ucfirst($p['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- 🔹 Category -->
              <div class="form-group col-sm-6">
                <label>Category</label>
                <select class="form-control select2" id="category" name="category" style="width: 100%;">
                  <option value="">Select Category</option>
                  <?php if (!empty($getCatgy)): ?>
                    <?php foreach ($getCatgy as $c): ?>
                      <option value="<?= $c['id']; ?>" <?= (!empty($getData['category_id']) && $getData['category_id'] == $c['id']) ? 'selected' : ''; ?>>
                        <?= ucfirst($c['category_name']); ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <!-- 🔹 Subcategory -->
              <div class="form-group col-sm-6">
                <label>Subcategory</label>
                <select class="form-control select2" id="subcategory" name="subcategory" style="width: 100%;">
                  <option value="">Select Subcategory</option>
                  <?php if (!empty($sub_cate_data)): ?>
                    <?php foreach ($sub_cate_data as $s): ?>
                      <option value="<?= $s['id']; ?>" <?= (!empty($getData['subcategory_id']) && $getData['subcategory_id'] == $s['id']) ? 'selected' : ''; ?>>
                        <?= ucfirst($s['sub_category_name']); ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>


              <div class="form-group col-sm-6">
                <label>Select Product(s)</label>
                <div class="product-checkbox-list"
                  style="max-height: 100px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;"
                  id="product_list_box">
                    <option value="">Select Product(s)</option>
                  <?php
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
                  <?php endforeach; ?>
                </div>
              </div>


              <div class="form-group col-sm-6">
                <label>Status</label>
                <select class="form-control select2" name="status" required>
                  <option value="1" <?= ($getData['status'] == '1') ? 'selected' : ''; ?>>Activated</option>
                  <option value="2" <?= ($getData['status'] == '2') ? 'selected' : ''; ?>>Deactivated</option>
                </select>
              </div>


              <div class="col-sm-12">
                <button type="submit" class="btn btn-info pull-right">Update</button>
              </div>
            </div>
          </form>



        </div>


      </div>

    </div>

  </section>

</div>
<script>
  $(document).ready(function () {

    function loadProducts(sub_id) {
      if (!sub_id) {
        $('#product_list_box').html('');
        return;
      }

      var preChecked = <?= json_encode(json_decode($getData['product_ids'], true) ?: []); ?>;

      $('#product_list_box').html('<p>Loading products...</p>');

      $.post('<?= site_url("admin/Dashboard/getProductsBySubCategory") ?>', { sub_id: sub_id, preChecked: preChecked }, function (res) {
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


    var initial_sub_id = $('#subcategory').val();
    if (initial_sub_id) {
      loadProducts(initial_sub_id);
    }

  });
</script>