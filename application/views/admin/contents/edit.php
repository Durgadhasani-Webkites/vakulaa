<header id="topbar" class="ph10">
    <div class="text-center">
        <h4>Content</h4>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/contents/add">Add</a>
            </li>
            <li class="active">
                <a href="javascript:">Edit</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/contents">View</a>
            </li>

        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">
        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs"> Edit Content</span>
            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form  id="edit_frm" action="<?php echo base_url('admin/contents/process_edit'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input name="id" type="hidden" value="<?php echo $admin_results['id']; ?>"/>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Title</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="page title" class="event-name gui-input br-light light" id="page_title" name="page_title" value="<?php echo $admin_results['page_title']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                    <em class="state-error" for="page_title"></em>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Content</small></h5>
                                    <textarea name="page_content" class="form-control summernote" style="height: 400px;" placeholder="page content"><?php echo $admin_results['page_content']; ?></textarea>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Short Content</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <textarea name="short_content" class="form-control limitchar" id="short_content" maxlength="450" placeholder="Write your content here" style="height: 100px;" ><?php echo $admin_results['short_content']; ?></textarea>
                                        <div class="note"><span id="chars">450</span> characters are remaining.</div>
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                        <em class="state-error" for="short_content"></em>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Meta Title</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="meta title" class="event-name gui-input br-light light" id="meta_title" name="meta_title" value="<?php echo $admin_results['meta_title']; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                        <em class="state-error" for="meta_title"></em>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Meta Description</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <textarea name="meta_description" placeholder="meta description" id="meta_description" class="form-control"  rows="3"><?php echo $admin_results['meta_description']; ?></textarea>
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                        <em class="state-error" for="meta_description"></em>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-10">
                                    <h5><small>Meta Keywords</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <textarea name="meta_keywords" placeholder="meta keywords" id="meta_keywords" class="form-control"  rows="3"><?php echo $admin_results['meta_keywords']; ?></textarea>
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                        <em class="state-error" for="meta_keywords"></em>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-md-3">
                                    <h5><small>Status</small></h5>
                                    <label class="field select" for="">
                                        <select name="status" id="status">
                                            <option value="">Choose status</option>
                                            <option value="1" <?php echo (isset($admin_results['status']) && $admin_results['status']==1)?'selected="selected"':''; ?>>Enable</option>
                                            <option value="2" <?php echo (isset($admin_results['status']) && $admin_results['status']==2)?'selected="selected"':''; ?>>Disable</option>
                                        </select>
                                        <i class="arrow double"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="width:100px;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Summernote CSS  -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.css">
<!-- Summernote Plugin -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/summernote/summernote.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>
<script type="text/javascript">
    $(function(){

        $("#edit_frm").validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                page_title:{
                    required: true,
                    noTild:true
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('div').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('div').removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    element.closest('.option-group').after(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
		
		$('.summernote').summernote({
			height: 255, //set editable area's height
			focus: false, //set focus editable area after Initialize summernote
			oninit: function() {},
			onChange: function(contents, $editable) {}
		});
		var app = angular.module('app', []);
		app.controller('MainCtrl', function($scope) {
		  $scope.count = 0;
		});

        $('.limitchar').keyup(function() {
            var $this=$(this);
            var maxLength=$this.attr('maxlength');
            var length = $this.val().length;
            length = maxLength-length;
            if(length<0){
                length=0;
            }
            $(this).siblings().find('#chars').html(length);
        });

    });
</script>