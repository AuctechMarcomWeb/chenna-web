<style>
    .view-order-btn {
        background-color: #0d6efd !important;
        color: #fff !important;
        border: none;
    }

    .view-order-btn:hover,
    .view-order-btn:focus,
    .view-order-btn:active {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
</style>
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Order confirmed</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url() ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Order confirmed</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->


<section class="py-5">
    <div class="container">
        <!-- Top Order Confirmation -->
        <div class="text-center mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="#28a745" class="mb-3"
                viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11.293l5.146-5.147-.708-.708L7 9.879 4.854 7.732l-.708.708L7 11.293z" />
            </svg>
            <h2 class="fw-bold text-dark">Order Confirmation</h2>
            <p class="text-muted mb-0 mt-3">Your order has been placed successfully. You’ll receive a confirmation
                shortly.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="table-responsive shadow-sm rounded-4 border overflow-hidden">
                    <table class="table table-border m-0">
                        <tbody>
                            <tr class="bg-light">
                                <th class="p-3">Order ID:</th>
                                <td class="p-3 text-danger fw-bold"><?= $order_data['order_number']; ?></td>
                            </tr>
                            <tr>
                                <th class="p-3">Shipping Address:</th>
                                <td class="p-3">
                                    <?= $address_data['title']; ?> <?= $address_data['contact_person']; ?><br>
                                    <?= $address_data['address']; ?>, <?= $address_data['localty']; ?>
                                    <?= $address_data['landmark']; ?>,
                                    <?= $address_data['city']; ?>, <?= $address_data['state']; ?><br>
                                    Phone: +91 <?= $address_data['mobile_number']; ?><br>
                                    Pincode: <?= $address_data['pincode']; ?>
                                </td>
                            </tr>
                            <tr class="bg-light">
                                <th class="p-3">Payment Method:</th>
                                <td class="p-3"><?= $paymentTypeName; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>





        <!-- Go Back Button -->
        <!-- <div class="text-center mt-4 d-flex justify-content-center">
            <a style="max-width:200px; background:#a81e23; color:#fff" href="<?php echo base_url(''); ?>" class="btn btn-sm btn-danger px-4 py-2 rounded-pill fw-semibold shadow-sm">
                Go Back Shopping
            </a>
        </div> -->
        <div class="text-center mt-4 d-flex justify-content-center">
            <a style="max-width:200px; background:#a81e23; color:#fff" href="<?php echo base_url(''); ?>"
                class="btn btn-sm btn-danger px-4 py-2 rounded-pill fw-semibold shadow-sm me-2">
                Go Back Shopping
            </a>

            <a href="<?= base_url('web/account_profile?tab=order'); ?>"
                class="btn btn-sm px-4 py-2 rounded-pill fw-semibold shadow-sm view-order-btn">
                View Order
            </a>
        </div>
    </div>
</section>