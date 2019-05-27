    <header id="topbar" class="ph10">

       <!--  <div class="text-center">
            <h4>Add Country</h4>
            <hr class="alt short" />
           <?php if($this->session->flashdata('notify_success')){ ?>
                   <?php echo $this->session->flashdata('notify_success'); ?>
           <?php } ?>
           <?php if($this->session->flashdata('notify_error')){ ?>
                   <?php echo $this->session->flashdata('notify_error'); ?>

           <?php } ?>
        </div> -->
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Create Country</li>
            <li class="crumb-link">
                <a href="#">add country</a>
            </li>

        </ol>
    </div>
        
    </header>
    <!-- End: Topbar -->

    <!-- Begin: Content -->
    <section id="content" class="table-layout animated fadeIn">

        <div class="row">

            <div class="panel">

                <div class="panel-body">
                   <form  id="country_frm" action="<?php echo base_url('admin/country/process_add'); ?>" method="post" class="form-horizontal" role="form">
                        <div class="clearfix">&nbsp;</div>
                        <div class="row ph15 mb10">
                            <div class="col-lg-4 col-md-4 col-sm-6">

                                <h5><small>Create Country*</small></h5>
                               <input type="text" name="country" class="form-control" placeholder="Enter Country">

                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-6 col-xs-12">
                                <h5><small>&nbsp;</small></h5>
                                <input type="submit" class="btn btn-success btn-block" id="search_stud" value="Search" >
                            </div>

                        </div>

                        <div class="clearfix">&nbsp;</div>

                    </form>


                </div>

            </div>

        </div>
    </section>
    <!-- End: Content -->

    <script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
    <script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
    <script>
        $(function(){

            $("#country_frm").validate({

                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    country: {
                        required: true
                    },
                }

            });

        });
    </script>
