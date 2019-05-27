<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Module</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/modules/add">Add</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/modules">View</a>
            </li>
        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">

        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> Add Module</span>

            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form  id="add_frm" action="<?php echo base_url('admin/modules/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Parent</small></h5>
                                    <div class="multiSelectBox">
                                        <select name="parent_id" class="multiselect" >
                                            <option value="0">-------------Main-------------</option>
                                            <?php if(!empty($modules)) {
                                                foreach($modules as $k=>$v) {
                                                        ?>
                                                        <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                                                    <?php
                                                } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Icon</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Module Icon" class="event-name gui-input br-light light" id="icon" name="icon" value='<span class="fa fa-list"></span>'>
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="icon"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Module Name" class="event-name gui-input br-light light" id="name" name="name">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Controller Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Controller Name" class="event-name gui-input br-light light" id="link" name="link">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="link"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Table Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Table Name" class="event-name gui-input br-light light" id="table_name" name="table_name">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="table_name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Sort Order</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Sort Order" class="event-name gui-input br-light light" id="sort_order" name="sort_order">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="sort_order"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Show In Dashboard</small></h5>
                                    <div class="option-group field">
                                        <label class="option option-primary">
                                            <input type="radio" id="show_in_dashboard_yes" value="2" name="show_in_dashboard">
                                            <span class="radio"></span>Yes</label>
                                        <label class="option option-primary">
                                            <input type="radio" id="show_in_dashboard_no" value="1" name="show_in_dashboard" checked="checked">
                                            <span class="radio"></span>No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-3">
                                    <h5><small>Status</small></h5>
                                    <label class="field select" for="">
                                        <select name="status" id="status">
                                            <option value="">Choose status</option>
                                            <option value="1" selected="selected">Enable</option>
                                            <option value="2">Disable</option>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="width:100px;">Submit</button>
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

        $('.multiselect').multiselect({
            enableFiltering: false
        });

        $("#add_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                name: {
                    required: true,
                    noTild:true
                },
                link:{
                    noTild:true
                },
                table_name:{
                    noTild:true
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('div').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('div').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element);
                }
            }

        });

    });
</script>
