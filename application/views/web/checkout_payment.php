

<?php $userData = $this->session->userdata('User'); ?>
<style>
  .cod-disabled {
    background: #f1f1f1;
    opacity: 0.7;
    pointer-events: none;
}

.cod-disabled .accordion-button {
       background: #f1f1f1;
    cursor: not-allowed;
}
.small {
    font-size: 17px;
}
</style>
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
  <div class="container-fluid-lg">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-contain">
          <h2>Select Payment Option</h2>
          <nav>
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>">
                  <i class="fa-solid fa-house"></i>
                </a>
              </li>
              <li class="breadcrumb-item active">Select Payment Option</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Section End -->



<!-- ================= Checkout Section ================= -->
<section class="checkout-section-2 section-b-space">
  <div class="container-fluid-lg">
    <div class="row g-sm-4 g-3">

      <!-- ================= LEFT : PAYMENT ================= -->
      <div class="col-lg-8">
        <div class="left-sidebar-checkout">
          <div class="checkout-detail-box">
            <ul>
              <li>
                <div class="checkout-box">
                  <div class="checkout-title">
                    <h4>Payment Option</h4>
                  </div>

                  <div class="checkout-detail">
                    <div class="accordion accordion-flush custom-accordion">

                      <!-- COD -->
                      <div class="accordion-item <?= (!$cod_available) ? 'cod-disabled' : '' ?>">
                          <div class="accordion-header">
                              <div class="accordion-button collapsed">
                                  <div class="custom-form-check form-check mb-0">
                                      <label class="form-check-label">
                                          <input type="radio"
                                              class="form-check-input mt-0 payment-option"
                                              name="payment_option"
                                              value="1"
                                              <?= (!$cod_available) ? 'disabled' : '' ?>
                                              <?= ($cod_available && $paymentType == 1) ? 'checked' : '' ?>>
                                          Cash on Delivery
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="accordion-body">
                              <?php if ($cod_available): ?>
                                  <p class="text-success small mb-0">
                                     Cash on Delivery is available for this product.
                                  </p>
                              <?php else: ?>
                                  <p class="text-danger small mb-0">
                                     Cash on Delivery is not available for this product.
                                  </p>
                              <?php endif; ?>
                          </div>
                      </div>


                      <!-- ONLINE -->
                      <div class="accordion-item">
                        <div class="accordion-header">
                          <div class="accordion-button collapsed">
                            <div class="custom-form-check form-check mb-0">
                              <label class="form-check-label">
                                <input type="radio"
                                  class="form-check-input mt-0 payment-option"
                                  name="payment_option"
                                  value="2"
                                  <?= (!$cod_available || $paymentType == 2) ? 'checked' : '' ?>>
                                Online Payment
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="accordion-body">
                          <p class="small mb-0">
                            Pay securely using PhonePe / UPI.
                          </p>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ================= RIGHT : ORDER SUMMARY ================= -->
      <div class="col-lg-4">
        <div class="right-side-summery-box">
          <div class="summery-box-2">

            <div class="summery-header">
              <h3>Order Summary</h3>
            </div>

            <?php
            $total_cost = 0;
            $gst_total = 0;
            $coupon = $this->session->userdata('applied_coupon');
            $coupon_disc = 0;

            foreach ($checkout_items as $item) {
              $total_cost += $item['final_price'] * $item['qty'];
            }

            if (!empty($coupon)) {
              $coupon_disc = ($coupon['discount_type'] == 'percent')
                ? ($coupon['discount_value'] / 100) * $total_cost
                : $coupon['discount_value'];

              if (!empty($coupon['max_discount_amount']) &&
                $coupon_disc > $coupon['max_discount_amount']) {
                $coupon_disc = $coupon['max_discount_amount'];
              }
            }

            $subtotal_after_coupon = $total_cost - $coupon_disc;

            foreach ($checkout_items as $item) {
              $item_total = $item['final_price'] * $item['qty'];
              $item_disc = ($total_cost > 0)
                ? ($item_total / $total_cost) * $coupon_disc
                : 0;

              $gst_total += (($item_total - $item_disc) * ($item['gst'] / 100));
            }

            $settings = $this->db->get_where('settings', ['id' => 1])->row_array();
            $shipping = ($subtotal_after_coupon >= $settings['min_order_bal'])
              ? 0
              : $settings['shipping_amount'];

            $grand_total = $subtotal_after_coupon + $gst_total + $shipping;
            ?>

            <ul class="summery-contain">
              <?php foreach ($checkout_items as $item): ?>
                <?php
                $item_total = $item['final_price'] * $item['qty'];
                $img = (filter_var($item['image'], FILTER_VALIDATE_URL))
                  ? $item['image']
                  : base_url('assets/product_images/' . $item['image']);
                ?>
                <li>
                  <img src="<?= $img ?>" class="img-fluid checkout-image">
                  <h4>
                    <?= $item['name']; ?> <span>x <?= $item['qty']; ?></span><br>
                    <small>Size: <?= $item['size']; ?></small>
                  </h4>
                  <h4 class="price">
                    ₹<?= number_format($item_total, 2); ?><br>
                    <small>GST <?= $item['gst']; ?>%</small>
                  </h4>
                </li>
              <?php endforeach; ?>
            </ul>

            <ul class="summery-total">
              <?php if ($coupon_disc > 0): ?>
                <li>
                  <h4>Coupon Discount</h4>
                  <h4 class="price text-success">-₹<?= number_format($coupon_disc, 2); ?></h4>
                </li>
              <?php endif; ?>

              <li>
                <h4>GST</h4>
                <h4 class="price">₹<?= number_format($gst_total, 2); ?></h4>
              </li>

              <li>
                <h4>Shipping</h4>
                <h4 class="price">₹<?= number_format($shipping, 2); ?></h4>
              </li>

              <li class="list-total">
                <h4>Total (INR)</h4>
                <h4 class="price">₹<?= number_format($grand_total, 2); ?></h4>
              </li>
            </ul>

            <!-- ================= FORM ================= -->
            <form id="checkoutForm" method="POST" action="<?= base_url('web/order_complete'); ?>">

              <input type="hidden" name="paymentType" id="paymentType"
                value="<?= ($cod_available && $paymentType == 1) ? 1 : 2 ?>">

              <input type="hidden" name="tid" id="tid"
                value="<?= (!$cod_available || $paymentType == 2) ? 'TXN_' . time() : '' ?>">

              <input type="hidden" name="address_id" value="<?= $address_data['id'] ?>">

              <button type="submit"
                id="placeOrderBtn"
                class="btn theme-bg-color text-white btn-md w-100 mt-3 fw-bold">
                Place Order
              </button>

            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= JS ================= -->
<script>
  const radios = document.querySelectorAll('.payment-option');
  const paymentType = document.getElementById('paymentType');
  const tid = document.getElementById('tid');

  radios.forEach(r => {
    r.addEventListener('change', function () {
      paymentType.value = this.value;

      if (this.value === '2') {
        tid.value = 'TXN_' + Date.now() + '_' + Math.floor(Math.random() * 1000);
      } else {
        tid.value = '';
      }
    });
  });

  document.getElementById('placeOrderBtn').onclick = function () {
    this.disabled = true;
    this.innerText = 'Processing...';
    document.getElementById('checkoutForm').submit();
  };
</script>
