<div class="content-wrapper">
    <div class="container-fluid">
        <h3 class="mb-4">Earnings Dashboard</h3>

        <!-- Filters -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-2">
                <label for="">Month</label>
                <input type="month" name="month" id="month" class="form-control"
                    value="<?= $this->input->get('month') ?>">
            </div>
            <div class="col-md-2">
                <label for="">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="<?= $this->input->get('from_date') ?>">
            </div>
            <div class="col-md-2">
                <label for="">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="<?= $this->input->get('to_date') ?>">
            </div>

            <?php if ($adminData['Type'] == 1): ?>
                <div class="col-md-3">
                    <label for="">Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="form-control">
                        <option value="">All Vendors</option>
                        <?php foreach ($vendors as $v): ?>
                            <option value="<?= $v->id ?>"><?= $v->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Promoters</label>
                    <select name="promoter_id" id="promoter_id" class="form-control">
                        <option value="">All Promoters</option>
                        <?php foreach ($promoters as $p): ?>
                            <option value="<?= $p->id ?>"><?= $p->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

        </form>
    </div>

    <!-- Dashboard Cards -->
    <div id="dashboard-cards">
        <section class="content">
            <div class="row">

                <?php if ($adminData['Type'] == 1): ?>
                    <!-- ================= ADMIN ================= -->

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3 id="total_earning">₹<?= number_format($summary['total_earning'], 2) ?></h3>
                                <p>Total Earning</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 id="total_orders"><?= $summary['total_orders'] ?></h3>
                                <p>Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3 id="pending_orders"><?= $summary['total_pending'] ?></h3>
                                <p>Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3 id="total_products"><?= $summary['total_products'] ?></h3>
                                <p>Total Products</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3 id="total_vendors"><?= $summary['total_vendors'] ?></h3>
                                <p>Total Vendors</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3 id="vendor_earning">₹<?= number_format($summary['vendor_earning'], 2) ?></h3>
                                <p>Vendor Earning</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-teal">
                            <div class="inner">
                                <h3 id="total_promoters"><?= $summary['total_promoters'] ?></h3>
                                <p>Total Promoters</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3 id="promoter_earning">₹<?= number_format($summary['promoter_earning'], 2) ?></h3>
                                <p>Promoter Earning</p>
                            </div>
                        </div>
                    </div>

                <?php elseif ($adminData['Type'] == 2): ?>
                    <!-- ================= VENDOR ================= -->

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 id="total_orders"><?= $summary['total_orders'] ?></h3>
                                <p>Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3 id="pending_orders"><?= $summary['total_pending'] ?></h3>
                                <p>Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3 id="total_products"><?= $summary['total_products'] ?></h3>
                                <p>Total Products</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3 id="vendor_earning">₹<?= number_format($summary['vendor_earning'], 2) ?></h3>
                                <p>Vendor Earning</p>
                            </div>
                        </div>
                    </div>

                <?php elseif ($adminData['Type'] == 3): ?>
                    <!-- ================= PROMOTER ================= -->

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 id="total_orders"><?= $summary['total_orders'] ?></h3>
                                <p>Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3 id="pending_orders"><?= $summary['total_pending'] ?></h3>
                                <p>Pending Orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3 id="total_products"><?= $summary['total_products'] ?></h3>
                                <p>Total Products</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3 id="promoter_earning">₹<?= number_format($summary['promoter_earning'], 2) ?></h3>
                                <p>Promoter Earning</p>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </section>
    </div>
</div>

<script>
    const form = document.getElementById('filterForm');
    const monthInput = document.getElementById('month');
    const fromDateInput = document.getElementById('from_date');
    const toDateInput = document.getElementById('to_date');
    const vendorInput = document.getElementById('vendor_id');
    const promoterInput = document.getElementById('promoter_id');


    const boxTotalVendors = document.querySelector('.small-box.bg-purple');
    const boxVendorEarning = document.querySelector('.small-box.bg-red');
    const boxTotalPromoters = document.querySelector('.small-box.bg-teal');
    const boxPromoterEarning = document.querySelector('.small-box.bg-green');


    function updateDashboard() {
        const formData = new FormData(form);

        fetch('<?= base_url("admin/EarningsDashboard/getSummaryAjax") ?>', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                const setText = (id, val) => {
                    const el = document.getElementById(id);
                    if (el) el.innerText = val;
                };

                setText('total_earning', '₹' + (+data.total_earning || 0).toFixed(2));
                setText('vendor_earning', '₹' + (+data.vendor_earning || 0).toFixed(2));
                setText('promoter_earning', '₹' + (+data.promoter_earning || 0).toFixed(2));

                setText('total_orders', data.total_orders || 0);
                setText('pending_orders', data.pending_orders || 0);
                setText('total_vendors', data.total_vendors || 0);
                setText('total_promoters', data.total_promoters || 0);
                setText('total_products', data.total_products || 0);

                /* ================= CONDITIONAL BOX VISIBILITY ================= */
                const isVendorSelected = vendorInput.value;
                const isPromoterSelected = promoterInput.value;


                if (isVendorSelected) {
                    if (boxTotalVendors) boxTotalVendors.style.display = 'none';
                    if (boxTotalPromoters) boxTotalPromoters.style.display = 'none';
                    if (boxPromoterEarning) boxPromoterEarning.style.display = 'none';
                    if (boxVendorEarning) boxVendorEarning.style.display = 'block';
                }

                else if (isPromoterSelected) {
                    if (boxTotalVendors) boxTotalVendors.style.display = 'block';
                    if (boxTotalPromoters) boxTotalPromoters.style.display = 'block';
                    if (boxPromoterEarning) boxPromoterEarning.style.display = 'block';
                    if (boxVendorEarning) boxVendorEarning.style.display = 'block';
                }

                else {
                    if (boxTotalVendors) boxTotalVendors.style.display = 'block';
                    if (boxTotalPromoters) boxTotalPromoters.style.display = 'block';
                    if (boxPromoterEarning) boxPromoterEarning.style.display = 'block';
                    if (boxVendorEarning) boxVendorEarning.style.display = 'block';
                }
            })
            .catch(err => console.error('Dashboard Error:', err));
    }


    function resetDateRange() { fromDateInput.value = ''; toDateInput.value = ''; }
    function resetMonth() { monthInput.value = ''; }
    function resetVendor() { if (vendorInput) vendorInput.value = ''; }
    function resetPromoter() { if (promoterInput) promoterInput.value = ''; }


    monthInput?.addEventListener('change', () => { resetDateRange(); updateDashboard(); });
    [fromDateInput, toDateInput].forEach(el => el?.addEventListener('change', () => {
        if (fromDateInput.value && toDateInput.value) { resetMonth(); updateDashboard(); }
    }));

    vendorInput?.addEventListener('change', () => {
        resetPromoter();
        updateDashboard();
    });

    promoterInput?.addEventListener('change', () => {
        const promoterId = promoterInput.value;
        resetVendor();


        const payload = {
            promoter_id: promoterId,
            month: monthInput.value,
            from_date: fromDateInput.value,
            to_date: toDateInput.value
        };

        fetch('<?= base_url("admin/EarningsDashboard/getVendorsByPromoter") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(data => {
                if (!vendorInput) return;

                let html = '<option value="">All Vendors</option>';
                data.forEach(v => { html += `<option value="${v.id}">${v.name}</option>`; });

                vendorInput.innerHTML = html;
                updateDashboard();
            })
            .catch(err => console.error('Vendor Load Error:', err));
    });


    updateDashboard();
</script>