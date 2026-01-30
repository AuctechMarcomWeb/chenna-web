<div class="content-wrapper">
    <div class="container-fluid">
        <h3 class="mb-4">Earnings Dashboard</h3>

        <!-- Filters -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-2">
                <input type="month" name="month" id="month" class="form-control"
                    value="<?= $this->input->get('month') ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="<?= $this->input->get('from_date') ?>">
            </div>
            <div class="col-md-2">
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="<?= $this->input->get('to_date') ?>">
            </div>

            <?php if ($adminData['Type'] == 1): ?>
                <div class="col-md-3">
                    <select name="vendor_id" id="vendor_id" class="form-control">
                        <option value="">All Vendors</option>
                        <?php foreach ($vendors as $v): ?>
                            <option value="<?= $v->id ?>"><?= $v->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
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
                    <!-- Admin Cards -->
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3 id="total_earning">₹<?= number_format($summary['total_earning'], 2) ?></h3>
                                <p>Total Earning</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($adminData['Type'] != 3): ?>
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
                <?php endif; ?>

                <?php if ($adminData['Type'] != 2): ?>
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
                <?php endif; ?>

                <!-- Common Cards -->
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
                            <h3 id="pending_orders"><?= $summary['pending_orders'] ?></h3>
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

function updateDashboard() {
    const formData = new FormData(form);

    fetch('<?= base_url("admin/EarningsDashboard/getSummaryAjax") ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const setText = (id, value) => {
            const el = document.getElementById(id);
            if(el) el.innerText = value;
        };

        // Main totals
        setText('total_earning', '₹' + (parseFloat(data.total_earning) || 0).toFixed(2));
        setText('vendor_earning', '₹' + (parseFloat(data.vendor_earning) || 0).toFixed(2));
        setText('promoter_earning', '₹' + (parseFloat(data.promoter_earning) || 0).toFixed(2));
        setText('total_orders', data.total_orders || 0);
        setText('pending_orders', data.pending_orders || 0);

        // Filtered totals (dynamic according to month/date/vendor/promoter)
        setText('total_vendors', data.total_vendors || 0);
        setText('total_promoters', data.total_promoters || 0);
        setText('total_products', data.total_products || 0);

        // Month/date-wise added counts
        setText('total_vendors_added', data.total_vendors_added || 0);
        setText('total_promoters_added', data.total_promoters_added || 0);
        setText('total_products_added', data.total_products_added || 0);
    })
    .catch(err => console.error('Error updating dashboard:', err));
}

// Filter event listeners
monthInput.addEventListener('change', () => {
    fromDateInput.value = '';
    toDateInput.value = '';
    updateDashboard();
});

[fromDateInput, toDateInput].forEach(el => el.addEventListener('change', () => {
    monthInput.value = '';
    if(fromDateInput.value && toDateInput.value) updateDashboard();
}));

vendorInput.addEventListener('change', () => {
    promoterInput.value = '';
    updateDashboard();
});

promoterInput.addEventListener('change', () => {
    const promoterId = promoterInput.value;
    fetch('<?= base_url("admin/EarningsDashboard/getVendorsByPromoter") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ promoter_id: promoterId })
    })
    .then(res => res.json())
    .then(data => {
        let html = '<option value="">Select Vendor</option>';
        data.forEach(v => html += `<option value="${v.id}">${v.name}</option>`);
        vendorInput.innerHTML = html;
        updateDashboard();
    })
    .catch(err => console.error('Error fetching vendors:', err));
});

// Initial load
updateDashboard();
</script>

