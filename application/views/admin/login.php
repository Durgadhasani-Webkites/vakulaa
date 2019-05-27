<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?php echo $meta_title; ?></title>
    <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>theme.css">

    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>admin-forms.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="external-page external-alt sb-l-c sb-r-c">

<!-- Start: Main -->
<div id="main" class="animated fadeIn">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Begin: Content -->
        <section id="content">

            <div class="admin-form theme-info mw600" style="margin-top: 11%;" id="login1">
                <div class="row mb15 table-layout">

                    <div class="col-xs-6 pln">
                        <a href="<?php echo base_url('admin'); ?>" title="logo" style="color:black;">
                            <img src="<?php echo $this->config->item('admin_images'); ?>logo.png" title="Logo" style="height:38px;" >
                        </a>
                    </div>

                    <div class="col-xs-6 va-b pr5">
                        <div class="login-links text-right">
                            <a href="<?php echo base_url('admin/index/forgot'); ?>" class="" title="Forgot Password">Forgot password?</a>
                        </div>

                    </div>

                </div>
                <div class="panel">

                    <!-- end .form-header section -->
                    <form method="post" action="<?php echo base_url('admin/index/process_login'); ?>" id="login_frm">
                        <div class="panel-body bg-light pn">

                            <div class="row table-layout">
                                <div class="col-xs-3 p20 pv15 va-m br-r bg-light">
                                    <img class="br-a bw4 br-grey img-responsive center-block" src="<?php echo $this->config->item('admin_images');?>nopic.jpg" title="Logo">
                                </div>
                                <div class="col-xs-9 p20 pv15 va-m bg-light">

                                    <?php if($this->session->userdata('loginerror')){ ?>
                                        <div class="state-error"></div>
                                        <em><?php echo $this->session->userdata('loginerror'); ?></em>
                                        <br/>
                                        <?php $this->session->unset_userdata('loginerror');
                                    } ?>

                                    <div class="section mt25">
                                        <label for="username" class="field prepend-icon">
                                            <input type="text" name="username" id="username" class="gui-input" placeholder="Enter user name" value="<?php  echo ($this->input->cookie('username'))?$this->input->cookie('username'):''; ?>">
                                            <label for="username" class="field-icon">
                                                <i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                        <?php echo form_error('username', '<div class="state-error"></div><em>', '</em>'); ?>
                                    </div>

                                    <div class="section mt25">
                                        <label for="password" class="field prepend-icon">
                                            <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password" value="<?php  echo ($this->input->cookie('password'))?$this->input->cookie('password'):''; ?>" />
                                            <label for="password" class="field-icon">
                                                <i class="fa fa-lock"></i>
                                            </label>
                                        </label>
                                        <?php echo form_error('password', '<div class="state-error"></div><em>', '</em>'); ?>
                                    </div>
                                    <!-- end section -->


                                </div>
                            </div>
                        </div>
                        <div class="panel-footer clearfix">
                            <button type="submit" class="button btn-info mr10 pull-right">Sign In</button>
                            <label class="switch ib switch-info mt10">
                                <input type="checkbox" name="remember" id="remember" value="yes" checked>
                                <label for="remember" data-on="YES" data-off="NO"></label>
                                <span>Remember me</span>
                            </label>
                        </div>
                        <!-- end .form-body section -->

                    </form>
                </div>

            </div>

        </section>
        <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->

</div>
<!-- End: Main -->

<!-- BEGIN: PAGE SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo $this->config->item('admin_js');?>jquery/jquery-1.11.1.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>jquery/jquery_ui/jquery-ui.min.js"></script>

<!-- Theme Javascript -->
<script src="<?php echo $this->config->item('admin_js');?>utility/utility.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>main.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>

<!-- Page Javascript -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        "use strict";
        // Init Theme Core
        Core.init();
        $("#login_frm").validate({
            /* @validation states + elements
             ------------------------------------------- */
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            /* @validation rules
             ------------------------------------------ */
            rules: {
                username: {
                    required: true
                },
                password:{
                    required: true
                }
            },
            /* @validation highlighting + error placement
             ---------------------------------------------------- */
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element.parent());
                }
            }
        });

    });
</script>

<!-- END: PAGE SCRIPTS -->
<style>
    a.active:hover{
        color:#FC0900 !important;
    }
</style>
</body>

</html>