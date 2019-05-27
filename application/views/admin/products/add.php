<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Products</li>
            <li class="crumb-link">
                <a href="#">Add New</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="">

<form  id="product_frm" action="<?php echo base_url('admin/products/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
<!-- dashboard tiles -->
<div class="row">
    <div class="col-md-10">
        <h4> Add Product</h4>
    </div>
    <div class="col-md-2">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save
            </button>
        </div>
        <div class="col-md-6">
            <a class="btn btn-primary" href="<?php echo base_url('admin/products'); ?>">
                <i class="fa fa-eye"></i> View all
            </a>
        </div>
    </div>
</div>

<hr class="alt short">
<br/>
<?php echo validation_errors(); ?>
<div class="row">
<div class="col-md-12">
<div class="bs-component">
<div class="panel">
    <div class="panel-heading">
    <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
        <li class="active">
            <a href="#general" data-toggle="tab">General</a>
        </li>
        <li>
            <a href="#data" data-toggle="tab">Data</a>
        </li>
        <li>
            <a href="#links" data-toggle="tab">Links</a>
        </li>
        <li>
            <a href="#attributes" data-toggle="tab">Attributes</a>
        </li>
        <li>
            <a href="#options" data-toggle="tab">Option</a>
        </li>
        <li>
            <a href="#offers" data-toggle="tab">Offers</a>
        </li>
        <li>
            <a href="#images" data-toggle="tab">Image</a>
        </li>
    </ul>
