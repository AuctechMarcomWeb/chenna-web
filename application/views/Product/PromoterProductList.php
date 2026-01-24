<script type="text/javascript">
  window.onload = function () {
    $("#hiddenSms").fadeOut(5000);
  }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
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

  .set_li {
    position: absolute;
    width: 70%;
    top: 41px;
    list-style: none;
    z-index: 9999;
    height: 0px;
    overflow: auto;
    background: aliceblue;
  }


  .pagination.pull-right a {
    background: #337ab7;
    color: #fff;
    font-size: 14px;
    padding: 11px 10px;
    top: -12px;
    margin-right: 5px;
  }

  .btn-cash {
    background: #339933;
    color: #fff;
  }

  .pagination>.active>a {
    background: red;
    padding: 11px;
    border: red;
    margin-right: 5px;
    color: #fff;

  }

  .pagination>.active>a:hover {
    background: red;
    padding: 11px;
    border: red;
    margin-right: 5px;
    color: #fff;

  }

  .b:hover {
    cursor: pointer;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .vendor-logo {
    width: 80px;
    height: 50px;
    object-fit: contain;
  }

  /* Progress bar styling */
  .progress-xs {
    height: 20px;
  }

  .progress-bar-custom {
    background-color: #28a745;
  }

  .pricing-range {
    width: 100%;
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
    outline: none;
    -webkit-appearance: none;
    margin: 20px 0;
  }

  /* Track for Chrome/Safari */
  .pricing-range::-webkit-slider-runnable-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  /* Thumb for Chrome/Safari */
  .pricing-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    margin-top: -6px;
    /* center thumb on track */
  }

  /* Track for Firefox */
  .pricing-range::-moz-range-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  /* Thumb for Firefox */
  .pricing-range::-moz-range-thumb {
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
  }

  /* Track for IE/Edge */
  .pricing-range::-ms-track {
    height: 6px;
    background: transparent;
    border-color: transparent;
    color: transparent;
  }

  .pricing-range::-ms-fill-lower {
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-ms-fill-upper {
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-ms-thumb {
    width: 18px;
    height: 18px;
    background: #ff6b6b;
    border-radius: 50%;
    border: 2px solid #fff;
  }

  /* MODAL BACKGROUND FEEL */

  .modal-content.pricing-modal {
    border-radius: 15px;
    border: none;
    background: #ffffff;
    box-shadow: 0 10px 30px rgb(217 184 184 / 64%);
  }

  .text-muted {
    color: #444;
    font-size: 15px;
  }

  /* TITLE */
  .pricing-modal h4 {
    font-size: 22px;
    font-weight: 700;
  }

  .plan-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 5px;
    border-bottom: 3px solid #ffd6d6;

    padding-top: 38px;
  }

  .heading-text {
    font-size: 15px;
    font-weight: 600;
  }

  .heading-icon {
    font-size: 18px;
    font-weight: 700;
    color: #ff6b6b;
    cursor: pointer;
  }


  /* RANGE SLIDER */
  .pricing-range {
    width: 60% !important;
    margin: 10px auto 23px;
  }

  .pricing-range::-webkit-slider-runnable-track {
    height: 6px;
    background: #ffd6d6;
    border-radius: 10px;
  }

  .pricing-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    background: #ff6b6b;
    border-radius: 50%;
    margin-top: -5px;
  }

  /* LEFT SECTION */
  .plan-box {

    padding: 10px 1px;
    border-radius: 14px;
    background: #fff;
  }

  /* PRICE TAG LEFT */
  .price-tag {
    background: #ffe6e6;
    color: #ff5a5a;
    font-size: 11px;
    font-weight: 700;
    padding: 4px 4px;
    border-radius: 5px;
  }

  /* FEATURES */
  .feature-list {
    list-style: none;
    padding: 0;
  }

  .feature-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    margin-bottom: 14px;
    text-align: left;
  }

  .feature-list .dot {
    width: 8px;
    height: 8px;
    background: #ff6b6b;
    border-radius: 50%;
    margin-right: 8px;
  }

  .cross {
    background: #ffe6e6;
    color: #ff6b6b;
    font-weight: bold;
    border-radius: 6px;
    padding: 2px 8px;
  }

  /* PRICING CARDS */
  .pricing-card {
    border: 1px solid #f1f1f1;
    border-radius: 7px;
    padding: 20px 15px;
    text-align: center;
    background: #fff;
    transition: all 0.3s ease;
    margin-top: 11px;
    cursor: pointer;
  }

  /* CARD TITLE */
  .pricing-card h6 {
    font-size: 16px;
    font-weight: 700;
  }

  /* PRICE */
  .card-price {
    position: relative;
    font-size: 14px;
    font-weight: 800;
    color: #ff6b6b;
    margin: 18px 0;
    padding: 8px 0px 8px 0px;
    border-top: 1px solid #ffd6d6;
    border-left: 1px solid #ffd6d6;
    border-radius: 10px;
    overflow: hidden;

    /* important */
  }

  /* bottom line */
  .card-price::after {
    content: "";
    position: absolute;
    left: 1px;
    bottom: 0;
    width: 60%;
    height: 1px;
    background: #ffd6d6;
    border-bottom-left-radius: 40px;
  }

  /* right line */
  .card-price::before {
    content: "";
    position: absolute;
    right: 0;
    top: 1px;
    height: 60%;
    width: 1px;
    background: #ffd6d6;
    border-top-right-radius: 40px;
  }


  /* CARD FEATURES */
  .pricing-card ul {
    list-style: none;
    padding: 0;
  }

  .pricing-card ul li {
    font-size: 14px;
    margin-bottom: 12px;
    color: #666;
    text-align: left;
  }

  /* MODAL BODY SPACING */
  .modal-body {
    padding: 29px 30px;
  }

  .plan-inline {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .plan-inline h6 {
    font-size: 12px;
    font-weight: 600;
  }

  #selectedPlanBox button#proceedPlan {
    background-color: #ff6b6b;
    border: none;
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 10px 0;
    transition: 0.3s;
  }

  #selectedPlanBox button#proceedPlan:hover {
    background-color: #ff3b3b;
  }

  .pricing-card.active {
    border: 1px solid #ff6b6b6e;
    box-shadow: 0 0px 5px rgba(255, 107, 107, 0.35);
    position: relative;
    cursor: pointer;
  }

  .btn-proceed {
    background: #ff6b6b;
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 30px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
  }

  .btn-proceed:hover {
    background: #35c708;
    box-shadow: 0 8px 20px rgba(136, 199, 107, 0.5);
    transform: translateY(-2px);
    color: white;
  }
  .pricing-modal {
    border-radius: 16px;
  }

  .pricing-card {
    border: 1px solid #eee;
    border-radius: 14px;
    padding: 13px;
    cursor: pointer;
    transition: all .25s ease;
    height: auto;
    background: #fff;
  }

  .pricing-card.active {
    border-color: #ffe4e4;
    background: linear-gradient(135deg, #ffffff, #fff);
    box-shadow: 0 11px 24px rgb(255 234 234);
  }

  .card-price {
    font-size: 13px;
    font-weight: 700;
    color: #e7331d;
  }

  .card-price small {
    font-size: 13px;
    font-weight: 500;
    color: #6c757d;
  }
  .btn-proceed {
    padding: 10px 21px;
    font-size: 16px;
    margin-top: 40px;
    border-radius: 50px;
    background: linear-gradient(135deg, #dd4b39, #f38f12);
    color: #fff;
    border: none;
     margin-bottom: 10px;
  }

  .btn-proceed:hover {
    background: linear-gradient(135deg, #17af27, #238522);
  }

  .section-title {
    position: relative;
    padding-bottom: 8px;
    margin-bottom: 15px;
    margin-top: 44px;
    font-weight: 600;
}

  .section-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50%;
    height: 2px;
    background: #dd4b394f;
    border-radius: 10px;
  }
</style>
<div class="content-wrapper">

  <section class="content-header">
    <h1>Manage Products
      <!-- Add Product Button -->
      <a href="javascript:void(0);" class="btn btn-info" style="float: right; padding-right: 10px;" id="addProductBtn">
        Add Product
      </a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="msg">
        <div class="col-xs-12">
          <div class="box">


            <div class="box-body" style="overflow-x:auto;">
              <br>
              <!-- FILTER FORM -->
              <div class="col-sm-12">
                <div class="col-md-12" id="hiddenSms">
                  <?php
                  if ($this->session->flashdata('activate'))
                  {
                    echo $this->session->flashdata('activate');
                    $this->session->unset_userdata('activate'); // Clear after showing
                  }
                  ?>
                </div>


                <form method="POST">
                  <div class="row" style="margin-top: -19px;">

                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="keywords" placeholder="Enter Product Name"
                        value="<?= @$_POST['keywords']; ?>">
                    </div>

                    <div class="col-sm-1">
                      <input type="submit" class="btn btn-info" value="GET PRODUCTS">
                    </div>
                  </div>
                </form>
              </div>
              <br><br><br>

              <!-- TABLE -->
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sr No.</th>
                    <th>Parent Category</th>
                    <th>Category</th>
                    <th>Sub-Category</th>
                    <th>Product Name</th>
                    <th>Shop</th>
                    <th>Shop Name</th>
                    <th>Name</th>
                    <th>Rate / MRP</th>
                    <th>Stock</th>
                    <th>Date</th>
                    <th>Verify</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $counter = ($pano - 1) * 20 + 1; ?>
                  <?php foreach ($results as $value): ?>
                    <tr>
                      <td><?= $counter; ?></td>
                      <td><?= $value['parent_category_name'] ?? ''; ?></td>
                      <td><?= $value['category_name'] ?? ''; ?></td>
                      <td><?= $value['sub_category_name'] ?? ''; ?></td>
                      <td>
                        <?= $value['product_name']; ?><br>
                        Color: <?= $value['color'] ?? ''; ?> | Size: <?= $value['size'] ?? ''; ?>
                      </td>
                      <td class="text-center text-blue">
                        <?php
                        if ($value['added_type'] == '3')
                        {
                          // Promoter product
                          $img = !empty($value['promoter_logo']) ? base_url($value['promoter_logo']) : base_url('plugins/images/logo.png');
                          $shop_name = $value['promoter_shop_name'] ?? $value['promoter_name'];
                        } else
                        {
                          // Vendor product
                          $img = !empty($value['vendor_logo']) ? base_url($value['vendor_logo']) : base_url('plugins/images/logo.png');
                          $shop_name = $value['vendor_shop_name'] ?? $value['shop_name'] ?? '';
                        }
                        ?>
                        <img src="<?= $img; ?>" alt="Shop Logo" class="vendor-logo"
                          onerror="this.src='<?= base_url('plugins/images/logo.png'); ?>'">
                        <br>
                        <span><?= $shop_name; ?></span>
                      </td>
                      <td><?= $value['promoter_shop_name'] ?? 'N/A'; ?></td>
                      <td><?= $value['promoter_name'] ?? 'N/A'; ?></td>
                      <td><?= $value['final_price']; ?> / <?= $value['price']; ?></td>
                      <td><?= $value['quantity']; ?></td>
                      <td><?= date('d-m-Y | h:i:s A', strtotime($value['add_date'] ?? date('Y-m-d H:i:s'))); ?></td>
                      <td>
                        <?php if ($promoterData['Type'] == 3)
                        { ?>
                          <label class="switch">
                            <input type="checkbox" <?= ($value['verify_status'] == 1) ? 'checked' : ''; ?>
                              onclick="verify_product(this.value, <?= $value['id']; ?>);">
                            <span class="slider round"></span>
                          </label>
                        <?php } else
                        { ?>
                          <span class="label <?= ($value['verify_status'] == 1) ? 'label-success' : 'label-danger'; ?>">
                            <?= ($value['verify_status'] == 1) ? 'VERIFY' : 'NOT VERIFY'; ?>
                          </span>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="<?= base_url('admin/Product/UpdateProduct/' . $value['id']); ?>" class="btn btn-info">
                          <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="<?= base_url('admin/product/delete_product/' . $value['id']); ?>" class="btn btn-danger"
                          onclick="return confirm('Are you sure?');">
                          <i class="fa-solid fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    <?php $counter++; ?>
                  <?php endforeach; ?>
                </tbody>

              </table>

              <!-- PAGINATION -->
              <div class="row">
                <div class="col-sm-6">
                  <?= @$entries; ?>
                </div>
                <div class="col-sm-6 text-right">
                  <ul class="pagination">
                    <?php foreach ($links as $link)
                    {
                      echo "<li>" . $link . "</li>";
                    } ?>
                  </ul>
                </div>
              </div>

            </div> <!-- /.box-body -->
          </div> <!-- /.box -->
        </div> <!-- /.col -->
      </div> <!-- /.row -->
  </section>

  <!-- /.content -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:100%">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Product Quantity</h4>
        </div>
        <form action="<?php echo base_url(); ?>admin/product/changePassword" method="POST">
          <div class="modal-body" id="show_html">

          </div>

        </form>
      </div>

    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>
<script type="text/javascript">

  function get_product_idss(id) {
    var val = [];
    $(':checkbox:checked').each(function (i) {
      val[i] = $(this).val();
    });

    $('#set_checked_id').val(val);

  }

  function change_quantity(product_code, qty) {
    $.ajax({
      url: '<?php echo base_url('admin/product/changeQty'); ?>',
      type: 'POST',
      data: { 'product_code': product_code, 'quantity': qty },
      dataType: 'HTML',
      success: function (response) {
        $('#show_html').html(response);
        $('#myModal').modal('show');
      }
    });


  }

  function verify_product(value, product_id) {
    $.ajax({
      url: '<?php echo base_url('admin/product/verify_product'); ?>',
      type: 'POST',
      data: { 'value': value, 'product_id': product_id },
      dataType: 'text',
      success: function (response) {
        if (response == '1') {
          alert('Product Verify Successfully.');
          location.reload();
        } else {
          alert('Product Unverify Successfully.');
          location.reload();
        }
      }
    });
  }


</script>



<!-- Add Product Button -->

<!-- Subscription / Pricing Modal -->
 <div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content pricing-modal">
        <div class="modal-body p-5">

          <div class="text-center mb-5">
            <h3 class="fw-bold">Choose Your Plan</h3>
            <p class="text-muted">Upgrade to unlock premium features</p>
          </div><br>

          <div class="row g-4">
            <!-- LEFT : Selected Plan -->
            <div class="col-md-4">
              <h6 class="fw-semibold mb-3 section-title">Selected Plan</h6>

              <div class="plan-box" id="selectedPlanBox">
                <h6><?= $plans[0]['plan_name'] ?></h6>
                <div class="price-tag" id="selectedPlanPrice">
                  <?= $plans[0]['plan_type'] == 1 ? '₹' . $plans[0]['price'] : $plans[0]['commission_percent'] . '%' ?>
                  <small>/<?= $plans[0]['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                </div><br>
                <small class="text-muted mt-3">Product Limit: <?= $plans[0]['product_limit'] ?></small>
              </div>
            </div>

            <!-- RIGHT : Plans -->
            <div class="col-md-8">
              <div class="row g-3">
                <?php foreach ($plans as $plan): ?>
                  <div class="col-md-6">
                    <div class="pricing-card select-plan" data-id="<?= $plan['id'] ?>" data-name="<?= $plan['plan_name'] ?>"
                      data-price="<?= $plan['price'] ?>" data-type="<?= $plan['plan_type'] ?>"
                      data-commission="<?= $plan['commission_percent'] ?>" data-limit="<?= $plan['product_limit'] ?>">
                      <h6 class="fw-semibold"><?= $plan['plan_name'] ?></h6>
                      <div class="card-price mt-2">
                        <?= $plan['plan_type'] == 1 ? '₹' . $plan['price'] : $plan['commission_percent'] . '%' ?>
                        <small>/<?= $plan['plan_type'] == 1 ? 'Month' : 'Per Product' ?></small>
                      </div>
                      <small class="text-muted">Product Limit: <?= $plan['product_limit'] ?></small>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="text-center mt-5">
            <button class="btn btn-proceed" id="proceedPlanBtn">
              Proceed to Payment →
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    var user_id = <?= $adminData['Id'] ?? 0 ?>;
    var user_type = <?= ($adminData['Type'] == 2 ? "'vendor'" : "'promoter'") ?>;

    document.getElementById('addProductBtn').addEventListener('click', function () {
      $.ajax({
        url: '<?= base_url("admin/Subscription/check_active_plan") ?>',
        type: 'POST',
        data: { user_id, user_type },
        dataType: 'json',
        success: function (res) {
          if (res.has_plan) {
           
            window.location.href = "<?= base_url('admin/Product/AddProduct'); ?>";
          } else {
           
            $('#subscriptionModal').modal('show');
            var defaultPlanCard = document.querySelector('.select-plan');
            if (defaultPlanCard) {
              $('.select-plan').removeClass('active');
              defaultPlanCard.classList.add('active');
              updateSelectedPlanBox(defaultPlanCard);
            }
          }
        },
        error: function (xhr) {
          console.error(xhr.responseText);
          alert('Could not verify plan status.');
        }
      });

    });

    // Plan selection click
    $(document).on('click', '.select-plan', function () {
      $('.select-plan').removeClass('active');
      $(this).addClass('active');
      updateSelectedPlanBox(this);
    });

    // Update left box
    function updateSelectedPlanBox(card) {
      document.getElementById('selectedPlanBox').innerHTML = `
      <div class="plan-inline d-flex justify-content-between align-items-center">
        <div><h6>${card.dataset.name}</h6></div>
        <div class="price-tag">
          ${card.dataset.type == 1 ? '₹' + card.dataset.price : card.dataset.commission + '%'}
          <small>/${card.dataset.type == 1 ? 'Month' : 'Per Product'}</small>
        </div>
      </div>
      <small>Product Limit: ${card.dataset.limit}</small>
    `;
    }
    document.getElementById('proceedPlanBtn').addEventListener('click', function () {
      var selectedPlan = document.querySelector('.select-plan.active');
      if (!selectedPlan) { alert('Please select a plan first.'); return; }

      var plan_id = selectedPlan.dataset.id;
      var plan_type = selectedPlan.dataset.type;

      $.ajax({
        url: '<?= base_url("admin/Subscription/create_subscription") ?>',
        type: 'POST',
        data: { user_id, plan_id, user_type },
        dataType: 'json',
        success: function (res) {
          if (res.status == 'success') {
            if (plan_type == 1) {
             
              var form = document.createElement('form');
              form.method = 'POST';
              form.action = '<?= base_url("phonepe/pay") ?>';
              form.innerHTML = `
              <input type="hidden" name="order_id" value="${res.merchant_txn_id}">
              <input type="hidden" name="amount" value="${res.amount}">
            `;
              document.body.appendChild(form);
              form.submit();
            } else {
             
              alert("Per-product plan activated. You can now add products.");
              $('#pricingModal').modal('hide');
              window.location.href = "<?= base_url('admin/Product/AddProduct'); ?>";
            }
          } else {
            alert(res.message);
          }
        },
        error: function (xhr) {
          console.error(xhr.responseText);
          alert('Something went wrong.');
        }
      });
    });

  });
</script>