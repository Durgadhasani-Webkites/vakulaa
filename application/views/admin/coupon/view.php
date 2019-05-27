<!-- Start: Topbar -->
<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Coupon</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/coupon/add">Add</a>
            </li>
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/coupon">View</a>
            </li>
        </ul>
    </div>
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">
    <div class="row">
        <div class="panel">
            <div class="panel-body pn">
                <form  id="action_frm" action="<?php echo base_url('admin/coupon/process_action'); ?>" method="post" class="form-horizontal" role="form">
                    <table class="table responsive admin-form theme-warning dtr-inline  fs13"  id="datatable">
                        <thead>
                        <tr class="bg-light">
                            <th class="text-center" width="5%">
                                <label class="option block mn">
                                    <input type="checkbox" id="check_all" class="mul_ch">
                                    <span class="checkbox mn"></span>
                                </label>
                            </th>
                            <th class="mobile-l mobile-p tablet-l tablet-p desktop">Coupon Name</th>
                            <th class="mobile-l mobile-p tablet-l tablet-p desktop">Coupon Code</th>
                            <th class="desktop">Valid From</th>
                            <th class="desktop">Valid To</th>
                            <th class="desktop">Created</th>
                            <th class="desktop">Status</th>
                            <th class="tablet-l tablet-p desktop" width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-success btn-block" type="submit" name="action" value="activate">Activate</button>
                    </div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-warning btn-block" type="submit" name="action" value="deactivate">DeActivate</button>
                    </div>
                    <div class="col-xs-12 actions-btn">
                        <button class="btn btn-sm btn-danger btn-block confirm" type="submit" name="action" value="delete">Delete</button>
                    </div>
                </form>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
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

            "aoColumnDefs": [

                { 'bSortable': false, 'aTargets': [0,7 ] } ],

            "pageLength": 20,

            "order": [],

            "ajax": {

                'type': 'GET',

                'url': base_url + "coupon/ajax_index"
            }

        });


        $('#action_frm').on('click','.confirm',function(){
            return confirm('Are you sure to delete?');
        });

        $('#check_all').click(function(){
            var checkboxes = $('#datatable').find('tbody .mul_ch');
            if($(this).is(':checked')){
                checkboxes.prop('checked',true)
            }else{
                checkboxes.prop('checked',false)
            }
        });
    });
</script>