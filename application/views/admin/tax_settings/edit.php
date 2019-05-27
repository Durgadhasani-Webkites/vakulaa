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

                <a href="javascript:">Edit</a>

            </li>
            <li>

                <a href="<?php echo base_url(); ?>admin/tax_settings">View</a>

            </li>
        </ul>

    </div>

</header>



<section id="content" class="table-layout animated fadeIn">

    <div class="tray tray-center" style="height: 510px;">

        <!-- create new order panel -->

        <div class="panel mb25 mt5">

            <div class="panel-heading">

                <span class="panel-title hidden-xs"> Edit Tax Settings</span>

            </div>

            <div class="panel-body p20 pb10">

                <div class="tab-content pn br-n admin-form">

                    <div class="tab-pane active" id="tab1_1">

                        <form  id="add_frm" action="<?php echo base_url('admin/tax_settings/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input name="id" id="id" value="<?php echo $admin_results['id']; ?>" type="hidden" />
                            <div class="section row">
                                <div class="col-md-6">
                                    <h5><small>Tax Type</small><span class="required">*</span></h5>
                                    <select name="tax_type" class="select2-single form-control">
                                        <option value="select">Select One</option>
                                        <option value="SGST" <?php echo ($admin_results['tax_type']=='SGST')?'selected="selected"':''; ?>>SGST</option>
                                        <option value="CGST" <?php echo ($admin_results['tax_type']=='CGST')?'selected="selected"':''; ?>>CGST</option>
                                    </select>
                                </div>
                            </div>
                            <div class="section row">

                                <div class="col-md-6">

                                    <h5><small>Tax Name</small><span class="required">*</span></h5>

                                    <label class="field prepend-icon" for="">

                                        <input type="text" placeholder="Enter Tax Name" class="event-name gui-input br-light light" id="tax_name" name="tax_name" value="<?php echo $admin_results['tax_name']; ?>">

                                        <label class="field-icon" for="">

                                            <i class="fa fa-edit"></i>

                                        </label>

                                    </label>

                                    <em class="state-error" for="tax_name"></em>

                                </div>

                            </div>

                            <div class="section row">

                                <div class="col-md-6">

                                    <h5><small>Rate(%)</small><span class="required">*</span></h5>

                                    <label class="field prepend-icon" for="">

                                        <input type="text" placeholder="Enter Tax Rate" class="event-name gui-input br-light light" id="tax_value" name="tax_value" value="<?php echo $admin_results['tax_value']; ?>">

                                        <label class="field-icon" for="">

                                            <i class="fa fa-edit"></i>

                                        </label>

                                    </label>

                                    <em class="state-error" for="tax_value"></em>

                                </div>

                            </div>

                            <div class="section row">
                                <div class="col-md-6">
                                    <h5><small>Status</small><span class="required">*</span></h5>
                                    <select name="status" class="form-control">
                                        <option value="1" <?php echo ($admin_results['status']==1)?'selected="selected"':''; ?>>Enabled</option>
                                        <option value="0" <?php echo ($admin_results['status']==0)?'selected="selected"':''; ?>>Disabled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="section row">

                                <div class="col-sm-12">

                                    <button type="submit" class="btn btn-primary" style="width:100px;">Submit</button>
                                    <a href="<?php echo base_url(); ?>admin/tax_settings" class="button"> Cancel </a>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>


<script type="text/javascript">

    $(function(){

        $("#add_frm").validate({
            ignore:[],
            errorClass: "state-error",

            validClass: "state-success",

            errorElement: "em",

            rules: {
                tax_type:{

                    required: true
                },
                tax_name: {
                    required: true,
                    noTild:true
                },
                tax_value:{

                    required: true
                }

            }

        });

    })

</script>

