<header id="topbar" class="ph10">

    <div class="text-center">
        <h4>Edit Shipping Address</h4>
        <a href="<?php echo base_url(); ?>admin/customers">View customers</a>
        <hr class="alt short">
    </div>
    <div class="topbar-left">
        <ul class="nav nav-list nav-list-topbar pull-left">
            <li>
                <a href="<?php echo base_url(); ?>admin/customers/shipping_address_add/<?php echo $user_id; ?>">Add</a>
            </li>
            <li class="active">
                <a href="javascript:">Edit</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>admin/customers/shipping_address/<?php echo $user_id; ?>">View</a>
            </li>

        </ul>
    </div>
</header>

<section id="content" class="table-layout animated fadeIn">
    <div class="tray tray-center" style="height: 510px;">

        <!-- create new order panel -->
        <div class="panel mb25 mt5">
            <div class="panel-heading">
                <span class="panel-title hidden-xs">Edit</span>
            </div>
            <div class="panel-body p20 pb10">
                <div class="tab-content pn br-n admin-form">
                    <div class="tab-pane active" id="tab1_1">
                        <form  id="edit_frm" action="<?php echo base_url('admin/customers/process_edit_shipping_address'); ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                            <div class="section row">
                                <div class="col-md-6">
                                    <h5><small>First Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="First Name" class="event-name gui-input br-light light" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <h5><small>Last Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Last name" class="event-name gui-input br-light light" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-xs-6">
                                    <h5><small>Email Address</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Email address" class="event-name gui-input br-light light" id="email_address" name="email_address" value="<?php echo $email_address; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <h5><small>Phone Number</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Phone Number" class="event-name gui-input br-light light" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-xs-6">
                                    <h5><small>House No</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="House No" class="event-name gui-input br-light light" id="house_no" name="house_no" value="<?php echo $house_no; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <h5><small>Apartment Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Apartment Name" class="event-name gui-input br-light light" id="apartment_name" name="apartment_name" value="<?php echo $apartment_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-xs-6">
                                    <h5><small>Street Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Street Name" class="event-name gui-input br-light light" id="street_name" name="street_name" value="<?php echo $street_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <h5><small>Area</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Area Name" class="area_name event-name gui-input br-light light" id="area_name" name="area_name" value="<?php echo $area_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="section row geo-location">
                                <div class="col-xs-6">
                                    <h5><small>City Name</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="City Name" data-geo="locality" class="geo_map event-name gui-input br-light light" id="city_name" name="city_name" value="<?php echo $city_name; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <h5><small>State</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="State" data-geo="administrative_area_level_1" class="geo_map event-name gui-input br-light light" id="state" name="state" value="<?php echo $state; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-xs-6">
                                    <h5><small>Pincode </small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Pincode" class="event-name gui-input br-light light" id="pincode" name="pincode" value="<?php echo $pincode; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>

                            

                                </div>
                                <div class="col-xs-6">
                                    <h5><small>Landmark</small></h5>
                                    <label class="field prepend-icon" for="">
                                        <input type="text" placeholder="Landmark" class="event-name gui-input br-light light" id="landmark" name="landmark" value="<?php echo $landmark; ?>">
                                        <label class="field-icon" for="">
                                            <i class="fa fa-edit"></i>
                                        </label>
                                    </label>
                                </div>

                            </div>
                            <div class="section row">
                                <div class="col-md-3">
                                    <input type="checkbox" name="default_address" id="default_address" value="1" <?php echo ($default_address==1)?'checked':''; ?>>
                                    <label  for="default_address" class="control-label text-left">Default Address</label>
                                </div>
                            </div>
                            <div class="section row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary" style="width:100px;">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDqWKKuqGqNmBnjMSsXNXxGjbvoy7gjYI0"></script>
<script type="text/javascript" src="<?php echo $this->config->item('user_js');?>jquery.geocomplete.min.js"></script>

<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/additional-methods.min.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>plugins/validate/jquery.validate.custom.min.js"></script>


<script type="text/javascript">
    $(function(){

        $(".area_name").geocomplete({
            types: ["geocode"]
        }).bind("geocode:result", function(event, result) {
            $(this).val(result.name);
        });
        $(".geo_map").geocomplete({
            details: ".geo-location",
            detailsAttribute: "data-geo",
            types: ["geocode"]
        });

        $("#edit_frm").validate({

            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                first_name:{
                    required:true,
                    noTild:true
                },
                last_name:{
                    required:true,
                    noTild:true
                },
                contact_number:{
                    required:true,
                    number:true,
                    maxlength:10,
                    minlength:10
                },
                email_address:{
                    validEmail:true
                },
                house_no:{
                    noTild:true
                },
                apartment_name:{
                    noTild:true
                },
                street_name:{
                    noTild:true
                },
                landmark:{
                    noTild:true
                },
                city:{
                    noTild:true
                },
                area_name:{
                    noTild:true
                },
                pincode:{
                    number:true
                }
            }
        });

    });
</script>
