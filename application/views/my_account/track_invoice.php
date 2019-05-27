<?php include_once('navigation.php'); ?>
<div class="col-lg-1 col-md-1 col-sm-1"></div>
<div class="col-lg-8 col-md-8 col-sm-8 right-sec">
    <div class="formhead">
        Track Order
        <a class="btn btn-default pull-right" href="<?php echo base_url(); ?>user/order_history"><< Back</a>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="col-lg-12 nopadding conpart">
        <?php if(isset($cart_items) && !empty($cart_items)) {
            $coupon_discount=0;
            $total_price=0;
            foreach ($cart_items as $k=>$cart_row) {
                $coupon_discount += $cart_row['coupon_discount'];
                $price=$cart_row['option_price'];
                if($cart_row['option_id']==0){
                    $price=$cart_row['product_price'];
                }

                $quantity=$cart_row['quantity'];
                $subtotal_price=$quantity*$price;
                $total_price+=$subtotal_price;
            }
            if(isset($coupon_code) && isset($coupon_applied_id)) {
                $total_price = $total_price - $coupon_discount;
            }
            $net_total=$total_price+$order_details['delivery_cost'];
            ?>
            <div class="table-responsive">
                <table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:22px; font-family:Open Sans, 'Times New Roman', Times, serif;">
                    <tr>
                        <td>
                            ORDER DETAILS
                        </td>
                        <td align="right">
                            ADDRESS
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr style="border-bottom:1px solid #cccccc;">
                        <td>
                            <p>Order No:<?php echo $order_details['order_id']; ?></p>
                            <p>Order Date: <?php echo date('d-m-Y', strtotime($order_details['created'])); ?></p>
                             <?php
                                    if($order_details['payment_mode']=='COD')
                                    {
                                        ?>
                                        <p>Total Amount: Rs. <?php echo number_format($net_total+60,2); ?></p>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <p>Total Amount: Rs. <?php echo number_format($net_total,2); ?></p>

                                        <?php
                                    }

                                    ?>  
                        </td>
                        <td align="right">
                            <strong>Shipping Address:</strong><br />
                            <b><?php echo $order_details['shipping_title']; ?>:</b><br/>
                            <?php echo $order_details['shipping_user_name']; ?>, <?php echo $order_details['shipping_user_address']; ?>,<?php echo $order_details['shipping_user_city']; ?> - <?php echo $order_details['shipping_user_pincode']; ?>.<br />
                            <p><strong>Mobile:</strong> <?php echo $order_details['shipping_user_contact_no']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table  width="100%" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:20px; font-family:Open Sans, 'Times New Roman', Times, serif;">
                                <?php
                                $total_price=0;
                                $total_cart_items=0;
                                $coupon_discount=0;
                                foreach ($cart_items as $k=>$cart_row) {
                                    if($cart_row['option_id']==0){
                                        $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
                                    }else{
                                        if(!empty($cart_row['option_image'])){
                                            $product_image = $this->config->item('upload') .'product_option_images/'.$cart_row['option_image'];
                                        }else{
                                            $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
                                        }
                                    }

                                    if($cart_row['coupon_applied_id']!=0) {
                                        $coupon_code = $cart_row['coupon_code'];
                                        $coupon_applied_id = $cart_row['coupon_applied_id'];
                                        $coupon_discount += $cart_row['coupon_discount'];
                                    }

                                    $price=$cart_row['option_price'];
                                    if($cart_row['option_id']==0){
                                        $price=$cart_row['product_price'];
                                    }

                                    $quantity=$cart_row['quantity'];
                                    $subtotal_price=$quantity*$price;

                                    ?>
                                    <tr>
                                        <td style="border-bottom:1px solid #cccccc;">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:20px; font-family:Open Sans, 'Times New Roman', Times, serif;">
                                                <tr>
                                                    <td style="width:30%"><img src="<?php echo $product_image; ?>" height="75" /> </td>
                                                    <td style="width:70%;padding: 0px 10px;">
                                                        <p><?php echo $cart_row['product_name']; ?></p>
                                                        <?php if($cart_row['option_name']!="") { ?>
                                                            <p>Option Code: <?php echo $cart_row['option_code']; ?></p>
                                                        <?php }else{ ?>
                                                            <p>Product Code : <?php echo $cart_row['product_code']; ?></p>
                                                        <?php } ?>
                                                        <?php if($cart_row['option_name']!="") { ?>
                                                            <p>Option: <?php echo $cart_row['option_name']; ?></p>
                                                        <?php } ?>
                                                        <?php if(!empty($cart_row['cart_offer_prod'])){
                                                            foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
                                                                <p class="promo-sec">Promo applied: <?php echo $v1['offer_product_name'];  ?> <?php echo (!empty($v1['offer_option_name']))?'-'.$v1['offer_option_name']:'';  ?></p>
                                                            <?php }  }?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td height="30" align="left" style="border-bottom:1px solid #cccccc;">
                                                <?php  if(!empty($cart_row['status_results'])){ ?>
                                                    <ul class="progress-tracker progress-tracker--text">
                                                        <li class="progress-step <?php echo (array_key_exists('Ordered',$cart_row['status_results']))?'is-complete':''; ?>">
                                                            <a href="javascript:" class="status_link" data-text="#ordered_text">
                                                                <span class="progress-marker"></span>
                                                                <span class="progress-text">
                                                                    <h4 class="progress-title">Ordered</h4>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <?php if(array_key_exists('Cancelled',$cart_row['status_results'])){ ?>
                                                            <li class="progress-step <?php echo (array_key_exists('Cancelled',$cart_row['status_results']))?'is-complete':''; ?>">
                                                                <a href="javascript:" class="status_link" data-text="#cancelled_text">
                                                                    <span class="progress-marker"></span>
                                                                    <span class="progress-text">
                                                                        <h4 class="progress-title">Cancelled</h4>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php } elseif(array_key_exists('Returned',$cart_row['status_results'])){ ?>
                                                            <li class="progress-step <?php echo (array_key_exists('Returned',$cart_row['status_results']))?'is-complete':''; ?>">
                                                                <a href="javascript:" class="status_link" data-text="#returned_text">
                                                                    <span class="progress-marker"></span>
                                                                    <span class="progress-text">
                                                                        <h4 class="progress-title">Returned</h4>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                        <?php }else{ ?>
                                                            <li class="progress-step <?php echo (array_key_exists('Shipped',$cart_row['status_results']))?'is-complete':''; ?>">
                                                                <a href="javascript:" class="status_link" data-text="#shipped_text">
                                                                    <span class="progress-marker"></span>
                                                                    <span class="progress-text">
                                                                        <h4 class="progress-title">Shipped</h4>
                                                                    </span>
                                                                </a>
                                                            </li>

                                                            <li class="progress-step <?php echo (array_key_exists('Delivered',$cart_row['status_results']))?'is-complete':''; ?>">
                                                                <a href="javascript:" class="status_link" data-text="#delivered_text">
                                                                    <span class="progress-marker"></span>
                                                                    <span class="progress-text">
                                                                        <h4 class="progress-title">Delivered</h4>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php } ?>


                                                    </ul>

                                                    <div style="width:400px;">
                                                        <span id="ordered_text"  style="display: none;min-height: 30px;">
                                                            <?php
                                                            if(isset($cart_row['status_results']['Ordered'])){
                                                                $status_row = $cart_row['status_results']['Ordered'];
                                                                echo '<span>'.date('D, dS M',strtotime($status_row['created'])).'</span>';
                                                                echo '&nbsp;&nbsp;<span>'.date('h:i A',strtotime($status_row['created'])).'</span>';
                                                                echo '<span class="pull-right">'.$status_row['comments'].'</span>';
                                                            }
                                                            ?> &nbsp; &nbsp;
                                                        </span>
                                                        <span id="cancelled_text"  style="display: none;min-height: 30px;">
                                                            <?php
                                                            if(isset($cart_row['status_results']['Cancelled'])){
                                                                $status_row = $cart_row['status_results']['Cancelled'];
                                                                echo '<span>'.date('D, dS M',strtotime($status_row['created'])).'</span>';
                                                                echo '&nbsp;&nbsp;<span>'.date('h:i A',strtotime($status_row['created'])).'</span>';
                                                                echo '<span class="pull-right">'.$status_row['comments'].'</span>';
                                                            }
                                                            ?> &nbsp; &nbsp;
                                                        </span>
                                                        <span id="returned_text"  style="display: none;min-height: 30px;">
                                                            <?php
                                                            if(isset($cart_row['status_results']['Returned'])){
                                                                $status_row = $cart_row['status_results']['Returned'];
                                                                echo '<span>'.date('D, dS M',strtotime($status_row['created'])).'</span>';
                                                                echo '&nbsp;&nbsp;<span>'.date('h:i A',strtotime($status_row['created'])).'</span>';
                                                                echo '<span class="pull-right">'.$status_row['comments'].'</span>';
                                                            }
                                                            ?> &nbsp; &nbsp;
                                                        </span>
                                                        <span id="shipped_text" style="display: none;min-height: 30px;">
                                                            <?php
                                                            if(isset($cart_row['status_results']['Shipped'])){
                                                                $status_row = $cart_row['status_results']['Shipped'];
                                                                echo '<span>'.date('D, dS M',strtotime($status_row['created'])).'</span>';
                                                                echo '&nbsp;&nbsp;<span>'.date('h:i A',strtotime($status_row['created'])).'</span>';
                                                                echo '<span class="pull-right">'.$status_row['comments'].'</span>';
                                                            }
                                                            ?> &nbsp; &nbsp;
                                                        </span>
                                                        <span id="delivered_text" style="display: none;min-height: 30px;">
                                                            <?php
                                                            if(isset($cart_row['status_results']['Delivered'])){
                                                                $status_row = $cart_row['status_results']['Delivered'];
                                                                echo '<span>'.date('D, dS M',strtotime($status_row['created'])).'</span>';
                                                                echo '&nbsp;&nbsp;<span>'.date('h:i A',strtotime($status_row['created'])).'</span>';
                                                                echo '<span class="pull-right">'.$status_row['comments'].'</span>';
                                                            }
                                                            ?> &nbsp; &nbsp;
                                                        </span>
                                                        &nbsp; &nbsp;
                                                    </div>
                                                <?php } ?>
                                            </td>

                                            <td align="right" style="border-bottom:1px solid #cccccc;">
                                                <p>&nbsp;</p>
                                                <p><?php echo number_format($subtotal_price, 2); ?></p>
                                                <p>&nbsp;</p>
                                                <?php if($cart_row['option_name']!="") { ?><p>&nbsp;</p><?php } ?>
                                                <?php if(!empty($cart_row['cart_offer_prod'])){
                                                    foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
                                                        <p class="promo-sec"><?php echo 'Free'; ?></p>
                                                    <?php } } ?>
                                                </td>
                                            </tr>
                                        <?php  } ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('user_css');?>progress-tracker.css">
<script>
    $(function(){
        $('.status_link').hover(function(){
            var target= $(this).attr('data-text');
            $(this).closest('td').find(target).show();
        },function(){
            var target= $(this).attr('data-text');
            $(this).closest('td').find(target).hide();
        })
    });

</script>
<style>
.progress-tracker{
    margin:10px 0;
}
.progress-text{
    padding:0 10px;
}
.status_link:hover{
    text-decoration: none;
}
</style>
