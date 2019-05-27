<table style="border:1px solid #000;width:100%;font-size:10px;">
    <tr>
        <td style="text-align:center;padding:5px;">
            <?php echo $supermarket_results['company_1']; ?>,<br/>
            <?php echo $supermarket_results['address_1']; ?>,<br/>
            <?php echo $supermarket_results['address_2']; ?>,<br/>
            <?php echo $supermarket_results['city']; ?> -  <?php echo $supermarket_results['pincode']; ?><br/>
            <?php echo $supermarket_results['state']; ?>  <?php echo $supermarket_results['country']; ?>.
            Ph: <?php echo $supermarket_results['phone_no']; ?><br/>
            <?php if(!empty($supermarket_results['email_address'])){ ?>
            Email: <?php echo $supermarket_results['email_address']; ?><br/>
            <?php } ?>
            <?php if(!empty($supermarket_results['website'])){ ?>
            Website: <?php echo $supermarket_results['website']; ?><br/>
            <?php } ?>
            GSTIN: <?php echo $supermarket_results['gstin_no']; ?><br/>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;font-size:10px;">
                <tr>
                    <td colspan="2" style="border-top:1px solid #000;text-align:center;border-bottom:1px solid #000;padding:5px;">Tax Invoice</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000;padding:5px;">Date: <?php echo date('d/m/Y',strtotime($bill_date)); ?></td>
                    <td style="border-bottom:1px solid #000;text-align:right;padding:5px;">Bill No: <?php echo $bill_id; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width:100%;font-size:10px;">
                <tr>
                    <th style="padding:0 5px;width:40%;text-align: left;">Particulars</th>
                    <th style="padding:0 5px;width:20%;text-align: left;">Qty</th>
                    <th style="padding:0 5px;width:20%;text-align: right;">Value</th>
                </tr>
                <?php if(!empty($bill_results)){
                    $total_price=0;
                    foreach($bill_results as $k=>$v){
                        if($v['option_id']==0){
                            $product_name=$v['product_name'];
                            $product_price= $v['product_price'];
                        }else{
                            $product_name=$v['product_name'].'('.$v['option_name'].')';
                            $product_price= $v['option_price'];
                        }
                        $product_price = $v['quantity']*$product_price;
                        $gst = $v['sgst_value']+$v['cgst_value'];
                        $sgst_rate = $product_price-$product_price*(100/(100+$gst));
                        $cgst_rate = $product_price-$product_price*(100/(100+$gst));

                        $subtotal_price = $product_price;
                    ?>
                <tr>
                    <td style="padding:5px;border-bottom:1px solid #000;vertical-align: top;">
                        <?php echo $product_name; ?><br/>
                    </td>
                    <td style="padding:5px;border-bottom:1px solid #000;vertical-align: top;">
                        <?php echo $v['quantity']; ?><br/>
                    </td>
                    <td style="padding:5px;text-align: right;border-bottom:1px solid #000;vertical-align: top;"><?php echo sprintf("%.2f",$product_price); ?></td>
                </tr>
                <?php $total_price+=$subtotal_price; }
                //$total_price = round($total_price);
                $total_price = round($total_amount);
                ?>
                <tr>
                    <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                        Sub Total
                    </td>
                    <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                        <?php echo $total_price; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                        Delivery Charges
                    </td>
                    <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                        <?php echo $delivery_cost = round($delivery_cost); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                        Discount(<?php echo $discount_percent;?>%)
                    </td>
                    <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                        <?php 
                        $net_total = $total_price + $delivery_cost;
                        $discount_amount = $net_total * ($discount_percent / 100);
                        echo round($discount_amount,2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                        Net Total
                    </td>
                    <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                        <?php
                        $net_total = round ($net_total - $discount_amount);
                        echo $net_total; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                        Cash Received
                    </td>
                    <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                        <?php
                        echo round($cash_received);
                        ?>
                    </td>
                </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;border-bottom:1px solid #000;">
                            Balance Paid
                        </td>
                        <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                            <?php echo round($balance_paid); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="padding:5px;text-align: center;">
                        <p>Thank you visit again!</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>