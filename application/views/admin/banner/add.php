<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Banners</li>
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
            <h4> Add Banner</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/banner'); ?>">
                <i class="fa fa-eye"></i> View all
            </a>
        </div>
    </div>

    <hr class="alt short">
    <br/>
    <div class="col-lg-6 nopadding">
        <form  id="banner_frm" action="<?php echo base_url('admin/banner/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Banner Name<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="banner_name" placeholder="Enter banner name" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label text-left" for="bannertype">Banner Type</label>
                <div class="col-md-8 multiSelectBox">
                    <select name="bannertype" class="single" id="bannertype">
                        <option value="0">Choose Banner Type</option>
                        <option value="1">Main Banner</option>
                        <option value="2">4 Block Banner</option>
                        <option value="3">5 Block Banner</option>
                        <option value="4">6 Block Banner</option>
                        <option value="5">Harizontal Banner</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Image Alt Name<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="image_name" placeholder="Enter image name" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left">Banner Image</label>
                <div class="col-lg-8 admin-form">
                    <label class="field prepend-icon append-button file">
                        <span class="button">Choose File</span>
                        <input type="file" class="gui-file" name="banner_image" onChange="document.getElementById('banner_image_uploader').value = this.value;">
                        <input type="text" class="gui-input" id="banner_image_uploader" placeholder="Please Select A Image">
                        <label class="field-icon">
                            <i class="fa fa-upload"></i>
                        </label>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Banner link<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="banner_link" placeholder="Enter banner url" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left">Sort Order<span class="mandatory">*</span></label>
                <div class="col-lg-8">
                    <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-level-up"></i>
                </span>
                        <input name="sort_order" class="form-control ui-spinner-input spinner" placeholder="Enter sort order" value="1" />
                    </div>
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

        $("#banner_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                banner_name: {
                    required: true
                },
                bannertype: {
                    required: true
                },
                banner_image:{
                    required: true,
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                sort_order:{
                    required: true
                },
                banner_status:{
                    required: true
                }
            }

        });

    });
</script>

