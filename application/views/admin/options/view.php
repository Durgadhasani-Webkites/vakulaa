<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Options</li>
            <li class="crumb-link">
                <a href="#">View</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="">

    <!-- dashboard tiles -->
    <div class="row">
        <div class="col-md-10">
            <h4> Manage Options</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/options/add'); ?>">
                <i class="fa fa-plus"></i> Add Options
            </a>
        </div>
    </div>

    <hr class="alt short">

    <table class="table table-striped table-hover" id="datatable" cellspacing="0" width="100%">
        <thead>
        <tr class="primary">
            <th>Option Name</th>
            <th>Type</th>
            <th>Sort Order</th>
            <th>Created</th>
            <th>Show/Hide</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($admin_results)){
            foreach($admin_results as $admin_details){ ?>
                <tr>
                    <td><?php echo $admin_details['option_name']; ?></td>
                    <td><?php echo $admin_details['type']; ?></td>
                    <td><?php echo $admin_details['sort_order']; ?></td>
                    <td><?php echo date('d/m/Y',strtotime($admin_details['created'])); ?></td>
                    <td>
                        <?php if($admin_details['status']==2){ ?>
                            <a class="confirm-alert" title="click to deactivate" href="<?php echo base_url('admin/options/deactivate/'.$admin_details['id']);?>"><i class="fa fa-check"></i></a>
                        <?php } else{ ?>
                            <a class="confirm-alert" title="click to activate" href="<?php echo base_url('admin/options/activate/'.$admin_details['id']);?>"><i class="fa fa-times" style="color:red;"></i></a>
                        <?php } ?>
                    </td>
                    <td><a title="click to edit" href="<?php echo base_url('admin/options/edit/'.$admin_details['id']);?>" ><i class="fa fa-pencil"></i></a></td>
                    <td><a class="confirm-alert" title="click to delete" href="<?php echo base_url('admin/options/delete/'.$admin_details['id']);?>" data-id="<?php echo $admin_details['id']; ?>" ><i class="fa fa-trash-o"></i></a></td>
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
            "aaSorting": [[ 6, "desc" ]],
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false },
                { "bSortable": false }
            ]
        });

    });
</script>