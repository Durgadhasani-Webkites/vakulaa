<?php include_once('navigation.php'); ?>
<div class="col-lg-9 col-md-9 col-sm-9">
    <div class="right-sec">
            <?php if( $this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <?php if( $this->session->flashdata('error')){ ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <div class="formhead">
                Order History
            </div>
            <div class="clearfix">&nbsp;</div>
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
</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<script>
    function ajax_paginate(offset) {
        offset = offset || '0';
        $.ajax({
            url: '<?php echo (isset($base_url))?$base_url:''; ?>' + offset,
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
        background-color: #f1f1f1;
        color: black;
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
    .order-a a{
        color: black;
    }

</style>