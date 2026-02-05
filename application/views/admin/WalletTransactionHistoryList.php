<div class="content-wrapper">
    <section class="content-header">
        <h1>Full Transaction History</h1>
    </section>

    <section class="content">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <?php if(!empty($transactions)) { ?>
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>S.No.</th>
                                    <th>User Type</th>
                                    <th>User ID</th>
                                    <th>Name / Shop</th>
                                    <th>Transaction Type</th>
                                    <th>Credit Amount</th>
                                    <th>Debit Amount</th>
                                    <th>Wallet Balance</th>
                                    <th>Order ID</th>
                                    <th>Order Number</th>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Main Image</th>
                                    <th>Plan Type</th>
                                    <th>Plan ID</th>
                                    <th>Final Price</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Admin Amount</th>
                                    <th>Vendor Amount</th>
                                    <th>Promoter Amount</th>
                                    <th>Source</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Requested On</th>
                                    <th>Approval Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($transactions as $txn){ 
                                    // Determine user type & name
                                    $userType = ucfirst($txn->user_type);
                                    $userName = '';
                                    if($txn->user_type == 'vendor'){
                                        $userName = $txn->vendor_name ? $txn->vendor_name . ' (' . $txn->shop_name . ')' : 'N/A';
                                    } elseif($txn->user_type == 'promoter'){
                                        $userName = $txn->promoter_name ?? 'N/A';
                                    }

                                    // Status badge
                                    if($txn->status == 0) $status = '<span class="badge bg-warning">Pending</span>';
                                    elseif($txn->status == 1) $status = '<span class="badge bg-success">Completed</span>';
                                    else $status = '<span class="badge bg-danger">Failed</span>';

                                    // Plan type
                                    $planType = '';
                                    if($txn->plan_type == 1) $planType = 'Monthly';
                                    elseif($txn->plan_type == 2) $planType = 'PerProduct';

                                    // Fill missing data from withdrawal request if null
                                    $orderId = $txn->order_id ?? $txn->wr_order_id;
                                    $walletBalance = $txn->wallet_amount ?? 0;
                                    $remark = $txn->remark ?? $txn->withdrawal_remarks;
                                    $requestDate = $txn->request_date ?? $txn->created_at;
                                    $approvalDate = $txn->approval_date ?? '-';
                                ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $userType; ?></td>
                                    <td><?= $txn->wr_user_id ?? $txn->vendor_id ?? $txn->promoter_id; ?></td>
                                    <td><?= $userName; ?></td>
                                    <td><?= ucfirst(str_replace('_',' ',$txn->transaction_type)); ?></td>
                                    <td><?= number_format($txn->credit_amount,2); ?></td>
                                    <td><?= number_format($txn->debit_amount,2); ?></td>
                                    <td><?= number_format($walletBalance,2); ?></td>
                                    <td><?= $orderId ?? '-'; ?></td>
                                    <td><?= $txn->order_number ?? $txn->order_number; ?></td>
                                    <td><?= $txn->product_id ?? '-'; ?></td>
                                    <td><?= $txn->product_name ?? '-'; ?></td>
                                    <td>
                                        <?php if($txn->main_image){ ?>
                                            <img src="<?= base_url('assets/product_images/'.$txn->main_image); ?>" width="50" class="img-thumbnail">
                                        <?php } ?>
                                    </td>
                                    <td><?= $planType; ?></td>
                                    <td><?= $txn->plan_id ?? '-'; ?></td>
                                    <td><?= number_format($txn->final_price ?? 0,2); ?></td>
                                    <td><?= number_format($txn->price ?? 0,2); ?></td>
                                    <td><?= $txn->qty ?? '-'; ?></td>
                                    <td><?= number_format($txn->admin_amount ?? 0,2); ?></td>
                                    <td><?= number_format($txn->vendor_amount ?? 0,2); ?></td>
                                    <td><?= number_format($txn->promoter_amount ?? 0,2); ?></td>
                                    <td><?= ucfirst($txn->source); ?></td>
                                    <td><?= $remark ?? '-'; ?></td>
                                    <td><?= $status; ?></td>
                                    <td><?= date('d-M-Y H:i', strtotime($requestDate)); ?></td>
                                    <td><?= $approvalDate != '-' ? date('d-M-Y H:i', strtotime($approvalDate)) : '-'; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                            <div class="alert alert-info mt-2">
                                No transactions found.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
