<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Add Contact</li>
            <li class="crumb-link">
                <a href="">Add</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="">

    <!-- dashboard tiles -->
    <div class="row">
        <div class="col-md-10">
            <h4> Add </h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/contact_details'); ?>">
                <i class="fa fa-eye"></i> View all
            </a>
        </div>
    </div>

    <hr class="alt short">
    <br/>
    <div class="col-lg-6 nopadding">
        <form  id="contact_frm" action="<?php echo base_url('admin/contact_details/add_process'); ?>" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-md-4 control-label text-left">Country</label>
                <div class="col-md-8 multiSelectBox">
                    <select name="country" class="single">
                        <option value=" ">select country</option>
                        <?php foreach ($results as $value) 
                        {
                        ?>
                        <option value="<?php echo $value['id']?>"><?php echo $value['country']?></option>
                        <?php
                        } 
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Designation<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="designation" placeholder="Enter Designation" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Name<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Mobile Number<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="mobile" placeholder="Enter Mobile Number" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Email<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="email" placeholder="Enter Email" class="form-control" >
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Google Map<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="google" placeholder="Google Map" class="form-control" >
                </div>
            </div>



            <div class="form-group">
                <label class="col-md-4 control-label text-left">Status</label>
                <div class="col-md-8 multiSelectBox">
                    <select name="status" class="single">
                        <option value="2">Enabled</option>
                        <option value="1">Disabled</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">&nbsp;</div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-hover btn-primary btn-block">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="clearfix">&nbsp;</div>
</section>
<!-- End: Content -->

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script>
    $(function(){
        $('.multiSelectBox .single').multiselect({
            enableFiltering: false
        });

        $(".spinner").spinner();

        $("#contact_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                country: {
                    required: true,
                },
                designation:{
                    required: true,
                },
                name:{
                    required: true,
                },
                mobile:{
                    digits:true,
                    required: true,
                },
                email:{
                    required: true,
                },

            }

        });

    });
</script>

