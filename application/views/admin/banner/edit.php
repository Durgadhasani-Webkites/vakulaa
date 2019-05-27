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
                <a href="">Edit</a>
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
            <h4> Edit Banner</h4>
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="<?php echo base_url('admin/banner'); ?>">
                <i class="fa fa-eye"></i> View all
            </a>
        </div>
    </div>

    <hr class="alt short">
    <br/>
    <?php
    if(isset($admin_result) && !empty($admin_result)) {
        foreach ($admin_result as $rows) {
            $ban_id=$rows['id'];
            $banner_name=$rows['title'];
            $bannertype=$rows['bannertype'];
            $image_name=$rows['image_name'];
            $banner_image=$rows['image'];
            $banner_image_link=$rows['image_link'];
            $sort_order=$rows['sort_order'];
            $status=$rows['status'];
        }
    }
    ?>
    <div class="col-lg-6 nopadding" >
    <form  id="banner_frm" action="<?php echo base_url('admin/banner/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <input type="hidden" name="ban_id" id="ban_id" class="form-control" value="<?php echo $ban_id; ?>">
        <div class="form-group">
            <label class="col-lg-4 control-label text-left" >Banner Name<span class="mandatory">*</span> </label>
            <div class="col-lg-8">
                <input type="text" name="banner_name" placeholder="Enter banner name" class="form-control" value="<?php echo $banner_name; ?>" />
            </div>
        </div>
        <div class="form-group">
                <label class="col-md-4 control-label text-left" for="bannertype">Banner Type</label>
                <div class="col-md-8 multiSelectBox">
                    <select name="bannertype" class="single" id="bannertype">
                        <option value="0">Choose Banner Type</option>
                        <option value="1"
                        <?php 
                        if($bannertype==1)
                        {
                            echo 'selected=selected';
                        }
                        ?>
                        >Main Banner</option>
                        <option value="2"
                        <?php 
                        if($bannertype==2)
                        {
                            echo 'selected=selected';
                        }
                        ?>
                        >4 Block Banner</option>
                        <option value="3"
                        <?php 
                        if($bannertype==3)
                        {
                            echo 'selected=selected';
                        }
                        ?>
                        >5 Block Banner</option>
                        <option value="4"
                        <?php 
                        if($bannertype==4)
                        {
                            echo 'selected=selected';
                        }
                        ?>
                        
                        >6 Block Banner</option>
                         <option value="5"
                        <?php 
                        if($bannertype==5)
                        {
                            echo 'selected=selected';
                        }
                        ?>
                        
                        >Harizontal Banner</option>
                    </select>
                </div>
            </div>
        <div class="form-group">
            <label class="col-lg-4 control-label text-left" >Image Alt Name<span class="mandatory">*</span> </label>
            <div class="col-lg-8">
                <input type="text" name="image_name" placeholder="Enter image name" class="form-control" value="<?php echo $image_name; ?>">
            </div>
        </div>
        <?php if($banner_image!="") { ?>
            <div class="form-group">
                <div class="col-lg-4 control-label text-left">&nbsp;</div>
                <div class="col-lg-7" style="overflow:hidden;"><img src="<?php echo $this->config->item('upload');?>banners/<?php echo $banner_image; ?>" height="150" /></div>
            </div>
        <?php } ?>
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
                <input type="text" name="banner_link" placeholder="Enter banner url" class="form-control"  value="<?php echo $banner_image_link; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 control-label text-left">Sort Order<span class="mandatory">*</span></label>
            <div class="col-lg-8">
                <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-level-up"></i>
                </span>
                    <input name="sort_order" class="form-control ui-spinner-input spinner" placeholder="Enter sort order" value="<?php echo $sort_order; ?>" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label text-left">Status</label>
            <div class="col-md-8 multiSelectBox">
                <select name="status" class="single">
                    <option value="2" <?php if($status=='2') { ?>selected="selected"<?php } ?> >Enabled</option>
                    <option value="1" <?php if($status=='1') { ?>selected="selected"<?php } ?> >Disabled</option>
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
                banner_image:{
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

