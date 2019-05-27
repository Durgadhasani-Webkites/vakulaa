<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Admin</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/admins/add">Add</a>
            </li>
            <li class="active">
                <a href="javascript:">Edit</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/admins">View</a>
            </li>

        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">
        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> Edit Admin</span>
            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form id="edit_frm" action="<?php echo base_url('admin/admins/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php  echo $admin_results['id']; ?>" />
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>User Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter user name" class="event-name gui-input br-light light" id="user_name" name="user_name" value="<?php  echo $admin_results['username']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Email Address</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter email address" class="event-name gui-input br-light light" id="user_email" name="user_email" value="<?php  echo $admin_results['email']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_email"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Privileges</small></h5>
                                    <div class="multiSelectBox">
                                        <?php
                                        $existing_prevl=explode(",",$admin_results['privileges']);
                                        ?>
                                        <select name="privileges[]" class="multiselect" multiple="multiple" >
                                            <?php if(!empty($modules)) {
                                                foreach($modules as $k=>$v) {
                                                    if(empty($v['sub_modules'])){
                                                        ?>
                                                        <option value="<?php echo $v['id'];?>" <?php echo (is_array($existing_prevl) && in_array($v['id'],$existing_prevl))?'selected="selected"':''; ?>><?php echo $v['name'];?></option>
                                                    <?php }else{
                                                        foreach($v['sub_modules'] as $k1=>$v1) {
                                                            $v1id=$v['id'].'-'.$v1['id'];
                                                            ?>
                                                            <option value="<?php echo $v1id;?>" <?php echo (is_array($existing_prevl) && in_array($v1id,$existing_prevl))?'selected="selected"':''; ?> ><?php echo $v1['name'];?></option>
                                                        <?php }
                                                    }
                                                } } ?>
                                        </select>
                                    </div>
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

        $("#edit_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                user_name: {
                    required: true
                },
                user_email:{
                    required: true,
                    email:true
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