</div>
    <div class="panel-body">
        <div class="tab-content pn br-n">
    <div id="general" class="tab-pane active">
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Product Name<span class="mandatory">*</span> </label>
            <div class="col-lg-10">
                <input type="text" name="product_name" placeholder="Enter product name" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Product Code<span class="mandatory">*</span></label>
            <div class="col-lg-10">
                <input type="text" name="product_code" placeholder="Enter product code"  class="form-control" >
            </div>
        </div>
       
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">What is it?
                <input type="text" name="detailpage_heading1" value="What is it?">
            </label>
            <div class="col-lg-10">
                <textarea name="what_is_it" class="summernote form-control"  rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">What is contains?
                <input type="text" name="detailpage_heading2" value="What is contains?">
            </label>
            <div class="col-lg-10">
                <textarea name="what_is_contains" class="summernote form-control"  rows="3"></textarea>
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-2 control-label text-left">How to prepare?
            <input type="text" name="detailpage_heading3" value="How to prepare?">
            </label>
            <div class="col-lg-10">
                <textarea name="how_to_prepare" class="summernote form-control"  rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Meta title</label>
            <div class="col-lg-10">
                <input type="text" name="meta_title" placeholder="Enter meta title" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Meta description</label>
            <div class="col-lg-10">
                <textarea name="meta_description" class="form-control"  rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Meta keywords</label>
            <div class="col-lg-10">
                <textarea name="meta_keywords" class="form-control"  rows="3"></textarea>
            </div>
        </div>
    </div>
    <div id="data" class="tab-pane">
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Thumb Image<span class="mandatory">*</span></label>
            <div class="col-lg-4 admin-form">
                <label class="field prepend-icon append-button file">
                    <span class="button">Choose File</span>
                    <input type="file" class="gui-file" name="thumb_image" id="thumb_image" />
                    <input type="text" class="gui-input"  placeholder="Please Select A File">
                    <label class="field-icon">
                        <i class="fa fa-upload"></i>
                    </label>
                </label>
                <span class="note">(Note: Upload image of width greater than 400px and height greater than 400px )</span>
                <em class="state-error" for="thumb_image"></em>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Quantity<span class="mandatory">*</span></label>
            <div class="col-lg-4">
                <input name="quantity" class="form-control" value="1" />
                <b> Note: </b>. Fill this only if there is no options for this product

            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Weight for shipping<span class="mandatory">*</span></label>
            <div class="col-lg-4">
              <input name="weight_shipping_single" class="form-control"/>
               <b> Note: </b>Mention weight in grams. Fill this only if there is no options for this product
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">HSN Number<span class="mandatory">*</span></label>
            <div class="col-lg-4">
                <input type="text" name="hsn_number" placeholder="Enter HSN Number" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">SGST<span class="mandatory">*</span></label>
            <div class="col-md-4 multiSelectBox">
                <select name="sgst" class="single">
                    <option value="">---Select---</option>
                    <?php if(!empty($sgst_res)){
                    foreach($sgst_res as $k=>$v){?>
                    <option value="<?php echo $v['id']; ?>"><?php echo $v['tax_name']; ?></option>
                  <?php } } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">CGST<span class="mandatory">*</span></label>
            <div class="col-md-4 multiSelectBox">
                <select name="cgst" class="single">
                    <option value="">---Select---</option>
                    <?php if(!empty($cgst_res)){
                        foreach($cgst_res as $k=>$v){?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['tax_name']; ?></option>
                        <?php } } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Price (This is  selling price)<span class="mandatory">*</span></label><span class="mandatory">*</span></label>
            <div class="col-lg-4">
                <input type="text" name="price" placeholder="Enter price" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Actual Price (This is not selling price)<span class="mandatory">*</span></label>
            <div class="col-lg-4">
                <input type="text" name="actual_price_single" placeholder="Enter actual price" class="form-control" >
            </div>
        </div>
        <!-- <div class="form-group">
            <div class="col-md-12">
                <input type="checkbox" name="is_product_variable" id="is_product_variable" value="1">
                <label  for="is_product_variable" class="control-label text-left">Is this product is variable?</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Weight</label>
            <div class="col-lg-4">
                <input type="text" name="weight" placeholder="Enter Weight" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Weight Class</label>
            <div class="col-lg-4 multiSelectBox">
                <select name="weight_class" class="single">
                    <option value="">---Select---</option>
                    <option value="g">Gram</option>
                    <option value="kg">Kilogram</option>
                    <option value="ml">Millilitre</option>
                    <option value="l">Litre</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Weight Price</label>
            <div class="col-lg-4">
                <input type="text" name="weight_price" placeholder="Enter Weight Price" class="form-control" >
            </div>
        </div> -->
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Stock</label>
            <div class="col-md-4 multiSelectBox">
                <select name="stock" class="single">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Tags</label>
            <div class="col-lg-10">
                <input type="text" name="tags" id="tagmanager" class="form-control tm-input" placeholder="Enter tags">
                <div class="tag-container tags"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label text-left">Sort Order</label>
            <div class="col-lg-4">
                <input type="text" name="sort_order" placeholder="Enter sort order" class="form-control" >
            </div>
        </div>
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Status</label>
            <div class="col-md-4 multiSelectBox">
                <select name="status" class="single" >
                    <option value="2">Enabled</option>
                    <option value="1">Disabled</option>
                </select>
            </div>
        </div>
      
    </div>
    <div id="links" class="tab-pane">

        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Categories<span class="mandatory">*</span></label>
            <div class="col-md-8 multiSelectBox">
                <select name="categories[]" class="multiple categories" multiple="multiple">
                   <!--  <option value="0" <?php echo set_select('category', '0'); ?> >Main Category</option> -->
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
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Filters</label>
            <div class="col-md-8 multiSelectBox">
                <select name="filters[]" class="multiple filterslist" multiple="multiple">

                </select>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Coupon</label>
            <div class="col-md-8 multiSelectBox">
                <select name="coupon[]" class="multiple" multiple="multiple">
                    <?php
                    if(!empty($special_coupons)) {
                        foreach ($special_coupons as $k => $v) {
                            ?>
                            <option value="<?php echo $v['id']; ?>" ><?php echo $v['coupon_code']; ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div id="attributes" class="tab-pane">
        <a target="_blank" class="pull-right btn btn-primary btn-sm" href="<?php echo base_url('admin/attribute/add'); ?>">
            <i class="fa fa-plus"></i> Add Attribute
        </a>
        <div class="clearfix">&nbsp;</div>
        <div class="form-group">
            <div class="col-md-12 text-center">
                <table class="table">
                    <thead>
                    <tr class="info">
                        <th>Attribute</th>
                        <th>Text</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="table-row">
                        <td>
                            <div class="multiSelectBox">
                                <select name="attribute_label[]" class="single">
                                    <?php
                                    if(!empty($attribute_view)) {
                                        foreach($attribute_view as $attribute) {
                                            ?>
                                           <option value="<?php echo $attribute['attribute_group_id']; ?>_<?php echo $attribute['id']; ?>" <?php echo set_select('attributes', $attribute['id']); ?> ><?php echo $attribute['attribute_group_name']; ?> - <?php echo $attribute['attribute_name']; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <textarea name="attribute_desc[]" class="form-control"  rows="3"></textarea>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary add_more">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div id="options" class="tab-pane">
        <a target="_blank" class="pull-right btn btn-primary btn-sm" href="<?php echo base_url('admin/options/add'); ?>">
            <i class="fa fa-plus"></i> Add Option
        </a>
        <div class="form-group">
            <label  class="col-md-2 control-label text-left">Option Name</label>
            <div class="col-md-4 multiSelectBox">
                <select name="option" class="single selectoption">
                    <option value="">--none--</option>
                    <?php
                    if(!empty($option_view)) {
                        foreach($option_view as $option) {
                            ?>
                            <option value="<?php echo $option['id']; ?>" <?php echo set_select('selectoption', '2'); ?> ><?php echo $option['option_name']; ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="options_data">

            </div>
        </div>

    </div>
    <div id="offers" class="tab-pane">
        <div class="form-group">
            <div class="col-md-12 text-center">
                <table class="table">
                    <thead>
                    <tr class="info">
                        <th width="25%">Product Option</th>
                        <th width="25%">Offer Product</th>
                        <th width="20%">Offer Product Option</th>
                        <th width="20%">Offer Quantity</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="offers-row">
                        <td>
                            <select name="product_option_id[]" class="select2-single product_option_select2 form-control">
                                <option value="">--none--</option>
                            </select>
                        </td>
                        <td>
                            <select name="offer_product_id[]" class="select2-single offer_product_select2 form-control">
                                <option value="">--none--</option>
                            </select>
                        </td>
                        <td>
                            <select name="offer_option_id[]" class="select2-single offer_option_select2 form-control">
                                <option value="">--none--</option>
                            </select>
                        </td>
                        <td>
                            <input name="offer_quantity[]" class="form-control"  />
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary add_more_offers">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="images" class="tab-pane">
        <div class="form-group">
            <div class="col-md-12 text-center">
                <table class="table">
                    <thead>
                    <tr class="info">
                        <th>Image(size above 700px)</th>
                        <th>Sort Order</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="table-row">
                        <td>
                            <div class="col-lg-10 admin-form">
                                <label class="field prepend-icon append-button file">
                                    <span class="button">Choose File</span>
                                    <input type="file" class="gui-file" name="product_images[]" id="product_images">
                                    <input type="text" class="gui-input" id="product_images_uploader1" placeholder="Please Select A File">
                                    <label class="field-icon">
                                        <i class="fa fa-upload"></i>
                                    </label>
                                </label>
                                <em class="state-error" for="product_images"></em>
                            </div>
                        </td>

                        <td><input type="text" name="product_image_order[]" placeholder="Enter sort order" class="form-control" ></td>
                        <td>
                            <button type="button" class="btn btn-primary add_more">
                                <i class="fa fa-plus"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>
    </div>
</div>
</div>

</div>
</div>

</form>
</section>
<!-- End: Content -->

<!-- Summernote CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.css">

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/tagmanager/tagmanager.css">

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css">

<!-- Time/Date Plugin Dependencies -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/globalize/globalize.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>

<!-- DateTime Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>

<!-- Summernote Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.min.js"></script>

<!-- TagManager Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/tagmanager/tagmanager.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.css">
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('keypress',":input",function(event){
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });


        $('.multiSelectBox .multiple').multiselect({
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All',
            maxHeight: 200,
            includeSelectAllOption: true
        });
        $('.multiSelectBox .single').multiselect({
            enableFiltering: false
        });
        $('.brand').multiselect();


        $('.summernote').summernote({
            height: 255,
            focus: false,
            oninit: function() {},
            onChange: function(contents, $editable) {}
        });

        $(".tm-input").tagsManager({
            tagsContainer: '.tags',
            tagClass: 'tm-tag-info'
        });

        $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            pickTime:false
        });

        $('.datetimepick').datetimepicker({
            format: 'DD-MM-YYYY hh:mm:ss a',
            pickTime:true
        });


        $(document).on('keypress',":input",function(event){
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });

        $("#product_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                product_name: {
                    required: true,
                    noTild:true
                },
                product_code:{
                    required: true,
                    noTild:true
                },
               
                thumb_image:{
                    required: true,
                    extension: "jpg|jpeg|png|JPG|JPEG|PNG"
                },
                'product_images[]':{
                    extension: "jpg|jpeg|png|JPG|JPEG|PNG"
                },
                quantity:{
                    required: true,
                    number:true
                },
                weight_shipping_single:{
                    required: true,
                    number:true
                },
                hsn_number:{
                    required: true,
                    alphanumeric:true
                },
                sgst:{
                    required: true
                },
                cgst:{
                    required: true
                },
                price:{
                    required: true
                }
            },
            messages:{
                thumb_image:{
                    extension: "Please upload valid jpg or png images"
                },
                'product_images[]':{
                    extension: "Please upload valid jpg or png images"
                }
            }

        });

        $('.selectoption').change(function(){
            var option = $(this).find('option:selected').val();
            $.ajax({
                type:'post',
                url:'<?php echo base_url('admin/products/open_options'); ?>',
                data:'id='+option,
                dataType:'html',
                success: function(response){
                    $('.options_data').html(response);
                }
            });

        });


        var $options_data = $(".options_data"),add_images_click=2;
        $options_data.on('click','.add_more',function() {
            var $this=$(this),
                td=$this.closest('td'),
                lastRow=td.find('.row').filter(':last'),
                clonedEle=lastRow.clone(),
                guiFile= clonedEle.find('.gui-file');

            clonedEle.find('input').val('');
            guiFile.attr('id','product_option_images'+add_images_click);
            clonedEle.find("label.file").siblings("em").attr('for','product_option_images'+add_images_click);
            clonedEle.find('.gui-input').attr('id','product_option_images_uploader'+add_images_click);
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');
            clonedEle.find('.add_more').addClass('btn-danger remove_more').removeClass('btn-primary add_more');

            clonedEle.insertAfter(lastRow);
            add_images_click++;
        });

        $options_data.on('click','.remove_more',function() {
            $(this).closest('.row').remove();
        });

        $options_data.on('change','.gui-file',function(){
            var  $this=$(this);
            $this.siblings('.gui-input').val($this.val());
        });


        var product_opt_select2_opt={
            placeholder:'Search for option',
            ajax: {
                url: base_url+"products/get_all_options",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20,
                        option_id:$('#options').find('select[name="option"]').val()
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
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
            templateResult: formatResult,
            templateSelection: formatSelection
        };
        $(".product_option_select2").select2(product_opt_select2_opt);

        var offer_product_select2_opt={
            placeholder:'Search for product',
            ajax: {
                url: base_url+"products/get_all_products",
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
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
            templateResult: formatResult,
            templateSelection: formatSelection
        };
        $(".offer_product_select2").select2(offer_product_select2_opt);


        var offer_option_select2_opt={
            placeholder:'Search for option',
            ajax: {
                url: base_url+"products/get_all_product_options",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit:20,
                        product_id:$(".offer_product_select2").val()
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
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 0,
            templateResult: formatResult,
            templateSelection: formatSelection
        };
        $(".offer_option_select2").select2(offer_option_select2_opt);

        $(".add_more_offers").click(function(){
            var $this=$(this),
                offersRow=$this.closest('.offers-row'),
                lastoffersRow=$this.closest('table').find('.offers-row').filter(':last'),
                clonedEle=offersRow.clone();
            clonedEle.find('input').val('');
            clonedEle.find('button').removeClass('btn-primary').addClass('btn-danger remove_more_offers');
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');

            var product_option_select2 = '<select name="product_option_id[]"  class="select2-single product_option_select2 form-control"><option value="">---Select Option---</option> </select>';
            var offer_product_select2 = '<select name="offer_product_id[]"  class="select2-single offer_product_select2 form-control"><option value="">---Select Product---</option> </select>';
            var offer_option_select2 = '<select name="offer_option_id[]"  class="select2-single offer_option_select2 form-control"><option value="">---Select Option---</option> </select>';
            clonedEle.find('td:eq(0)').html(product_option_select2);
            clonedEle.find('td:eq(1)').html(offer_product_select2);
            clonedEle.find('td:eq(2)').html(offer_option_select2);
            clonedEle.find(".product_option_select2").select2(product_opt_select2_opt);
            clonedEle.find(".offer_product_select2").select2(offer_product_select2_opt);
            var offer_option_select2_opt1={
                placeholder:'Search for option',
                ajax: {
                    url: base_url+"products/get_all_product_options",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            limit:20,
                            product_id:clonedEle.find(".offer_product_select2 ").val()
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
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 0,
                templateResult: formatResult,
                templateSelection: formatSelection
            };
            clonedEle.find(".offer_option_select2").select2(offer_option_select2_opt1);

            clonedEle.insertAfter(lastoffersRow);
        });

        $("table").on('click','.remove_more_offers',function(){
            $(this).closest('.offers-row').remove();
        });


        $(".add_more").click(function(){
            var $this=$(this),
                tableRow=$this.closest('.table-row'),
                lastTableRow=$this.closest('table').find('.table-row').filter(':last'),
                clonedEle=tableRow.clone(),
            guiFile= clonedEle.find('.gui-file');
            clonedEle.find('input').val('');
            clonedEle.find('button').not('.multiselect').removeClass('btn-primary').addClass('btn-danger remove_more');
            clonedEle.find('.multiSelectBox .btn-group').remove();
            clonedEle.find('i').removeClass('fa-plus').addClass('fa-minus');

            guiFile.attr('id','product_images'+add_images_click);
            clonedEle.find("label.file").siblings("em").attr('for','product_images'+add_images_click);
            clonedEle.find('.gui-input').attr('id','product_images_uploader'+add_images_click);


            clonedEle.insertAfter(lastTableRow);
            clonedEle.find('.multiSelectBox .single').multiselect("refresh");
            add_images_click++;
        });



        $("table").on('click','.remove_more',function(){
            $(this).closest('.table-row').remove();
        });

        $(".table").on('change','.gui-file',function(){
            var  $this=$(this);
            $this.siblings('.gui-input').val($this.val());
        });

        var _URL = window.URL || window.webkitURL;
        $("#thumb_image").change(function(){
            var  $this=$(this),image, file;

            if ((file = this.files[0])) {

                image = new Image();

                image.onload = function() {

                    $this.siblings('.gui-input').val($this.val());
                };
                image.src = _URL.createObjectURL(file);

            }

        });

        $(".categories").change(function(){
            var $this=$(this),
                $selectedCat=$this.val(),
                brandSelectBox=$('.brand'),
            filtersSelectBox=$('.filterslist');
            if($selectedCat){
                $.ajax({
                    type:'post',
                    url:'<?php echo base_url('admin/products/get_product_filters_brands'); ?>',
                    data:'cid='+$selectedCat,
                    dataType:'json',
                    success: function(response){
                        if(response){
                            if(response.hasOwnProperty('brands')){
                                brandSelectBox.multiselect();
                                brandSelectBox.multiselect('dataprovider', response.brands);
                            }
                            if(response.hasOwnProperty('filters')){
                                filtersSelectBox.multiselect();
                                filtersSelectBox.multiselect('dataprovider', response.filters);
                            }

                        }else{
                            brandSelectBox.multiselect('dataprovider', '');
                        }

                    }
                });
            }else{
                brandSelectBox.multiselect('dataprovider', '');
            }

        });

    });
    function formatResult (data) {
        return data.name;
    }
    function formatSelection (data) {
        return data.name || data.text;
    }
</script>
<style>
    .select2{
        width:100% !important;
    }
</style>
<!-- END: PAGE SCRIPTS