<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Sales Report</h4>
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
                <a href="">Sales Report</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">
        <div class="col-md-12">
                <?php if(isset($admin_results['id'])){ ?>
                    <input type="hidden" name="id" value="<?php echo $admin_results['id']; ?>" />
                <?php } ?>

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Search</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form id="search_frm" method="get" action="<?php echo base_url(); ?>admin/sales_report" class="form-horizontal" role="form">
                            <div class="clearfix">&nbsp;</div>

                            <div class="row ph15 mb10">
                                <div class="col-lg-3 col-md-3">

                                    <h5><small>From Date</small></h5>

                                    <input type="text" name="order_from_date" id="order_from_date" class="form-control datepicker" placeholder="Enter from date" value="<?php echo (isset($_GET['order_from_date']))?$_GET['order_from_date']:''; ?>">

                                </div>

                                <div class="col-lg-3 col-md-3">

                                    <h5><small>To Date</small></h5>

                                    <input type="text" name="order_to_date" id="order_to_date" class="form-control datepicker" placeholder="Enter to date" value="<?php echo (isset($_GET['order_to_date']))?$_GET['order_to_date']:''; ?>">

                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <h5><small>Order Type</small></h5>
                                    <select name="order_type" class="form-control">
                                        <option value="online" <?php echo (isset($_GET['order_type']) && ($_GET['order_type']=='online'))?'selected="selected"':''; ?>>Online</option>
                                        <option value="offline" <?php echo (isset($_GET['order_type']) && ($_GET['order_type']=='offline'))?'selected="selected"':''; ?>>Offline</option>
                                        <option value="both" <?php echo (isset($_GET['order_type']) && ($_GET['order_type']=='both'))?'selected="selected"':''; ?>>Both</option>
                                    </select>
                                </div>

                                <div class="col-lg-2 col-md-3">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <input type="submit" class="btn btn-success btn-block" id="search_stud" value="Search">

                                </div>

                                <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                    <a href="<?php echo base_url(); ?>admin/sales_report" class="btn btn-default btn-block" id="clear">Clear</a>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            <div class="panel">
                <div class="panel-body admin-form">
                    <h1>Total Sales Amount: <span class="order_cost"></span> </h1>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body admin-form">
            <table class="table theme-warning order_datatable"  id="datatable">

                <thead>

                <tr class="bg-light">

                    <th width="10%">Order Id</th>

                    <th width="22%">Name</th>

                    <th width="15%">Amount</th>

                    <th width="10%">Order Type</th>

                    <th width="10%">Order Date</th>

                    <th class="" width="10%">Action</th>

                </tr>

                </thead>

                <tbody>


                </tbody>


            </table>
                    </div>
            </div>
            <div class="panel">
                <div class="panel-body admin-form">
            <table class="table admin-form theme-warning product_datatable"  id="datatable">

                <thead>

                <tr class="bg-light">

                    <th width="60%">Product Name</th>

                    <th width="20%">Quantity</th>

                    <th width="20%">Cost</th>

                </tr>

                </thead>

                <tbody>


                </tbody>
                <tfoot>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th></th>
                </tfoot>

            </table>
                </div>
            </div>
           <!-- <div class="panel">

                <div class="panel-body report_data">

                </div>
            </div>-->

        </div>
    </div>

</section>

<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<link  rel="stylesheet" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css" />

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/css/dataTables.bootstrap.css">
<!-- Datatables -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/jquery.dataTables.js"></script>
<!-- Datatables Bootstrap Modifications  -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">
    $(function(){

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY', pickTime: false
        });

        $("#search_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                order_from_date: {
                    noTild:true
                },
                order_to_date:{
                    noTild:true
                }
            }
        });


        var order_datatable = $('.order_datatable').DataTable({

            "processing": false,

            "serverSide": true,

            "pageLength": 10,

            "order": [],

            "ajax": {

                'type': 'GET',

                'url': base_url + "sales_report/orders_ajax",

                'data': function(d){

                    d.formValues = $('#search_frm').serialize();

                }
            }

        });

        order_datatable.on( 'xhr', function () {
            var json = order_datatable.ajax.json();
            $('.order_cost').html(json.order_cost)
        } );

        var product_datatable=$('.product_datatable');

        product_datatable.dataTable({

            "processing": false,

            "serverSide": true,

            "pageLength": 10,

            "order": [],

            "ajax": {

                'type': 'GET',

                'url': base_url + "sales_report/products_ajax",

                'data': function(d){

                    d.formValues = $('#search_frm').serialize();

                }
            }

        });
    });
</script>
