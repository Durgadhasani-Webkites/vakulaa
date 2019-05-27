<?php if(isset($cart_items) && !empty($cart_items)) { ?>
    <table width="700px" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:22px; font-family:Open Sans, 'Times New Roman', Times, serif;">
        <tr>
            <td align="center"><img src="<?php echo $this->config->item('user_images');?>logo.png" alt="" class="img-responsive"></td>
        </tr>
        <tr>
            <td align="center">
                <table width="990px" border="0" cellspacing="0" cellpadding="10">
                    <tr>
                        <td>
                            <span style="float:left;text-align: left;">Order No:<?php echo $order_details['order_id']; ?></span>
                        </td>
                        <td>
                            Retail Invoice/Bill<br/>
                            <?php if(!empty($supermarket_results)){ ?>
                                <?php echo $supermarket_results['company_1']; ?>,<br/>
                                <?php echo $supermarket_results['address_1']; ?>,<br/>
                                <?php echo $supermarket_results['address_2']; ?>,<br/>
                                <?php echo $supermarket_results['city']; ?> - <?php echo $supermarket_results['pincode']; ?><br/>
                                <?php echo $supermarket_results['state']; ?>  <?php echo $supermarket_results['country']; ?>.
                                Ph: <?php echo $supermarket_results['phone_no']; ?><br/>
                                <?php if(!empty($supermarket_results['email_address'])){ ?>
                                    Email: <?php echo $supermarket_results['email_address']; ?><br/>
                                <?php } ?>
                                <?php if(!empty($supermarket_results['website'])){ ?>
                                    Website: <?php echo $supermarket_results['website']; ?><br/>
                                <?php } ?>
                                GSTIN: <?php echo $supermarket_results['gstin_no']; ?><br/>
                            <?php } ?>
                        </td>
                        <td>
                            <span style="float:right;text-align: right;">Invoice Date:<?php echo date('d-m-Y', strtotime($order_details['created'])); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="font-size:13px; height:30px;"><strong>ORDER DETAILS :</strong></div>
                <table width="990px" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:20px; font-family:Open Sans, 'Times New Roman', Times, serif;">
                    <tr style="font-weight:bold;">
                        <td width="10%" height="30" align="left" style="border-bottom:2px solid #4F7F31; border-top:1px solid #4F7F31; font-size:13px;">Sl No.</td>
                        <td width="30%" align="center" style="border-bottom:2px solid #4F7F31; border-top:1px solid #4F7F31; font-size:13px;">DESCRIPTION</td>
                        <td width="20%" align="center" style="border-bottom:2px solid #4F7F31; border-top:1px solid #4F7F31; font-size:13px;">UNIT PRICE</td>
                        <td width="20%" align="center" style="border-bottom:2px solid #4F7F31; border-top:1px solid #4F7F31; font-size:13px;">QUANTITY</td>
                        <td width="20%" align="right" style="border-bottom:2px solid #4F7F31; border-top:1px solid #4F7F31; font-size:13px;">SUB TOTAL</td>
                    </tr>
                    <?php
                    $total_price=0;
                    $total_cart_items=0;
                    $coupon_discount=0;
                    foreach ($cart_items as $k=>$cart_row) {
                        if($cart_row['option_id']==0){
                            $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
                        }else{
                            $product_image = $this->config->item('upload') .'product_option_images/'.$cart_row['option_image'];
                            if(empty($cart_row['option_image'])){
                                $product_image = $this->config->item('upload') .'products/'.$cart_row['product_thumb_image'];
                            }
                        }
                        if($cart_row['coupon_applied_id']!=0) {
                            $coupon_code = $cart_row['coupon_code'];
                            $coupon_applied_id = $cart_row['coupon_applied_id'];
                            $coupon_discount += $cart_row['coupon_discount'];
                        }
                        ?>
                        <tr>
                            <td style="border-bottom:1px solid #cccccc;"><?php echo ($k+1); ?></td>
                            <td height="30" align="left" style="border-bottom:1px solid #cccccc;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="10" style="font-size:14px; line-height:20px; font-family:Open Sans, 'Times New Roman', Times, serif;">
                                    <tr>
                                        <td style="width:15%"><img src="<?php echo $product_image; ?>" height="75" /> </td>
                                        <td style="width:85%">
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
                                <td align="center" style="border-bottom:1px solid #cccccc;">
                                    <p>&nbsp;</p>
                                    <?php
                                    $price=$cart_row['option_price'];
                                    if($cart_row['option_id']==0){
                                        $price=$cart_row['product_price'];
                                    }

                                    $quantity=$cart_row['quantity'];
                                    $subtotal_price=$quantity*$price;
                                    ?>
                                    <p><?php echo number_format($price, 2); ?></p>
                                    <p>&nbsp;</p>
                                    <?php if($cart_row['option_name']!="") { ?><p>&nbsp;</p><?php } ?>
                                    <?php if(!empty($cart_row['cart_offer_prod'])){
                                        foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
                                            <p class="promo-sec"><?php echo 'Free'; ?></p>
                                        <?php } } ?>
                                    </td>
                                    <td align="center" style="border-bottom:1px solid #cccccc;">
                                        <p><?php echo $quantity; ?></p>
                                        <?php if($cart_row['option_name']!="") { ?><p>&nbsp;</p><?php } ?>
                                        <?php if(!empty($cart_row['cart_offer_prod'])){
                                            foreach($cart_row['cart_offer_prod'] as $k1=>$v1){?>
                                                <p class="offer_qty promo-sec"><?php echo $v1['offer_product_qty']; ?></p>
                                            <?php } } ?>
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
                                        <?php   $total_price+=$subtotal_price;
                                        $total_cart_items++; } 

                                        ?>
                                        <tr>
                                            <td height="80" colspan="2" align="left" valign="top">
                                                <strong>Shipping Address:</strong><br />
                                                <b><?php echo $order_details['shipping_title']; ?>:</b><br/>
                                                <?php echo $order_details['shipping_user_name']; ?>, <?php echo $order_details['shipping_user_address']; ?>,<?php echo $order_details['shipping_user_city']; ?> - <?php echo $order_details['shipping_user_pincode']; ?>.<br />
                                                <strong>Mobile:</strong> <?php echo $order_details['shipping_user_contact_no']; ?><br />
                                                <strong>Landmark:</strong> <?php echo $order_details['shipping_user_landmark']; ?><br/>
                                                <?php if(!empty($order_details['delivery_date'])){ ?>
                                                    <strong>Delivery Date:</strong> <?php echo date('D d M Y',strtotime(str_replace('/','-',$order_details['delivery_date']))); ?>
                                                    <?php if(!empty($order_details['delivery_time_slot'])){ ?>
                                                        between <?php echo $order_details['delivery_time_slot'];  ?>
                                                    <?php } ?>
                                                    <br/>
                                                <?php } ?>
                                                <?php if(!empty($order_details['payment_mode'])){ ?>
                                                    <strong>Payment Mode:</strong> <?php echo $order_details['payment_mode']; ?>
                                                <?php } ?>
                                            </td>
                                            <td colspan="3" align="right" style="font-size:16px; color:#000000;" valign="top">
                                               <div style="font-weight:normal; font-size:13px;">
                                                   <p>Sub Total: Rs.<?php echo number_format($total_price, 2); ?></p>

                                                   <?php

                                                   if(isset($coupon_code) && isset($coupon_applied_id)) {
                                                       $total_price=  $total_price-$coupon_discount;
                                                       ?>
                                                       <p>Coupon Discount for "<?php echo $coupon_code; ?>": -Rs.<?php echo number_format($coupon_discount, 2); ?></p>
                                                   <?php }
                                                   $net_total=$total_price+$order_details['delivery_cost'];
                                                   ?>
                                                   <p>Delivery Cost: Rs.<?php echo number_format($order_details['delivery_cost'], 2); ?></p>
                                               </div>
                                              
                                               <?php
                                               if($order_details['payment_mode']=='COD')
                                               {
                                                ?>
                                                <p>COD Charge: Rs.60</p>
                                                <span style="font-weight:bold;">Amount to pay with COD charge: Rs.<?php echo number_format($net_total+60, 2); ?></span>

                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span style="font-weight:bold;">Paid Amount: Rs.<?php echo number_format($net_total, 2); ?></span>

                                                <?php
                                            }

                                            ?>  

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php } ?>