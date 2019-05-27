<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Headings</h4>
        <hr class="alt short" />
    </div>
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-link">
                <a href="">Headings</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('admin/headings/process'); ?>" class="form-horizontal" id="headings_frm" method="post" role="form">
                <?php if(isset($admin_results['id'])){ ?>
                    <input type="hidden" name="id" value="<?php echo $admin_results['id']; ?>" />
                <?php } ?>

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Headings</span>
                    </div>
                    <div class="panel-body admin-form">
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-xs-6">
                            <h5><small>Heading1</small></h5>
                            <input id="home_heading_1" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 1" name="home_heading_1"  value="<?php echo (isset($admin_results['home_heading_1']))?$admin_results['home_heading_1']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading2</small></h5>
                            <input id="home_heading_2" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 2" name="home_heading_2"  value="<?php echo (isset($admin_results['home_heading_2']))?$admin_results['home_heading_2']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading3</small></h5>
                            <input id="home_heading_1" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 3" name="home_heading_3"  value="<?php echo (isset($admin_results['home_heading_3']))?$admin_results['home_heading_3']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading4</small></h5>
                            <input id="home_heading_4" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 4" name="home_heading_4"  value="<?php echo (isset($admin_results['home_heading_4']))?$admin_results['home_heading_4']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading5</small></h5>
                            <input id="home_heading_5" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 5" name="home_heading_5"  value="<?php echo (isset($admin_results['home_heading_5']))?$admin_results['home_heading_5']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading6</small></h5>
                            <input id="home_heading_6" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 6" name="home_heading_6"  value="<?php echo (isset($admin_results['home_heading_6']))?$admin_results['home_heading_6']:'';?>">
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Heading7</small></h5>
                            <input id="home_heading_7" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 7" name="home_heading_7"  value="<?php echo (isset($admin_results['home_heading_7']))?$admin_results['home_heading_7']:'';?>">
                        </div>
                         <div class="col-xs-6">
                            <h5><small>Heading8</small></h5>
                            <input id="home_heading_8" class="event-name gui-input br-light light" type="text" placeholder="Enter heading 8" name="home_heading_8"  value="<?php echo (isset($admin_results['home_heading_8']))?$admin_results['home_heading_8']:'';?>">
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-sm-12">
                            <div class="clearfix">&nbsp;</div>
                            <div class="widget-menu text-center mt10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</section>
<!-- End: Content -->
<!-- Start: Topbar -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_css');?>admin-forms.css" />

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script type="text/javascript">
    $(function(){

        $("#settings_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                home_headings_1: {
                    noTild:true
                },
                home_headings_2:{
                    noTild:true
                },
                home_headings_3:{
                    noTild:true
                },
                home_headings_4:{
                    noTild:true
                },
                home_headings_5:{
                    noTild:true
                },
                home_headings_6:{
                    noTild:true
                },
                home_headings_7:{
                    noTild:true
                }
            }

        });


    });
</script>