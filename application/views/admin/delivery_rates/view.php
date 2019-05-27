<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Delivery Rates</h4>
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
                <a href="">Delivery Rates</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('admin/delivery_rates/process_delivery_rates'); ?>" class="form-horizontal" id="settings_frm" method="post" role="form">
                <?php if(isset($admin_results['id'])){ ?>
                    <input type="hidden" name="id" value="<?php echo $admin_results['id']; ?>" />
                <?php } ?>

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Delivery Rates</span>
                    </div>
                    <div class="panel-body admin-form">
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-xs-10">
                            <div class="col-lg-3 nopadding">
                                <label class="control-label text-left" ><b>Grams <span class="mandatory">*</span></b></label>
                                <div class="clearfix">&nbsp;</div>
                                <input id="grams" class="event-name gui-input br-light light" type="text" placeholder="Enter grams" name="grams"  value="<?php echo (isset($admin_results['grams']))?$admin_results['grams']:'500';?>" readonly>
                            </div>
                            <div class="col-lg-1 text-center">
                                <br/>
                                <div class="clearfix">&nbsp;</div>
                                <div class="clearfix">&nbsp;</div>
                                =
                            </div>
                            <div class="col-lg-4 nopadding">
                                <label class="control-label text-left" ><b>Rate <span class="mandatory">*</span></b></label>
                                <div class="clearfix">&nbsp;</div>
                                <input id="rate" class="event-name gui-input br-light light" type="text" placeholder="Enter cost" name="rate"  value="<?php echo (isset($admin_results['rate']))?$admin_results['rate']:'';?>">
                            </div>
                        </div>
                        
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-sm-12">
                            <div class="clearfix">&nbsp;</div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
<!-- End: Content -->
<!-- Start: Topbar -->

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/datepicker/css/bootstrap-datetimepicker.css">

<!-- Time/Date Plugin Dependencies -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/globalize/globalize.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/moment/moment.min.js"></script>

<!-- DateTime Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/datepicker/js/bootstrap-datetimepicker.js"></script>

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
                rates: {
                    required:true
                }
            }

        });

    });
</script>