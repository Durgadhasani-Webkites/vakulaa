<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Admin</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li class="active">
                <a href="<?php echo base_url(); ?>admin/admins/add">Add</a>
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
                <span class="panel-title hidden-xs"> Add Admin</span>
            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form  id="add_frm" action="<?php echo base_url('admin/admins/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>User Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter user name" class="event-name gui-input br-light light" id="user_name" name="user_name">
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
                                        <input type="text" placeholder="Enter email address" class="event-name gui-input br-light light" id="user_email" name="user_email">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_email"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Password</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Enter password" class="event-name gui-input br-light light" id="user_password" name="user_password">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="user_password"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-9">
                                    <h5><small>Privileges</small></h5>
                                   <div class="multiSelectBox">
                                       <select name="privileges[]" class="multiselect" multiple="multiple" >
                                           <?php if(!empty($modules)) {
                                               foreach($modules as $k=>$v) {
                                                   if(empty($v['sub_modules'])){
                                                   ?>
                                                   <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                                               <?php }else{
                                                      foreach($v['sub_modules'] as $k1=>$v1) { ?>
                                                          <option value="<?php echo $v['id'];?>-<?php echo $v1['id'];?>"><?php echo $v1['name'];?></option>
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

        $("#add_frm").validate({

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
                user_password:{
                    required:true
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
    $(document).on("cut copy paste","#user_password",function(e) {
        e.preventDefault();
    });
});
</script>