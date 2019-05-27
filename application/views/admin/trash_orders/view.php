<!-- Start: Topbar -->

<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Orders</h4>

        <hr class="alt short">

    </div>

    <div class="topbar-left">

        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/orders">Online</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/offline_orders">Offline</a>
            </li>
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/trash_orders">Trash</a>
            </li>
        </ul>

    </div>

</header>

<!-- End: Topbar -->



<!-- Begin: Content -->

<section id="content" class="table-layout animated fadeIn">

    <div class="row">

        <div class="panel">

            <div class="panel-body">
                <a class="btn btn-primary btn-sm pull-right" href="<?php echo base_url(); ?>admin/bill">Create Bill</a>
                <form id="search_frm" method="get" class="form-horizontal" role="form">
                    <input type="hidden" name="list" value="<?php echo (isset($_GET['list']))?$_GET['list']:''; ?>"
                    <div class="clearfix">&nbsp;</div>

                    <div class="row ph15 mb10">

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>Order No</small></h5>

                            <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Search order no" value="<?php echo (isset($_GET['order_no']))?$_GET['order_no']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>User Name</small></h5>

                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Search user name" value="<?php echo (isset($_GET['user_name']))?$_GET['user_name']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>User Mobile</small></h5>

                            <input type="text" name="user_mobile" id="user_mobile" class="form-control" placeholder="Search user mobile" value="<?php echo (isset($_GET['user_mobile']))?$_GET['user_mobile']:''; ?>">

                        </div>

                    </div>

                    <div class="row ph15 mb10">

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>Order From</small></h5>

                            <input type="text" name="order_from" id="order_from" class="form-control datepicker" placeholder="Search order from" value="<?php echo (isset($_GET['order_from']))?$_GET['order_from']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>Order To</small></h5>

                            <input type="text" name="order_to" id="order_to" class="form-control datepicker" placeholder="Search order to" value="<?php echo (isset($_GET['order_to']))?$_GET['order_to']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>Paid Status</small></h5>
                            <select name="paid_status" id="paid_status" class="form-control">
                                <option value="">Select</option>
                                <option value="2" <?php echo (isset($_GET['paid_status']) && ($_GET['paid_status']=='2'))?'selected="selected"':''; ?>>Paid</option>
                                <option value="1" <?php echo (isset($_GET['paid_status']) && ($_GET['paid_status']=='1'))?'selected="selected"':''; ?>>Not Paid</option>
                            </select>
                        </div>

                        <div class="clearfix visible-sm">&nbsp;</div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                    <div class="row ph15 mb10">

                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">

                            <input type="submit" class="btn btn-success btn-block" id="search_stud" value="Search">

                        </div>

                        <div class="clearfix visible-xs">&nbsp;</div>

                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">

                            <a href="<?php echo base_url(); ?>admin/trash_orders" class="btn btn-default btn-block" id="clear">Clear</a>

                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                </form>

                <?php if(!empty($admin_results)){ ?>

                <form  id="action_frm" action="<?php echo base_url('admin/trash_orders/process_action'); ?>" method="post" class="form-horizontal" role="form">

                    <?php } ?>

                    <table class="table admin-form theme-warning tc-checkbox-1 fs13"  id="datatable">

                        <thead>

                        <tr class="bg-light">


                            <th width="12%">Order Id</th>

                            <th width="22%">Name</th>

                            <th width="10%">Mobile</th>

                            <th width="10%">Amount</th>

                            <th width="10%">Mode</th>

                            <th width="15%">Order Date</th>

                            <th width="10%">Status</th>

                            <th class="" width="10%">Action</th>

                        </tr>

                        </thead>

                        <tbody>


                        </tbody>

                    </table>

                    <?php if(!empty($admin_results)){ ?>

                    <div class="clearfix"></div>

                </form>


            <?php } ?>

            </div>

        </div>

    </div>

</section>

<!-- End: Content -->



<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<link  rel="stylesheet" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css" />


<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/css/dataTables.bootstrap.css">
<!-- Datatables -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/jquery.dataTables.js"></script>
<!-- Datatables Bootstrap Modifications  -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        $('.datepicker').datetimepicker({
            format: 'DD-MM-YYYY', pickTime: false
        });

        var datatable=$('#datatable');

        datatable.dataTable({

            "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',

            "processing": false,

            "serverSide": true,

            "aoColumnDefs": [

                { 'bSortable': false, 'aTargets': [0,7 ] } ],

            "pageLength": 20,

            "order": [],

            "ajax": {

                'type': 'GET',

                'url': base_url + "trash_orders/ajax_index",

                'data': function(d){

                    d.formValues = $('#search_frm').serialize();

                }
            }

        });

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });


        $('#datatable').on('click', '.confirm', function () {
            return confirm('Are you sure to delete?');
        });

        $('#globalModal').on('loaded.bs.modal', function (e) {
            var $modal = $(this);
            $modal.find('.datepicker').datetimepicker({
                format: 'DD/MM/YYYY', pickTime: false
            });
        });

    });

</script>