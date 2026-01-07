<script type="text/javascript">
    window.onload = function () {
        $("#hiddenSms").fadeOut(5000);
    }
</script>

<style type="text/css">
    .ratingpoint {
        color: red;
    }

    i.fa.fa-fw.fa-trash {
        font-size: 30px;
        color: darkred;
        top: 5px;
        position: relative;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Tags <a href="<?php echo base_url('admin/Dashboard/addTag/'); ?>" class="btn btn-info"
                style="float: right; padding-right: 10px; ">Add Tag</a>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
                    <div class="box-body">
                        <h3><?= $title ?></h3>

                        <?php if (!empty($products)): ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Parent Category</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Products</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;

                                    $grouped = [];
                                    foreach ($products as $p)
                                    {
                                        $parent = $p['parent_category_name'] ?: 'N/A';
                                        $cat = $p['category_name'] ?: 'N/A';
                                        $sub = $p['sub_category_name'] ?: 'N/A';
                                        $grouped[$parent][$cat][$sub][] = $p['product_name'];
                                    }

                                    foreach ($grouped as $parentName => $cats)
                                    {
                                        foreach ($cats as $catName => $subs)
                                        {
                                            foreach ($subs as $subName => $prodNames)
                                            {
                                                echo "<tr>
                                                <td>{$counter}</td>
                                                <td>" . ucfirst($parentName) . "</td>
                                                <td>" . ucfirst($catName) . "</td>
                                                <td>" . ucfirst($subName) . "</td>
                                                <td>" . implode(', ', array_map('ucfirst', $prodNames)) . "</td>
                                            </tr>";
                                                $counter++;
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">No products linked to this tag.</td>
                            </tr>
                        <?php endif; ?>

                       
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>



