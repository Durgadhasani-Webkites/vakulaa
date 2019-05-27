<!-- Start: Topbar -->

<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Customers</h4>

        <hr class="alt short">

    </div>

</header>

<!-- End: Topbar -->



<!-- Begin: Content -->

<section id="content" class="table-layout animated fadeIn">

    <div class="row">

        <div class="panel">

            <div class="panel-body">
                <form id="search_frm" method="get" class="form-horizontal" role="form">
                    <div class="clearfix">&nbsp;</div>
                    <div class="row ph15 mb10">
                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>User Name</small></h5>

                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Search user name" value="<?php echo (isset($_GET['user_name']))?$_GET['user_name']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>User Email</small></h5>

                            <input type="text" name="user_email" id="user_email" class="form-control" placeholder="Search user email" value="<?php echo (isset($_GET['user_email']))?$_GET['user_email']:''; ?>">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">

                            <h5><small>User Mobile</small></h5>

                            <input type="text" name="user_phone" id="user_phone" class="form-control" placeholder="Search user mobile" value="<?php echo (isset($_GET['user_mobile']))?$_GET['user_mobile']:''; ?>">

                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                    <div class="row ph15 mb10">

                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">

                            <input type="submit" class="btn btn-success btn-block" id="search_stud" value="Search">

                        </div>

                        <div class="clearfix visible-xs">&nbsp;</div>

                        <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">

                            <a href="<?php echo base_url(); ?>admin/customers" class="btn btn-default btn-block" id="clear">Clear</a>

                        </div>

                        <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">

                            <a href="<?php echo base_url(); ?>admin/customers/customers_download" class="btn btn-primary btn-block" id="clear">Download</a>

                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>

                </form>
                <form  id="action_frm" action="<?php echo base_url('admin/customers/process_action'); ?>" method="post" class="form-horizontal" role="form">
                <table class="table admin-form theme-warning"  id="datatable">

                    <thead>

                    <tr class="bg-light">

                        <th class="text-center" width="5%">
                            <label class="option block mn">
                                <input type="checkbox" id="check_all" class="mul_ch">
                                <span class="checkbox mn"></span>
                            </label>
                        </th>

                        <th width="20%">Name</th>

                        <th width="20%">Email</th>

                        <th width="20%">Mobile</th>

                        <th width="15%">Registered</th>

                        <th width="10%">Action</th>

                    </tr>

                    </thead>

                    <tbody>


                    </tbody>

                </table>
                <div class="clearfix">&nbsp;</div>
                <div class="col-xs-12 actions-btn">
                    <button class="btn btn-sm btn-danger btn-block confirm" type="submit" name="action" value="delete">Delete</button>
                </div>
                </form>
            </div>

        </div>

    </div>

</section>

<!-- End: Content -->


<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/css/dataTables.bootstrap.css">
<!-- Datatables -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/jquery.dataTables.js"></script>
<!-- Datatables Bootstrap Modifications  -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        var datatable=$('#datatable');

        datatable.dataTable({

            "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',

            "processing": false,

            "serverSide": true,

            "pageLength": 20,

            "order": [],

            "ajax": {

                'type': 'GET',

                'url': base_url + "customers/ajax_index",

                'data': function(d){

                    d.formValues = $('#search_frm').serialize();

                }
            }

        });


        $(document).on('click', '.confirm', function () {
            return confirm('Are you sure to delete?');
        });


    });

</script>