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
        <h1>Full Transaction History</h1>
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
                                <?php $walletBalances = [];?>
                                <?php foreach ($transactions as $row): ?>
                                    <?php
                                 
                                    if (!empty($row->wr_user_type))
                                    {
                                        $userTypeRow = $row->wr_user_type;
                                        $userIdRow = $row->wr_user_id;
                                    } else
                                    {
                                        if (!empty($row->vendor_id))
                                        {
                                            $userTypeRow = 'Vendor';
                                            $userIdRow = $row->vendor_id;
                                        } elseif (!empty($row->promoter_id))
                                        {
                                            $userTypeRow = 'Promoter';
                                            $userIdRow = $row->promoter_id;
                                        } elseif (!empty($row->admin_id))
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
                                        $username = 'Vendor [' . ($row->vendor_random_number ?? '-') . ']';
                                    } elseif ($userTypeRow == 'Promoter')
                                    {
                                        $username = 'Promoter [' . ($row->promoter_random_number ?? '-') . ']';
                                    } elseif ($userTypeRow == 'Admin')
                                    {
                                        $username = 'Chenna';
                                    } else
                                    {
                                        $username = 'Unknown';
                                    }

                                 
                                    if (in_array($row->transaction_type, ['wallet_credit', 'order']))
                                    {
                                        $amount = $row->credit_amount ?? 0;
                                        $type = 'Credit';
                                        $displayAmount = '+' . $amount;
                                    } elseif (in_array($row->transaction_type, ['wallet_debit', 'withdrawal']))
                                    {
                                        $amount = $row->debit_amount ?? 0;
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

                                   
                                    $refId = $row->wr_order_id ?? $row->order_id ?? '-';
                                    $date = date('d-M-Y', strtotime($row->created_at ?? $row->request_date));
                                    ?>
                                    <tr>
                                        <td><?= $date; ?></td>
                                        <td><?= $username; ?></td>
                                        <td><?= $type; ?></td>
                                        <td><?= ucfirst($row->source ?? '-'); ?></td>

                                        <td><?= number_format($displayAmount, 2); ?></td>
                                        <td><?= number_format($opening, 2); ?></td>
                                        <td><?= number_format($closing, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No Transactions Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>


                </div>
            </div>
        </div>
    </section>

</div>