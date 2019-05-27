<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Categories</li>
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
            <h4> Manage Categories</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/categories/add'); ?>">
                <i class="fa fa-plus"></i> Add Category
            </a>
        </div>
    </div>

    <hr class="alt short">

    <table class="table table-striped table-hover" id="datatable" cellspacing="0" width="100%">
        <thead>
        <tr class="primary">
            <th>Category Name</th>
            <th>Sort Order</th>
            <th>Created</th>
            <th class="text-center">Show/Hide</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($admin_results)){
            foreach($admin_results as $id=>$admin_details){
                $highlight_row='';
                if($admin_details['parent_id']==0){
                    $highlight_row='class="info"';
                }
                ?>
                <tr <?php //echo $highlight_row; ?>>
                    <td><?php echo ($admin_details['parent_id']==0)?"<b>".$admin_details['category_name']."</b>":$admin_details['category_name']; ?></b></td>
                    <td><?php echo $admin_details['sort_order']; ?></td>
                    <td><?php echo date('d/m/Y',strtotime($admin_details['created'])); ?></td>
                    <td class="text-center">
                        <?php if($admin_details['status']==1){ ?>
                            <a class="confirm-alert" title="click to deactivate" href="<?php echo base_url('admin/categories/deactivate/'.$id);?>"><i class="fa fa-check"></i></a>
                        <?php }
                        if($admin_details['status']==0){ ?>
                            <a class="confirm-alert" title="click to activate" href="<?php echo base_url('admin/categories/activate/'.$id);?>"><i class="fa fa-times" style="color:red;"></i></a>
                        <?php } ?>
                    </td>
                    <td class="text-center"><a title="click to edit" href="<?php echo base_url('admin/categories/edit/'.$id);?>" ><i class="fa fa-pencil"></i></a></td>
                    <td class="text-center"><a class="confirm-alert" title="click to delete" href="<?php echo base_url('admin/categories/delete/'.$id);?>" ><i class="fa fa-trash-o"></i></a></td>
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

        $('#datatable').dataTable({
            "iDisplayLength": 50,
            "oTableTools": {
                "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            },
            "aaSorting": [],
            "aoColumns": [
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
