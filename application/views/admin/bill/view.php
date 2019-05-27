<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Bill</h4>

        <hr class="alt short">

    </div>

</header>

<section id="content" class="table-layout animated fadeIn">
    <form id="bill_frm" method="get" class="form-horizontal" role="form">
    <?php if(isset($bill_results['id'])){ ?>
        <input name="bill_id" value="<?php echo $bill_results['id']; ?>" type="hidden"/>
    <?php } ?>
        <div class="panel">

            <div class="panel-body">

                <div class="row ph15 mb10">
                    <div class="col-lg-6 col-md-6 col-sm-6 pull-right text-right">
                        <a href="<?php echo base_url(); ?>admin/offline_orders" class="btn btn-primary">View Offline Orders</a>
                        <a href="<?php echo base_url(); ?>admin/bill" class="btn btn-primary">Create new Bill</a>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-lg-3 col-md-3 col-sm-7">

                        <h5><small>Order No</small></h5>

                        <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter order no" value="<?php echo (isset($bill_results['order_id']))?$bill_results['order_id']:$order_id; ?>" readonly>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-5">

                        <h5><small>Customer</small></h5>

                        <select name="customer_no" id="customer_no" class="form-control">
                            <option value="guest" <?php echo (isset($bill_results['shipping_user_name']) && ($bill_results['shipping_user_name']=='guest'))?'selected="selected"':''; ?>>Guest</option>
                            <?php if(isset($bill_results['shipping_user_name']) && ($bill_results['shipping_user_name']!='guest')){ ?>
                                <option value="<?php echo $bill_results['user_id']; ?>" selected="selected"><?php echo $bill_results['shipping_user_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 nopadding">
                        <h5><small>&nbsp;</small></h5>
                        <a  id="newCusDet" href="javascript:"><i class="fa fa-plus-circle fa-2x"></i></a>
                        <a id="customerInfoView" data-toggle="modal" data-target="#CustomerDet" href="javascript:" <?php echo (isset($bill_results) && $bill_results['shipping_user_name']!='guest')?'':'style="display:none;'; ?>><i class="fa fa-info-circle fa-2x"></i></a>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-5">

                        <h5><small>Shipping Fee</small></h5>

                        <input type="text" name="shipping_fee" id="shipping_fee" class="form-control" placeholder="Enter shipping fee" value="<?php echo (isset($bill_results['delivery_cost']))?$bill_results['delivery_cost']:0; ?>">

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Phone Number</small></h5>

                        <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Enter phone no" value="<?php echo (isset($bill_results['shipping_user_contact_no']))?trim($bill_results['shipping_user_contact_no']):''; ?>">

                    </div>

                </div>
                <div class="row ph15 mb10">
                    <div class="col-lg-6 col-md-6 col-sm-6">

                        <h5><small>Remarks</small></h5>

                        <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter remarks"><?php echo (isset($bill_results['comments']))?$bill_results['comments']:''; ?></textarea>

                    </div>
                </div>

            </div>

        </div>
        <div class="panel">
            <div class="panel-body">
                <table class="producttb table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="5%">SNo</th>
                        <th width="15%">Code</th>
                        <th>Description</th>
                        <th width="10%">Qty</th>
                        <th width="10%">Rate</th>
                        <th width="15%">Amount</th>
                        <th width="5%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bill_items)){
                        $sliced_bill= array_slice($bill_items,0,2);
                        $remaining_bill= array_slice($bill_items,2);
                    } ?>
                    <?php
                    $total_cost=0;
                    $subtotal_price=0;
                    for($i=0;$i<=1;$i++){
                    $product_option_id='';
                    if(isset($sliced_bill[$i]['product_id']) && isset($sliced_bill[$i]['option_id'])){
                        $product_option_id = $sliced_bill[$i]['product_id'].'_'.$sliced_bill[$i]['option_id'];
                    }
                    $product_code_text='';
                    if(isset($sliced_bill[$i]['product_code'])){
                        $product_code_text= $sliced_bill[$i]['product_code'];
                    }
                    $product_name_text='';
                    if(isset($sliced_bill[$i]['product_name'])){
                        $product_name_text= $sliced_bill[$i]['product_name'];
                    }
                    $product_quantity=0;
                    if(isset($sliced_bill[$i]['quantity'])){
                        $product_quantity= $sliced_bill[$i]['quantity'];
                    }
                    $is_variable_product=0;
                    if(isset($sliced_bill[$i]['is_variable_product']) && ($sliced_bill[$i]['is_variable_product']==1)){
                        $is_variable_product=1;

                    }
                    $product_price=0;
                    $product_weight='';
                    $product_weight_class='';
                    if(isset($sliced_bill[$i]['product_price'])){
                        $product_price= $sliced_bill[$i]['product_price'];
                        $product_weight=$sliced_bill[$i]['product_weight'];
                        $product_weight_class=$sliced_bill[$i]['product_weight_class'];
                    }

                    $weight_price=0;
                    $weight='';
                    $weight_class='';
                    if(isset($sliced_bill[$i]['weight_price'])){
                        $weight_price= $sliced_bill[$i]['weight_price'];
                        $weight=$sliced_bill[$i]['weight'];
                        $weight_class=$sliced_bill[$i]['weight_class'];
                    }

                    if(isset($sliced_bill[$i]['option_id']) && $sliced_bill[$i]['option_id']!=0){
                        $product_code_text= $sliced_bill[$i]['option_code'];
                        $product_name_text= $sliced_bill[$i]['product_name'].'_'.$sliced_bill[$i]['option_name'];
                        $product_price= $sliced_bill[$i]['option_price'];
                    }
                    $subtotal_price = $product_quantity*$product_price;
                    $total_cost+=$subtotal_price;
                    ?>
                    <tr class="productrow">
                        <td data-sno="<?php echo ($i+1); ?>"><?php echo ($i+1); ?>.</td>
                        <td>
                            <label for="barcode_mode_<?php echo $i; ?>">
                                <input type="radio"  name="scan_mode_<?php echo $i; ?>" id="barcode_mode_<?php echo $i; ?>" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_<?php echo $i; ?>">
                                <input type="radio"  name="scan_mode_<?php echo $i; ?>" id="manual_mode_<?php echo $i; ?>" class="scan_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="<?php echo $product_option_id; ?>" />
                            <input type="text" name="product_code_text[]" class="form-control" value="<?php echo $product_code_text; ?>" />
                            <select name="product_code_select[]" id="product_code_1" class="form-control product_code_select2"  style="display:none;">
                                <?php if(!empty($product_option_id) && !empty($product_code_text)){ ?>
                                    <option value="<?php echo $product_option_id; ?>" selected="selected"><?php echo $product_code_text; ?></option>
                                <?php } ?>
                            </select>
                            </td>
                        <td>
                            <select name="product_description[]" id="product_description_1" class="form-control product_desc_select2">
                                <?php if(!empty($product_option_id) && !empty($product_name_text)){ ?>
                                    <option value="<?php echo $product_option_id; ?>" selected="selected"><?php echo $product_name_text; ?></option>
                                <?php } ?>
                            </select>
                            <div class="clearfix">&nbsp;</div>
                            <div class="weight_container" style="<?php echo ($is_variable_product)?'':'display: none;'; ?>">
                                <input type="hidden" id="weightage" value="<?php echo $weight; ?>"/>
                                <input type="hidden" id="weight_class" value="<?php echo $weight_class; ?>" />
                                <input type="hidden" id="weight_price" value="<?php echo $weight_price; ?>"/>
                                <div class="col-lg-6">
                                    <input type="text" name="product_weight[]" class="product_weight form-control" value="<?php echo (!empty($product_weight))?$product_weight:''; ?>" />
                                </div>
                                <div class="col-lg-6">
                                    <select name="product_weight_class[]" id="product_weight_class_1" class="form-control product_weight_class">
                                        <option value="" <?php echo (empty($product_weight_class))?'selected="selected"':''; ?>>--Weight Class--</option>
                                        <option value="g" <?php echo (!empty($product_weight_class) &&($product_weight_class=='g'))?'selected="selected"':''; ?>>Gram</option>
                                        <option value="kg" <?php echo (!empty($product_weight_class) &&($product_weight_class=='kg'))?'selected="selected"':''; ?>>Kilogram</option>
                                        <option value="ml" <?php echo (!empty($product_weight_class) &&($product_weight_class=='ml'))?'selected="selected"':''; ?> >Millilitre</option>
                                        <option value="l" <?php echo (!empty($product_weight_class) &&($product_weight_class=='l'))?'selected="selected"':''; ?>>Litre</option>
                                    </select>
                                </div>
                            </div>

                           </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value="<?php echo (isset($product_quantity) && (isset($bill_results['payment_status']) && $bill_results['payment_status']==2))?$product_quantity:''; ?>"/>
                            <input name="product_qty[]" id="product_qty_<?php echo ($i+1); ?>" type="text" class="numeric form-control" value="<?php echo (!empty($product_quantity))?$product_quantity:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (!empty($product_price))?$product_price:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control"  value="<?php echo (!empty($subtotal_price))?$subtotal_price:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php } ?>
                    <?php
                    $count=3;
                    if(!empty($remaining_bill)){
                    foreach($remaining_bill as $k=>$v){
                    ?>
                    <tr class="productrow">
                        <?php if(!empty($v)){
                        $product_option_id = $v['product_id'].'_'.$v['option_id'];
                        $product_code= $v['product_code'];
                        $product_name_text= $v['product_name'];
                        $product_quantity = (isset($v['quantity']))?$v['quantity']:0;
                        $product_price= $v['product_price'];

                        $is_variable_product=$v['is_variable_product'];
                        $product_weight= $v['product_weight'];
                        $product_weight_class= $v['product_weight_class'];

                        $weight_price= $v['weight_price'];
                        $weight=$v['weight'];
                        $weight_class=$v['weight_class'];

                        if($v['option_id']!=0){
                            $product_code= $v['option_code'];
                            $product_name_text= $v['product_name'].'_'.$v['option_name'];
                            $product_price= $v['option_price'];
                        }
                        $subtotal_price = $product_quantity*$product_price; ?>
                        <td data-sno="<?php echo  $count;?>"><?php echo $count; ?></td>
                        <td>
                            <label for="barcode_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode_<?php echo  $count;?>" id="barcode_mode_<?php echo  $count;?>" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode_<?php echo  $count;?>" id="manual_mode_<?php echo  $count;?>" class="scan_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="<?php echo (!empty($product_option_id))?$product_option_id:''; ?>" />
                            <input type="text" name="product_code_text[]" class="form-control" value="<?php echo (!empty($product_code))?$product_code:''; ?>" />
                            <select name="product_code[]" id="product_code_2" class="form-control product_code_select2" style="display: none;">
                                <?php if(!empty($product_option_id) && !empty($product_code)){ ?>
                                    <option value="<?php echo $product_option_id; ?>" selected="selected"><?php echo $product_code; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="product_description[]" id="product_description_2" class="form-control product_desc_select2">
                                <?php if(!empty($product_option_id) && !empty($product_name_text)){ ?>
                                    <option value="<?php echo $product_option_id; ?>" selected="selected"><?php echo $product_name_text; ?></option>
                                <?php } ?>
                            </select>
                            <div class="clearfix">&nbsp;</div>
                            <div class="weight_container" style="<?php echo ($is_variable_product)?'':'display: none;'; ?>">
                                <input type="hidden" id="weightage" value="<?php echo $weight; ?>"/>
                                <input type="hidden" id="weight_class" value="<?php echo $weight_class; ?>" />
                                <input type="hidden" id="weight_price" value="<?php echo $weight_price; ?>"/>
                                <div class="col-lg-6">
                                    <input type="text" name="product_weight[]" class="product_weight form-control" value="<?php echo (!empty($product_weight))?$product_weight:''; ?>" />
                                </div>
                                <div class="col-lg-6">
                                    <select name="product_weight_class[]" id="product_weight_class_<?php echo  $count;?>" class="form-control product_weight_class">
                                        <option value="" <?php echo (empty($product_weight_class))?'selected="selected"':''; ?>>--Weight Class--</option>
                                        <option value="g" <?php echo (!empty($product_weight_class) &&($product_weight_class=='g'))?'selected="selected"':''; ?>>Gram</option>
                                        <option value="kg" <?php echo (!empty($product_weight_class) &&($product_weight_class=='kg'))?'selected="selected"':''; ?>>Kilogram</option>
                                        <option value="ml" <?php echo (!empty($product_weight_class) &&($product_weight_class=='ml'))?'selected="selected"':''; ?>>Millilitre</option>
                                        <option value="l" <?php echo (!empty($product_weight_class) &&($product_weight_class=='l'))?'selected="selected"':''; ?>>Litre</option>
                                    </select>
                                </div>
                            </div>

                        </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value="<?php echo (isset($product_quantity) && ($bill_results['payment_status']==2))?$product_quantity:''; ?>"/>
                            <input name="product_qty[]" id="product_qty_2" type="text" class="numeric form-control" value="<?php echo (isset($product_quantity))?$product_quantity:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($product_price))?$product_price:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="<?php echo (isset($subtotal_price))?$subtotal_price:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                            <?php } ?>
                    </tr>
                    <?php $count++;
                        $total_cost+=$subtotal_price;
                    } }
                    $delivery_cost = (isset($bill_results['delivery_cost'])) ? $bill_results['delivery_cost'] : 0;
                    ?>
                    <tr class="productrow">
                        <td data-sno="<?php echo  $count;?>"><?php echo  $count;?></td>
                        <td class="product_code_cell">
                            <label for="barcode_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode[]" id="barcode_mode_<?php echo  $count;?>" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode[]" class="scan_mode" id="manual_mode_<?php echo  $count;?>" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="" />
                            <input type="text" name="product_code_text[]" class="form-control" value="" />
                            <select name="product_code_select[]" id="product_code_3" class="form-control product_code_select2"  style="display:none">
                            </select>
                        </td>
                        <td class="product_desc_cell">
                            <select name="product_description[]" id="product_description_3" class="form-control product_desc_select2">
                            </select>
                            <div class="clearfix">&nbsp;</div>
                            <div class="weight_container" style="display: none;">
                                <input type="hidden" id="weightage" />
                                <input type="hidden" id="weight_class" />
                                <input type="hidden" id="weight_price" />
                                <div class="col-lg-6">
                                    <input type="text" name="product_weight[]" class="product_weight form-control" value="" />
                                </div>
                                <div class="col-lg-6">
                                    <select name="product_weight_class[]" id="product_weight_class_1" class="form-control product_weight_class">
                                        <option value="" selected="selected">--Weight Class--</option>
                                        <option value="g" >Gram</option>
                                        <option value="kg" >Kilogram</option>
                                        <option value="ml" >Millilitre</option>
                                        <option value="l" >Litre</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value=""/>
                            <input name="product_qty[]" id="product_qty_3" type="text" class="numeric form-control" value="" /> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="" /> <a href="javascript:" class="addmore"><i class="fa fa-plus-circle fa-2x"></i></a></td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Total</td>
                        <td><input name="total_cost" type="text" readonly class="form-control" value="<?php echo (isset($bill_results['total_amount'])) ? $bill_results['total_amount'] : 0; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Shipping Cost</td>
                        <td class="shipping_cost" style="padding: 10px 22px;"><?php echo $delivery_cost; ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Discount Percentage</td>
                        <td class="discount_percent" style="padding: 10px;"><input name="discount_percent" type="text" class="form-control" value="<?php echo (isset($bill_results['discount_percent'])) ? $bill_results['discount_percent'] : 0; ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Net Total</td>
                        <td><input name="net_total" type="text" readonly class="form-control net_total" value="<?php echo (isset($bill_results['net_total']))? $bill_results['net_total'] :''; ?>" /></td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="panel">
        <div class="panel-body">
            <div class="row ph15 mb10">
                <h5 class="text-center">Balance Calculator</h5>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <h5><small>Amount Received</small></h5>
                    <input type="text" name="cash_received" class="form-control" id="amount_received_input" value="<?php echo (isset($bill_results['cash_received']))?$bill_results['cash_received']:''; ?>">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <h5><small>Net Total</small></h5>
                    <input type="text" class="form-control net_total" id="net_total" value="<?php echo (isset($bill_results['net_total'])) ? $bill_results['net_total'] : ''; ?>" readonly>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <h5><small>Balance Remaining</small></h5>
                    <input type="text" name="balance_paid" class="form-control" id="balance_input" readonly value="<?php echo (isset($bill_results['balance_paid']))?$bill_results['balance_paid']:''; ?>">
                </div>
            </div>
        </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="row ph15 mb10">
                    <div class="col-lg-3 col-md-3 col-sm-12">

                        <h5><small>Payment By</small></h5>

                        <select name="payment_by" id="payment_by" class="form-control">
                            <option value="Cash" <?php echo (isset($bill_results['payment_mode']) && ($bill_results['payment_mode']=='Cash'))?'selected="selected"':''; ?>>Cash</option>
                            <option value="Credit Card" <?php echo (isset($bill_results['payment_mode']) && ($bill_results['payment_mode']=='Credit Card'))?'selected="selected"':''; ?>>Credit Card</option>
                            <option value="Debit card" <?php echo (isset($bill_results['payment_mode']) && ($bill_results['payment_mode']=='Debit Card'))?'selected="selected"':''; ?>>Debit Card</option>
                            <option value="Cheque" <?php echo (isset($bill_results['payment_mode']) && ($bill_results['payment_mode']=='Cheque'))?'selected="selected"':''; ?>>Cheque</option>
                            <option value="Others" <?php echo (isset($bill_results['payment_mode']) && ($bill_results['payment_mode']=='Others'))?'selected="selected"':''; ?>>Others</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Reference No</small></h5>

                        <input type="text" name="reference_no" id="reference_no" class="form-control" placeholder="Enter reference no" value="<?php echo (isset($bill_results['payment_id']))?$bill_results['payment_id']:''; ?>">

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Payment Status</small></h5>

                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="paid" <?php echo (isset($bill_results['payment_status']) && ($bill_results['payment_status']=='2'))?'selected="selected"':''; ?>>Paid</option>
                            <option value="unpaid" <?php echo (isset($bill_results['payment_status']) && ($bill_results['payment_status']=='1'))?'selected="selected"':''; ?>>UnPaid</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <h5><small>&nbsp;</small></h5>
                        <button type="button" class="btn btn-primary save_print_bill">Save and Print Bill </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
    </form>


</section>


<div id="CustomerDet" class="modal fade" role="dialog">
    <?php if(isset($bill_results)){
        $shipping_user_name=$bill_results['shipping_user_name'];
        $shipping_user_contact_no=$bill_results['shipping_user_contact_no'];
        $shipping_user_email=$bill_results['shipping_user_email'];
        $shipping_user_house_no=$bill_results['shipping_user_house_no'];
        $shipping_user_apt_name=$bill_results['shipping_user_apt_name'];
        $shipping_user_street_addr=$bill_results['shipping_user_street_addr'];
        $shipping_user_landmark=$bill_results['shipping_user_landmark'];
        $shipping_user_city_name=$bill_results['shipping_user_city_name'];
        $shipping_user_state=$bill_results['shipping_user_state'];
        $shipping_user_area_name=$bill_results['shipping_user_area_name'];
        $shipping_user_pincode=$bill_results['shipping_user_pincode'];
        if($bill_results['shipping_user_name']!='guest'){
            if(!empty($user_shipping_results)){
                $shipping_user_name=$user_shipping_results['first_name'].' '.$user_shipping_results['last_name'];
                $shipping_user_contact_no=$user_shipping_results['contact_number'];
                $shipping_user_email=$user_shipping_results['email_address'];
                $shipping_user_house_no=$user_shipping_results['house_no'];
                $shipping_user_apt_name=$user_shipping_results['apartment_name'];
                $shipping_user_street_addr=$user_shipping_results['street_name'];
                $shipping_user_landmark=$user_shipping_results['landmark'];
                $shipping_user_city_name=$user_shipping_results['city_name'];
                $shipping_user_state=$user_shipping_results['state'];
                $shipping_user_area_name=$user_shipping_results['area_name'];
                $shipping_user_pincode=$user_shipping_results['pincode'];
            }

        }
    } ?>
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="<?php echo base_url(); ?>admin/bill/process_customer" id="customer_form">
                <input type="hidden" name="id" id="id" value="<?php echo (isset($bill_results['user_id']))?$bill_results['user_id']:''; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Name<span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Name" value="<?php echo (isset($shipping_user_name))?$shipping_user_name:''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">Phone No<span class="text-danger">*</span></label>
                                <input type="text" name="customer_phone_no" id="customer_phone_no" class="form-control" placeholder="Phone No" value="<?php echo (isset($shipping_user_contact_no))?$shipping_user_contact_no:''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">Email</label>
                                <input type="text" name="customer_email" id="customer_email" class="form-control" placeholder="Email Address" value="<?php echo (isset($shipping_user_email))?$shipping_user_email:''; ?>">
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">House No</label>
                                <input type="text" name="house_no" id="house_no" class="form-control" placeholder="House No" value="<?php echo (isset($shipping_user_house_no))?$shipping_user_house_no:''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">Apartment Name</label>
                                <input type="text" name="apartment_name" id="apartment_name" class="form-control" placeholder="Apartment name" value="<?php echo (isset($shipping_user_apt_name))?$shipping_user_apt_name:''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">Street Name</label>
                                <input type="text" name="street_name" id="street_name" class="form-control" placeholder="Street name" value="<?php echo (isset($shipping_user_street_addr))?$shipping_user_street_addr:''; ?>">
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Landmark</label>
                                <input type="text" name="landmark" id="landmark" class="form-control" placeholder="Landmark" value="<?php echo (isset($shipping_user_landmark))?$shipping_user_landmark:''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="">City</label>
                                <input type="text" name="city_name" id="city_name" class="form-control" placeholder="City name" value="<?php echo (isset($shipping_user_city_name))?$shipping_user_city_name:''; ?>" >
                            </div>
                            <div class="col-md-4">
                                <label for="">Area</label>
                                <input type="text" name="area_name" id="area_name" class="form-control area_name" placeholder="Area name" value="<?php echo (isset($shipping_user_area_name))?$shipping_user_area_name:''; ?>">
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Pincode</label>
                                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" value="<?php echo (isset($shipping_user_pincode))?$shipping_user_pincode:''; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>



<div id="areaToPrint" style="display: none;">

</div>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDqWKKuqGqNmBnjMSsXNXxGjbvoy7gjYI0"></script>
<script type="text/javascript" src="<?php echo $this->config->item('user_js');?>jquery.geocomplete.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js'); ?>plugins/select2/select2.min.css" />
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        window.addmore = function(){
            var lastrow = $('.producttb').find('.productrow:last');
            var clone = lastrow.clone();
            var sno = lastrow.find('td:first').data('sno')+1;
            clone.find('input').val('');
            clone.find('.select2').remove();
            var product_code_select2 = '<label for="barcode_mode_'+sno+'">' +
                '<input type="radio" name="scan_mode_'+sno+'" id="barcode_mode_'+sno+'" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode</label>'+
            '<label for="manual_mode_'+sno+'"> <input type="radio"  name="scan_mode_'+sno+'" id="manual_mode_'+sno+'" class="scan_mode" value="manual"/>&nbsp;Manual</label> ' +
                '<input type="hidden" name="product_option_id[]" value="" />' +
                '<input type="text" name="product_code_text[]" class="form-control" value="" />' +
                '<select name="product_code_select[]" class="form-control product_code_select2" style="display:none;"></select>';
            clone.find('.product_code_cell').html(product_code_select2);
            var product_desc_select2 = '<select name="product_description[]" class="form-control product_desc_select2"></select>' +
                '<div class="clearfix">&nbsp;</div>' +
                '<div class="weight_container" style="display: none;">' +
                '<input type="hidden" id="weightage" />' +
                '<input type="hidden" id="weight_class" />' +
                '<input type="hidden" id="weight_price" />' +
                '<div class="col-lg-6">' +
                '<input type="text" name="product_weight[]" class="product_weight form-control" value="" />' +
                '</div><div class="col-lg-6">' +
                '<select name="product_weight_class[]" id="product_weight_class_1" class="form-control product_weight_class">' +
                '<option value="" selected="selected">--Weight Class--</option>' +
                '<option value="g" >Gram</option>' +
                '<option value="kg" >Kilogram</option>' +
                '<option value="ml" >Millilitre</option>' +
                '<option value="l" >Litre</option>' +
                '</select></div></div>';
            clone.find('.product_desc_cell').html(product_desc_select2);
            clone.find("select[name='product_description[]']").select2(product_desc_select2_opt).on("select2:select", function(e) {
                product_desc_select2_eventf(e,$(this));
            });

            clone.find('td:first').attr('data-sno',sno).html(sno+'.');
            lastrow.find('.fa-plus-circle').remove();
            lastrow.after(clone);
            return true;
        };


        $('#shipping_fee').keyup(function(){
            var shippingCost=$('#shipping_fee').val();
            if(shippingCost==''){
                shippingCost=0;
            }
            shippingCost = parseInt(shippingCost);
            $('.shipping_cost').html(shippingCost);

            var total_cost = $('input[name="total_cost"]').val();
            if(total_cost==''){
                total_cost=0;
            }
            total_cost = parseInt(total_cost);

            var discountVal = $('input[name="discount_percent"]').val();
            if(discountVal==''){
                discountVal=0;
            }
            discountVal = parseInt(discountVal);

            var netTotal = total_cost+shippingCost;
            netTotal = netTotal - (netTotal*(discountVal/100));
            $('.net_total').val(Math.round(netTotal));
            calculateBal();
        });

        $('input[name="discount_percent"]').keyup(function(){
            var discountVal=$('input[name="discount_percent"]').val();
            if(discountVal==''){
                discountVal=0;
            }
            discountVal = parseInt(discountVal);

            var shippingCost = parseInt($('#shipping_fee').val());
            if(shippingCost==''){
                shippingCost = 0;
            }
            shippingCost = parseInt(shippingCost);

            var totalCost = parseInt($('input[name="total_cost"]').val());
            if(totalCost==''){
                totalCost = 0;
            }
            totalCost = parseInt(totalCost);

            var netTotal = totalCost+shippingCost;
            netTotal = netTotal - (netTotal*(discountVal/100));
            $('.net_total').val(Math.round(netTotal));
            calculateBal();
        });

        $(document).on('keyup','input[name="product_qty[]"]',function (e) {
            var $this=$(this),qty = $(this).val();

           if(qty!='') {
               var product_option_id,tr = $(this).closest('tr'),
                   existing_product_qty =tr.find('.existing_product_qty').val();
               if(existing_product_qty==''){
                   existing_product_qty=0;
               }
               existing_product_qty=parseInt(existing_product_qty);
               product_option_id = tr.find('input[name="product_option_id[]"]').val();
               $.ajax({
                   url: base_url + "bill/get_product_details",
                   type: 'post',
                   data: 'product_option_id=' + product_option_id,
                   dataType: 'json',
                   success: function (response) {
                       if (response != '') {
                           var product_qty=parseInt(response.product_qty);
                           var final_qty = existing_product_qty+product_qty;
                           if ((final_qty) == 0) {
                               $this.val(0);
                               alert('No Stock available');
                           }

                           if ((final_qty) < parseInt(qty)) {
                               if(existing_product_qty!=0){
                                   $this.val(existing_product_qty);
                               }else{
                                   $this.val(final_qty);
                               }
                               alert('only '+final_qty+' is available');
                           }
                       }
                       calculate_total($this);
                   }
               });
           }
        });

        $(document).on('keydown','.producttb .productrow:last .amounttd',function (e) {
            var key = e.which;
            if (key == 13)
            {
                addmore();
                return false;
            }
        });
        $(document).on('click','.addmore',addmore);
        $(document).on('click','.removemore',function () {
           $(this).closest('tr').remove();
            resetSNo();
            calculate_total($(this));
        });
        $(document).on('click','.clear_row',function () {
            var tr = $(this).closest('tr');
            if(tr.find('.fa-plus-circle').length>0){
                tr.find('input:text').val('');
                tr.find('input:hidden').val('');
                tr.find(".product_code_select2").val('').trigger('change');
                tr.find(".product_desc_select2").val('').trigger('change');
            }else{
                tr.remove();
            }
            resetSNo();
            calculate_total($(this));
        });

        var resetSNo=function(){
            $('.productrow').each(function(i,v){
                i = i+1;
                $(this).find('td:first').attr('data-sno',i).html(i+'.');
            });
        };
        $(".area_name").geocomplete({
            details: ".geo-location",
            types: ["geocode"]
        }).bind("geocode:result", function(event, result) {
            $(this).val(result.name);
        });

        var product_code_select2_opt={
            tokenSeparators: [","],
            placeholder:'Type your product code',
            casesensitive:false,
            ajax: {
                url: base_url+"bill/get_product_code",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 20) < data.total_count
                        }
                    };
                },
                cache: true
            },
            selectOnBlur: true,
            selectOnClose: true,
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            maximumSelectionSize:3,
            templateResult: formatResult,
            templateSelection: formatSelection
        };

        $(document).on('change','.scan_mode',function(){
            var td= $(this).closest('td');
            td.find('.clear_row').trigger('click');
            if($(this).val()=='barcode'){
                td.find('input[name="product_code_text[]"]').show();
                td.find('.product_code_select2').hide();
                td.find('.select2').remove();
            }else{
                td.find('input[name="product_code_text[]"]').hide();
                td.find('.product_code_select2').show();
                td.find('.product_code_select2').select2(product_code_select2_opt).on("select2:select", function(e) {
                    product_code_select2_eventf(e,$(this));
                });
            }
        });

        $(document).on('keyup','input[name="product_code_text[]"]', function (e) {
            if (e.keyCode === 13)
            {
                var $this= $(this);
                var self=this;
                var value= $this.val();

                if((value!='') &&(value.length>2)){
                    product_code_ajax(self,value);
                }
                return false;
            }
        });

        var calculateNewPrice=function(){
            var $this= $(this);
            var tr = $this.closest('tr');
            var weightage = tr.find('#weightage').val();
            var weightClass = tr.find('#weight_class').val();
            var weightPrice = tr.find('#weight_price').val();
            var productWeightClass = tr.find('.product_weight_class option:selected').val();
            var productWeight = tr.find('.product_weight').val();
            var productPrice=0;
            var calcWeight=0;
            var calcProductWeight=0;
            //console.log(productWeightClass);
            //console.log(weightClass);
            if(productWeightClass!=''){
                calcWeight=weightage;
                if(weightClass=='kg' || weightClass=='l') {
                    calcWeight = weightage*1000;
                }
               // console.log(calcWeight);
                calcProductWeight=productWeight;
                if(productWeightClass=='kg' || productWeightClass=='l') {
                    calcProductWeight = productWeight*1000;
                }
               // console.log(calcProductWeight);
                productPrice = (calcProductWeight/calcWeight)*weightPrice;
                tr.find('input[name="product_rate[]"]').val(productPrice.toFixed(2));
            }
            calculate_total($this);
        };
        $(document).on('keyup','input[name="product_weight[]"]', calculateNewPrice);
        $(document).on('change','select[name="product_weight_class[]"]', calculateNewPrice);

        var product_desc_select2_opt={
            tokenSeparators: [","],
            placeholder:'Type your product desc',
            casesensitive:false,
            ajax: {
                url: base_url+"bill/get_product_desc",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 20) < data.total_count
                        }
                    };
                },
                cache: true
            },
            selectOnBlur: true,
            selectOnClose: true,
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            maximumSelectionSize:3,
            templateResult: formatResult,
            templateSelection: formatSelection
        };


        $('.product_desc_select2').select2(product_desc_select2_opt).on("select2:select", function(e) {
            product_desc_select2_eventf(e,$(this));
        });


        $('#customer_no').select2({
            tokenSeparators: [","],
            placeholder:'Type your customer name',
            casesensitive:false,
            ajax: {
                url: base_url+"bill/get_customer_list",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 20) < data.total_count
                        }
                    };
                },
                cache: true
            },
            selectOnBlur: true,
            selectOnClose: true,
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1,
            maximumSelectionSize:3,
            templateResult: formatResult,
            templateSelection: formatSelection
        }).on('select2:select',function(e) {
            var phone_no = e.params.data.title;
            var split = phone_no.split('-');
            $('#phone_no').val(split[1]);
            var $CustomerDet = $('#CustomerDet');
            $('#customerInfoView').show();
            $CustomerDet.find('#id').val(e.params.data.id);
            $CustomerDet.find('#customer_name').val(e.params.data.user_name);
            $CustomerDet.find('#customer_phone_no').val((e.params.data.contact_number).trim());
            $CustomerDet.find('#customer_email').val(e.params.data.email_address);
            $CustomerDet.find('#apartment_name').val(e.params.data.apartment_name);
            $CustomerDet.find('#house_no').val(e.params.data.house_no);
            $CustomerDet.find('#street_name').val(e.params.data.street_name);
            $CustomerDet.find('#landmark').val(e.params.data.landmark);
            $CustomerDet.find('#city_name').val(e.params.data.city_name);
            $CustomerDet.find('#area_name').val(e.params.data.area_name);
            $CustomerDet.find('#pincode').val(e.params.data.pincode);
        });


        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g,'');
        });
        $('#bill_frm').validate({
                ignore: ':hidden',
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                cash_received:{
                    required:true
                },
                'product_qty[]':{
                    required:true,
                    number:true
                },
                'product_option_id[]':{
                    required:true
                },
                'product_description[]':{
                    required:true
                }
            }
        });

        $('#customer_form').validate({
            ignore: [],
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                customer_name:{
                    required:true,
                    noTild:true
                },
                customer_phone_no:{
                    required:true,
                    number:true,
                    maxlength:10,
                    minlength:10
                },
                customer_email:{
                    validEmail:true
                },
                house_no:{
                    noTild:true
                },
                apartment_name:{
                    noTild:true
                },
                street_name:{
                    noTild:true
                },
                landmark:{
                    noTild:true
                },
                city:{
                    noTild:true
                },
                area_name:{
                    noTild:true
                },
                pincode:{
                  number:true
                }

            },
            submitHandler:function(form){
                $.ajax({
                    url:$(form).attr('action'),
                    type:'post',
                    data:$(form).serialize(),
                    success:function(response){
                        $('#customer_no').html(response).trigger('change');
                        $('#CustomerDet').modal('hide');
                    }
                });
            }
        });

        $('.save_print_bill').click(function(){
            if($('#bill_frm').valid()){
                $.ajax({
                    url:base_url+'bill/save_print_bill',
                    type:'post',
                    data:$('#bill_frm').serialize(),
                    success:function(response){
                        $('#areaToPrint').html(response);
                        printDiv();
                        window.location.reload();
                    }
                });
                return false;
            }
        });

        $('#amount_received_input').keyup(calculateBal);

        $('#newCusDet').click(function(){
            $('#CustomerDet').find('input[type="text"]').val('');
            $('#CustomerDet').find('input[type="hidden"]').val('');
            $('#CustomerDet').modal('show');
        })
    });
    function printDiv() {
        var divToPrint = document.getElementById('areaToPrint');
        newWin = window.open("");
        newWin.document.write(divToPrint.innerHTML);
        newWin.print();
        newWin.close();
    }
    function calculate_total($this){
        var tr = $this.closest('tr');
        var qty = tr.find('input[name="product_qty[]"]').val();
        var rate = tr.find('input[name="product_rate[]"]').val();
        var sub_total = (qty*rate);
        tr.find('input[name="product_amount[]"]').val(sub_total);
        var total_amt=0;
        $('.producttb').find('.amounttd').each(function(){
            total_amt += Number($(this).val());
        });
        var shipping_fee = $('#shipping_fee').val();
        if(shipping_fee==''){
            shipping_fee=0;
        }
        $('input[name="total_cost"]').val(Math.round(total_amt));
        total_amt=Math.round(total_amt+parseFloat(shipping_fee));
        $('.net_total').val(total_amt);
        $('#amount_received_input').val(total_amt);
        calculateBal();
    }

    function product_code_ajax(self,value){
        var __self=$(self);
        var $product_code_text=$('input[name="product_code_text[]"]');
        $.ajax({
            url:base_url+"bill/get_product_code_details",
            type:'post',
            data:'product_code='+value,
            dataType:'json',
            success:function(response){
                if(response!=''){
                    if(response.product_qty==0){
                        alert('No Stock available');
                        __self.val('');
                        return false;
                    }else{
                        var product_code=response.product_code;
                        var codeExists=false;
                        $product_code_text.each(function(i,v){
                            if($(this).val()==product_code && ($(this).closest('tr').find('input[name="product_qty[]"]').val()!='')) {
                                var tr = $(this).closest('tr');
                                var qty=parseInt(tr.find('input[name="product_qty[]"]').val())+1;
                                tr.find('input[name="product_qty[]"]').val(qty);
                                calculate_total($(this));
                                __self.val('');
                                codeExists=true;
                            }
                        });

                        if(!codeExists){
                            console.log(response.product_qty);
                            var tr = __self.closest('tr');
                            var product_desc_ele = tr.find('select[name="product_description[]"]');
                            product_desc_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_desc+'</option>').trigger('change.select2');
                            tr.find('input[name="product_option_id[]"]').val(response.product_option_id);

                            tr.find('#weightage').val(0);
                            tr.find('#weight_class').val('');
                            tr.find('#weight_price').val(0);
                            tr.find('.product_weight').val('');
                            tr.find('.product_weight_class').val('');
                            if(response.is_product_variable==1){
                                tr.find('.weight_container').show();
                                tr.find('#weightage').val(response.weightage);
                                tr.find('.product_weight_class option').prop('disabled',true);
                                if((response.weight_class=='g') || (response.weight_class=='kg')){
                                    tr.find('.product_weight_class option').filter('[value="g"],[value="kg"]').prop('disabled',false);
                                }
                                if((response.weight_class=='ml') || (response.weight_class=='l')){
                                    tr.find('.product_weight_class option').filter('[value="ml"],[value="l"]').prop('disabled',false);
                                }
                                tr.find('#weight_class').val(response.weight_class);
                                tr.find('#weight_price').val(response.weight_price);
                            }else{
                                tr.find('.weight_container').hide();
                            }

                            tr.find('input[name="product_qty[]"]').val(1);
                            tr.find('input[name="product_rate[]"]').val(response.product_price);
                            tr.find('input[name="product_amount[]"]').val(response.product_price);
                            calculate_total(__self);

                            if($product_code_text.index(self)==($product_code_text.length-1)){
                                window.addmore();
                            }
                            $product_code_text= $('input[name="product_code_text[]"]');
                            $product_code_text.eq(($product_code_text.index(self))+1).focus();
                        }
                    }
                }else{
                    alert('No product found');
                    __self.val('');
                    return false;
                }
            }
        });
    }

    function product_code_select2_eventf(e,$this){
        var product_option_id = e.params.data.id;
        $.ajax({
            url:base_url+"bill/get_product_details",
            type:'post',
            data:'product_option_id='+product_option_id,
            dataType:'json',
            success:function(response){
                if(response!=''){
                    var tr = $this.closest('tr');
                    if(response.product_qty==0){
                        alert('No Stock available');
                        tr.find('.product_code_select2').val('').trigger('change');
                        return false;
                    }else {
                        var product_desc_ele = tr.find('select[name="product_description[]"]');
                        product_desc_ele.html('<option value="' + response.product_option_id + '" selected="selected">' + response.product_desc + '</option>').trigger('change.select2');
                        tr.find('input[name="product_option_id[]"]').val(response.product_option_id);

                        tr.find('#weightage').val(0);
                        tr.find('#weight_class').val('');
                        tr.find('#weight_price').val(0);
                        tr.find('.product_weight').val('');
                        tr.find('.product_weight_class').val('');
                        if(response.is_product_variable==1){
                            tr.find('.weight_container').show();
                            tr.find('#weightage').val(response.weightage);
                            tr.find('.product_weight_class option').prop('disabled',true);
                            if((response.weight_class=='g') || (response.weight_class=='kg')){
                                tr.find('.product_weight_class option').filter('[value="g"],[value="kg"]').prop('disabled',false);
                            }
                            if((response.weight_class=='ml') || (response.weight_class=='l')){
                                tr.find('.product_weight_class option').filter('[value="ml"],[value="l"]').prop('disabled',false);
                            }
                            tr.find('#weight_class').val(response.weight_class);
                            tr.find('#weight_price').val(response.weight_price);
                        }else{
                            tr.find('.weight_container').hide();
                        }

                        tr.find('input[name="product_qty[]"]').val(1);
                        tr.find('input[name="product_rate[]"]').val(response.product_price);
                        tr.find('input[name="product_amount[]"]').val(response.product_price);
                        calculate_total($this);
                    }
                }
            }
        });
    }

    function product_desc_select2_eventf(e,$this){
        var product_option_id = e.params.data.id;
        $.ajax({
            url:base_url+"bill/get_product_details",
            type:'post',
            data:'product_option_id='+product_option_id,
            dataType:'json',
            success:function(response){
                if(response!=''){
                    if(response.product_qty==0){
                        alert('No Stock available');
                        tr.find('.product_desc_select2').val('').trigger('change');
                        return false;
                    }else{
                        var tr = $this.closest('tr');
                        var product_code_ele = tr.find('.product_code_select2');
                        product_code_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_code+'</option>').trigger('change.select2');
                        tr.find('input[name="product_option_id[]"]').val(response.product_option_id);
                        tr.find('input[name="product_code_text[]"]').val(response.product_code);

                        tr.find('#weightage').val(0);
                        tr.find('#weight_class').val('');
                        tr.find('#weight_price').val(0);
                        tr.find('.product_weight').val('');
                        tr.find('.product_weight_class').val('');
                        if(response.is_product_variable==1){
                            tr.find('.weight_container').show();
                            tr.find('#weightage').val(response.weightage);
                            tr.find('.product_weight_class option').prop('disabled',true);
                            if((response.weight_class=='g') || (response.weight_class=='kg')){
                                tr.find('.product_weight_class option').filter('[value="g"],[value="kg"]').prop('disabled',false);
                            }
                            if((response.weight_class=='ml') || (response.weight_class=='l')){
                                tr.find('.product_weight_class option').filter('[value="ml"],[value="l"]').prop('disabled',false);
                            }
                            tr.find('#weight_class').val(response.weight_class);
                            tr.find('#weight_price').val(response.weight_price);
                        }else{
                            tr.find('.weight_container').hide();
                        }
                        tr.find('input[name="product_qty[]"]').val(1);
                        tr.find('input[name="product_rate[]"]').val(response.product_price);
                        tr.find('input[name="product_amount[]"]').val(response.total_amt_with_tax);
                        calculate_total($this);
                    }
                }

            }
        });
    }

    function calculateBal(){
        var net_total = $('#net_total').val();
        var amount_received_input =  $('#amount_received_input').val()
        if(amount_received_input==''){
            amount_received_input=0;
        }
        if(net_total==''){
            net_total=0;
        }
        net_total=parseFloat(net_total);
        amount_received_input = parseFloat(amount_received_input);
        var balanceAmt = net_total-amount_received_input;
        
        $('#balance_input').val(Math.abs(balanceAmt));
    }



    function formatResult (data) {
        return data.title;
    }
    function formatSelection (data) {
        return data.title || data.text;
    }

</script>
<style>
    .select2-container{
        width: 100% !important;
        height: 40px;
        font-size:13px;

    }
    .select2-container--default .select2-selection--single{
        height:40px;
        border:1px solid #e8e7e3;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height:38px;
    }
    .pac-container{
        z-index: 99999 !important;
    }
    .amounttd{
        display: inline-block;
        width: 80%;
    }
    .amounttd+a{

    }

</style>