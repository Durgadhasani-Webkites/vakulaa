<?php
if(!empty($order_history)) {
    foreach($order_history as $k=>$v) {
        $total_price=0;
        if(!empty($v['cart_items'])){
            ?>
            <tr>
                <td style="text-align:left;padding:0 !important;">
                    <div class="col-lg-12 order_head">
                        <span class="label label-success mt5 mb5 pull-left"><?php echo $v['order_id']; ?></span>
                        <a  class="btn btn-sm btn-primary pull-right mt5 mb5" target="_blank" href="<?php echo  base_url();?>admin/customers/view_invoice/<?php echo $v['id']; ?>">View Invoice</a>
                        <a  class="btn btn-sm btn-warning pull-right mt5 mb5" target="_blank" href="<?php echo  base_url();?>admin/customers/track_invoice/<?php echo $v['order_id']; ?>">Track Invoice</a>
                    </div>
                    <div class="col-lg-12 order_body">
                        <?php
                        $coupon_discount=0;
                        foreach($v['cart_items'] as $k1=>$v1) {
                            $product_link=base_url().'product/'.$v1['product_id'].'/'.strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $v1['product_name']));
                            if($v1['option_id']==0){
                                $product_image = $this->config->item('upload') .'products/'.$v1['product_thumb_image'];
                            }else{
                                $product_image = $this->config->item('upload') .'product_option_images/'.$v1['option_image'];
                                if(empty($cart_row['option_image'])){
                                    $product_image = $this->config->item('upload') .'products/'.$v1['product_thumb_image'];
                                }
                            }
                            $price=$v1['option_price'];
                            if($v1['option_id']==0){
                                $price=$v1['product_price'];
                            }

                            if($v1['coupon_applied_id']!=0) {
                                $coupon_code = $v1['coupon_code'];
                                 $coupon_applied_id = $v1['coupon_applied_id'];
                                 $coupon_discount += $v1['coupon_discount'];
                            }

                            $quantity=$v1['quantity'];
                            $subtotal_price=$quantity*$price;
                            ?>
                            <div class="row">
                                <div class="col-lg-3 text-center">
                                    <a  target="_blank" href="<?php echo $product_link; ?>"><img src="<?php echo $product_image; ?>" height="70"> </a>
                                </div>
                                <div class="col-lg-7 pad10">
                                    <b><a target="_blank" href="<?php echo $product_link; ?>"><?php echo $v1['product_name']; ?></a></b>
                                    <?php if($v1['option_code']!="") { ?>
                                        <p>Option Code: <?php echo $v1['option_code']; ?></p>
                                    <?php }else{ ?>
                                        <p>Product Code : <?php echo $v1['product_code']; ?></p>
                                    <?php } ?>
                                    <?php if($v1['option_name']!="") { ?>
                                        <p>Option: <?php echo $v1['option_name']; ?></p>
                                    <?php } ?>
                                    <?php if($v1['coupon_applied_id']!=0) {
                                        $coupon_code = $v1['coupon_code'];
                                        $coupon_applied_id= $v1['coupon_applied_id'];
                                        ?>
                                        <p>Coupon applied: <?php echo $coupon_code; ?></p>
                                    <?php } ?>
                                    <?php if(!empty($v1['cart_offer_prod'])){
                                        foreach($v1['cart_offer_prod'] as $k2=>$v2){?>
                                            <p class="promo-sec">Promo applied: <?php echo $v2['offer_product_name'];  ?> <?php echo (!empty($v2['offer_option_name']))?'-'.$v2['offer_option_name']:'';  ?></p>
                                        <?php }  }?>
                                    <p>Quantity: <?php echo $v1['quantity']; ?></p>
                                </div>
                                <div class="col-lg-2 pad10 text-right">
                                    <b>Rs. <?php echo number_format($subtotal_price,2); ?></b>
                                </div>
                            </div>
                            <?php  $total_price+=$subtotal_price; }
                        if(isset($coupon_code) && isset($coupon_applied_id)) {
                            $total_price = $total_price - $coupon_discount;
                        }
                        $net_total=$total_price+$v['delivery_cost'];
                        ?>
                    </div>
                    <div class="col-lg-12 order_foot">
                        <div class="col-lg-6  nopadding text-left">
                            <p>Ordered on <strong><?php echo date('d/m/Y h:i:s A',strtotime($v['created'])); ?></strong></p>
                        </div>
                        <div class="col-lg-6 nopadding text-right">
                            <p>Order Total <strong>Rs. <?php echo number_format($net_total,2); ?></strong></p>
                        </div>
                    </div>

                </td>
            </tr>
            <tr><td style="height:15px;">&nbsp;</td></tr>
        <?php
        }
    } }else{ ?>
    <tr><td><p class="text-order"> No order has been placed.</p></td></tr>
<?php } ?>