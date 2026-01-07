<style>
    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        flex-direction: column;
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap;
        gap: 20px;
        background-color: #f8f8f8;
        padding: calc(15px + 5 * (100vw - 320px) / 1600);
        margin-top: 30px;
        border-radius: 8px;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: start;
    }


    .view-details-btn {
        display: inline-block;
        padding: 6px 24px;
        background-color: #0da487;
        color: #fff !important;
        text-decoration: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .view-details-btn:hover {
        background-color: #0da487;
        transform: scale(1.05);
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail div:hover .order-image img,
    .order-image img {
        height: 120px;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-bg-box {
        width: 100%;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .order-container .order-detail h4 span {
        font-size: 14px;
        padding: 6px 6px;
    }

    .user-dashboard-section .dashboard-right-sidebar .dashboard-order .order-contain .order-box .product-order-detail {
        margin-top: 10px;
    }

    .add-to-cart-box .btn-add-cart {
        padding: calc(3px + 4 * (94vw - 314px) / 1590) 0;
        width: 75%;
        font-size: calc(14px + 1 * (100vw - 320px) / 1600);
        margin: 10px 60px 0 60px;
        display: block;
        color: #4a5568;
        border-radius: 44px;
        font-weight: 500;
        border: 1px solid #80808033;
        text-align: center;
    }

    .color-option {
        cursor: pointer;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
        border: 1px solid #ccc;
        transition: all 0.2s;
    }

    .color-option.selected-color {
        border: 3px double #ff0000;
    }

    .size-option {
        cursor: pointer;
        padding: 4px 5px;
        border: 1px solid #ddd;
        border-radius: 25px;
        height: 35px;
        width: 35px;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
        transition: all 0.2s;
        text-align: center;
        line-height: 24px;
        color: black;
    }

    .size-option:hover {
        border-color: #ff7272;
    }

    .size-option.selected-size {
        border: 1px solid #00000042;
        background-color: #ffeaea;
        font-weight: bold;
        color: black;
    }

    .color-option.active {
        border: 3px double #007bff;
        padding: 3px;
    }

    .size-option.active {
        border: 2px solid #777;
        background: #ff727214;
    }

    .color-option,
    .size-option {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 4px;
        cursor: pointer;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        transition: all 0.2s ease-in-out;
        user-select: none;
    }

    .color-option {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #eee;
    }

    .size-option {
        min-width: 38px;

        height: 38px;
        padding: 0 6px;

        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 13px;
        white-space: nowrap;

    }

    .color-option.active,
    .size-option.active {
        border: 2px solid #000;
        background-color: #fff;
        font-weight: 600;
    }

    .color-option:hover,
    .size-option:hover {
        border-color: #000;
    }

    @media (max-width: 576px) {
        .size-option {
            min-width: 34px;
            height: 34px;
            font-size: 12px;
            padding: 0 4px;
        }

        .color-option {
            width: 26px;
            height: 26px;
        }
    }

    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }

    .product-box-4:hover .product-image img {
        transform: scale(1.04);
    }

    .product-box-4 .product-detail .buy-button {
        background: #ffffffff !important;
        color: #d80101 !important;
        border: 1px solid #ff4f4f21 !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 18px 15px !important;
        font-size: 14px;
    }

    .buy-button-2:hover {
        background: #a50000;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 480px) {
        .product-box-4 .product-detail .price-qty .buy-button {
            width: 100%;
            margin-top: -43px !important;
        }
    }

    .product-box-4 .product-detail {
        text-align: left;
        margin-top: 1px;
        position: relative;
    }

    .fa-star::before {
        color: goldenrod;
    }

    .product-box-4 {
        border: 1px solid #ff727238;
        border-radius: 8px;
        padding: 15px;
        position: relative;
        text-align: center;
        background: white;
    }

    .top-0 {
        top: -18px !important;
    }

    .label-flex {

        left: -17px;
    }
</style>

<?php
if (empty($userInfo['profile_pic']))
{
    $profile = base_url() . 'assets/images/account02.png';
} else
{
    $profile = base_url() . 'assets/profile_image/' . $userInfo['profile_pic'];
} ?>


<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2> Wishlist</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Wishlist </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- User Dashboard Section Start -->
<section class="user-dashboard-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-lg-12">

                <!-- Mobile Show Menu -->


                <div class="dashboard-right-sidebar">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-wishlist" role="tabpanel">
                            <div class="dashboard-wishlist">

                                <!-- Section Title -->
                                <div class="title mb-4">
                                    <h2 class="mb-0">My Wishlist</h2>
                                    <span class="title-leaf title-leaf-gray">
                                        <svg class="icon-width bg-gray">
                                            <use xlink:href="../plugins/svg/leaf.svg#leaf"></use>
                                        </svg>
                                    </span>
                                </div>

                                <!-- Product Grid -->
                                <div class="row g-3 g-sm-4">
                                    <?php if (!empty($wishListData)):
                                        foreach ($wishListData as $value):
                                            $product_res = $this->db->get_where('sub_product_master', ['id' => $value['product_id']])->row_array();


                                            $array_url = parse_url($product_res['main_image']);
                                            $img_url = empty($array_url['host'])
                                                ? base_url('assets/product_images/' . $product_res['main_image'])
                                                : 'https://' . $array_url['host'] . $array_url['path'] . '?raw=1';
                                            $rating = $value['product']['average_rating'] ?? 0;

                                            ?>

                                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                                <div class="product-box-4 h-100 theme-bg-white">


                                                    <div class="product-image position-relative">
                                                        <a
                                                            href="<?= base_url() . slugify($product_res['product_name']) . '/' . $product_res['id']; ?>">
                                                            <img src="<?= $img_url ?>" class="img-fluid"
                                                                alt="<?= $product_res['product_name']; ?>">
                                                        </a>
                                                        <div class="label-flex position-absolute top-0 end-0 m-2">
                                                            <button class="btn wishlist-button close_button"
                                                                data-product-id="<?= $product_res['id']; ?>"
                                                                data-user-id="<?= $userInfo['id']; ?>"
                                                                style="background: #fff; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.2); padding: 0;">
                                                                <i data-feather="x" style="color: #d80101;"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Product Detail -->
                                                    <div class="product-detail mt-2">
                                                        <ul class="rating mb-2 d-flex align-items-center"
                                                            style="list-style:none; padding:0;">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <li class="me-1">
                                                                    <?php if ($i <= floor($rating)): ?>
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    <?php elseif ($i - $rating <= 0.5): ?>
                                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                                    <?php else: ?>
                                                                        <i class="far fa-star text-muted"></i>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endfor; ?>
                                                            <!-- <span class="ms-2">(<?= $rating ?>)</span> -->
                                                        </ul>

                                                        <a
                                                            href="<?= base_url() . slugify($product_res['product_name']) . '/' . $product_res['id']; ?>">
                                                            <h6 class="name mb-2 text-truncate"
                                                                title="<?= $product_res['product_name']; ?>">
                                                                <?= strlen($product_res['product_name']) > 40 ?
                                                                    substr($product_res['product_name'], 0, 40) . '...' :
                                                                    $product_res['product_name']; ?>
                                                            </h6>
                                                        </a>

                                                        <h6 class="price theme-color mt-2">
                                                            <span>₹<?= $product_res['final_price'] ?></span>
                                                            <del class="ms-2 small">₹<?= $product_res['price'] ?></del>
                                                        </h6>

                                                        <div class="price-qty mt-5">
                                                            <button
                                                                class="buy-button buy-button-2 btn w-100 d-flex align-items-center justify-content-center"
                                                                onclick="add_cart(<?= $product_res['id'] ?>)">
                                                                <i class="iconly-Buy icli me-2"></i> Add to Cart
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach;
                                    else: ?>
                                        <div class="text-center py-5">
                                            <img style="height: 250px; width:100%; object-fit: contain;"
                                                src="<?= base_url(); ?>assets/img/imgpsh_fullsize_anim.jpg"
                                                alt="No Products">
                                            <p class="mt-3">No products in wishlist</p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- User Dashboard Section End -->




<!-- Bg overlay Start -->
<div class="bg-overlay"></div>
<!-- Bg overlay End -->


<!-- Location Modal Start -->
<div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Choose your Delivery Location</h5>
                <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="location-list">
                    <div class="search-input">
                        <input type="search" class="form-control" placeholder="Search Your Area">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="disabled-box">
                        <h6>Select a Location</h6>
                    </div>

                    <ul class="location-select custom-height">
                        <li>
                            <a href="javascript:void(0)">
                                <h6>Alabama</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Arizona</h6>
                                <span>Min: $150</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>California</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Colorado</h6>
                                <span>Min: $140</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Florida</h6>
                                <span>Min: $160</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Georgia</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Kansas</h6>
                                <span>Min: $170</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Minnesota</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>New York</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Washington</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Location Modal End -->



<!-- Edit Card Start -->
<div class="modal fade theme-modal" id="editCard" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel8">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-xxl-6">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="finame" value="Mark">
                                <label for="finame">First Name</label>
                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-6">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="laname" value="Jecno">
                                <label for="laname">Last Name</label>
                            </div>
                        </form>
                    </div>

                    <div class="col-xxl-4">
                        <form>
                            <div class="form-floating theme-form-floating">
                                <select class="form-select" id="floatingSelect12">
                                    <option selected>Card Type</option>
                                    <option value="kingdom">Visa Card</option>
                                    <option value="states">MasterCard Card</option>
                                    <option value="fra">RuPay Card</option>
                                    <option value="china">Contactless Card</option>
                                    <option value="spain">Maestro Card</option>
                                </select>
                                <label for="floatingSelect12">Card Type</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light">Update Card</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Card End -->



<!-- First Confirmation Modal -->
<div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h5 class="modal-title w-100">Are You Sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete_address_id">
                <div class="remove-box">
                    <p>This action cannot be undone. Do you want to delete this address?</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                    id="confirmDelete">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Done!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="remove-box text-center">
                    <h4 class="text-content">It's Removed.</h4>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn theme-bg-color btn-md fw-bold text-light" data-bs-dismiss="modal"
                    onclick="location.reload();">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Profile Start -->
<div class="modal fade theme-modal" id="editProfile" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">

        <form action="<?php echo base_url(); ?>web/account_profile" method="POST" enctype=multipart/form-data>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="pname" name="username"
                                    value="<?= $userInfo['username']; ?>" placeholder="UserName" required>
                                <label for="pname">Full Name</label>
                            </div>

                        </div>

                        <div class="col-xxl-6">

                            <div class="form-floating theme-form-floating">
                                <input type="email" class="form-control" id="email1" name="email_id"
                                    value="<?= $userInfo['email_id']; ?>" placeholder="Email Address">
                                <label for="email1">Email address</label>
                            </div>

                        </div>

                        <div class="col-xxl-6">

                            <div class="form-floating theme-form-floating">
                                <input class="form-control" type="tel" name="mobile" value="<?= $userInfo['mobile']; ?>"
                                    required placeholder="Phone Number" readonly id="mobile" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                <label for="mobile">Mobile</label>
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address1" name="address"
                                    value="<?= $userInfo['address']; ?>" required>
                                <label for="address1">Flat,House no.,Building,Company,Apartment</label>
                            </div>

                        </div>

                        <div class="col-12">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address2" placeholder="Locality" type="text"
                                    name="locality" value="<?= $userInfo['locality']; ?>" required>
                                <label for="address2">Area, Street, Sector, Village</label>
                            </div>

                        </div>

                        <div class="col-xxl-4">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="state" type="text" name="state"
                                    value="<?= $userInfo['state']; ?>" required>
                                <label for="floatingSelect">State</label>
                            </div>

                        </div>

                        <div class="col-xxl-4">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="city" type="text" name="city"
                                    value="<?= $userInfo['city']; ?>" required>
                                <label for="floatingSelect">Town/City</label>
                            </div>

                        </div>

                        <div class="col-xxl-4">

                            <div class="form-floating theme-form-floating">
                                <input type="text" class="form-control" id="address3" placeholder="Pincode"
                                    name="pincode" value="<?= $userInfo['pincode']; ?>" required>
                                <label for="address3">Pin Code</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" data-bs-dismiss="modal"
                        class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>

        </form>

    </div>
</div>
<!-- Edit Profile End -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    function order_detail(o_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>web/order_history/" + o_id,
            dataType: "JSON",
            success: function (result) {

                console.log(result);
                $('#pro').html(result);
            }
        });
    }

</script>

<script>

    $('.open-delete-modal').click(function () {
        var addressId = $(this).data('id');
        $('#delete_address_id').val(addressId);
    });


    $('#confirmDelete').click(function () {
        var addressId = $('#delete_address_id').val();

        $.ajax({
            url: '<?= base_url('web/delete_jail_address') ?>/' + addressId,
            type: 'POST',
            success: function (response) {

                $('#removeProfile').modal('hide');


                $('#removeAddress').modal('show');
            },
            error: function () {
                alert('Something went wrong. Try again!');
            }
        });
    });
</script>

<script>
$(document).ready(function () {
    $('.wishlist-button').on('click', function () {
        var button = $(this);
        var productId = button.data('product-id');
        var userId = button.data('user-id');

        $.ajax({
            url: '<?= base_url(); ?>web/remove_wishlist',
            type: 'POST',
            data: {
                product_id: productId,
                user_id: userId
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                  
                    button.closest('.col-6').fadeOut(300, function() {
                        $(this).remove();

                     
                        if ($('.col-6').length === 0) {
                            $('.row.g-3.g-sm-4').html(`
                                <div class="text-center py-5">
                                    <img style="height: 250px; width:100%; object-fit: contain;"
                                        src="<?= base_url(); ?>assets/img/imgpsh_fullsize_anim.jpg"
                                        alt="No Products">
                                    <p class="mt-3">No products in wishlist</p>
                                </div>
                            `);
                        }
                    });

                  
                    $('#no_of_wishlist_item').each(function () {
                        let currentCount = parseInt($(this).text()) || 0;
                        $(this).text(Math.max(0, currentCount - 1));
                    });

                    toastr.warning(response.message, '', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 2000,
                        positionClass: 'toast-top-right'
                    });

                } else {
                    toastr.info(response.message, '', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 2000,
                        positionClass: 'toast-top-right'
                    });
                }
            },
            error: function () {
                toastr.error('Failed to communicate with the server.', '', {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 2000,
                    positionClass: 'toast-top-right'
                });
            }
        });
    });
});
</script>

