<!-- Start: Topbar -->

<header id="topbar" class="ph10">


    <div class="text-center">

        <h4>Tax Settings</h4>

        <hr class="alt short">

    </div>

    <div class="topbar-left">

        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>

                <a href="<?php echo base_url(); ?>admin/tax_settings/add">Add</a>

            </li>
            <li class="active">

                <a href="<?php echo base_url(); ?>admin/tax_settings">View</a>

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

                <?php if(!empty($admin_results)){ ?>

                <form  id="action_frm" action="<?php echo base_url('admin/tax_settings/process_action'); ?>" method="post" class="form-horizontal" role="form">

                    <?php } ?>

                    <table class="table admin-form theme-warning tc-checkbox-1 fs13"  id="datatable">

                        <thead>

                        <tr class="bg-light">
                            <th class="text-center" width="5%">Select</th>
                            <th width="15%">TAX NAME</th>

                            <th width="22%">TAX TYPE</th>

                            <th width="15%">RATE(%)</th>

                            <th width="15%">STATUS</th>

                            <th class="" width="10%">ACTION</th>

                        </tr>

                        </thead>

                        <tbody>
                        <?php if(!empty($admin_results)){
                            foreach($admin_results as $admin_result_row){
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <label class="option block mn">
                                            <input type="checkbox" name="id[]" class="mul_ch" value="<?php echo $admin_result_row['id']; ?>">
                                            <span class="checkbox mn"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $admin_result_row['tax_name']; ?></td>
                                    <td><?php echo $admin_result_row['tax_type']; ?></td>
                                    <td><?php echo $admin_result_row['tax_value']; ?></td>
                                    <td>
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
                                                    <a title="click to edit" href="<?php echo base_url('admin/tax_settings/edit/'.$admin_result_row['id']);?>">Edit</a>
                                                    <a title="click to show" href="<?php echo base_url('admin/tax_settings/approve/'.$admin_result_row['id']);?>">Show</a>
                                                    <a title="click to hide" href="<?php echo base_url('admin/tax_settings/disapprove/'.$admin_result_row['id']);?>">Hide</a>
                                                    <a class="confirm-alert" title="click to delete" href="<?php echo base_url('admin/tax_settings/delete/'.$admin_result_row['id']);?>">Remove</a>
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
                    <?php } ?>
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

            "aoColumnDefs": [

                { 'bSortable': false, 'aTargets': [0,3 ] } ],

            "pageLength": 20,

            "order": []

        });

        $('#datatable').on('click','.confirm',function(e){

            return (!confirm('Are you sure to perform this action?'))?0:1;

        });

    });

</script>