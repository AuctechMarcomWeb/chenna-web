<div class="content-wrapper">
    <div class="container-fluid">
        <h3 class="mb-4">Subs / Advertisement Earnings Dashboard</h3>
        <br>
        <!-- Filters -->
        <form id="filterForm" class="row g-3 mb-4">
            <div class="col-md-2">
                <label>Month</label>
                <input type="month" name="month" id="month" class="form-control"
                    value="<?= $this->input->get('month') ?>">
            </div>
            <div class="col-md-2">
                <label>From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control"
                    value="<?= $this->input->get('from_date') ?>">
            </div>
            <div class="col-md-2">
                <label>To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control"
                    value="<?= $this->input->get('to_date') ?>">
            </div>
            <div class="col-md-2">
                <label>Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="">All</option>
                    <option value="subscription">Subscriptions Earning</option>
                    <option value="advertisement">Advertisements Earning</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>Monthly / Per Product Plan Earning </label>
                <select name="subscription_type" id="subscription_type" class="form-control">
                    <option value="">All</option>
                    <option value="subscription">Monthly Earning</option>
                    <option value="advertisement">Per Product Earning</option>
                </select>
            </div>
            <div class="col-md-1">
                <label>Promoter</label>
                <select name="promoter_id" id="promoter_id" class="form-control">
                    <option value="">All Promoters</option>
                    <?php foreach ($promoters as $p): ?>
                        <option value="<?= $p->id ?>"><?= $p->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1">
                <label>Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-control">
                    <option value="">All Vendors</option>
                    <?php foreach ($vendors as $v): ?>
                        <option value="<?= $v->id ?>"><?= $v->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
        <br>
        <!-- Dashboard Cards -->
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 id="total_earning">₹0.00</h3>
                        <p>Total Earning</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-yellow" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_subscriptions">0</h3>
                        <p>All Subscriptions</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-red" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_monthly_subscriptions">0</h3>
                        <p>Monthly Subscriptions</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-green" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_per_product_subscriptions">0</h3>
                        <p>Per Product Subscriptions</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-purple" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_monthly_active_subscriptions">0</h3>
                        <p>Monthly Active Subscriptions</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-teal" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_per_product_active_subscriptions">0</h3>
                        <p>Per Product Active Subscriptions</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-maroon" id="subscription_card">
                    <div class="inner">
                        <h3 id="total_sub_earning">₹0.00</h3>
                        <p>Total Subscription Earnings</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-orange" id="advertisement_card">
                    <div class="inner">
                        <h3 id="total_advertisements">0</h3>
                        <p>All Advertisement </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-light-blue" id="advertisement_card">
                    <div class="inner">
                        <h3 id="total_active_advertisements">0</h3>
                        <p>Active Advertisement </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-red" id="advertisement_card">
                    <div class="inner">
                        <h3 id="total_pending_advertisements">0</h3>
                        <p>Pending Advertisement </p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-navy" id="advertisement_card">
                    <div class="inner">
                        <h3 id="total_adv_earning">₹0.00</h3>
                        <p>Total Advertisement Earnings</p>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 totalVendorCard">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3 id="total_vendors">0</h3>
                        <p>Total Vendors</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 totalPromoterCard">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3 id="total_promoters">0</h3>
                        <p>Total Promoters</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        const form = document.getElementById("filterForm");

        const monthInput = document.getElementById("month");
        const fromDateInput = document.getElementById("from_date");
        const toDateInput = document.getElementById("to_date");

        const vendorInput = document.getElementById("vendor_id");
        const promoterInput = document.getElementById("promoter_id");

        const typeInput = document.getElementById("type");
        const subscriptionTypeInput = document.getElementById("subscription_type");

        /* -----------------------------
           Dashboard Data Load
        ----------------------------- */
        function updateDashboard() {

            const formData = new FormData(form);

            fetch('<?= base_url("admin/SubscriptionAdvertismentEarningDashboard/getSummaryAjax") ?>', {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {

                    const setText = (id, val) => {
                        const el = document.getElementById(id);
                        if (el) el.innerText = val;
                    };

                    /* -----------------------------
                       Amounts
                    ----------------------------- */
                    setText('total_earning', '₹' + (+data.total_earning || 0).toFixed(2));
                    setText('total_sub_earning', '₹' + (+data.total_sub_earning || 0).toFixed(2));
                    setText('total_adv_earning', '₹' + (+data.total_adv_earning || 0).toFixed(2));

                    /* -----------------------------
                       Subscription Counts
                    ----------------------------- */
                    setText('total_subscriptions', data.total_subscriptions || 0);
                    setText('total_monthly_subscriptions', data.total_monthly_subscriptions || 0);
                    setText('total_per_product_subscriptions', data.total_per_product_subscriptions || 0);
                    setText('total_monthly_active_subscriptions', data.total_monthly_active_subscriptions || 0);
                    setText('total_per_product_active_subscriptions', data.total_per_product_active_subscriptions || 0);

                    /* -----------------------------
                       Advertisement Counts
                    ----------------------------- */
                    setText('total_advertisements', data.total_advertisements || 0);
                    setText('total_active_advertisements', data.total_active_advertisements || 0);
                    setText('total_pending_advertisements', data.total_pending_advertisements || 0);

                    /* -----------------------------
                       Other
                    ----------------------------- */
                    setText('total_vendors', data.total_vendors || 0);
                    setText('total_promoters', data.total_promoters || 0);

                    /* -----------------------------
                       Type Based Hide
                    ----------------------------- */
                    const type = typeInput.value;

                    document.querySelectorAll("#subscription_card").forEach(card => {
                        card.style.display = (type === "advertisement") ? "none" : "block";
                    });

                    document.querySelectorAll("#advertisement_card").forEach(card => {
                        card.style.display = (type === "subscription") ? "none" : "block";
                    });

                    /* -----------------------------
                       Vendor / Promoter Hide Logic
                    ----------------------------- */

                    const vendorSelected = vendorInput.value;
                    const promoterSelected = promoterInput.value;

                    const vendorCards = document.querySelectorAll(".totalVendorCard");
                    const promoterCards = document.querySelectorAll(".totalPromoterCard");

                    if (vendorSelected) {
                        vendorCards.forEach(c => c.style.display = "none");
                        promoterCards.forEach(c => c.style.display = "none");
                    }
                    else if (promoterSelected) {
                        vendorCards.forEach(c => c.style.display = "block");
                        promoterCards.forEach(c => c.style.display = "none");
                    }
                    else {
                        vendorCards.forEach(c => c.style.display = "block");
                        promoterCards.forEach(c => c.style.display = "block");
                    }

                })
                .catch(err => console.log("Dashboard Error:", err));
        }

        /* -----------------------------
           Month vs Date (Only one)
        ----------------------------- */
        monthInput?.addEventListener("change", function () {
            fromDateInput.value = "";
            toDateInput.value = "";
            updateDashboard();
        });

        [fromDateInput, toDateInput].forEach(el => {
            el?.addEventListener("change", function () {
                monthInput.value = "";
                updateDashboard();
            });
        });

        /* -----------------------------
           Vendor Change
        ----------------------------- */
        vendorInput?.addEventListener("change", function () {
            promoterInput.value = "";
            updateDashboard();
        });

        /* -----------------------------
           Promoter Change
        ----------------------------- */
        promoterInput?.addEventListener("change", function () {

            vendorInput.value = "";

            fetch('<?= base_url("admin/SubscriptionAdvertismentEarningDashboard/getVendorsByPromoter") ?>', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ promoter_id: this.value })
            })
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">All Vendors</option>';
                    data.forEach(v => {
                        html += `<option value="${v.id}">${v.name}</option>`;
                    });
                    vendorInput.innerHTML = html;
                    updateDashboard();
                })
                .catch(err => console.log(err));
        });

        /* -----------------------------
           Other Filters
        ----------------------------- */
        [typeInput, subscriptionTypeInput].forEach(el => {
            el?.addEventListener("change", updateDashboard);
        });

        /* First Time Load */
        updateDashboard();

    });
</script>