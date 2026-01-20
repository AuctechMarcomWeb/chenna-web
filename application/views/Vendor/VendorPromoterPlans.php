<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 22px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 5px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #47b6d5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .badge {
        display: inline-block;

        width: 80px;
        height: 23px !important;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #00a613;
        border-radius: 50px;
    }
</style>

<div class="content-wrapper">
   <section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">My Subscription Plan</h3>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>User Type</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Plan Type</th>
                                <th>Status</th>
                                <th>Approval</th>
                                <th>Product Limit</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($subscriptions)): ?>
                                <?php $i = 1; foreach ($subscriptions as $sub): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td>
                                            <span class="badge <?= $sub['user_type'] == 'Vendor' ? 'bg-primary' : 'bg-success'; ?>">
                                                <?= $sub['user_type']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?= $sub['user_name']; ?>
                                            <?php if (!empty($sub['shop_name'])): ?>
                                                <small class="text-muted">(<?= $sub['shop_name']; ?>)</small>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= $sub['email']; ?></td>

                                        <td>
                                            <span class="badge <?= $sub['plan_type'] == 1 ? 'bg-info' : 'bg-warning'; ?>">
                                                <?= $sub['plan_type'] == 1 ? 'Monthly' : 'Per Product'; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php
                                            $today = date('Y-m-d');

                                            if ($sub['approval_status'] == 0) {
                                                echo '<span class="text-warning">Pending</span>';
                                            } elseif ($sub['approval_status'] == 2) {
                                                echo '<span class="text-danger">Rejected</span>';
                                            } else {
                                                if (!empty($sub['end_date']) && $sub['end_date'] < $today) {
                                                    echo '<span class="text-danger">Expired</span>';
                                                } else {
                                                    echo '<span class="text-success">Active</span>';
                                                }
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($sub['approval_status'] == 1)
                                                echo '<span class="badge bg-success">Approved</span>';
                                            elseif ($sub['approval_status'] == 0)
                                                echo '<span class="badge bg-warning">Pending</span>';
                                            else
                                                echo '<span class="badge bg-danger">Rejected</span>';
                                            ?>
                                        </td>

                                        <td><?= $sub['product_limit'] ?? 'Unlimited'; ?></td>

                                        <td>
                                            <?= $sub['product_limit'] !== null
                                                ? max(0, $sub['product_limit'] - $sub['products_used'])
                                                : 'Unlimited'; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        No subscription plan found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>









<script>
    $(document).ready(function () {
        $('#tableProductItem').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel'
            ],
            scrollX: true,
            pageLength: 20
        });
    });
</script>