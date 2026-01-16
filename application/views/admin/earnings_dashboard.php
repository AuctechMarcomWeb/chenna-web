<div class="content-wrapper">
    <div class="container-fluid">
        <h3 class="mb-4">Earnings Dashboard</h3>

        <!-- ================= FILTERS ================= -->
        <form method="get" id="filterForm" class="row mb-4">
            <div class="col-md-3">
                <label>Month</label>
                <input type="month" name="month" id="month" class="form-control"
                    value="<?= $this->input->get('month'); ?>">
            </div>

            <div class="col-md-3">
                <label>Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-control">
                    <option value="">All Vendors</option>
                    <?php foreach ($vendors as $v): ?>
                        <option value="<?= $v->id ?>" <?= ($this->input->get('vendor_id') == $v->id) ? 'selected' : '' ?>>
                            <?= $v->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="<?= $this->input->get('from_date'); ?>">
            </div>

            <div class="col-md-3">
                <label>To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="<?= $this->input->get('to_date'); ?>">
            </div>
        </form>
    </div>

    <section class="content">
        <div class="row">

            <!-- ================= ADMIN DASHBOARD ================= -->
            <?php if ($adminData['Type'] == 1): ?>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>₹ <?= number_format($summary['total_earning'], 2) ?></h3>
                            <p>Total Earning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3><?= $summary['total_vendors'] ?></h3>
                            <p>Total Vendors</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>₹ <?= number_format($summary['vendor_earning'], 2) ?></h3>
                            <p>Total Vendor Earning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= $summary['total_orders'] ?></h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= $summary['total_products'] ?></h3>
                            <p>Total Products</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ================= VENDOR DASHBOARD ================= -->
            <?php if ($adminData['Type'] == 2): ?>
                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>₹ <?= number_format($summary['vendor_earning'], 2) ?></h3>
                            <p>Total Vendor Earning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= $summary['total_orders'] ?></h3>
                            <p>Total Orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= $summary['total_products'] ?></h3>
                            <p>Total Products</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>
</div>
<script>
const form = document.getElementById('filterForm');
const monthInput = document.getElementById('month');
const fromDateInput = document.getElementById('from_date');
const toDateInput = document.getElementById('to_date');
const vendorInput = document.getElementById('vendor_id');

// ===== PAGE LOAD CHECK =====
window.addEventListener('DOMContentLoaded', () => {
    // Agar month set hai → reset from/to/vendor
    if(monthInput && monthInput.value !== '') {
        if(fromDateInput) fromDateInput.value = '';
        if(toDateInput) toDateInput.value = '';
        if(vendorInput) vendorInput.value = '';
    } 
    // Agar date range set hai → reset month
    else if((fromDateInput && fromDateInput.value !== '') || (toDateInput && toDateInput.value !== '')) {
        if(monthInput) monthInput.value = '';
    }
});

// ===== ON CHANGE EVENTS =====

// Month select → reset from/to date + vendor
if(monthInput){
    monthInput.addEventListener('change', function () {
        if(fromDateInput) fromDateInput.value = '';
        if(toDateInput) toDateInput.value = '';
        if(vendorInput) vendorInput.value = '';
        form.submit();
    });
}

// From date → reset month
if(fromDateInput){
    fromDateInput.addEventListener('change', function () {
        if(monthInput) monthInput.value = '';
        form.submit();
    });
}

// To date → reset month
if(toDateInput){
    toDateInput.addEventListener('change', function () {
        if(monthInput) monthInput.value = '';
        form.submit();
    });
}

// Vendor select → reset month + from/to date
if(vendorInput){
    vendorInput.addEventListener('change', function () {
        if(monthInput) monthInput.value = '';
        if(fromDateInput) fromDateInput.value = '';
        if(toDateInput) toDateInput.value = '';
        form.submit();
    });
}
</script>


