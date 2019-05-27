<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Banner</li>
            <li class="crumb-link">
                <a href="">View</a>
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
            <h4> Manage Banners</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/banner/add'); ?>">
                <i class="fa fa-plus"></i> Add Banner
            </a>
        </div>
    </div>

    <hr class="alt short">

    <table class="table table-striped table-hover" id="datatable" cellspacing="0" width="100%">
        <thead>
        <tr class="primary">
            <th width="32%">Banner Name</th>
            <th width="32%">Banner Type</th>
            <th width="10%" > Order</th>
            <th width="10%" >Created</th>
            <th width="10%">Visiblity</th>
            <th width="6%" >Edit</th>
            <th width="6%">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($admin_results)){
            foreach($admin_results as $admin_details){ ?>
                <tr>
                    <td><?php echo $admin_details['title']; ?></td>
                    <td><?php 
                     if($admin_details['bannertype']==1 || $admin_details['bannertype']==0)
                     {
                         echo 'Main Banner';
                     }
                     if($admin_details['bannertype']==2)
                     {
                         echo '4 Block Banner';
                     }
                     if($admin_details['bannertype']==3)
                     {
                         echo '5 Block Banner';
                     }
                     if($admin_details['bannertype']==4)
                     {
                         echo '6 Block Banner';
                     }
                    
                  ?></td>
                    <td><?php echo $admin_details['sort_order']; ?></td>
                    <td><?php echo date('d/m/Y',strtotime($admin_details['created'])); ?></td>
                    <td>
                        <?php if($admin_details['status']==2){ ?>
                            <a class="confirm-alert" title="click to deactivate" href="<?php echo base_url('admin/banner/deactivate/'.$admin_details['id']);?>"><i class="fa fa-check"></i></a>
                        <?php } else{ ?>
                            <a class="confirm-alert" title="click to activate" href="<?php echo base_url('admin/banner/activate/'.$admin_details['id']);?>"><i class="fa fa-times" style="color:red;"></i></a>
                        <?php } ?>
                    </td>
                    <td><a title="click to edit" href="<?php echo base_url('admin/banner/edit/'.$admin_details['id']);?>" ><i class="fa fa-pencil"></i></a></td>
                    <td><a class="confirm-alert" title="click to delete" href="<?php echo base_url('admin/banner/delete/'.$admin_details['id']);?>" data-id="<?php echo $admin_details['id']; ?>" ><i class="fa fa-trash-o"></i></a></td>
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
