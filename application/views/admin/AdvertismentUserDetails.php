


<style>
.content-wrapper{
    background:#f1f5f9;
}

/* PAGE HEADER */
.page-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:15px;
}

/* SUMMARY CARDS */
.summary-card{
    background:#fff;
    border-radius:14px;
    padding:18px;
    border:1px solid #e5e7eb;
    box-shadow:0 2px 10px rgba(0,0,0,.04);
    height:auto;
}
.summary-title{ 
    font-size: 18px;
    color: #000;
    margin-bottom: 6px;
    text-transform: uppercase;
    font-weight: 700;
}
.summary-value{
   font-size: 13px;
    font-weight: 600;
    color: #444;
}

/* BADGES */
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}
.badge-paid{background:#16a34a;color:#fff;}
.badge-pending{background:#f59e0b;color:#fff;}
.badge-active{background:#16a34a;color:#fff;}
.badge-stop{background:#dc2626;color:#fff;}

/* SECTION */
.section-box{
    margin-top:20px;
    background:#fff;
    border-radius:14px;
    border:1px solid #e5e7eb;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
    overflow:hidden;
}
.section-title{
    padding:14px 18px;
    font-weight:700;
    background:linear-gradient(45deg,#3c8dbc,#00c0ef);
    color:#fff;
}

/* INFO TABLE */
.info-table{
    margin:0;
}
.info-table th{
    width:250px;
    background:#f8fafc;
    font-weight:600;
}
.info-table td, .info-table th{
    padding:12px 15px !important;
    vertical-align:middle !important;
}
.info-table tr:nth-child(even){
    background:#fcfdff;
}

/* BENEFITS */
.benefit-pill{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    background:#e0f2fe;
    color:#0369a1;
    font-size:12px;
    font-weight:600;
    margin:3px;
}

/* PROGRESS */
.progress{
    height:18px;
    border-radius:20px;
    background:#e5e7eb;
}
.progress-bar{
    background:#22c55e;
    font-size:11px;
    font-weight:600;
}

/* PRODUCT TABLE */
.product-table{
    margin:0;
}
.product-table thead th{
    background:#111827;
    color:#fff;
    font-size:13px;
}
.product-table tbody tr:hover{
    background:#f1f5f9;
}

/* IMAGE */
.product-img{
    width:55px;
    height:55px;
    object-fit:contain;
    border-radius:8px;
    border:1px solid #eee;
    padding:3px;
    background:#fff;
}
.expired{
    color: #fff;
    font-weight: 600;
    background: #dc2626;
    padding: 5px 12px;
    border-radius: 50px;
    /* line-height: 1px; */
    text-align: center;
    font-size: 12px;
}
</style>
<?php
function timeAgo($datetime)
{
  $time = time() - strtotime($datetime);

  if ($time < 60)
    return 'Just now';
  if ($time < 3600)
    return floor($time / 60) . ' min ago';
  if ($time < 86400)
    return floor($time / 3600) . ' hours ago';
  if ($time < 2592000)
    return floor($time / 86400) . ' days ago';
  if ($time < 31536000)
    return floor($time / 2592000) . ' months ago';

  return floor($time / 31536000) . ' years ago';
}
?>
<?php
$limit = (int)($purchase['product_limit'] ?? 0);
$used = count($products);
$remaining = max($limit - $used, 0);

$start = strtotime($purchase['start_date']);
$end = strtotime($purchase['end_date']);
$today = time();
$daysLeft = ceil(($end - $today) / 86400);

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Advertisement Details
      
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="msg">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-body"><br>
             <div class="row">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-title">User Nme</div>
                        <div class="summary-value"><?= $purchase['user_name'] ?></div>
                        <small><?= ($purchase['user_type']==2)?'Vendor':'Promoter' ?></small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-title">Plan Name</div>
                        <div class="summary-value"><?= $purchase['plan_name'] ?></div>
                        <small><?= $purchase['duration_days'] ?> Days</small>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-title">Plan Price</div>
                        <div class="summary-value">₹<?= $purchase['price'] ?></div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-title">Plan Payment</div>
                        <?php if($purchase['payment_status']=='paid'){ ?>
                            <span class="badge badge-paid">Paid</span>
                        <?php } else { ?>
                            <span class="badge badge-pending">Pending</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
          </div>
        </div>
        
      </div>
      <div id="msg">
        <div class="col-xs-12">
          <div class="box">
            <div class="section-title">Purchase Information</div>
            <div class="box-body" style="overflow-x:auto;"><br>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <tr>
                        <th>Transaction ID</th>
                        <td><?= $purchase['transaction_id'] ?></td>
                    </tr>

                    <tr>
                        <th>Start Date</th>
                        <td><?= date('d M Y', $start) ?></td>
                    </tr>

                    <tr>
                        <th>End Date</th>
                        <td><?= date('d M Y', $end) ?></td>
                    </tr>

                    <tr>
                        <th>Expire Status</th>
                        <td>
                            <?php if($daysLeft > 0){ ?>
                                <span style="color:##fff;font-weight:600;" class="expired">
                                    <?= $daysLeft ?> days left
                                </span>
                            <?php } else { ?>
                                <span  class="expired">Expired</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Product Limit</th>
                        <td><?= $limit ?></td>
                    </tr>

                    <tr>
                        <th>Products Used</th>
                        <td><?= $used ?></td>
                    </tr>

                    <tr>
                        <th>Remaining</th>
                        <td><?= $remaining ?></td>
                    </tr>

                    <tr>
                        <th>Plan Benefits</th>
                        <td>
                            <?php
                            $b = [];
                            if($purchase['hot_deal']) echo '<span class="benefit-pill">Hot Deal</span>';
                            if($purchase['spacial_offer']) echo '<span class="benefit-pill">Special Offer</span>';
                            if($purchase['product_for_you']) echo '<span class="benefit-pill">Product For You</span>';
                            if($purchase['banner']) echo '<span class="benefit-pill">Banner</span>';
                            if(empty($b) && !$purchase['hot_deal'] && !$purchase['spacial_offer'] && !$purchase['product_for_you'] && !$purchase['banner'])
                                echo 'No extra benefits';
                            ?>
                        </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

       <div id="msg">
        <div class="col-xs-12">
          <div class="box">
            <div class="section-title">Advertised Products</div>
            <div class="box-body" style="overflow-x:auto;"><br>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="product-table table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Ad Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Registered Date</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($products)){
                            foreach($products as $k=>$p){ ?>
                        <tr>
                            <td><?= $k+1 ?></td>
                            <td><?php if($p['main_image']){ ?><img src="<?= base_url('assets/product_images/'.$p['main_image']) ?>" class="product-img"><?php } ?></td>
                            <td><?= $p['product_name'] ?></td>
                            <td><?= ucfirst(str_replace('_',' ',$p['ad_type'])) ?></td>
                            <td><?= date('d-m-Y h:m:s A', strtotime($p['start_date'])) ?></td>
                            <td><?= date('d-m-Y h:m:s A', strtotime($p['end_date'])) ?></td>
                            <td><?php if($p['status']==1){ ?><span class="badge badge-active">Active</span><?php } else { ?><span class="badge badge-stop">Pending</span><?php } ?></td>
                           <td><?= date('d-m-Y h:i:s A', strtotime($p['created_at'])) ?></td>
                            <td><?= timeAgo($p['created_at']) ?></td>

                        </tr>
                        <?php } } else { ?>
                        <tr><td colspan="9" class="text-center">No Products Found</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
   
  </section>

</div>
