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
    <link rel="shortcut icon" href="<?php  echo $this->config->item('admin_images'); ?>zo.ico">

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

        <!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
            <canvas id="demo-canvas"></canvas>
        </div>

        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">

            <div class="admin-form theme-info mw500" style="margin-top: 10%;" id="login">
                <div class="row mb15 table-layout">

                    <div class="col-xs-6 pln">
                        <a href="<?php echo base_url('admin');?>" title="logo" style="color:black;">
                            <img src="<?php echo $this->config->item('admin_images'); ?>logo.png" title="Logo" style="height:38px;" >
                        </a>
                    </div>

                    <div class="col-xs-6 va-b">
                        <div class="login-links text-right">
                            <a href="<?php echo base_url('admin');?>" class="backsignin" title="sign in">SignIn</a>
                        </div>
                    </div>
                </div>

                <div class="panel">

                    <form method="post" action="<?php echo base_url('admin/index/process_forgot'); ?>" id="forgot_frm">
                        <div class="panel-body p15">
                            <h4>Forgot Password</h4>
                            <?php if($this->session->flashdata('forgot_success')){ ?>
                                <div class="alert alert-micro alert-border-left alert-success pastel alert-dismissable mn">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-info pr10"></i><?php  echo $this->session->flashdata('forgot_success'); ?>
                                </div>
                            <?php } ?>
                            <?php if($this->session->flashdata('forgot_error')){ ?>
                                <div class="alert alert-micro alert-border-left alert-danger pastel alert-dismissable mn">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-info pr10"></i> <?php  echo $this->session->flashdata('forgot_error'); ?>
                                </div>
                            <?php } ?>

                        </div>
                        <!-- end .form-body section -->
                        <div class="panel-footer p25 pv15">

                            <div class="section mn">

                                <div class="smart-widget sm-right smr-80">
                                    <label for="email" class="field prepend-icon">
                                        <input type="text" name="email" id="email" class="gui-input" placeholder="Your Email Address">
                                        <label for="email" class="field-icon">
                                            <i class="fa fa-envelope-o"></i>
                                        </label>
                                    </label>
                                    <button type="submit" class="button btn-primary">Submit</button>
                                </div>
                                <?php echo form_error('email', '<div class="state-error"></div><em>', '</em>'); ?>
                                <!-- end .smart-widget section -->

                            </div>
                            <!-- end section -->

                        </div>
                        <!-- end .form-footer section -->

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

        $("#forgot_frm").validate({

            /* @validation states + elements
             ------------------------------------------- */

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            /* @validation rules
             ------------------------------------------ */

            rules: {

                email: {
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
<style type="text/css">
    .backsignin:hover{
        color:#FC0900 !important;
    }
</style>

<!-- END: PAGE SCRIPTS -->

</body>

</html>
