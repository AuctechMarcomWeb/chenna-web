<?php
$userData = @$this->session->userdata('User');
$user_id = @$userData['id'];

?>


<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>My Cart</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url(''); ?>">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">My Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Cart Section Start -->
<?php $this->load->view('web/user_cart'); ?>
<!-- Cart Section End -->


<script>

    function update_cart_qty(val, cart_id) {
        var pro_id = $('#pro_' + cart_id).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>cart/update_cart_quantity",
            data: { 'update_qty': val, 'rowid': cart_id, 'pro_id': pro_id },
            success: function (result) {
                var jsonResponse = JSON.parse(result);

                // Access the 'qty' property
                var qtyValue = jsonResponse.qty;
                if (qtyValue == 'false') {
                  
                    alert('Sorry, You can\'t add more of this item');
                    // window.location.reload();
                    refreshCartData();
                } else {
                    //window.location.reload();
                    refreshCartData();
                }
                console.log(result);

            }
        });
    }

    function refreshCartData() {
        $.ajax({
            url: '<?php echo base_url('web/user_cart_data'); ?>', 
            success: function (data) {
                $('#user_cart').html(data);
            }
        });
    }



    function remove_cart(cart_row_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>cart/remove_cart/" + cart_row_id,
            success: function (result) {
                if (result != "") {
                    refreshCartIcon();   
                    refreshRightCartIcon();
                    refreshCartData();
                }
            }
        });
    }
    function remove_cart(cart_row_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>cart/remove_cart/" + cart_row_id,
            success: function (result) {
                if (result != "") {
                    // Update all cart sections (desktop + mobile) using the same ID
                    $.ajax({
                        url: '<?php echo base_url('web/cart_icon_partial'); ?>',
                        success: function (data) {
                            $('[id="cart_items"]').each(function () {
                                $(this).html(data);
                            });
                        }
                    });

                    // Optionally refresh right-side cart dropdown
                    refreshRightCartIcon();
                    refreshCartData();
                }
            }
        });
    }


    function refreshCartIcon() {
        $.ajax({
            url: '<?php echo base_url('web/cart_icon_partial'); ?>', // This should return cart_icon.php output
            success: function (data) {
                $('#cart_items').html(data);
            }
        });
    }

    function refreshRightCartIcon() {
        $.ajax({
            url: '<?php echo base_url('web/right_cart_icon_partial'); ?>', // This should return cart_icon.php output
            success: function (data) {
                $('#right_cart_items').html(data);
            }
        });
    }


</script>

<script>
    var delayedUpdateTimeout;

    function delayedUpdate(value, rowid) {
        // Clear the previous timeout
        clearTimeout(delayedUpdateTimeout);

        // Set a new timeout for 500 milliseconds
        delayedUpdateTimeout = setTimeout(function () {
            update_cart_qty(value, rowid);
        }, 500);
    }

    //const input = $('.quantity__input');
    function minus(rowid) {
        var input = document.getElementById('quantity_' + rowid);
        var value = input.value;

        if (value > 1) {
            value--;
            input.value = value;
            update_cart_qty(value, rowid)
        } else {
            update_cart_qty(0, rowid);
        }

    }

    function plus(rowid) {
        var input = document.getElementById('quantity_' + rowid);
        var value = input.value;
        value++;
        input.value = value;
        update_cart_qty(value, rowid)
    }

</script>