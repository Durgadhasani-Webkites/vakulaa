<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-active">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">Dashboard</a>
            </li>
        </ol>
    </div>
    <div class="topbar-right">
        <a href="<?php echo base_url(); ?>admin/bill" class="btn btn-sm btn-primary">Create Bill</a>
    </div>
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <!-- begin: .tray-center -->
    <div class="tray tray-center">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel" id="p18">
                    <div class="panel-heading">
                        <?php $orders_today_count = (!empty($orders_today))?count($orders_today):0; ?>
                        <span class="panel-title">Online Orders Today (<?php echo $orders_today_count; ?>) | Recent 7 Orders</span>
                        <span class="pull-right">
                            <a href="<?php echo base_url(); ?>admin/orders?list=today">View All</a>
                        </span>
                    </div>
                    <div class="panel-body pn" style="display: block;">
                        <?php if(!empty($orders_today)) { ?>
                        <table class="table mbn">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>InvoiceNo</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders_today as $k=>$v){
                                $view_url=base_url().'admin/orders/view_invoice/'.$v['id'];
                                if($v['order_type']=='offline'){
                                    $view_url=base_url().'admin/offline_orders/view_bill/'.$v['order_id'];
                                }
                                ?>
                            <tr>
                                <td><?php echo $v['shipping_user_name']; ?></td>
                                <td><?php echo date('d/m/Y',strtotime($v['created'])); ?></td>
                                <td><?php echo $v['order_id']; ?></td>
                                <td>    
                                <a href="<?php echo $view_url; ?>">View Details</a></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php }else { ?>
                            <p class="p10"> No orders today</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel" id="p18">
                    <div class="panel-heading">
                        <span class="panel-title">Products under Out of Stock</span>
                         <span class="pull-right">
                            <a href="<?php echo base_url(); ?>admin/products?stock=0">View All</a>
                        </span>
                    </div>
                    <div class="panel-body pn" style="display: block;">
                        <?php if(!empty($out_of_stock_products)) { ?>
                        <table class="table mbn">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th style="text-align: right">#</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($out_of_stock_products as $k=>$v){ ?>
                                <tr>
                                    <td><?php echo $v['product_name']; ?><?php echo (!empty($v['option_name']))?'('.$v['option_name'].')':''; ?></td>
                                    <td align="right"><a href="<?php echo base_url(); ?>admin/products/edit/<?php echo $v['id']; ?>">View Details</a></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                        <?php }else { ?>
                            <p class="p10"> No products is out of stock</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel" id="p18">
                    <div class="panel-heading">
                        <span class="panel-title">Products nearing Out of Stock</span>
                         <span class="pull-right">
                            <a href="<?php echo base_url(); ?>admin/products?stock=1">View All</a>
                        </span>
                    </div>
                    <div class="panel-body pn" style="display: block;">
                        <?php if(!empty($nearing_out_of__products)) { ?>
                            <table class="table mbn">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="text-align: right">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($nearing_out_of__products as $k=>$v){ ?>
                                    <tr>
                                        <td><?php echo $v['product_name']; ?><?php echo (!empty($v['option_name']))?'('.$v['option_name'].')':''; ?></td>
                                        <td align="right"><a href="<?php echo base_url(); ?>admin/products/edit/<?php echo $v['id']; ?>">View Details</a></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        <?php }else { ?>
                            <p class="p10"> No products is out of stock</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix">&nbsp;</div>
        <div class="row">
            <a href="<?php echo base_url('admin').'/orders?list=today'; ?>">
                <div class="col-sm-4 col-xl-3">
                    <div class="panel panel-tile text-center br-a br-grey">
                        <div class="panel-body">
                            <h1 class="fs30 mt5 mbn"><?php
                                echo (!empty($total_value_today))?$total_value_today:0;
                                ?></h1>

                        </div>
                        <div class="panel-footer br-t p12">
                            <h6 class="text-system">TOTAL TODAY</h6>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo base_url('admin').'/orders?list=week'; ?>">
                <div class="col-sm-4 col-xl-3">
                    <div class="panel panel-tile text-center br-a br-grey">
                        <div class="panel-body">
                            <h1 class="fs30 mt5 mbn"><?php echo (!empty($total_value_thisweek))?$total_value_thisweek:0;?></h1>

                        </div>
                        <div class="panel-footer br-t p12">
                            <h6 class="text-system">TOTAL THIS WEEK</h6>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo base_url('admin').'/orders?list=month'; ?>">
                <div class="col-sm-4 col-xl-3">
                    <div class="panel panel-tile text-center br-a br-grey">
                        <div class="panel-body">
                            <h1 class="fs30 mt5 mbn"><?php
                                echo  (!empty($total_value_thismonth))?$total_value_thismonth:0; ?></h1>

                        </div>
                        <div class="panel-footer br-t p12">
                            <h6 class="text-system">TOTAL THIS MONTH</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="clearfix">&nbsp;</div>

        <!-- dashboard tiles -->
        <div class="row">
            <?php 
			if(!empty($dashboard_modules)) {

            foreach($dashboard_modules as $k=>$v) {
            ?>
            <a href="<?php echo base_url('admin').'/'.$v['link']; ?>">
                <div class="col-sm-4 col-xl-3">
                    <div class="panel panel-tile text-center br-a br-grey">
                        <div class="panel-body">
                            <h1 class="fs30 mt5 mbn"><?php
								if(!empty($v['table_name'])) {
                                $b=$v['table_name'] . '_count';
                                echo $$b;
								}
                                ?></h1>

                        </div>
                        <div class="panel-footer br-t p12">
                            <h6 class="text-system">TOTAL <?php echo strtoupper($v['name']); ?></h6>
                        </div>
                    </div>
                </div>
            </a>
            <?php } } ?>
        </div>



        <!-- Admin-panels -->

    </div>
    <!-- end: .tray-center -->

</section>
<!-- End: Content -->
<script type="text/javascript">
    $(function () {

    });
</script>
