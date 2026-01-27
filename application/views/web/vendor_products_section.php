<div id="vendor-products-section">
    <div class="row mb-3">
        <!-- Filters Section -->
        <div class="col-md-3">
            <h6>Category</h6>
            <select id="category_filter" class="form-control">
                <option value="">All Categories</option>
                <?php foreach($categories as $cat){ ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3">
            <h6>Sub-Category</h6>
            <select id="sub_category_filter" class="form-control">
                <option value="">All Sub-Categories</option>
                <?php foreach($sub_categories as $sub){ ?>
                    <option value="<?= $sub['id'] ?>"><?= $sub['sub_category_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3">
            <h6>Price</h6>
            <input type="number" id="price_filter" class="form-control" placeholder="Max Price">
        </div>
        <div class="col-md-3">
            <h6>Rating</h6>
            <select id="rating_filter" class="form-control">
                <option value="">All Ratings</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars & Up</option>
                <option value="3">3 Stars & Up</option>
            </select>
        </div>
    </div>

    <!-- Product List -->
    <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
        <?php foreach($products as $p){ ?>
            <div>
                <div class="product-box-3 h-100 wow fadeInUp">
                    <div class="product-header">
                        <div class="product-image">
                            <a href="#">
                                <img src="<?= !empty($p['main_image']) ? base_url($p['main_image']) : base_url('assets/no-image.png') ?>" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="product-footer">
                        <div class="product-detail">
                            <a href="#"><h5 class="name"><?= $p['product_name'] ?></h5></a>
                            <p class="text-content mt-1 mb-2 product-content"><?= $p['product_description'] ?></p>
                            <div class="product-rating mt-2">
                                <ul class="rating">
                                    <?php for($i=1;$i<=5;$i++){ ?>
                                        <li>
                                            <svg width="24" height="24" fill="<?= $i <= 4 ? 'currentColor' : 'none' ?>" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <span>(4.0)</span>
                            </div>
                            <h5 class="price"><span class="theme-color">$<?= $p['final_price'] ?></span></h5>
                            <div class="add-to-cart-box bg-white">
                                <button class="btn btn-add-cart addcart-button">Add
                                    <span class="add-icon bg-light-gray"><i class="fa-solid fa-plus"></i></span>
                                </button>
                                <div class="cart_qty qty-box">
                                    <div class="input-group bg-white">
                                        <button type="button" class="qty-left-minus bg-gray" data-type="minus" data-field="">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input class="form-control input-number qty-input" type="text" name="quantity" value="0">
                                        <button type="button" class="qty-right-plus bg-gray" data-type="plus" data-field="">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
