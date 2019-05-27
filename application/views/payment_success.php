<script>
    <?php
    if (base_url() == 'https://www.vakulla.com/') {
        ?>
        fbq('track', 'Purchase', {
            value: <?php echo $net_total.'00'; ?>,
            currency: 'INR'
        });
        <?php
    }
    ?>
</script>
<div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
       <!--  <ol class="breadcrumb">
            <li><a class="blackdark" href="<?php  echo base_url(); ?>">Home</a></li>
            <li><a class="active text-green" href="">Payment Success</a></li>
        </ol> -->
        <div class="text-center">
            <div class="center-block col-lg-6" style="float:none;padding:20px;border:1px solid #eee;">
                <img src="<?php echo $this->config->item('user_images');?>Thanku.png" height="50" alt=""/>
                <div style="font-size:13px; font-weight:bold;">Thank you for your transaction!</div>
                <div class="clearfix">&nbsp;</div>
                <?php echo $net_total; ?>
                <p>Your order ID: <?php echo $order_id; ?> | Order Placed on : <?php echo date('d-m-Y h:i:s A'); ?></p>
                Thanks,<br />
                Vakulla team
            </div>

        </div>

    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
</div>
<style>
.payment_info{
    border:1px solid #eee;
    width:520px;
    margin:0 auto;
    padding:15px;
}
</style>