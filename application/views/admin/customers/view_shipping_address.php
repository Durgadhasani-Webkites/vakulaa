<!-- Start: Topbar -->

<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Customers - Shipping Address</h4>

        <a href="<?php echo base_url(); ?>admin/customers">View customers</a>
        <hr class="alt short">

    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/customers/shipping_address_add/<?php echo $customer_id; ?>">Add</a>
            </li>
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/customers/shipping_address/<?php echo $customer_id; ?>">View</a>
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

                <table class="table admin-form theme-warning"  id="datatable">

                    <thead>

                    <tr class="bg-light">

                        <th width="30%">Name</th>

                        <th width="15%">Email</th>

                        <th width="15%">Phone</th>

                        <th width="15%">City</th>

                        <th width="10%">Pincode</th>

                        <th width="10%">Default</th>

                        <th width="10%">Registered</th>

                        <th width="10%">Action</th>

                    </tr>

                    </thead>

                    <tbody>


                    </tbody>

                </table>


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

                'url': base_url + "customers/shipping_address_index",

                'data': function(d){

                    d.customer_id = '<?php echo $customer_id; ?>';

                }
            }

        });


        datatable.on('click', '.confirm', function () {
            return confirm('Are you sure to delete?');
        });


    });

</script>