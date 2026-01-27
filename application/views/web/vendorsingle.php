<?php foreach ($vendors as $v)
{ ?>
    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-12">
        <div class="vendor-card h-100">
            <div class="vendor-top">
                <div class="vendor-image">
                    <img src="<?= !empty($v['profile_pic']) ? base_url($v['profile_pic']) : base_url('assets/no-image.png') ?>"
                        class="img-fluid" alt="">
                </div>
                <div class="vendor-info">
                    <h5 class="vendor-name"><?= $v['name']; ?></h5>
                    <span class="vendor-city">
                        <img width="30" height="30" src="https://img.icons8.com/glyph-neue/64/fb5808/place-marker.png"
                            alt="place-marker" />
                        <?= $v['city']; ?>, <?= $v['state']; ?>
                    </span>
                </div>
            </div>
            <div class="vendor-footer">
                <span class="text-black fs-6">Products</span>
                <strong><span class="text-black fs-6">Total : </span> <?= $v['total_products']; ?></strong>
            </div>
        </div>
    </div>
<?php } ?>