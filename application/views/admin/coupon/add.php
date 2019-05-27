<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Coupon</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="javascript:">Add</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/coupon">View</a>
            </li>

        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">

        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> Add Coupon</span>

            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form  id="add_frm" action="<?php echo base_url('admin/coupon/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <div class="section row">
                                <div class="col-md-12">
                                <h5><small>Coupon Type</small><span class="required">*</span></h5>
                                <div class="col-md-2 nopadding">
                                    <input type="radio" name="coupon_type" id="coupon_type_special" value="special"  />
                                    <label for="coupon_type_special" class="control-label text-left">Special Products</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" name="coupon_type" id="coupon_type_category" value="category"  />
                                    <label for="coupon_type_category" class="control-label text-left">Category</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="radio" name="coupon_type" id="coupon_type_all" value="all"  />
                                    <label for="coupon_type_all" class="control-label text-left">All Products</label>
                                </div>
                                </div>
                            </div>
                            <div class="section row category_row" style="display: none;">
                                <div class="col-md-9">
                                    <h5><small>Categories</small><span class="required">*</span></h5>
                                    <div class="col-md-6 nopadding multiSelectBox">
                                    <select name="categories[]" class="multiple categories" multiple="multiple">
                                        <?php
                                        if(!empty($category_view)) {
                                            foreach ($category_view as $key => $value) {
                                                ?>
                                                <option value="<?php echo $key; ?>" <?php echo set_select('category', $key); ?> ><?php echo $value; ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                </div>
                            </div>

                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Coupon Name</small><span class="required">*</span></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Coupon Name" class="event-name gui-input br-light light" id="coupon_name" name="coupon_name">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="coupon_name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Coupon Code</small><span class="required">*</span></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Coupon Code" class="event-name gui-input br-light light" id="coupon_code" name="coupon_code">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="coupon_code"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Discount Type</small><span class="required">*</span></h5>
                                    <select name="discount_type" id="discount_type" class="form-control">
                                        <option value="">---Select---</option>
                                        <option value="Percentage">Percentage</option>
                                        <option value="Amount">Amount</option>
                                    </select>
                                    <em class="state-error" for="discount_type"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Discount</small><span class="required">*</span></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Discount" class="event-name gui-input br-light light" id="discount" name="discount">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="discount"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Minimum Amount</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Minimum Amount" class="event-name gui-input br-light light" id="minimum_amount" name="minimum_amount">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="minimum_amount"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Max Usage</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Max Usage" class="event-name gui-input br-light light" id="max_usage" name="max_usage">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="max_usage"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Valid From</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Valid From" class="event-name gui-input br-light light datepicker" id="valid_from" name="valid_from">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="valid_from"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Valid To</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter Valid To" class="event-name gui-input br-light light datepicker" id="valid_to" name="valid_to">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="valid_to"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Status</small></h5>
                                    <label class="field select" for="">
                                        <select name="status" id="status">
                                            <option value="">Choose status</option>
                                            <option value="2" selected="selected">Active</option>
                                            <option value="1">InActive</option>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="width:100px;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css">

<!-- Time/Date Plugin Dependencies -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>

<!-- DateTime Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>

<script type="text/javascript">
    $(function(){

        $('.multiSelectBox .multiple').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true
        });

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            pickTime:false
        });

        $('input[name="coupon_type"]').change(function(){
            var val = $(this).val(),$category_row = $('.category_row');
            $category_row.hide();
            if(val=='category'){
                $category_row.show();
            }
        });

        $("#add_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                coupon_name: {
                    required: true,
                    noTild:true
                },
                coupon_code: {
                    required: true,
                    noTild:true
                },
                discount_type:{
                    required: true
                },
                discount:{
                    required: true,
                    noTild:true
                }
            }

        });

    })
</script>
