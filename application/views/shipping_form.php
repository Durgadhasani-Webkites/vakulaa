<form id="shipping_frm" class="form-inline" action="<?php echo base_url();?>checkout/process_shipping_addr" method="post">
    <?php if(!empty($shipping_address)){ ?>
    <input type="hidden" name="id" value="<?php echo $shipping_address['id']; ?>"/>
    <?php } ?>
    <div class="row">
        <div class="col-md-4 col-xs-12 ship-form">
            <select name="title" class="form-control" id="title">
                <option value="">Title</option>
                <option value="home" <?php echo (isset($shipping_address['title']) && $shipping_address['title']=='home')?'selected="selected"':''; ?>>Home</option>
                <option value="office" <?php echo (isset($shipping_address['title']) && $shipping_address['title']=='office')?'selected="selected"':''; ?>>Office</option>
                <option value="other" <?php echo (isset($shipping_address['title']) && $shipping_address['title']=='other')?'selected="selected"':''; ?>>Other</option>
            </select>
        </div>
        <div class="col-md-8 col-xs-12 ship-form">
            <input name="contact_name" type="text" class="form-control" id="contact_name" placeholder="Enter Your Name" value="<?php echo (!empty($shipping_address['contact_name']))?$shipping_address['contact_name']:''; ?>">
        </div>
        <div class="col-md-12 col-xs-12 ship-form">
            <textarea name="address" placeholder="Address"  class="form-control" id="address" rows="3"><?php echo (!empty($shipping_address['address']))?$shipping_address['address']:''; ?></textarea>
        </div>
        <div class="col-md-12 col-xs-12 ship-form">
            <input name="landmark" type="text" class="form-control" id="landmark" placeholder="Landmark(optional)" value="<?php echo (!empty($shipping_address['landmark']))?$shipping_address['landmark']:''; ?>">
        </div>
        <div class="col-md-6 col-xs-12 ship-form">
            <input name="pincode" type="text" class="form-control" id="pincode" maxlenght="6" placeholder="Pincode" value="<?php echo (!empty($shipping_address['pincode']))?$shipping_address['pincode']:''; ?>">
        </div>
        <div class="geo-details">
            <div class="col-md-6 col-xs-12 ship-form">
            <input name="city" type="text" class="form-control geo_map" id="city" data-geo="administrative_area_level_2" placeholder="City" value="<?php echo (!empty($shipping_address['city']))?$shipping_address['city']:''; ?>">
        </div>
        <div class="col-md-6 col-xs-12 ship-form">
            <input name="state" type="text" class="form-control geo_map" id="state" data-geo="administrative_area_level_1" placeholder="State" value="<?php echo (!empty($shipping_address['state']))?$shipping_address['state']:''; ?>">
        </div>
        <div class="col-md-6 col-xs-12 ship-form">
            <input name="country" type="text" class="form-control geo_map" data-geo="country" id="country" placeholder="Country" value="<?php echo (!empty($shipping_address['country']))?$shipping_address['country']:''; ?>">
        </div>
        </div>
        
        <div class="col-md-6 col-xs-12 ship-form">
            <input name="contact_number" type="text" class="form-control" id="contact_number" maxlength="10" placeholder="Mobile number" value="<?php echo (!empty($shipping_address['contact_number']))?$shipping_address['contact_number']:''; ?>">
        </div>
        <div class="col-md-6 col-xs-12 ship-form">
            <input name="email_address" type="text" class="form-control" id="email_address" placeholder="Email Address" value="<?php echo (!empty($shipping_address['email_address']))?$shipping_address['email_address']:''; ?>">
        </div>
        <div class="col-md-12 col-xs-12 ship-form">
            <label>
                <input name="make_default" type="checkbox" id="make_default" value="1" <?php echo (!empty($shipping_address['make_default']) && ($shipping_address['make_default']==1))?'checked="checked"':''; ?>/>
                Make this as default address
            </label> 
        </div>
        <div class="col-md-12 col-xs-12">
            <div class="continue-btn">
                <button type="submit" class="btn-now ship-mdl-btn">Submit</button>
            </div>
        </div>  
    </div>
</form>