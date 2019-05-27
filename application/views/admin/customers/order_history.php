<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Order History</h4>
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
                <a href="<?php echo base_url('admin/customers'); ?>">Customers</a>
            </li>
            <li class="crumb-link">
                <a href="">Order History</a>
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
                <table cellpadding="0" cellspacing="0" width="100%" class="table order_his_table">
                    <tbody>
                    <?php include_once'order_history_ajax.php'; ?>
                    </tbody>
                </table>
                <?php if(!empty($page_link)){ ?>
                    <div class="row ph15 mb10 text-center pageLink">
                        <?php echo $page_link; ?>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                <?php }?>
            </div>
        </div>
    </div>

</section>
<script>
    function ajax_paginate(offset) {
        offset = offset || '0';
        $.ajax({
            url: '<?php echo (isset($base_url))?$base_url:''; ?>' + '/'+offset,
            type:'post',
            dataType: 'json',
            success: function (response) {
                if (response != '') {
                    var $order_his_table = $(".order_his_table");
                    $order_his_table.find('tbody').html(response.html);
                    $(".pageLink").html(response.page_link);
                }
            }
        });
    }
</script>
<style>

    .order_head,.order_foot{
        border:1px solid #e6e6e6;
        padding:10px;
    }
    .order_body{
        border-left:1px solid #e6e6e6;
        border-right:1px solid #e6e6e6;
        padding:10px;
    }
    .order_head .label{
        padding:5px;
        font-size:15px;
    }
    .order_head a{
        border:1px solid #e6e6e6;
        display: block;
        padding:5px;
    }
    .order_body .row{
        margin-bottom:10px;
    }
    .order_body p{
        color:#867a7a;
        margin:0;
    }
    .order_his_table > tbody > tr > td{
        border:0;
    }
</style>