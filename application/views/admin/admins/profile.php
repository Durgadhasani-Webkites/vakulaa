<header id="topbar" class="ph10">
    <div class="text-center">
        <h4>Profile</h4>
        <hr class="alt short">
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">
        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> Profile Information</span>
            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form id="edit_frm" action="<?php echo base_url('admin/profile/process_profile'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php  echo $admin_results['id']; ?>" />
                            <?php if($this->session->userdata('resource_id')==0){ ?>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>User Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter user name" class="event-name gui-input br-light light" id="user_name" name="user_name" value="<?php echo $admin_results['username']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_name"></em>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Email Address</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter email address" class="event-name gui-input br-light light" id="user_email" name="user_email" value="<?php echo $admin_results['email']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_email"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>First Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter first name" class="event-name gui-input br-light light" id="first_name" name="first_name" value="<?php echo $admin_results['first_name']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="first_name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Last Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter last name" class="event-name gui-input br-light light" id="last_name" name="last_name" value="<?php echo $admin_results['last_name']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="last_name"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Mobile No</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter mobile no" class="event-name gui-input br-light light" id="mobile_no" name="mobile_no" value="<?php echo $admin_results['mobile_no']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="mobile_no"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Full Address</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <textarea name="fulladdress" placeholder="Enter address" class="form-control" ><?php echo $admin_results['fulladdress'];?></textarea>
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="fulladdress"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Old Password</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="password" placeholder="Enter old password" class="event-name gui-input br-light light" id="old_password" name="old_password">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="old_password"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>New Password</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="password" placeholder="Enter new password" class="event-name gui-input br-light light" id="new_password" name="new_password">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="new_password"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Repeat Password</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="password" placeholder="Enter repeat password" class="event-name gui-input br-light light" id="repeat_password" name="repeat_password">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="repeat_password"></em>
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
                },
                old_password:{
                    remote: '<?php echo base_url(); ?>admin/profile/check_old_pass'
                },
                repeat_password:{
                    equalTo:'#new_password'
                }
            },
			
            messages:{
				old_password: {
                    remote:'Old password is wrong'
                },
                repeat_password:{
                    equalTo:'Please enter same password again'
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
//cut copy paste not allowed	
$(function(){
    $(document).on("cut copy paste","#repeat_password",function(e) {
        e.preventDefault();
    });
});
</script>