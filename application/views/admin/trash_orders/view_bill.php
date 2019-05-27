
<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Bill</h4>

        <hr class="alt short">

    </div>

    <div class="topbar-left">

        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">

                <a href="">Bill</a>

            </li>
            <li class="">

                <a href="<?php echo base_url(); ?>admin/trash_orders">View Trash</a>

            </li>
        </ul>

    </div>

</header>
<section id="content" class="table-layout animated fadeIn">

<div class="row">

<div class="panel">

<div class="panel-body">
    <div class="clearfix">&nbsp;</div>
    <table style="border:1px solid #000;width:100%;font-size:14px;">
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
                <table style="width:100%;font-size:14px;">
                    <tr>
                        <td colspan="2" style="border-top:1px solid #000;text-align:center;border-bottom:1px solid #000;padding:5px;">Tax Invoice</td>
                    </tr>
                    <tr>
                        <td style="border-bottom:1px solid #000;padding:5px;">Date: <?php echo date('d/m/Y'); ?></td>
                        <td style="border-bottom:1px solid #000;text-align:right;padding:5px;">Bill No: <?php echo $bill_id; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;font-size:14px;">
                    <tr>
                        <th style="padding:0 5px;width:40%;text-align: left;">Particulars</th>
                        <th style="padding:0 5px;width:20%;text-align: left;">Qty</th>
                        <th style="padding:0 5px;width:20%;text-align: left;">Rate GST</th>
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
                            $product_price=$product_price*$v['quantity'];
                            $gst = $v['sgst_value']+$v['cgst_value'];
                            $sgst_rate = $product_price-$product_price*(100/(100+$gst));
                            $cgst_rate = $product_price-$product_price*(100/(100+$gst));

                            $subtotal_price = $product_price;
                            ?>
                            <tr>
                                <td style="padding:5px;border-bottom:1px solid #000;vertical-align: top;">
                                    <?php echo $product_name; ?><br/>
                                    HSN: <?php echo $v['hsn_number']; ?><br/>
                                    SGST: <?php echo $v['sgst_value']; ?>%<br/>
                                    CGST: <?php echo $v['cgst_value']; ?>%
                                </td>
                                <td style="padding:5px;border-bottom:1px solid #000;vertical-align: top;">
                                    <?php echo $v['quantity']; ?><br/>
                                    <br/><br/>
                                    <?php echo sprintf("%.2f",($product_price-$sgst_rate)); ?><br/>
                                    <?php echo sprintf("%.2f",($product_price-$cgst_rate)); ?>
                                </td>
                                <td style="padding:5px;border-bottom:1px solid #000;vertical-align: top;">
                                    0.00<br/>
                                    <br/><br/>
                                    <?php echo sprintf("%.2f",$sgst_rate); ?><br/>
                                    <?php echo sprintf("%.2f",$cgst_rate); ?>
                                </td>
                                <td style="padding:5px;text-align: right;border-bottom:1px solid #000;vertical-align: top;"><?php echo sprintf("%.2f",$product_price); ?></td>
                            </tr>
                            <?php $total_price+=$subtotal_price; } ?>
                        <tr>
                            <td colspan="3" style="text-align: right;border-bottom:1px solid #000;">
                                Sub Total
                            </td>
                            <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                                <?php echo round($total_price); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;border-bottom:1px solid #000;">
                                Packing charges
                            </td>
                            <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                                <?php echo round($delivery_cost); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;border-bottom:1px solid #000;">
                               Discount(<?php echo $discount_percent; ?>%)
                            </td>
                            <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                                <?php 
                                $net_total = $total_price + $delivery_cost;
                                $discount = $net_total*($discount_percent/100);
                                echo round($discount,2); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;border-bottom:1px solid #000;">
                                Net Total
                            </td>
                            <td style="text-align: right;padding:5px;border-bottom:1px solid #000;">
                                <?php
                               
                                echo round($net_total- $discount); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" style="padding:5px;text-align: center;">
                            <p>Thank you visit again!</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="text-right"><b>Remarks:</b>&nbsp;<?php echo $remarks; ?></div>
</div>
</div>
</div>
</section>
<script type="text/javascript">
    $(function(){
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('.print_bill').click(function(){
            $.ajax({
                url:'<?php echo base_url('admin/offline_orders/print_bill/' . $bill_id); ?>',
                type:'post',
                success:function(response){
                    newWin = window.open("");
                    newWin.document.write(response);
                    newWin.print();
                    newWin.close();
                }
            });
        });
    });
</script>
