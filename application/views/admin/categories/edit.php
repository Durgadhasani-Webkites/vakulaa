<!-- Start: Topbar -->
<header id="topbar" class="alt">
    <div class="topbar-left">
        <ol class="breadcrumb">
            <li class="crumb-icon">
                <a href="<?php echo base_url('admin/index/dashboard'); ?>">
                    <span class="glyphicon glyphicon-home"></span>
                </a>
            </li>
            <li class="crumb-trail">Categories</li>
            <li class="crumb-link">
                <a href="">Edit</a>
            </li>

        </ol>
    </div>

</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="">
<?php echo validation_errors(); ?>
    <form  id="category_frm" action="<?php echo base_url('admin/categories/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
        <!-- dashboard tiles -->
        <input type="hidden" name="id" value="<?php echo $admin_results['id'];?>" />
        <div class="row">
            <div class="col-md-10">
                <h4> Edit Category</h4>
            </div>
            <div class="col-md-2">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="<?php echo base_url('admin/categories'); ?>">
                        <i class="fa fa-eye"></i> View all
                    </a>
                </div>
            </div>
        </div>

        <hr class="alt short">
        <br/>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-component">
                    <div class="panel">
                        <div class="panel-heading">
                            <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
                                <li class="active">
                                    <a href="#general" data-toggle="tab">General</a>
                                </li>
                                <li>
                                    <a href="#data" data-toggle="tab">Data</a>
                                </li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content pn br-n">
                                <div id="general" class="tab-pane active">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Category name<span class="mandatory">*</span></label>
                                        <div class="col-lg-10">
                                            <input type="text" name="category_name" placeholder="Enter category name" class="form-control" value="<?php echo $admin_results['category_name'];?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Description</label>
                                        <div class="col-lg-10">
                                            <div class="bs-component">
                                                <textarea name="category_description" class="form-control summernote" style="height: 400px;"><?php echo $admin_results['description'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Meta title</label>
                                        <div class="col-lg-10">
                                            <input type="text" name="meta_title" placeholder="Enter meta title" class="form-control" value="<?php echo $admin_results['meta_title']; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Meta description</label>
                                        <div class="col-lg-10">
                                            <textarea name="meta_description" class="form-control"  rows="3"><?php echo $admin_results['meta_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Meta keywords</label>
                                        <div class="col-lg-10">
                                            <textarea name="meta_keywords" class="form-control"  rows="3"><?php echo $admin_results['meta_keywords']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="data" class="tab-pane">
                                    <div class="form-group">
                                        <label  class="col-md-2 control-label text-left">Parent</label>
                                        <div class="col-md-4">
                                            <select name="parent" class="select2">
                                                <option value="0">Main Category</option>
                                                <?php
                                                if(!empty($category_view)){
                                                    foreach ($category_view as $key => $value) {
                                                        if($admin_results['id'] != $key) {
                                                            ?>
                                                            <option value="<?php echo $key; ?>" <?php if($key==$admin_results['parent_id']) { ?>selected="selected"<?php } ?> ><?php echo $value; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-2 control-label text-left">Filters</label>
                                        <div class="col-md-4 multiSelectBox">
                                            <select name="filters[]" class="multiselect" multiple="multiple">
                                                <?php
                                                if(!empty($filters_for_category)){
                                                    foreach($filters_for_category as $row){
                                                        $filter_ids[]=$row['filter_group_id']."_".$row['filter_id'];
                                                    }
                                                }
                                                if(!empty($filter_view)){
                                                    foreach($filter_view as $row){
                                                        $filter_row = $row['filter_group_id']."_".$row['id'];
                                                        ?>
                                                        <option value="<?php echo $row['filter_group_id']; ?>_<?php echo $row['id']; ?>" <?php if(isset($filter_ids) && in_array($filter_row, $filter_ids)) { ?>selected="selected"<?php } ?> ><?php echo $row['filter_group_name']; ?> - <?php echo $row['filter_name']; ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Category Image Alt Name</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="category_image_name" placeholder="Enter alt name" class="form-control" value="<?php echo $admin_results['category_image_name']; ?>">
                                        </div>
                                    </div>
                                    <?php if($admin_results['category_image']!="") { ?>
                                        <div class="form-group">
                                            <div class="col-lg-2">&nbsp;</div>
                                            <div class="col-lg-10">
                                                <img src="<?php echo $this->config->item('images');?>category/<?php echo $admin_results['category_image']; ?>" height="100" />
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Category Image</label>
                                        <div class="col-lg-10 admin-form">
                                            <label class="field prepend-icon append-button file">
                                                <span class="button">Choose File</span>
                                                <input type="file" class="gui-file" name="category_image" onChange="document.getElementById('category_image_uploader').value = this.value;">
                                                <input type="text" class="gui-input" id="category_image_uploader" placeholder="Please Select A File">
                                                <label class="field-icon">
                                                    <i class="fa fa-upload"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>

                                    <?php 
                                    //print_r($admin_results);
                                    if($admin_results['category_slider_image']!="") { ?>
                                        <div class="form-group">
                                            <div class="col-lg-2">&nbsp;</div>
                                            <div class="col-lg-10">
                                                <img src="<?php echo $this->config->item('images');?>category/<?php echo $admin_results['category_slider_image']; ?>" height="100" />
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Other Category Image</label>
                                        <div class="col-lg-10 admin-form">
                                            <label class="field prepend-icon append-button file">
                                                <span class="button">Choose File</span>
                                                <input type="file" class="gui-file" name="category_image_other" onChange="document.getElementById('category_image_other_uploader').value = this.value;">
                                                <input type="text" class="gui-input" id="category_image_other_uploader" placeholder="Please Select A File">
                                                <label class="field-icon">
                                                    <i class="fa fa-upload"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label text-left">Sort Order</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="sort_order" placeholder="Enter sort order" class="form-control" value="<?php echo $admin_results['sort_order'];?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-2 control-label text-left">Status</label>
                                        <div class="col-md-4">
                                            <select name="status" class="form-control">
                                                <option value="1" <?php if($admin_results['status']==2) { ?>selected="selected"<?php } ?> >Enabled</option>
                                                <option value="0" <?php if($admin_results['status']==0) { ?>selected="selected"<?php } ?> >Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>
</section>
<!-- End: Content -->

<!-- Summernote CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.css">

<!-- Summernote Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.min.js"></script>


<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.css">
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>

<script type="text/javascript">
    $(function() {

        $('.select2').select2();

        $('.multiselect').multiselect({
            enableFiltering: true,
            allSelectedText: 'All',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 200,
            includeSelectAllOption: true
        });
        $('.multiSelectBox .single').multiselect({
            maxHeight: 200,
            enableFiltering: false
        });

        // Init Summernote Plugin
        $('.summernote').summernote({
            height: 255, //set editable area's height
            focus: false, //set focus editable area after Initialize summernote
            oninit: function() {},
            onChange: function(contents, $editable) {}
        });

        $("#category_frm").validate({
            ignore:[],
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                category_name: {
                    required: true
                }
            }

        });

    });
</script>
<style>
    .select2-container{
        width:100% !important;
    }
    .select2-container--default .select2-selection--single{
        background-color: #fff;
    }
</style>