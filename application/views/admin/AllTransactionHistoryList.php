<style>
    .wallet-card {
        background: #fff;

        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05)
    }

    .wallet-card table th,
    .wallet-card table td {
        text-align: center;
        vertical-align: middle
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
        <h1> Transaction History</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="wallet-card">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Date</th>
                                <th>User (Type)</th>
                                <th>Type</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Opening</th>
                                <th>Closing</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($transactions)): ?>
                                <?php $walletBalances = []; ?>

                                <?php foreach ($transactions as $row): ?>
                                    <?php
                                   
                                    if (!empty($row->wr_user_type) && !empty($row->wr_user_id))
                                    {
                                        $userTypeRow = ucfirst($row->wr_user_type);
                                        $userIdRow = $row->wr_user_id;
                                    } else
                                    {
                                        // Priority 2 → Order data
                                        if (isset($row->vendor_id) && $row->vendor_id > 0)
                                        {
                                            $userTypeRow = 'Vendor';
                                            $userIdRow = $row->vendor_id;
                                        } elseif (isset($row->promoter_id) && $row->promoter_id > 0)
                                        {
                                            $userTypeRow = 'Promoter';
                                            $userIdRow = $row->promoter_id;
                                        } elseif (isset($row->admin_id) && $row->admin_id > 0)
                                        {
                                            $userTypeRow = 'Admin';
                                            $userIdRow = $row->admin_id;
                                        } else
                                        {
                                            $userTypeRow = 'Unknown';
                                            $userIdRow = 0;
                                        }
                                    }

                                    if ($userTypeRow == 'Vendor')
                                    {
                                        $rand = $row->vendor_random_number ?? '-';
                                        $username = 'Vendor [' . $rand . ']';
                                    } elseif ($userTypeRow == 'Promoter')
                                    {
                                        $rand = $row->promoter_random_number ?? '-';
                                        $username = 'Promoter [' . $rand . ']';
                                    } elseif ($userTypeRow == 'Admin')
                                    {
                                        $username = 'Admin';
                                    } else
                                    {
                                        $username = 'Unknown';
                                    }


                                  
                                    if ($row->credit_amount > 0)
                                    {
                                        $amount = $row->credit_amount;
                                        $type = 'Credit';
                                        $displayAmount = '+' . $amount;
                                    } elseif ($row->debit_amount > 0)
                                    {
                                        $amount = $row->debit_amount;
                                        $type = 'Debit';
                                        $displayAmount = '-' . $amount;
                                    } else
                                    {
                                        $amount = 0;
                                        $type = '-';
                                        $displayAmount = 0;
                                    }


                                   
                                    $key = $userTypeRow . '_' . $userIdRow;
                                    $opening = $walletBalances[$key] ?? 0;

                                    if ($type == 'Credit')
                                    {
                                        $closing = $opening + $amount;
                                    } elseif ($type == 'Debit')
                                    {
                                        $closing = $opening - $amount;
                                    } else
                                    {
                                        $closing = $opening;
                                    }

                                    $walletBalances[$key] = $closing;

                                    $date = '-';
                                    if (!empty($row->created_at))
                                    {
                                        $date = date('d-M-Y', strtotime($row->created_at));
                                    } elseif (!empty($row->request_date))
                                    {
                                        $date = date('d-M-Y', strtotime($row->request_date));
                                    }
                                    ?>

                                    <tr>
                                        <td><?= $date; ?></td>
                                        <td><?= $username; ?></td>
                                        <td><?= $type; ?></td>
                                        <td><?= ucfirst($row->source ?? '-'); ?></td>
                                        <td>₹ <?= ($type == 'Credit') . number_format((float) $amount, 2); ?></td>
                                        <td>₹ <?= number_format((float) $opening, 2); ?></td>
                                        <td>₹ <?= number_format((float) $closing, 2); ?></td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No Transactions Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </section>

</div>