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

  .card {
    border: 1px solid #dd4b3924;
    border-radius: 14px;
    padding: 13px;
    cursor: pointer;
    transition: all .25s ease;
    height: auto;
    background: #fff;
  }

  .select-plan.active {
    border-color: #dd4b3985;
    background: linear-gradient(135deg, #ffffff, #fff);
    box-shadow: 0 11px 13px rgb(255 234 234);
  }

  .card-price {
    font-size: 13px;
    font-weight: 700;
    color: #e7331d;
    text-align: center;
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


  .plan-benefits {
    list-style: none;
    padding-left: 0;
    margin-top: 10px;
  }

  .plan-benefits li {
    position: relative;
    padding-left: 28px;
    margin-bottom: 8px;
    font-size: 14px;
  }

  .plan-benefits li::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 1px;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    background: #18b310;
    color: #fff;
    font-size: 10px;
    text-align: center;
    line-height: 18px;
    font-weight: bold;
  }

  .plan-name {
    font-weight: bold;
    font-size: 15px;
  }

  .text-muted {
    color: #000;
    font-size: 15px;
  }

  .choose-plan {
    color: #000;
  }



  .table thead th {
    background: #3c8dbc;
    color: #fff;
    font-weight: 600;
    white-space: nowrap;
  }

  .table tbody tr:hover {
    background: #f5f9ff;
    transition: 0.3s;
  }

  .badge-paid {
    background: #28a745;
    color: #fff;
  }

  .badge-pending {
    background: #ffc107;
    color: #000;
  }

  .product-list {
    padding-left: 18px;
    margin: 0;
  }

  .product-list li {
    margin-bottom: 6px;
    font-size: 13px;
  }

  .product-list img {
    width: 50px;
    height: 70px;
    object-fit: scale-down;
    border-radius: 4px;
    margin-right: 6px;
    border: 1px solid #f96522;
  }

  .expired {
    color: red;
    font-weight: 600;
  }

  .progress {
    height: 18px;
    background: #e9ecef;
  }

  .progress-bar {
    font-size: 11px;
  }

  .ad-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
  }

  .ad-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .ad-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 50px;
  }

  .ad-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
  }

  .ad-switch input:checked+.ad-slider {
    background-color: #28a745;
  }

  .ad-switch input:checked+.ad-slider:before {
    transform: translateX(26px);
  }
  .bg-success{
    background:green;
  }
  .bg-warning{
    background:orange;
  }
