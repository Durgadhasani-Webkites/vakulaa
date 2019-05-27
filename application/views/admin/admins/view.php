<!-- Start: Topbar -->
<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Admin Manager</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/admins/add">Add</a>
            </li>
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/admins">View</a>
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
                <?php if(!empty($admin_results)){ ?>
                <form  id="action_frm" action="<?php echo base_url('admin/admins/process_action'); ?>" method="post" class="form-horizontal" role="form">
                    <?php } ?>
                    <table class="table admin-form theme-warning tc-checkbox-1 fs13"  id="datatable">
                        <thead>
                        <tr class="bg-light">
                            <th class="text-center" width="5%">Select</th>
                            <th width="22%">Username</th>
                            <th width="38%">Email</th>
                            <th class="" width="13%">Created On</th>
                            <th class="" width="5%">Status</th>
                            <th class="" width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($admin_results)){ ?>
                            <?php
                            foreach($admin_results as $admin_result_row){
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <label class="option block mn">
                                            <input type="checkbox" name="id[]" class="mul_ch" value="<?php echo $admin_result_row['id']; ?>">
                                            <span class="checkbox mn"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $admin_result_row['username']; ?></td>
                                    <td><?php echo $admin_result_row['email']; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($admin_result_row['created'])); ?></td>
                                    <td align="center">
                                        <?php if($admin_result_row['status']==1){ ?>
                                            <i class="fa fa-check" style="color:#56C046"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-times" style="color:#D53C24;" ></i>
                                        <?php } ?>
                                    </td>
                                    <td class="">
                                        <div class="btn-group text-right">
                                            <button type="button" class="btn btn-success br2 btn-xs fs12 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Change
                                                <span class="caret ml5"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a title="click to edit" href="<?php echo base_url('admin/admins/edit/'.$admin_result_row['id']);?>">Edit</a>
                                                    <a title="click to show" href="<?php echo base_url('admin/admins/approve/'.$admin_result_row['id']);?>">Show</a>
                                                    <a title="click to hide" href="<?php echo base_url('admin/admins/disapprove/'.$admin_result_row['id']);?>">Hide</a>
                                                    <a class="confirm-alert" title="click to delete" href="<?php echo base_url('admin/admins/delete/'.$admin_result_row['id']);?>">Remove</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                    <?php if(!empty($admin_results)){ ?>
                    <div class="clearfix"></div>
                    <div class="col-xs-2 actions-btn">
                        <button class="btn btn-sm btn-success btn-block" type="submit" name="action" value="approve">Approve</button>
                    </div>
                    <div class="col-xs-2 actions-btn">
                        <button class="btn btn-sm btn-danger btn-block" type="submit" name="action" value="disapprove">Disapprove</button>
                    </div>
                    <div class="col-xs-2 actions-btn">
                        <button class="btn btn-sm btn-success btn-block confirm" type="submit" name="action" value="delete">Delete</button>
                    </div>
                </form>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
            <?php } ?>
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
        // Init DataTables
        $('#datatable').dataTable({
            //"sDom": 't<"dt-panelfooter clearfix"ip>',
            "oTableTools": {
                "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
            }
        });
        $(".confirm").click(function(e){
            return (!confirm('Are you sure to perform this action?'))?0:1;
        });
    });
</script>