<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Stock Report</h4>
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
                <a href="">Stock Report</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">

        <div class="panel">

            <div class="panel-body">
                <form id="report_frm" method="post" action="<?php echo base_url(); ?>admin/stock_report/process" class="form-horizontal" role="form">
                    <div class="clearfix">&nbsp;</div>
                    <div class="row ph15 mb10">
                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>Category</small></h5>

                            <select name="category[]" id="category" class="form-control category_select2" multiple>
                            </select>
                            <label><input type="checkbox" id="check_all_cat" value="1"> Select All</label>

                        </div>
                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
                            <h5><small>&nbsp;</small></h5>
                            <input type="submit" class="btn btn-success btn-block" id="search_stud" value="Search">

                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                </form>


            </div>

        </div>

    </div>
</section>
<!-- End: Content -->
<!-- Start: Topbar -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js'); ?>plugins/select2/select2.min.css" />
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>
<script type="text/javascript">
    $(function() {

        var category_select2_opt = {
            tokenSeparators: [","],
            placeholder: 'Select your category',
            casesensitive: false,
            ajax: {
                url: base_url + "stock_report/get_category",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page,
                        limit: 20
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
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1,
            templateResult: formatResult,
            templateSelection: formatSelection
        };

        $('.category_select2').select2(category_select2_opt);

        $('#check_all_cat').click(function(){
            $('.category_select2').find('option').remove();
            if($('#check_all_cat').is(':checked')){
                $('.category_select2').select2({minimumResultsForSearch: -1});
                $('.category_select2').append('<option value="all" selected="selected">All</option>');
            }else{
                $('.category_select2').select2(category_select2_opt).trigger('change');
            }
        });
    });


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