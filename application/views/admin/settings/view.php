<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Settings</h4>
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
                <a href="">Settings</a>
            </li>
        </ol>
    </div>
    
</header>
<!-- End: Topbar -->

<!-- Begin: Content -->
<section id="content" class="table-layout animated fadeIn">

    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('admin/settings/process_settings'); ?>" class="form-horizontal" id="settings_frm" method="post" role="form">
                <?php if(isset($admin_results['id'])){ ?>
                    <input type="hidden" name="id" value="<?php echo $admin_results['id']; ?>" />
                <?php } ?>

                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Settings</span>
                    </div>
                    <div class="panel-body admin-form">
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-xs-6">
                            <h5><small>Facebook URL</small></h5>
                            <label class="field prepend-icon" for="facebook_uri">
                                <input id="facebook_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter facebook url" name="facebook_uri"  value="<?php echo (isset($admin_results['facebook_uri']))?$admin_results['facebook_uri']:'';?>">
                                <label class="field-icon" for="facebook_uri">
                                    <i class="fa fa-facebook"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>GooglePlus URL</small></h5>
                            <label class="field prepend-icon" for="gplus_uri">
                                <input id="gplus_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter gplus url" name="gplus_uri"  value="<?php echo (isset($admin_results['gplus_uri']))?$admin_results['gplus_uri']:'';?>">
                                <label class="field-icon" for="gplus_uri">
                                    <i class="fa fa-google-plus"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Twitter URL</small></h5>
                            <label class="field prepend-icon" for="twitter_uri">
                                <input id="twitter_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter twitter url" name="twitter_uri"  value="<?php echo (isset($admin_results['twitter_uri']))?$admin_results['twitter_uri']:'';?>">
                                <label class="field-icon" for="twitter_uri">
                                    <i class="fa fa-twitter"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Youtube URL</small></h5>
                            <label class="field prepend-icon" for="youtube_uri">
                                <input id="youtube_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter youtube url" name="youtube_uri"  value="<?php echo (isset($admin_results['youtube_uri']))?$admin_results['youtube_uri']:'';?>">
                                <label class="field-icon" for="youtube_uri">
                                    <i class="fa fa-youtube"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>LinkedIn URL</small></h5>
                            <label class="field prepend-icon" for="linkedin_uri">
                                <input id="linkedin_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter linkedin url" name="linkedin_uri"  value="<?php echo (isset($admin_results['linkedin_uri']))?$admin_results['linkedin_uri']:'';?>">
                                <label class="field-icon" for="linkedin_uri">
                                    <i class="fa fa-linkedin"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Instagram URL</small></h5>
                            <label class="field prepend-icon" for="linkedin_uri">
                                <input id="instagram_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter instagram url" name="instagram_uri"  value="<?php echo (isset($admin_results['instagram_uri']))?$admin_results['instagram_uri']:'';?>">
                                <label class="field-icon" for="instagram_uri">
                                    <i class="fa fa-instagram"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Pinterest URL</small></h5>
                            <label class="field prepend-icon" for="pinterest_uri">
                                <input id="pinterest_uri" class="event-name gui-input br-light light" type="text" placeholder="Enter pinterest url" name="pinterest_uri"  value="<?php echo (isset($admin_results['pinterest_uri']))?$admin_results['pinterest_uri']:'';?>">
                                <label class="field-icon" for="pinterest_uri">
                                    <i class="fa fa-pinterest"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Contact Number</small></h5>
                            <label class="field prepend-icon" for="contact_number">
                                <input id="contact_number" class="event-name gui-input br-light light" type="text" placeholder="Enter number" name="contact_number"  value="<?php echo (isset($admin_results['contact_number']))?$admin_results['contact_number']:'';?>">
                                <label class="field-icon" for="contact_number">
                                    <i class="fa fa-mobile"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Contact Email</small></h5>
                            <label class="field prepend-icon" for="contact_email">
                                <input id="contact_email" class="event-name gui-input br-light light" type="text" placeholder="Enter email address" name="contact_email"  value="<?php echo (isset($admin_results['contact_email']))?$admin_results['contact_email']:'';?>">
                                <label class="field-icon" for="contact_email">
                                    <i class="fa fa-envelope"></i>
                                </label>
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <h5><small>Offer Text</small></h5>
                            <label class="field prepend-icon" for="offertext">
                                <input id="offertext" class="event-name gui-input br-light light" type="text" placeholder="Enter offer text" name="offertext"  value="<?php echo (isset($admin_results['offertext']))?$admin_results['offertext']:'';?>">
                                <label class="field-icon" for="offertext">
                                    <i class="fa fa-envelope"></i>
                                </label>
                            </label>
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

            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Supermarket Settings</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form action="<?php echo base_url('admin/settings/process_supermarket_addr'); ?>" class="form-horizontal" id="settings2_frm" method="post" role="form">
                            <?php if(isset($supermarket_results['id'])){ ?>
                                <input type="hidden" name="id" value="<?php echo $supermarket_results['id']; ?>" />
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Company1</small></h5>
                                <input id="company_1" class="event-name gui-input br-light light" type="text" placeholder="Enter company1 name" name="company_1"  value="<?php echo (isset($supermarket_results['company_1']))?$supermarket_results['company_1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Company2</small></h5>
                                <input id="company_2" class="event-name gui-input br-light light" type="text" placeholder="Enter company2 name" name="company_2"  value="<?php echo (isset($supermarket_results['company_2']))?$supermarket_results['company_2']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Address1</small></h5>
                                <input id="address_1" class="event-name gui-input br-light light" type="text" placeholder="Enter address1 name" name="address_1"  value="<?php echo (isset($supermarket_results['address_1']))?$supermarket_results['address_1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Address2</small></h5>
                                <input id="address_2" class="event-name gui-input br-light light" type="text" placeholder="Enter address2 name" name="address_2"  value="<?php echo (isset($supermarket_results['address_2']))?$supermarket_results['address_2']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>City</small></h5>
                                <input id="city" class="event-name gui-input br-light light" type="text" placeholder="Enter city name" name="city"  value="<?php echo (isset($supermarket_results['city']))?$supermarket_results['city']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Pincode</small></h5>
                                <input id="pincode" class="event-name gui-input br-light light" type="text" placeholder="Enter pincode name" name="pincode"  value="<?php echo (isset($supermarket_results['pincode']))?$supermarket_results['pincode']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>State</small></h5>
                                <input id="state" class="event-name gui-input br-light light" type="text" placeholder="Enter state name" name="state"  value="<?php echo (isset($supermarket_results['state']))?$supermarket_results['state']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Country</small></h5>
                                <input id="country" class="event-name gui-input br-light light" type="text" placeholder="Enter country name" name="country"  value="<?php echo (isset($supermarket_results['country']))?$supermarket_results['country']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Phone No</small></h5>
                                <input id="phone_no" class="event-name gui-input br-light light" type="text" placeholder="Enter phone number" name="phone_no"  value="<?php echo (isset($supermarket_results['phone_no']))?$supermarket_results['phone_no']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Email Address</small></h5>
                                <input id="email_address" class="event-name gui-input br-light light" type="text" placeholder="Enter email address" name="email_address"  value="<?php echo (isset($supermarket_results['email_address']))?$supermarket_results['email_address']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Website</small></h5>
                                <input id="website" class="event-name gui-input br-light light" type="text" placeholder="Enter website" name="website"  value="<?php echo (isset($supermarket_results['website']))?$supermarket_results['website']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>GSTIN Number</small></h5>
                                <input id="gstin_no" class="event-name gui-input br-light light" type="text" placeholder="Enter gstin number" name="gstin_no"  value="<?php echo (isset($supermarket_results['gstin_no']))?$supermarket_results['gstin_no']:'';?>">
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="widget-menu text-center mt10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Home page products</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form action="<?php echo base_url('admin/settings/process_home_product_add'); ?>" class="form-horizontal" id="settings3_frm" method="post" role="form" enctype="multipart/form-data">
                            <?php if(isset($home_page_products['id'])){ ?>
                                <input type="hidden" name="id" value="<?php echo $home_page_products['id']; ?>" />
                            <?php } ?>

                            <?php if(isset($home_page_products['image1']) && $home_page_products['image1'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image1']; ?>" height="100" />
                                        <input type="hidden" name="image1_name" value="<?php echo $home_page_products['image1'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Product Image1</small></h5>
                                <input type="file" class="form-control" name="image1">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Product Link1</small></h5>
                                <input id="link1" class="event-name gui-input br-light light" type="text" placeholder="link1" name="link1"  value="<?php echo (isset($home_page_products['link1']))?$home_page_products['link1']:'';?>">
                            </div>
                             <div class="clearfix">&nbsp;</div>
                             <?php if(isset($home_page_products['image2']) && $home_page_products['image2'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image2']; ?>" height="100" />
                                        <input type="hidden" name="image2_name" value="<?php echo $home_page_products['image2'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Product Image2</small></h5>
                                <input type="file" class="form-control" name="image2">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Product Link2</small></h5>
                                <input id="link2" class="event-name gui-input br-light light" type="text" placeholder="link2" name="link2"  value="<?php echo (isset($home_page_products['link2']))?$home_page_products['link2']:'';?>">
                            </div>
                             <div class="clearfix">&nbsp;</div>
                            <?php if(isset($home_page_products['image3']) && $home_page_products['image3'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image3']; ?>" height="100" />
                                        <input type="hidden" name="image3_name" value="<?php echo $home_page_products['image3'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Product Image3</small></h5>
                                <input type="file" class="form-control" name="image3">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Product Link3</small></h5>
                                <input id="link3" class="event-name gui-input br-light light" type="text" placeholder="link3" name="link3"  value="<?php echo (isset($home_page_products['link3']))?$home_page_products['link3']:'';?>">
                            </div>
                            <div class="clearfix">&nbsp;</div>
                             <?php if(isset($home_page_products['image4']) && $home_page_products['image4'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>home_page_products/<?php echo $home_page_products['image4']; ?>" height="100" />
                                        <input type="hidden" name="image4_name" value="<?php echo $home_page_products['image4'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Product Image4</small></h5>
                                <input type="file" class="form-control" name="image4">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Product Link4</small></h5>
                                <input id="link4" class="event-name gui-input br-light light" type="text" placeholder="link4" name="link4"  value="<?php echo (isset($home_page_products['link4']))?$home_page_products['link4']:'';?>">
                            </div>
                            
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="widget-menu text-center mt10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">How to Prepare?</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form action="<?php echo base_url('admin/settings/process_how_to_prepare_add'); ?>" class="form-horizontal" id="settings4_frm" method="post" role="form" enctype="multipart/form-data">
                            <?php if(isset($how_to_prepare['id'])){ ?>
                                <input type="hidden" name="id" value="<?php echo $how_to_prepare['id']; ?>" />
                            <?php } ?>

                            <?php if(isset($how_to_prepare['prepare_image1']) && $how_to_prepare['prepare_image1'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image1']; ?>" height="100" />
                                        <input type="hidden" name="prepare_image1_name" value="<?php echo $how_to_prepare['prepare_image1'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Image1</small></h5>
                                <input type="file" class="form-control" name="prepare_image1">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Title1</small></h5>
                                <input id="title1" class="event-name gui-input br-light light" type="text" placeholder="title1" name="title1"  value="<?php echo (isset($how_to_prepare['title1']))?$how_to_prepare['title1']:'';?>">
                            </div>
                             <div class="clearfix">&nbsp;</div>
                             <?php if(isset($how_to_prepare['prepare_image2']) && $how_to_prepare['prepare_image2'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image2']; ?>" height="100" />
                                        <input type="hidden" name="prepare_image2_name" value="<?php echo $how_to_prepare['prepare_image2'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Image2</small></h5>
                                <input type="file" class="form-control" name="prepare_image2">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Title2</small></h5>
                                <input id="title2" class="event-name gui-input br-light light" type="text" placeholder="title2" name="title2"  value="<?php echo (isset($how_to_prepare['title2']))?$how_to_prepare['title2']:'';?>">
                            </div>
                             <div class="clearfix">&nbsp;</div>
                            <?php if(isset($how_to_prepare['prepare_image3']) && $how_to_prepare['prepare_image3'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image3']; ?>" height="100" />
                                        <input type="hidden" name="prepare_image3_name" value="<?php echo $how_to_prepare['prepare_image3'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Image3</small></h5>
                                <input type="file" class="form-control" name="prepare_image3">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Title3</small></h5>
                                <input id="title3" class="event-name gui-input br-light light" type="text" placeholder="title3" name="title3"  value="<?php echo (isset($how_to_prepare['title3']))?$how_to_prepare['title3']:'';?>">
                            </div>
                            <div class="clearfix">&nbsp;</div>
                             <?php if(isset($how_to_prepare['prepare_image4']) && $how_to_prepare['prepare_image4'] != '') { ?>
                                <div class="form-group">
                                    <div class="col-lg-2">&nbsp;</div>
                                    <div class="col-lg-10">
                                        <img src="<?php echo $this->config->item('images');?>how_to_prepare/<?php echo $how_to_prepare['prepare_image4']; ?>" height="100" />
                                        <input type="hidden" name="prepare_image4_name" value="<?php echo $how_to_prepare['prepare_image4'] ?>">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Image4</small></h5>
                                <input type="file" class="form-control" name="prepare_image4">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Title4</small></h5>
                                <input id="title4" class="event-name gui-input br-light light" type="text" placeholder="title4" name="title4"  value="<?php echo (isset($how_to_prepare['title4']))?$how_to_prepare['title4']:'';?>">
                            </div>
                            
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="widget-menu text-center mt10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Address</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form action="<?php echo base_url('admin/settings/process_contact_address'); ?>" class="form-horizontal" id="settings5_frm" method="post" role="form">
                            <?php if(isset($contact_address['id'])){ ?>
                                <input type="hidden" name="id" value="<?php echo $contact_address['id']; ?>" />
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Address</small></h5>
                                <input id="address" class="event-name gui-input br-light light" type="text" placeholder="Enter address" name="address"  value="<?php echo (isset($contact_address['address']))?$contact_address['address']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>City</small></h5>
                                <input id="city" class="event-name gui-input br-light light" type="text" placeholder="Enter city name" name="city"  value="<?php echo (isset($contact_address['city']))?$contact_address['city']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Pincode</small></h5>
                                <input id="pincode" class="event-name gui-input br-light light" type="text" placeholder="Enter pincode" name="pincode"  value="<?php echo (isset($contact_address['pincode']))?$contact_address['pincode']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>State</small></h5>
                                <input id="state" class="event-name gui-input br-light light" type="text" placeholder="Enter state name" name="state"  value="<?php echo (isset($contact_address['state']))?$contact_address['state']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Country</small></h5>
                                <input id="country" class="event-name gui-input br-light light" type="text" placeholder="Enter country name" name="country"  value="<?php echo (isset($contact_address['country']))?$contact_address['country']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Phone No</small></h5>
                                <input id="phone_no" class="event-name gui-input br-light light" type="text" placeholder="Enter phone number" name="phone_no"  value="<?php echo (isset($contact_address['phone_no']))?$contact_address['phone_no']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Email Address</small></h5>
                                <input id="email_address" class="event-name gui-input br-light light" type="text" placeholder="Enter email address" name="email_address"  value="<?php echo (isset($contact_address['email_address']))?$contact_address['email_address']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Website</small></h5>
                                <input id="website" class="event-name gui-input br-light light" type="text" placeholder="Enter website" name="website"  value="<?php echo (isset($contact_address['website']))?$contact_address['website']:'';?>">
                            </div>
                             <div class="col-xs-6">
                                <h5><small>Map ( iframe )</small></h5>
                                <input id="map" class="event-name gui-input br-light light" type="text" placeholder="Enter map iframe src code" name="map"  value="<?php echo (isset($contact_address['map']))?$contact_address['map']:'';?>">
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="widget-menu text-center mt10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="clearfix">&nbsp;</div>
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-icon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <span class="panel-title">Position</span>
                    </div>
                    <div class="panel-body admin-form">
                        <form action="<?php echo base_url('admin/settings/process_position'); ?>" class="form-horizontal" id="settings6_frm" method="post" role="form">
                            <?php if(isset($position_details['id'])){ ?>
                                <input type="hidden" name="id" value="<?php echo $position_details['id']; ?>" />
                            <?php } ?>
                            <div class="col-xs-6">
                                <h5><small>Position1</small></h5>
                                <input id="position1" class="event-name gui-input br-light light" type="text" placeholder="Enter position1" name="position1"  value="<?php echo (isset($position_details['position1']))?$position_details['position1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Name1</small></h5>
                                <input id="name1" class="event-name gui-input br-light light" type="text" placeholder="Enter name1" name="name1"  value="<?php echo (isset($position_details['name1']))?$position_details['name1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Phone no1</small></h5>
                                <input id="phone_no1" class="event-name gui-input br-light light" type="text" placeholder="Enter phone no1" name="phone_no1"  value="<?php echo (isset($position_details['phone_no1']))?$position_details['phone_no1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Email1</small></h5>
                                <input id="email1" class="event-name gui-input br-light light" type="text" placeholder="Enter email1" name="email1"  value="<?php echo (isset($position_details['email1']))?$position_details['email1']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Position2</small></h5>
                                <input id="position2" class="event-name gui-input br-light light" type="text" placeholder="Enter position2" name="position2"  value="<?php echo (isset($position_details['position2']))?$position_details['position2']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Name2</small></h5>
                                <input id="name2" class="event-name gui-input br-light light" type="text" placeholder="Enter name2" name="name2"  value="<?php echo (isset($position_details['name2']))?$position_details['name2']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Phone no2</small></h5>
                                <input id="phone_no2" class="event-name gui-input br-light light" type="text" placeholder="Enter phone no2" name="phone_no2"  value="<?php echo (isset($position_details['phone_no2']))?$position_details['phone_no2']:'';?>">
                            </div>
                            <div class="col-xs-6">
                                <h5><small>Email2</small></h5>
                                <input id="email2" class="event-name gui-input br-light light" type="text" placeholder="Enter email2" name="email2"  value="<?php echo (isset($position_details['email2']))?$position_details['email2']:'';?>">
                            </div>
                           
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-sm-12">
                                <div class="widget-menu text-center mt10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                facebook_uri: {
                    required:true,
                },
                gplus_uri:{
                    required:true,
                },
                twitter_uri:{
                    required:true,
                },
                contact_email:{
                    required:true,
                    email:true
                }

            }

        });

        $("#settings2_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                company_1: {
                    required:true
                },
                company_2:{
                    required:true
                },
                address_1:{
                    required:true
                },
                address_2:{
                    required:true
                },
                city:{
                    required:true
                },
                pincode:{
                    required:true
                },
                state:{
                    required:true
                },
                country:{
                    required:true,
                },
                phone_no:{
                    number:true,
                    minlength:10,
                    maxlength:10
                },
                email_address:{
                    email:true
                },
                website:{
                    url:true
                },
                gstin_no:{
                    required:true,
                }
            }

        });

         $("#settings3_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                image1: {
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                image2:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                image3:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                image4:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                 link1: {
                    required:true,
                },
                link2:{
                    required:true,
                },
                link3:{
                    required:true,
                },
                link4:{
                    required:true,
                }

            }

        });

        $("#settings4_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                prepare_image1: {
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                prepare_image2:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                prepare_image3:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                prepare_image4:{
                    extension:'jpeg|png|jpg|JPG|PNG|JPEG'
                },
                 title1: {
                    required:true,
                },
                title2:{
                    required:true,
                },
                title3:{
                    required:true,
                },
                title4:{
                    required:true,
                }

            }

        });

         $("#settings5_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                address:{
                    required:true
                },
                city:{
                    required:true
                },
                pincode:{
                    required:true
                },
                state:{
                    required:true
                },
                // country:{
                //     required:true,
                // },
                // phone_no:{
                //     number:true,
                //     minlength:10,
                //     maxlength:10
                // },
                email_address:{
                    email:true
                },
                website:{
                    url:true
                },
                 map:{
                    required:true,
                }
               
            }

        });

         $("#settings6_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",

            rules: {
                position1:{
                    required:true
                },
                name1:{
                    required:true
                },
                phone_no1:{
                    required:true
                },
                email1:{
                    required:true
                },
                
               
            }

        });

    });
</script>