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
                    <div class="col-lg-2 col-md-2 col-sm-6">

                        <h5><small>Order No</small></h5>

                        <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter order no" value="<?php echo (isset($bill_results['order_id']))?$bill_results['order_id']:date('Ymdhis'); ?>" readonly>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-5">

                        <h5><small>Customer</small></h5>

                        <select name="customer_no" id="customer_no" class="form-control">
                            <option value="guest" <?php echo (isset($bill_results['shipping_user_name']) && ($bill_results['shipping_user_name']=='guest'))?'selected="selected"':''; ?>>Guest</option>
                            <?php if(isset($bill_results['shipping_user_name'])){ ?>
                                <option value="<?php echo $bill_results['shipping_user_name']; ?>" selected="selected"><?php echo $bill_results['shipping_user_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 nopadding">
                        <h5><small>&nbsp;</small></h5>
                        <a data-toggle="modal" data-target="#newCustomer" href="javascript:"><i class="fa fa-plus-circle fa-2x"></i></a>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Shipping Fee</small></h5>

                        <input type="text" name="shipping_fee" id="shipping_fee" class="form-control" placeholder="Enter shipping fee" value="<?php echo (isset($bill_results['delivery_cost']))?$bill_results['delivery_cost']:''; ?>">

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Phone Number</small></h5>

                        <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="Enter phone no" value="<?php echo (isset($bill_results['shipping_user_contact_no']))?$bill_results['shipping_user_contact_no']:''; ?>">

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
                    <tr class="productrow">
                        <?php
                        $net_total=0;
                        if(!empty($sliced_bill[0])){
                        $product_option_id_0 = $sliced_bill[0]['product_id'].'_'.$sliced_bill[0]['option_id'];
                        $product_code_text_0= $sliced_bill[0]['product_code'];
                        $product_name_text_0= $sliced_bill[0]['product_name'];
                        $product_quantity_0 = (isset($sliced_bill[0]['quantity']))?$sliced_bill[0]['quantity']:0;
                        $product_price_0= $sliced_bill[0]['product_price'];

                        if($sliced_bill[0]['option_id']!=0){
                            $product_code_text_0= $sliced_bill[0]['option_code'];
                            $product_name_text_0= $sliced_bill[0]['product_name'].'_'.$sliced_bill[0]['option_name'];
                            $product_price_0= $sliced_bill[0]['option_price'];
                        }
                        $subtotal_price_0 = $product_quantity_0*$product_price_0;
                            $net_total+=$subtotal_price_0;
                            ?>
                        <?php } ?>
                        <td data-sno="1">1.</td>
                        <td>
                            <label for="barcode_mode_0">
                                <input type="radio"  name="scan_mode_0" id="barcode_mode_0" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_0">
                                <input type="radio"  name="scan_mode_0" id="manual_mode_0" class="scan_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="<?php echo (!empty($product_option_id_0))?$product_option_id_0:''; ?>" />
                            <input type="text" name="product_code_text[]" class="form-control" value="<?php echo (!empty($product_code_text_0))?$product_code_text_0:''; ?>" />
                            <select name="product_code_select[]" id="product_code_1" class="form-control product_code_select2"  style="display:none;">
                                <?php if(!empty($product_option_id_0) && !empty($product_code_text_0)){ ?>
                                    <option value="<?php echo $product_option_id_0; ?>" selected="selected"><?php echo $product_code_text_0; ?></option>
                                <?php } ?>
                            </select>
                            </td>
                        <td>
                            <select name="product_description[]" id="product_description_1" class="form-control product_desc_select2">
                                <?php if(!empty($product_option_id_0) && !empty($product_name_text_0)){ ?>
                                    <option value="<?php echo $product_option_id_0; ?>" selected="selected"><?php echo $product_name_text_0; ?></option>
                                <?php } ?>
                            </select>
                           </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value="<?php echo (isset($product_quantity_0) && ($bill_results['payment_status']==2))?$product_quantity_0:''; ?>"/>
                            <input name="product_qty[]" id="product_qty_1" type="text" class="numeric form-control" value="<?php echo (isset($product_quantity_0))?$product_quantity_0:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($product_price_0))?$product_price_0:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control"  value="<?php echo (isset($subtotal_price_0))?$subtotal_price_0:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>

                    </tr>
                    <tr class="productrow">
                        <?php if(!empty($sliced_bill[1])){
                        $product_option_id_1 = $sliced_bill[1]['product_id'].'_'.$sliced_bill[1]['option_id'];
                        $product_code_text_1= $sliced_bill[1]['product_code'];
                        $product_name_text_1= $sliced_bill[1]['product_name'];
                        $product_quantity_1 = (isset($sliced_bill[1]['quantity']))?$sliced_bill[1]['quantity']:0;
                        $product_price_1= $sliced_bill[1]['product_price'];

                        if($sliced_bill[1]['option_id']!=0){
                            $product_code_text_1= $sliced_bill[1]['option_code'];
                            $product_name_text_1= $sliced_bill[1]['product_name'].'_'.$sliced_bill[1]['option_name'];
                            $product_price_1= $sliced_bill[1]['option_price'];
                        }
                        $subtotal_price_1 = $product_quantity_1*$product_price_1;
                            $net_total+=$subtotal_price_1;
                            ?>
                        <?php } ?>
                        <td data-sno="2">2.</td>
                        <td>
                            <label for="barcode_mode_1">
                                <input type="radio"  name="scan_mode_1" id="barcode_mode_1" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_1">
                                <input type="radio"  name="scan_mode_1" id="manual_mode_1" class="scan_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="<?php echo (!empty($product_option_id_1))?$product_option_id_1:''; ?>" />
                            <input type="text" name="product_code_text[]" class="form-control" value="<?php echo (!empty($product_code_text_1))?$product_code_text_1:''; ?>" />
                            <select name="product_code_select[]" id="product_code_2" class="form-control product_code_select2"  style="display: none;">
                                <?php if(!empty($product_option_id_1) && !empty($product_code_text_1)){ ?>
                                    <option value="<?php echo $product_option_id_1; ?>" selected="selected"><?php echo $product_code_text_1; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="product_description[]" id="product_description_2" class="form-control product_desc_select2">
                                <?php if(!empty($product_option_id_1) && !empty($product_name_text_1)){ ?>
                                    <option value="<?php echo $product_option_id_1; ?>" selected="selected"><?php echo $product_name_text_1; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value="<?php echo (isset($product_quantity_1) && ($bill_results['payment_status']==2))?$product_quantity_1:''; ?>"/>
                            <input name="product_qty[]" id="product_qty_2" type="text" class="numeric form-control" value="<?php echo (isset($product_quantity_1))?$product_quantity_1:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($product_price_1))?$product_price_1:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="<?php echo (isset($subtotal_price_1))?$subtotal_price_1:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>

                    </tr>
                    <?php

                    $count=3;
                    if(!empty($remaining_bill)){
                    foreach($remaining_bill as $k=>$v){
                    ?>
                    <tr class="productrow">
                        <?php if(!empty($v)){
                        $item_arr[$k]['product_option_id'] = $v['product_id'].'_'.$v['option_id'];
                        $item_arr[$k]['product_code']= $v['product_code'];
                        $item_arr[$k]['product_name_text']= $v['product_name'];
                        $item_arr[$k]['product_quantity'] = (isset($v['quantity']))?$v['quantity']:0;
                        $item_arr[$k]['product_price']= $v['product_price'];

                        if($v['option_id']!=0){
                            $item_arr[$k]['product_code']= $v['option_code'];
                            $item_arr[$k]['product_name_text']= $v['product_name'].'_'.$v['option_name'];
                            $item_arr[$k]['product_price']= $v['option_price'];
                        }
                        $item_arr[$k]['subtotal_price'] = $item_arr[$k]['product_quantity']*$item_arr[$k]['product_price']; ?>
                        <td data-sno="<?php echo  $count;?>"><?php echo $count; ?></td>
                        <td>
                            <label for="barcode_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode_<?php echo  $count;?>" id="barcode_mode_<?php echo  $count;?>" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode_<?php echo  $count;?>">
                                <input type="radio"  name="scan_mode_<?php echo  $count;?>" id="manual_mode_<?php echo  $count;?>" class="scan_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="<?php echo (!empty($item_arr[$k]['product_option_id']))?$item_arr[$k]['product_option_id']:''; ?>" />
                            <input type="text" name="product_code_text[]" class="form-control" value="<?php echo (!empty($item_arr[$k]['product_code']))?$item_arr[$k]['product_code']:''; ?>" />
                            <select name="product_code[]" id="product_code_2" class="form-control product_code_select2" style="display: none;">
                                <?php if(!empty($item_arr[$k]['product_option_id']) && !empty($item_arr[$k]['product_code'])){ ?>
                                    <option value="<?php echo $item_arr[$k]['product_option_id']; ?>" selected="selected"><?php echo $item_arr[$k]['product_code']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="product_description[]" id="product_description_2" class="form-control product_desc_select2">
                                <?php if(!empty($item_arr[$k]['product_option_id']) && !empty($item_arr[$k]['product_name_text'])){ ?>
                                    <option value="<?php echo $item_arr[$k]['product_option_id']; ?>" selected="selected"><?php echo $item_arr[$k]['product_name_text']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="existing_product_qty[]" class="existing_product_qty" type="hidden" value="<?php echo (isset($item_arr[$k]['product_quantity']) && ($bill_results['payment_status']==2))?$item_arr[$k]['product_quantity']:''; ?>"/>
                            <input name="product_qty[]" id="product_qty_2" type="text" class="numeric form-control" value="<?php echo (isset($item_arr[$k]['product_quantity']))?$item_arr[$k]['product_quantity']:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($item_arr[$k]['product_price']))?$item_arr[$k]['product_price']:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="<?php echo (isset($item_arr[$k]['subtotal_price']))?$item_arr[$k]['subtotal_price']:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                            <?php } ?>
                    </tr>
                    <?php $count++;
                        $net_total+=$item_arr[$k]['subtotal_price'];
                    } } ?>
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
                        <td><input name="total_amount" type="text" readonly class="form-control" value="<?php echo (isset($net_total))?$net_total:''; ?>" /></td>
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
                    <input type="text" class="form-control" id="amount_received_input">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <h5><small>Total Cost</small></h5>
                    <input type="text" class="form-control" id="total_cost_input" value="<?php echo (isset($net_total))?$net_total:''; ?>">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <h5><small>Balance Remaining</small></h5>
                    <input type="text" class="form-control" id="balance_input">
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

<div id="newCustomer" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="<?php echo base_url(); ?>admin/bill/process_add_customer" id="customer_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Customer</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Name<span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-md-4">
                                <label for="">Phone No<span class="text-danger">*</span></label>
                                <input type="text" name="customer_phone_no" id="customer_phone_no" class="form-control" placeholder="Phone No" >
                            </div>
                            <div class="col-md-4">
                                <label for="">Email</label>
                                <input type="text" name="customer_email" id="customer_email" class="form-control" placeholder="Email Address" >
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">House No</label>
                                <input type="text" name="house_no" id="house_no" class="form-control" placeholder="House No" >
                            </div>
                            <div class="col-md-4">
                                <label for="">Apartment Name</label>
                                <input type="text" name="apartment_name" id="apartment_name" class="form-control" placeholder="Apartment name" >
                            </div>
                            <div class="col-md-4">
                                <label for="">Street Name</label>
                                <input type="text" name="street_name" id="street_name" class="form-control" placeholder="Street name" >
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Landmark</label>
                                <input type="text" name="landmark" id="landmark" class="form-control" placeholder="Landmark" >
                            </div>
                            <div class="col-md-4">
                                <label for="">City</label>
                                <input type="text" name="city_name" id="city_name" class="form-control" placeholder="City name" >
                            </div>
                            <div class="col-md-4">
                                <label for="">Area</label>
                                <input type="text" name="area_name" id="area_name" class="form-control area_name" placeholder="Area name" >
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="section row" id="spy1">
                            <div class="col-md-4">
                                <label for="">Pincode</label>
                                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode" >
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
            var product_desc_select2 = '<select name="product_description[]" class="form-control product_desc_select2"></select>';
            clone.find('.product_desc_cell').html(product_desc_select2);
            clone.find("select[name='product_description[]']").select2(product_desc_select2_opt).on("select2:select", function(e) {
                product_desc_select2_eventf(e,$(this));
            });

            clone.find('td:first').attr('data-sno',sno).html(sno+'.');
            clone.find('a').addClass('removemore').removeClass('addmore');
            clone.find('i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
            lastrow.after(clone);
            return true;
        };

        $(document).on('keyup','input[name="product_qty[]"]',function (e) {
            var $this=$(this),qty = $(this).val();

           if(qty!='') {
               var product_code,tr = $(this).closest('tr'),
                   existing_product_qty =tr.find('.existing_product_qty').val();
               if(existing_product_qty==''){
                   existing_product_qty=0;
               }
               existing_product_qty=parseInt(existing_product_qty);
               if(tr.find('.scan_mode:checked').val()=='barcode'){
                   product_code = tr.find('input[name="product_code_text[]"]').val();
               }else{
                   product_code = tr.find('input[name="product_code_select[]"]').text();
               }
               $.ajax({
                   url: base_url + "bill/get_product_code_details",
                   type: 'post',
                   data: 'product_code=' + product_code,
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
            calculate_total($(this));
        });
        $(document).on('click','.clear_row',function () {
            var tr = $(this).closest('tr');
            tr.find('input:text').val('');
            tr.find('input:hidden').val('');
            tr.find(".product_code_select2").val('').trigger('change');
            tr.find(".product_desc_select2").val('').trigger('change');
            calculate_total($(this));
        });
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
                        $('#newCustomer').modal('hide');
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
                    }
                });
                return false;
            }
        });

        $('#amount_received_input').keyup(function(){
            var total_cost_input = parseFloat($('#total_cost_input').val());
            var amount_received_input = parseFloat($(this).val());
            var balanceAmt = total_cost_input-amount_received_input;

            $('#balance_input').val(balanceAmt)
        });
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
        $('input[name="total_amount"]').val(total_amt);
        $('#total_cost_input').val(total_amt);
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
                            var tr = __self.closest('tr');
                            var product_desc_ele = tr.find('select[name="product_description[]"]');
                            product_desc_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_desc+'</option>').trigger('change.select2');
                            tr.find('input[name="product_option_id[]"]').val(response.product_option_id);
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
                        tr.find('input[name="product_qty[]"]').val(1);
                        tr.find('input[name="product_rate[]"]').val(response.product_price);
                        tr.find('input[name="product_amount[]"]').val(response.total_amt_with_tax);
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
                        tr.find('input[name="product_qty[]"]').val(1);
                        tr.find('input[name="product_rate[]"]').val(response.product_price);
                        tr.find('input[name="product_amount[]"]').val(response.total_amt_with_tax);
                        calculate_total($this);
                    }
                }

            }
        });
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