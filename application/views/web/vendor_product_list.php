<style>
    .buy-button {
        background: #fff !important;
        color: #d80101 !important;
        border: 1px solid #ff4f4f21 !important;
        font-weight: 600;
        border-radius: 25px !important;
        padding: 7px 15px !important;
        font-size: 13px;
    }

    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card img {
        width: 100%;
        height: 150px;
        object-fit: contain;
        display: block;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        height: 150px;
    }

    .product-image img {
        width: 100%;
        object-fit: contain;
    }

    small {
        font-size: 100%;
    }

    .product-name {
        font-size: 0.95rem;
        font-weight: 500;
    }


    .product-rating small {
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .product-image {
            height: 180px;
        }
    }

    @media (max-width: 576px) {
        .product-image {
            height: 150px;
        }
    }

    .btn-warning {
        color: #000;
        background-color: #ffca2c;
        border-color: #ffc720;
    }
</style>


<div class="row g-3">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $p): ?>
            <div class="col-12 col-sm-6 col-lg-2">
                <div class="product-card border rounded shadow-sm h-100 d-flex flex-column">

                    <!-- IMAGE -->
                    <div class="product-image position-relative overflow-hidden">
                        <a href="<?= base_url('product/' . $p['id']); ?>">
                            <img src="<?= base_url('assets/product_images/' . $p['main_image']) ?>"
                                alt="<?= $p['product_name'] ?>" class="mt-2">
                        </a>
                    </div>

                    <!-- DETAILS -->
                    <div class="product-details p-3 flex-grow-1 d-flex flex-column">
                        <h6 class="product-name mb-2"><?= $p['product_name'] ?></h6>

                      
                        <div class="product-rating mb-2">
                            <?php $avg = round($p['avg_rating']); ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa fa-star <?= $i <= $avg ? 'text-warning' : 'text-muted' ?>"></i>
                            <?php endfor; ?>
                            <small>(<?= !empty($p['avg_rating']) ? number_format($p['avg_rating'], 1) : 0 ?>)</small>
                        </div>

                        <!-- PRICE -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-danger fw-bold mb-0">₹<?= $p['final_price'] ?></h6>
                            <small class="text-muted"><del><?= !empty($p['price']) ? '₹' . $p['price'] : '' ?></del></small>
                        </div>

                        <!-- SIZE -->
                        <!-- <div class="mb-3">
                        <span class="badge bg-light text-dark border"><?= $p['size'] ?></span>
                        </div> -->

                        <!-- BUTTON -->
                        <button class="buy-button btn w-100" onclick="add_cart(<?= $p['id'] ?>)">Add to Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 d-flex justify-content-center align-items-center py-5">
            <div class="card border-0 text-center p-5" style="max-width:600px;">
                <img src="<?= base_url('plugins/images/3081840.png') ?>" class="img-fluid mb-4" style="max-height:250px;">
                <h3 class="text-muted mb-4">Oops! No Products Available 😔</h3>
                <a href="<?= base_url(); ?>" class="btn btn-warning text-white px-5 py-2">
                    <i class="fa fa-home me-2"></i> Back to Home
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>