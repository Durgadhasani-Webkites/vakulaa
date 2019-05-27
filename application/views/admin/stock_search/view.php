<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Stock Search</h4>
        <hr class="alt short" />
    </div>
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-link">
                <a href="">Stock Search</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('admin/stock_search/process'); ?>" class="form-horizontal" id="headings_frm" method="post" role="form">
                <?php if(isset($admin_results['id'])){ ?>
                    <input type="hidden" name="id" value="<?php echo $admin_results['id']; ?>" />
                <?php } ?>

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Stock Search</span>
                    </div>
                    <div class="panel-body admin-form">
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-xs-4">
                            <h5><small>Product Code</small></h5>
                            <label for="barcode_mode">
                                <input type="radio"  name="scan_mode[]" id="barcode_mode" class="scan_mode" value="barcode" checked="checked"/>&nbsp;Barcode
                            </label>
                            <label for="manual_mode">
                                <input type="radio"  name="scan_mode[]" class="scan_mode" id="manual_mode" value="manual"/>&nbsp;Manual
                            </label>
                            <input type="hidden" name="product_option_id[]" value="" />
                            <input type="text" name="product_code_text[]" class="form-control" value="" />
                            <select name="product_code_select[]" id="product_code_3" class="form-control product_code_select2"  style="display:none">
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <h5><small>Product Name</small></h5>
                            <br/>
                            <select name="product_description[]" id="product_description_3" class="form-control product_desc_select2">
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <h5><small>Stock</small></h5>
                            <br/>
                            <input id="stock" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 3" name="stock"  value="">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
<!-- End: Content -->
<!-- Start: Topbar -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>admin-forms.css" />

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js'); ?>plugins/select2/select2.min.css" />
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>

<script type="text/javascript">
    $(function(){

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
            var div = $(this).closest('div');
            if($(this).val()=='barcode'){
                $('input[name="product_code_text[]"]').show();
                $('.product_code_select2').hide();
                div.find('.select2').remove();
            }else{
                $('input[name="product_code_text[]"]').hide();
                $('.product_code_select2').show();
                $('.product_code_select2').select2(product_code_select2_opt).on("select2:select", function(e) {
                    show_stock(e);
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
            show_stock(e);
        });

    });

    function show_stock(e){
        var product_option_id = e.params.data.id;
        $.ajax({
            url:base_url+"bill/get_product_details",
            type:'post',
            data:'product_option_id='+product_option_id,
            dataType:'json',
            success:function(response){
                if(response!=''){
                    $('#stock').val(response.product_qty);
                    var product_desc_ele = $('select[name="product_description[]"]');
                    product_desc_ele.html('<option value="' + response.product_option_id + '" selected="selected">' + response.product_desc + '</option>').trigger('change.select2');
                    var product_code_ele = $('.product_code_select2');
                    product_code_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_code+'</option>').trigger('change.select2');
                }
            }
        });
    }

    function product_code_ajax(self,value){
        var __self=$(self);
        $.ajax({
            url:base_url+"bill/get_product_code_details",
            type:'post',
            data:'product_code='+value,
            dataType:'json',
            success:function(response){
                if(response!=''){
                    $('#stock').val(response.product_qty);
                    var product_desc_ele = $('select[name="product_description[]"]');
                    product_desc_ele.html('<option value="' + response.product_option_id + '" selected="selected">' + response.product_desc + '</option>').trigger('change.select2');
                    var product_code_ele = $('.product_code_select2');
                    product_code_ele.html('<option value="'+response.product_option_id+'" selected="selected">'+response.product_code+'</option>').trigger('change.select2');
                }else{
                    alert('No product found');
                    __self.val('');
                    return false;
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
</style>