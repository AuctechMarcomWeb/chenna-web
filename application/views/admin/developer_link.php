<script type="text/javascript">
    window.onload=function(){
        $("#hiddenSms").fadeOut(5000);
    }
</script>
<style type="text/css">
    .form-horizontal .control-label{text-align: left;}
    .logo_img{height: 100px; width: 100px; padding: 5px; border: 1px solid #ddd; margin-top: 15px;}
    .fav_img{height: 50px; width: 50px; padding: 5px; border: 1px solid #ddd; margin-top: 15px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Manage Developer Links</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-md-12" id="hiddenSms"><?php echo $this->session->flashdata('activate'); ?></div>
        <div class="row">
            <div class="col-md-12">   
                <div class="box box-info">
                    <form class="form-horizontal"  action="<?php echo site_url('admin/Dashboard/developer_link');?>" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">GST Allow or Not:</label>
                                <div class="col-sm-10" style="padding-top: 10px;">
                                    <input type="radio" name="gst_allow" value="1" <?php if ($dev_links['gst_allow'] == 1) { echo "checked"; }?>> Yes &nbsp; &nbsp; &nbsp;  
                                    <input type="radio" name="gst_allow" value="2" <?php if ($dev_links['gst_allow'] == 2) { echo "checked"; }?>> No
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Login Functionality:</label>
                                <div class="col-sm-10" style="padding-top: 10px;">
                                    <input type="radio" name="login" value="1" <?php if ($dev_links['login_type'] == 1) { echo "checked"; }?>> OTP login functionality &nbsp; &nbsp; &nbsp;  
                                    <input type="radio" name="login" value="2" <?php if ($dev_links['login_type'] == 2) { echo "checked"; }?>> Custom login functionality &nbsp; &nbsp; &nbsp;  
                                    <input type="radio" name="login" value="3" <?php if ($dev_links['login_type'] == 3) { echo "checked"; }?>> Both 
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Social Media Login Functionality:</label>
                                <div class="col-sm-10" style="padding-top: 10px;">
                                    <input type="radio" name="media_login" value="1" <?php if ($dev_links['media_login'] == 1) { echo "checked"; }?>> Yes &nbsp; &nbsp; &nbsp;  
                                    <input type="radio" name="media_login" value="2" <?php if ($dev_links['media_login'] == 2) { echo "checked"; }?>> No
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Website Name:</label>
                                <div class="col-sm-10" style="">
                                    <input type="text" name="website_name" value="<?= $dev_links['website_name']; ?>" placeholder="Website Name" class="form-control" id="website_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Logo:</label>
                                <div class="col-sm-10" style="">
                                    <input type="file" name="logo" class="form-control" id="logo">
                                    <input type="hidden" name="old_logo" value="<?= $dev_links['logo']; ?>">
                                    <img src="<?php echo base_url(); ?>assets/Website/img/<?php echo $dev_links['logo']; ?>" class="logo_img">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Favicon:</label>
                                <div class="col-sm-10" style="">
                                    <input type="file" name="favicon" class="form-control" id="favicon" >
                                    <input type="hidden" name="old_favicon" value="<?= $dev_links['favicon']; ?>">
                                    <img src="<?php echo base_url(); ?>assets/Website/img/<?php echo $dev_links['favicon']; ?>" class="fav_img">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Copyright:</label>
                                <div class="col-sm-10" style="">
                                    <input type="text" name="copyright" value="<?= $dev_links['copyright']; ?>" placeholder="Copyright" class="form-control" id="copyright" required>
                                </div>
                            </div>


                            <div class="form-group">
                               
                                <div class="col-sm-offset-2 col-sm-10" style="">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>