</style>
<?php
function timeAgo($datetime)
{
  $time = time() - strtotime($datetime);

  if ($time < 60)
    return 'Just now';
  if ($time < 3600)
    return floor($time / 60) . ' min ago';
  if ($time < 86400)
    return floor($time / 3600) . ' hours ago';
  if ($time < 2592000)
    return floor($time / 86400) . ' days ago';
  if ($time < 31536000)
    return floor($time / 2592000) . ' months ago';

  return floor($time / 31536000) . ' years ago';
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Manage Products
      <a href="javascript:void(0);" class="btn btn-info" style="float: right; padding-right: 10px;"
        id="addProductBtn">Add Advertisment</a>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="msg">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body" style="overflow-x:auto;"><br>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Product</th>
                        <th>Plan Name</th>
                        <th>Payment</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Expire In</th>
                        <th>Transaction ID</th>
                        <th>Approval</th>
                        <th>Registered Date</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($activePlans)): ?>
                        <?php foreach ($activePlans as $i => $ap):
                          $expireDays = floor((strtotime($ap['end_date']) - time()) / 86400); ?>
                          <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                              <?= $ap['user_name'] ?><br>
                              <a class="btn btn-primary"
                                href="<?= base_url('admin/Subscription/AdvertismentUserDetails/' . $ap['purchase_id']) ?>">View
                                Details</a>
                            </td>
                            <td><?= ($ap['user_type'] == 2) ? 'Vendor' : 'Promoter' ?></td>
                            <td style="min-width:220px;">
                              <?php
                              if (!empty($ap['product_names']))
                              {
                                $names = explode('||', $ap['product_names']);
                                $images = explode('||', $ap['product_images']);
                                echo '<ol class="product-list">';
                                foreach ($names as $k => $n)
                                {
                                  $img = $images[$k] ?? '';
                                  echo '<li>';
                                  if ($img)
                                    echo '<img src="' . base_url('assets/product_images/' . $img) . '">';
                                  echo $n . '</li>';
                                }
                                echo '</ol>';
                              } else
                                echo '-';
                              ?>
                            </td>
                            <td><b><?= $ap['plan_name'] ?></b><br>₹<?= $ap['paid_price'] ?></td>
                            <td>
                              <?php if ($ap['payment_status'] == 'paid'): ?>
                                <span class="badge badge-paid">Paid</span>
                              <?php else: ?>
                                <span class="badge badge-pending">Pending</span>
                              <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y', strtotime($ap['start_date'])) ?></td>
                            <td><?= date('d-m-Y', strtotime($ap['end_date'])) ?></td>
                            <td>
                              <?php
                              if ($expireDays < 0)
                                echo '<span class="expired">Expired</span>';
                              elseif ($expireDays == 0)
                                echo 'Today';
                              else
                                echo $expireDays . ' days';
                              ?>
                            </td>
                            <td><?= $ap['transaction_id'] ?></td>
                            <td>
                              <?php if ($adminData['Type'] == 1): ?>
                               
                                <label class="ad-switch">
                                  <input type="checkbox" class="planStatusToggle" data-id="<?= $ap['purchase_id'] ?>"
                                    <?= ($ap['status'] == 1) ? 'checked' : '' ?>>
                                  <span class="ad-slider"></span>
                                </label>
                              <?php else: ?>
                               
                                <?php if ($ap['status'] == 1): ?>
                                  <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                  <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                              <?php endif; ?>
                            </td>
                            <td><?= date('d-m-Y h:i:s A', strtotime($ap['created_at'])) ?></td>
                            <td><?= timeAgo($ap['created_at']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="13" class="text-center">No Plan Available</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</div>


<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js'); ?>"></script>

<!-- Advertisement Plan Modal -->
<div class="modal fade" id="advertisementModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content pricing-modal">
      <div class="modal-body p-5">

        <div class="text-center mb-5">
          <h3 class="fw-bold choose-plan">Choose Your Advertisement Plan</h3>
          <p class="text-muted">Select a plan to promote your products</p>
        </div>

        <div class="row g-4">
          <div class="col-md-12">
            <div class="row g-3">
              <?php foreach ($plans as $plan): ?>
                <div class="col-md-4">
                  <div class="card select-plan p-3 cursor-pointer" data-id="<?= $plan['id'] ?>"
                    data-name="<?= $plan['plan_name'] ?>" data-price="<?= $plan['price'] ?>"
                    data-duration="<?= $plan['duration_days'] ?>" data-limit="<?= $plan['product_limit'] ?>"
                    data-hotdeal="<?= $plan['hot_deal'] ?>" data-productforyou="<?= $plan['product_for_you'] ?>"
                    data-banner="<?= $plan['banner'] ?>" data-spacialoffer="<?= $plan['spacial_offer'] ?>">

                    <h6 class="bold plan-name"><?= $plan['plan_name'] ?></h6>
                    <div class="card-price mt-2">
                      ₹<?= $plan['price'] ?> <small>/<?= $plan['duration_days'] ?> Days</small>
                    </div>

                    <small class="text-muted d-block mt-1 mb-2 fw-bold">Benefits:</small>
                    <ul class="plan-benefits">
                      <?php if ($plan['product_for_you']): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Product for you</li>
                      <?php endif; ?>
                      <?php if ($plan['hot_deal']): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Hot Deal</li>
                      <?php endif; ?>
                      <?php if ($plan['spacial_offer']): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Special Offer</li>
                      <?php endif; ?>
                      <?php if ($plan['banner']): ?>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Banner </li>
                      <?php endif; ?>
                      <li>Product Limit: <?= $plan['product_limit'] ?></li>
                    </ul>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="text-center mt-4">
          <button class="btn btn-proceed px-5" id="proceedPlanBtn">Proceed to Payment →</button>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {

    let selectedPlan = null;

    $(document).ready(function () {

  let selectedPlan = null;

  // ✅ BUTTON CLICK → ALWAYS OPEN MODAL
  $('#addProductBtn').on('click', function () {
      $('#advertisementModal').modal('show');
  });

  // ✅ PLAN SELECT
  $(document).on('click', '.select-plan', function () {
      $('.select-plan').removeClass('border border-success');
      $(this).addClass('border border-success');
      selectedPlan = $(this);
  });


  $('#proceedPlanBtn').on('click', function () {

      if (!selectedPlan) {
          alert('Please select a plan');
          return;
      }

      $.post("<?= base_url('admin/Subscription/create_advetisment_plan') ?>", {
          plan_id: selectedPlan.data('id'),
          user_id: <?= $adminData['Id'] ?>,
          user_type: <?= $adminData['Type'] ?>
      }, function (res) {

          if (res.status === 'success') {
              window.location.href = "<?= base_url('admin/Subscription/AdvertismentProducts') ?>";
          } else {
              alert(res.message || 'Something went wrong');
          }

      }, 'json');
  });

});


    // Select plan
    $(document).on('click', '.select-plan', function () {
      $('.select-plan').removeClass('active border border-success');
      $(this).addClass('active border border-success');
      selectedPlan = $(this);

      let benefits = [];
      if ($(this).data('productforyou') == 1) benefits.push('Product For You');
      if ($(this).data('hotdeal') == 1) benefits.push('Hot Deal');
      if ($(this).data('spacialoffer') == 1) benefits.push('Special Offer');
      if ($(this).data('banner') == 1) benefits.push('Banner');

      $('#selectedPlanBox').html(`
      <h6 class="fw-bold">${$(this).data('name')}</h6>
      <div class="price-tag fw-bold text-success">₹${$(this).data('price')}</div>
      <small class="text-muted">Product Limit: ${$(this).data('limit')}</small>
      <ul class="plan-benefits mt-2">
        ${benefits.length ? benefits.map(b => `<li><i class="bi bi-check-circle-fill text-success"></i> ${b}</li>`).join('') : '<li>No extra promotion</li>'}
      </ul>
    `);
    });

    // Proceed button → Create session & redirect
    $('#proceedPlanBtn').on('click', function () {
      if (!selectedPlan) {
        alert('Please select a plan');
        return;
      }

      $.post("<?= base_url('admin/Subscription/create_advetisment_plan') ?>", {
        plan_id: selectedPlan.data('id'),
        user_id: <?= $adminData['Id'] ?>,
        user_type: <?= $adminData['Type'] ?>
      }, function (res) {
        if (res.status === 'success') {
          window.location.href = "<?= base_url('admin/Subscription/AdvertismentProducts') ?>";
        } else {
          alert(res.message || 'Something went wrong');
        }
      }, 'json');
    });

  });
</script>
<script>
 $(document).ready(function(){
  $('.planStatusToggle').change(function(){
    var id = $(this).data('id');
    var status = $(this).is(':checked') ? 1 : 0;
    $.ajax({
      url:'<?= base_url("admin/Subscription/updatePlanStatus") ?>',
      type:'POST',
      data:{id:id,status:status},
      dataType:'json',
      success:function(res){
        if(res.status==1){
          alert('Plan status updated!');
          location.reload();
        } else {
          alert(res.msg || 'Failed!');
        }
      },
      error:function(){ alert('Server error!'); }
    });
  });
});

</script>