<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Blogs</li>
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
            <h4> Add Blog</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/blog'); ?>">
                <i class="fa fa-eye"></i> View all
            </a>
        </div>
    </div>

    <hr class="alt short">
    <br/>
    <div class="col-lg-6 nopadding">
        <form  id="blog_frm" action="<?php echo base_url('admin/blog/process_add'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Title<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="title" placeholder="Enter title" class="form-control" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left">Blog Image<span class="mandatory">*</span></label>
                <div class="col-lg-8 admin-form">
                 <input type="file" class="form-control" name="blog_image">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label text-left" >Image link<span class="mandatory">*</span> </label>
                <div class="col-lg-8">
                    <input type="text" name="image_link" placeholder="Enter image url" class="form-control" >
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

        $("#blog_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                title: {
                    required: true
                },
                blog_image:{
                    required: true,
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                image_link:{
                    required: true,
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

