<!-- Start: Topbar -->
<header id="topbar" class="ph10">
    <div class="text-center"><h4>Partner With Us</h4>

        <hr class="alt short">
    </div>
    
    <div class="topbar-left">

        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/partners/overseas">Overseas Details</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/partners">Contact Details</a>
            </li>
        </ul>

    </div>
</header><!-- End: Topbar --><!-- Begin: Content -->


<!-- Begin: Content -->
<section id="content" class="">

    <!-- dashboard tiles -->

    <table class="table table-striped table-hover" id="datatable" cellspacing="0" width="100%">
        <thead>
        <tr class="primary">
            <th>Organisation</th>
            <th>First Name</th>
            <th>Mobile</th>
            <th>Catgory</th>
            <th>Process</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($admin_results)){
            foreach($admin_results as $admin_details){ ?>
                <tr>
                    <td><?php echo $admin_details['Company_name']; ?></td>
                    <td><?php echo $admin_details['first_name']; ?></td>
                    <td><?php echo $admin_details['mobile']; ?></td>
                    <td>
                     <?php echo $admin_details['category']; ?>
                    </td>
                    <td><a title="click to edit" href="<?php echo base_url('admin/partners/overseas_readmore/'.$admin_details['id']);?>" class="btn btn-success btn-sm mb5">Read More</a></td>
                     <td><a title="click to edit" href="<?php echo base_url('admin/partners/overseas_delete/'.$admin_details['id']);?>" class="confirm btn btn-danger btn-sm mb5" id='action_frm'>Remove</a></td>
                </tr>
            <?php
            }
        } ?>
        </tbody>
    </table>

</section>
<!-- End: Content -->

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/css/dataTables.bootstrap.css">

<!-- Datatables -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/jquery.dataTables.js"></script>
<!-- Datatables Bootstrap Modifications  -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datatables/media/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Init DataTables
        $('#datatable').dataTable({
            "iDisplayLength": 50,
            "oTableTools": {
                "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            },
            "aaSorting": [[ 5, "desc" ]],
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false },
                { "bSortable": false }
            ]
        });

         $('#action_frm').on('click', '.confirm', function () {
            return confirm('Are you sure to delete?');
        });

    });
</script>