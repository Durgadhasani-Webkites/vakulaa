
<div class="container">
    <div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
      <!--   <ol class="breadcrumb">
            <li><a class="blackdark" href="<?php  echo base_url(); ?>">Home</a></li>
            <li><a class="active text-green" href="">Payment Failure</a></li>
        </ol> -->
        <div class="text-center">
            <div class="center-block col-lg-6" style="float:none;padding:20px;border:1px solid #eee;">
                    <img src="<?php echo $this->config->item('user_images');?>sorry.png" height="50" alt=""/>

                    <div style="font-size:13px; font-weight:bold;">Sorry!, Your order cannot be processed due to payment failure or any technical issues. Please contact us at admin@vakulla.com for further details.</div>
                    <div class="clearfix">&nbsp;</div>
                    <p>Your order ID: <?php echo $order_id; ?> | Transaction made on : <?php echo date('d-m-Y H:i:s'); ?></p>
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
        width:400px;
        margin:0 auto;
        padding:15px;
    }
</style>