<?php include_once('navigation.php'); ?>
<div class="col-lg-8 col-md-8 col-sm-6 ">
    <div class="right-sec">
        <?php if( $this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
            <div class="clearfix">&nbsp;</div>
        <?php } ?>
        <?php if( $this->session->flashdata('error')){ ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
            <div class="clearfix">&nbsp;</div>
        <?php } ?>
        <div class="formhead">
            Shipping Address
        </div>

        <div class="clearfix">&nbsp;</div>
        <div class="new_shipping_form" style="display: none;">
            <?php
            $attributes = array('class' => 'form-horizontal new-address-form');
            echo form_open_multipart('user/process_shipping_address', $attributes);
            ?>
            <div class="form-group">
                <div class="col-lg-6">
                    <select name="title" class="form-control" id="title">
                        <option value="">Select Title</option>
                        <option value="home">Home</option>
                        <option value="office">Office</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            
                <div class="col-lg-6 ">
                    <input type="text" class="form-control" placeholder="Enter your name" name="contact_name" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 ">
                    <textarea name="address" placeholder="Address" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 ">
                   <input type="text" class="form-control" placeholder="Landmark (Optional)" name="landmark">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 ">
                    <input type="text" class="form-control" placeholder="Pincode" name="pincode">
                </div>
                <div class="col-lg-6 ">
                    <input type="text" class="form-control" placeholder="City" name="city">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 ">
                    <input type="text" class="form-control" placeholder="State" name="state">
                </div>
                <div class="col-lg-6 ">
                    <input type="text" class="form-control" placeholder="Country" name="country">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 ">
                    <input type="text" class="form-control" placeholder="Mobile Number" name="contact_number">
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12">
                     <input type="text" class="form-control" placeholder="Enter Your Email Address" name="email_address">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12 ">
                    <input class="btn btn-black " id='update' type="submit" value="Save Changes">
                    <input class="btn btn-default" id='cancel_new_addr' type="button" value="Cancel">
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <div class="col-lg-12 nopadding">
            <a href="javascript:" class="add_new_addr"><i class="fa fa-plus"></i> Add new address</a>
        </div>
        <div class="col-lg-12 nopadding shipping_addr">
            <?php if(!empty($shipping_address)){
                foreach($shipping_address as $k=>$address_row){ ?>
                    <div class="col-lg-12 existing_shipaddr">
                        <div>
                            <?php echo $address_row['contact_name'] ; ?>,
                            <?php echo $address_row['address'] ; ?>,
                            <?php echo $address_row['city'] ; ?> - <?php echo $address_row['pincode'] ; ?>.
                            <?php echo (!empty($address_row['contact_number']))?'Phone: '.$address_row['contact_number']:'' ; ?>
                            <?php echo (!empty($address_row['email_address']))?'Email: '.$address_row['email_address']:'' ; ?>
                        </div>
                        <div class="col-lg-12 nopadding">
                        <div class="col-lg-6 col-md-6 nopadding">
                            <input type="radio" id="default_address_<?php echo $address_row['id']; ?>" class="default_address" name="make_default" value="<?php echo $address_row['id']; ?>" <?php echo ($address_row['make_default']==1)?'checked="checked"':''; ?> />
                            <label class="my_acc_label" for="default_address_<?php echo $address_row['id']; ?>"> Default Address</label>
                        </div>
                        <div class="col-lg-6 col-md-6 text-right"><a style="color: black;" href="<?php echo base_url(); ?>user/delete_address/<?php echo $address_row['id']; ?> "><i class="fa fa-trash" aria-hidden="true"></i> Delete address</a></div>
                        </div>
                    </div>
                <?php
                }

            } ?>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
     <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>
     <div class="clearfix">&nbsp;</div>
</div>
</div>
</div>


<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_js'); ?>plugins/select2/select2.min.css" />
<script src="<?php echo $this->config->item('admin_js');?>plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('user_js');?>jquery.geocomplete.min.js"></script>

<script type="text/javascript">
    $(function(){

        $('.new-address-form').validate({
            errorClass: "error-msg",
            ignore: [],
            errorElement:'div',
            rules: {
                title: {
                    required: true,
                },
                contact_name:{
                    required: true,
                },
                 address:{
                    required: true
                },
                pincode:{
                    required: true
                },
                 city:{
                    required: true,
                },
                state:{
                    required: true,
                },
                country:{
                    required: true,
                },
                email_address:{
                    required:true,
                    email: true,
                },
                contact_number:{
                    required: true,
                    number:true,
                    minlength:10,
                    maxlength:10
                },
            }
        });
        $(".default_address").change(function(){
            var $this=$(this);
            $.post( '<?php echo base_url(); ?>user/set_default_shipping_addr', {id:$this.val()} );
        });

        // $(".geo_map").geocomplete({
        //     details: ".geo-location",
        //     detailsAttribute: "data-geo",
        //     types: ["geocode"]
        // });

        // $(".area_name").geocomplete({
        //     types: ["geocode"]
        // }).bind("geocode:result", function(event, result) {
        //     $(this).val(result.name);
        // });

        $('.add_new_addr').click(function(){
            $(this).hide();
            $('.new_shipping_form').show();
        });
        $('#cancel_new_addr').click(function(){
            $('.add_new_addr').show();
            $('.new_shipping_form').hide();
        });
    });

    function formatResult (data) {
        return data.title;
    }
    function formatSelection (data) {
        return data.title || data.text;
    }

</script>
<style>
    .existing_shipaddr{
        border:1px solid #eee;
    }
    .select2-container{
        width: 100% !important;
        height: 40px;
        font-size:13px;

    }
    .select2-container--default .select2-selection--single{
        height:40px;
        border:1px solid #e8e7e3;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height:38px;
    }
</style>