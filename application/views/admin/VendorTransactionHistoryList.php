<style>
    .wallet-card {
        background: #fff;

        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05)
    }


    .badge {
        padding: 6px 12px;
        border-radius: 20px
    }

    .badge-warning {
        background: #f39c12;
        color: #fff
    }

    .badge-success {
        background: #28a745;
        color: #fff
    }

    .badge-danger {
        background: #dc3545;
        color: #fff
    }

    .modal-header .close {
        margin-top: -24px;
    }

    .close {
        color: white;
        opacity: 0.10;
        opacity: inherit;
    }

    button.close {
        width: 30px;
        height: 30px;
        border-radius: 50px;
        background: #dd4b39;
    }

    .close:hover {
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: inherit;
        background: red;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Transaction History</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="wallet-card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>S.No</th>
                                    <th>Transaction Type</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Source</th>
                                    <th>Remarks</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($transactions)): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($transactions as $row): ?>
                                        <tr
                                            class="<?= $row->debit_amount > 0 ? 'table-warning' : ($row->credit_amount > 0 ? 'table-success-light' : '') ?>">
                                            <td><?= $i++ ?></td>

                                            <td class="text-start">
                                                <?php if ($row->credit_amount > 0 && !empty($row->product_id) && !empty($row->product_name)): ?>
                                                    <div class="d-flex align-items-center gap-3 text-nowrap">

                                                        <span class="fw-bold text-black" style="min-width:95px;">
                                                            <b>Product Sell :</b>
                                                        </span>

                                                        <?php
                                                        $img = !empty($row->product_image)
                                                            ? base_url('assets/product_images/' . $row->product_image)
                                                            : base_url('assets/img/no-image.jpg');
                                                        ?>
                                                        <img src="<?= $img ?>" class="rounded"
                                                            style="width:70px;height:auto;object-fit:contain;border:1px solid #dd4b39;border-radius:5px;padding:4px;">

                                                        <span class="small fw-medium">
                                                            Price : ₹
                                                            <?php
                                                            $type = $this->session->userdata('adminData')['Type'] ?? 0;

                                                            if ($type == 2)
                                                            {          // Vendor
                                                                echo number_format($row->vendor_amount, 2);
                                                            } elseif ($type == 3)
                                                            {    // Promoter
                                                                echo number_format($row->promoter_amount, 2);
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>

                                                <?php elseif (stripos($row->remark ?? '', 'withdrawal') !== false): ?>
                                                    <strong class="text-danger">Withdrawal from Wallet to Bank</strong>

                                                <?php else: ?>
                                                    <?= htmlspecialchars($row->transaction_type ?? 'Other Transaction') ?>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Debit -->
                                            <td class="fw-bold text-danger text-end">
                                                <?= $row->debit_amount > 0 ? '₹ ' . number_format($row->debit_amount, 2) : '—' ?>
                                            </td>

                                            <!-- Credit -->
                                            <td class="fw-bold text-success text-end">
                                                <?php
                                                $type = $this->session->userdata('adminData')['Type'] ?? 0;

                                                if ($row->credit_amount > 0 && !empty($row->product_id))
                                                {

                                                    if ($type == 2)
                                                    {
                                                        echo '₹ ' . number_format($row->vendor_amount, 2);
                                                    } elseif ($type == 3)
                                                    {
                                                        echo '₹ ' . number_format($row->promoter_amount, 2);
                                                    }

                                                } else
                                                {
                                                    echo ($row->credit_amount > 0) ? '₹ ' . number_format($row->credit_amount, 2) : '—';
                                                }
                                                ?>
                                            </td>

                                            <!-- Source -->
                                            <td>
                                                <?php
                                                if ($row->credit_amount > 0 && !empty($row->product_id))
                                                {
                                                    echo '<span>Order</span>';
                                                } elseif (stripos($row->remark ?? '', 'withdrawal') !== false)
                                                {
                                                    echo '<span>Withdrawal</span>';
                                                } elseif (stripos($row->remark ?? '', 'monthly') !== false)
                                                {
                                                    echo '<span>Monthly Fund</span>';
                                                } else
                                                {
                                                    echo ucfirst($row->source ?? '-');
                                                }
                                                ?>
                                            </td>

                                            <!-- Remark -->
                                            <td>
                                                <?php
                                                if ($row->credit_amount > 0 && $row->product_id && $row->product_name)
                                                {
                                                    echo 'Product Sell';
                                                } else
                                                {
                                                    echo htmlspecialchars($row->remark ?? 'Withdrawal');
                                                }
                                                ?>
                                            </td>

                                            <!-- Date -->
                                            <td><?= date('d M Y h:i:s A', strtotime($row->created_at ?? '')) ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-wallet2 fs-1 text-muted"></i>
                                                <h5 class="mt-3 text-muted">No transactions yet</h5>
                                                <small class="text-muted">Your wallet transaction history will appear
                                                    here</small>
                                            </div>
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