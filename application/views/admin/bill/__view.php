<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Bill</h4>

        <hr class="alt short">

    </div>

</header>

<section id="content" class="table-layout animated fadeIn">
    <form id="bill_frm" method="get" class="form-horizontal" role="form">
        <div class="panel">

            <div class="panel-body">

                <div class="row ph15 mb10">
                    <div class="col-lg-6 col-md-6 col-sm-6 pull-right text-right">
                        <a href="<?php echo base_url(); ?>admin/offline_orders" class="btn btn-primary">View Offline Orders</a>
                        <button type="button" class="btn btn-primary new_bill" onclick="javascript:window.location.reload();">Create new Bill</button>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-lg-2 col-md-2 col-sm-6">

                        <h5><small>Order No</small></h5>

                        <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter order no" value="<?php echo (isset($bill_results['order_id']))?$bill_results['order_id']:''; ?>" readonly>

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-5">

                        <h5><small>Customer</small></h5>

                        <select name="customer_no" id="customer_no" class="form-control">
                            <option value="guest" <?php echo (isset($bill_results['shipping_user_name']) && ($bill_results['shipping_user_name']=='Guest'))?'selected="selected"':''; ?>>Guest</option>
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

                        <textarea name="remarks" id="remarks" class="form-control" placeholder="Enter remarks"><?php echo (isset($bill_results['payment_details']))?$bill_results['payment_details']:''; ?></textarea>

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
                        <?php if(!empty($sliced_bill[0])){
                        $product_code_0 = $sliced_bill[0]['product_id'].'_'.$sliced_bill[0]['option_id'];
                        $product_code_text_0= $sliced_bill[0]['product_code'];
                        $product_name_text_0= $sliced_bill[0]['product_name'];
                        $product_quantity_0 = (isset($sliced_bill[0]['quantity']))?$sliced_bill[0]['quantity']:0;
                        $product_price_0= $sliced_bill[0]['product_price'];

                        if($sliced_bill[0]['option_id']!=0){
                            $product_code_text_0= $sliced_bill[0]['option_code'];
                            $product_name_text_0= $sliced_bill[0]['product_name'].'_'.$sliced_bill[0]['option_name'];
                            $product_price_0= $sliced_bill[0]['option_price'];
                        }
                        $subtotal_price_0 = $product_quantity_0*$product_price_0; ?>
                        <?php } ?>
                        <td data-sno="1">1.</td>
                        <td>
                            <select name="product_code[]" id="product_code_1" class="form-control product_code_select2" multiple="multiple">
                                <?php if(!empty($product_code_0) && !empty($product_code_text_0)){ ?>
                                    <option value="<?php echo $product_code_0; ?>" selected="selected"><?php echo $product_code_text_0; ?></option>
                                <?php } ?>
                            </select>
                            </td>
                        <td>
                            <select name="product_description[]" id="product_description_1" class="form-control product_desc_select2">
                                <?php if(!empty($product_code_0) && !empty($product_name_text_0)){ ?>
                                    <option value="<?php echo $product_code_0; ?>" selected="selected"><?php echo $product_name_text_0; ?></option>
                                <?php } ?>
                            </select>
                           </td>
                        <td><input name="product_qty[]" id="product_qty_1" type="text" class="numeric form-control" value="<?php echo (isset($product_quantity_0))?$product_quantity_0:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($product_price_0))?$product_price_0:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control"  value="<?php echo (isset($subtotal_price_0))?$subtotal_price_0:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>

                    </tr>
                    <tr class="productrow">
                        <?php if(!empty($sliced_bill[1])){
                        $product_code_1 = $sliced_bill[1]['product_id'].'_'.$sliced_bill[1]['option_id'];
                        $product_code_text_1= $sliced_bill[1]['product_code'];
                        $product_name_text_1= $sliced_bill[1]['product_name'];
                        $product_quantity_1 = (isset($sliced_bill[1]['quantity']))?$sliced_bill[1]['quantity']:0;
                        $product_price_1= $sliced_bill[1]['product_price'];

                        if($sliced_bill[1]['option_id']!=0){
                            $product_code_text_1= $sliced_bill[1]['option_code'];
                            $product_name_text_1= $sliced_bill[1]['product_name'].'_'.$sliced_bill[1]['option_name'];
                            $product_price_1= $sliced_bill[1]['option_price'];
                        }
                        $subtotal_price_1 = $product_quantity_1*$product_price_1; ?>
                        <?php } ?>
                        <td data-sno="2">2.</td>
                        <td>
                            <select name="product_code[]" id="product_code_2" class="form-control product_code_select2" multiple>
                                <?php if(!empty($product_code_1) && !empty($product_code_text_1)){ ?>
                                    <option value="<?php echo $product_code_1; ?>" selected="selected"><?php echo $product_code_text_1; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="product_description[]" id="product_description_2" class="form-control product_desc_select2">
                                <?php if(!empty($product_code_1) && !empty($product_name_text_1)){ ?>
                                    <option value="<?php echo $product_code_1; ?>" selected="selected"><?php echo $product_name_text_1; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input name="product_qty[]" id="product_qty_2" type="text" class="numeric form-control" value="<?php echo (isset($product_quantity_1))?$product_quantity_1:''; ?>"/> </td>
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
                        $item_arr[$k]['product_code'] = $v['product_id'].'_'.$v['option_id'];
                        $item_arr[$k]['product_code_text']= $v['product_code'];
                        $item_arr[$k]['product_name_text']= $v['product_name'];
                        $item_arr[$k]['product_quantity'] = (isset($v['quantity']))?$v['quantity']:0;
                        $item_arr[$k]['product_price']= $v['product_price'];

                        if($v['option_id']!=0){
                            $item_arr[$k]['product_code_text']= $v['option_code'];
                            $item_arr[$k]['product_name_text']= $v['product_name'].'_'.$v['option_name'];
                            $item_arr[$k]['product_price']= $v['option_price'];
                        }
                        $item_arr[$k]['subtotal_price'] = $item_arr[$k]['product_quantity']*$item_arr[$k]['product_price']; ?>
                        <td data-sno="2"><?php echo $count; ?></td>
                        <td>
                            <select name="product_code[]" id="product_code_2" class="form-control product_code_select2" multiple="multiple">
                                <?php if(!empty($item_arr[$k]['product_code']) && !empty($item_arr[$k]['product_code_text'])){ ?>
                                    <option value="<?php echo $item_arr[$k]['product_code']; ?>" selected="selected"><?php echo $item_arr[$k]['product_code_text']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="product_description[]" id="product_description_2" class="form-control product_desc_select2">
                                <?php if(!empty($item_arr[$k]['product_code']) && !empty($item_arr[$k]['product_name_text'])){ ?>
                                    <option value="<?php echo $item_arr[$k]['product_code']; ?>" selected="selected"><?php echo $item_arr[$k]['product_name_text']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td><input name="product_qty[]" id="product_qty_2" type="text" class="numeric form-control" value="<?php echo (isset($item_arr[$k]['product_quantity']))?$item_arr[$k]['product_quantity']:''; ?>"/> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="<?php echo (isset($item_arr[$k]['product_price']))?$item_arr[$k]['product_price']:''; ?>" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="<?php echo (isset($item_arr[$k]['subtotal_price']))?$item_arr[$k]['subtotal_price']:''; ?>" /> </td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                            <?php } ?>
                    </tr>
                    <?php $count++; } } ?>
                    <tr class="productrow">
                        <td data-sno="3"><?php echo  $count;?></td>
                        <td class="product_code_cell">
                            <select name="product_code[]" id="product_code_3" class="form-control product_code_select2" multiple="multiple">
                            </select>
                        </td>
                        <td class="product_desc_cell">
                            <select name="product_description[]" id="product_description_3" class="form-control product_desc_select2">
                            </select>
                        </td>
                        <td><input name="product_qty[]" id="product_qty_3" type="text" class="numeric form-control" value="1" /> </td>
                        <td><input name="product_rate[]" type="text" readonly class="form-control" value="" /> </td>
                        <td><input name="product_amount[]" type="text" readonly class="amounttd form-control" value="" /> <a href="javascript:" class="addmore"><i class="fa fa-plus-circle fa-2x"></i></a></td>
                        <td><a class="clear_row" href="javascript:"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Total</td>
                        <td><input name="total_amount" type="text" readonly class="form-control" /></td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="row ph15 mb10">
                    <div class="col-lg-3 col-md-3 col-sm-12">

                        <h5><small>Payment By</small></h5>

                        <select name="payment_by" id="payment_by" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="cash">Credit Card</option>
                            <option value="cash">Debit Card</option>
                            <option value="cash">Cheque</option>
                            <option value="cash">Others</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Reference No</small></h5>

                        <input type="text" name="reference_no" id="reference_no" class="form-control" placeholder="Enter reference no" value="">

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">

                        <h5><small>Payment Status</small></h5>

                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="paid">Paid</option>
                            <option value="unpaid">UnPaid</option>
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
        var addmore = function(){
            var lastrow = $('.producttb').find('.productrow:last');
            var clone = lastrow.clone();
            clone.find('input').val('');
            clone.find('.select2').remove();
            var product_code_select2 = '<select name="product_code[]" class="form-control product_code_select2"></select>';
            clone.find('.product_code_cell').html(product_code_select2);
            clone.find("select[name='product_code[]']").select2(product_code_select2_opt).on("select2:select", function(e) {
                product_code_select2_eventf(e,$(this));
            });
            var product_desc_select2 = '<select name="product_description[]" class="form-control product_desc_select2"></select>';
            clone.find('.product_desc_cell').html(product_desc_select2);
            clone.find("select[name='product_description[]']").select2(product_desc_select2_opt).on("select2:select", function(e) {
                product_desc_select2_eventf(e,$(this));
            });
            var sno = lastrow.find('td:first').data('sno')+1;
            clone.find('td:first').attr('data-sno',sno).html(sno+'.');
            clone.find('a').addClass('removemore').removeClass('addmore');
            clone.find('i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
            lastrow.after(clone);
        };

        $(document).on('keyup','input[name="product_qty[]"]',function (e) {
            calculate_total($(this));
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
            tr.find('input').val('');
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
            maximumSelectionLength: 1,
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

        $('.product_code_select2').select2(product_code_select2_opt).on("select2:select", function(e) {
            product_code_select2_eventf(e,$(this));
        });

        $('.select2-search__field').on('keyup', function (e) {
            if (e.keyCode === 13)
            {

                $('.product_code_select2').eq($(this).index()+1).select2('open');

                return false;
            }
        });

        $('.select2-search__field').on('blur', function (e) {
            $('.select2-search__field').eq($(this).index()+1).focus();
            if($(this).index()==$('.product_code_select2').filter(':last').index()){
                //addmore();
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
                ignore: [],
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                'product_qty[]':{
                    required:true,
                    number:true
                },
                'product_code[]':{
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
                    var product_desc_ele = tr.find('select[name="product_description[]"]');
                    product_desc_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_desc+'</option>').trigger('change.select2');
                    tr.find('input[name="product_qty[]"]').val(1);
                    tr.find('input[name="product_rate[]"]').val(response.product_price);
                    tr.find('input[name="product_amount[]"]').val(response.total_amt_with_tax);
                    calculate_total($this);
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
                    var tr = $this.closest('tr');
                    var product_code_ele = tr.find('select[name="product_code[]"]');
                    product_code_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_code+'</option>').trigger('change.select2');
                    tr.find('input[name="product_qty[]"]').val(1);
                    tr.find('input[name="product_rate[]"]').val(response.product_price);
                    tr.find('input[name="product_amount[]"]').val(response.total_amt_with_tax);
                    calculate_total($this);
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